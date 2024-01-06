<?php
require_once '../inc/func.inc';

$SOURCE_ID = isset($_GET['sid']) ? $_GET['sid'] : 1;
$dbconn = dbconn();

$SOURCE = select_source($SOURCE_ID);
$cs = $SOURCE['source_category'];


$CONTENTS_TITLE = "■本の検索■";
$PAGE_TITLE = " - 『{$SOURCE['source_name']}』";

require_once $_SERVER["DOCUMENT_ROOT"] . '/inc/head_set_2column.inc';
?>

<table class="detail">
    <tr>
        <td width="100"  bold nowrap="nowrap" align="right">出典名：</td>
        <td width="310" ><?= $SOURCE['source_name']; ?></td>
        <td width="120" rowspan="8" valign="top">
            <?php if ($SOURCE['source_asin'] != "") { ?>
                <table cellpadding="2" width="120" align="right">
                    <tr>
                        <td align="center">
                            <a href="https://www.amazon.co.jp/dp/<?= $SOURCE['source_asin'] ?>/ref=nosim?tag=aaaaea00-22" target="_blank">
                                <img src="https://images-na.ssl-images-amazon.com/images/P/<?= $SOURCE['source_asin'] ?>.09.LZZZZZZZ.jpg" style="width: 120px;border: 1px solid black">
                            </a>
                        </td>
                    </tr>
                </table>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td  bold nowrap="nowrap" align="right">おすすめ度：</td>
        <td ><?php view_source_rec_level($SOURCE['source_rec_level']) ?>&nbsp;<font size="1"><a
                        href=./ onclick="window.open('/popup.php', '', 'width=300,height=300');"
                target=_blank>※おすすめ度について</a></font></td>
    </tr>
    <tr>
        <td  bold nowrap="nowrap" align="right" width="100">本のカテゴリ：</td>
        <td ><?= $source_category[$cs] ?></td>
    </tr>
    <tr>
        <td  bold nowrap="nowrap" align="right">副題：</td>
        <td ><?= $SOURCE['source_subtitle'] ?>&nbsp;</td>
    </tr>
    <tr>
        <td  bold nowrap="nowrap" align="right">著者：</td>
        <td ><?= $SOURCE['source_author'] ?>&nbsp;</td>
    </tr>
    <tr>
        <td  bold nowrap="nowrap" align="right">訳者：</td>
        <td ><?= $SOURCE['source_translator'] ?>&nbsp;</td>
    </tr>
    <tr>
        <td  bold nowrap="nowrap" align="right">出版社：</td>
        <td ><?= $SOURCE['source_company'] ?>&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr valign=top>
        <td  bold nowrap="nowrap" align="right">本の内容：</td>
        <td  colspan="2"><?= nl2br(str_replace("<br>", "", $SOURCE['source_value'])) ?>&nbsp;</td>
    </tr>
</table>

<br>

<?php
if ($SOURCE_ID) {
    $sql = "SELECT ";
    $sql .= "KOTOBA_ID, ";
    $sql .= "CS_ID       , ";
    $sql .= "SOURCE_ID   , ";
    $sql .= "KOTOBA_DATE , ";
    $sql .= "KOTOBA_VALUE, ";
    $sql .= "COMMENT      ";
    $sql .= "FROM KOTOBA_MASTER ";
    $sql .= "WHERE SOURCE_ID = $SOURCE_ID ";
    $sql .= "ORDER BY KOTOBA_DATE DESC";

    $result = pg_query($dbconn, $sql);

    $NUM = pg_numrows($result);
    if ($NUM != 0) {
        ?>
        <div id="maintitle">■この本から紹介している「今日のことば」■</div><br>
        <table class="list">
            <tr align=center>
                <td  bold bgcolor="#d9df7d" width="45%">この本からのことば</td>
                <td  bold bgcolor="#d9df7d" width="45%">感想</td>
                <td  bold bgcolor="#d2ee91" width="10%">掲載日</td>
            </tr>
            <?php
            for ($i = 0; $i < $NUM; $i++) {
                $KOTOBA_ID = pg_result($result, $i, 'KOTOBA_ID');
                $CS_ID = pg_result($result, $i, 'CS_ID');
                $SOURCE_ID = pg_result($result, $i, 'SOURCE_ID');
                $KOTOBA_DATE = pg_result($result, $i, 'KOTOBA_DATE');
                $KOTOBA_VALUE = strip_tags(pg_result($result, $i, 'KOTOBA_VALUE'));
                $COMMENT = strip_tags(pg_result($result, $i, 'COMMENT'));
                ?>
                <tr valign=top>
                    <td  bgcolor="#f6ffdf"><a href="/kotoba/view.php?kid=<?= $KOTOBA_ID; ?>">
                            <?= mb_substr($KOTOBA_VALUE, 0, 50) ?></a></td>
                    <td  bgcolor="#f6ffdf"><?= substr($COMMENT, 0, 100); ?></td>
                    <td  bgcolor="#f2fae5" nowrap="nowrap" valign="middle"><?= $KOTOBA_DATE; ?></td>
                </tr>
                <?php
            }
            ?>
        </table>

        <?php
    }
}
?>

<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/inc/foot_set_2column.inc' ?>
