<?php require_once '../inc/func.inc'; ?>
<?php
require_once $INC_PATH . 'html_head.inc';
require_once $ROOT_PATH . 'admin/inc/admin_start.inc';

$P_NUM = isset($_GET['p_num']) ? $_GET['p_num'] : 1;
$KEY = isset($_GET['key']) ? $_GET['key'] : NULL;
$NEWS_ID = isset($_GET['news_id']) ? $_GET['news_id'] : NULL;
define('LIST_NUM', 20);

$sql1 = "SELECT count(*) from NEWS_MASTER";
$result1 = pg_query($dbconn, $sql1);
$REC_CNT = pg_result($result1, 0, 0);
$LAST_PAGE = ($REC_CNT - ($REC_CNT % LIST_NUM)) / LIST_NUM + 1;
$OFFSET_NUM = ($P_NUM - 1) * LIST_NUM;
$LIMIT_NUM = LIST_NUM;

$sql = "SELECT ";
$sql .= "NEWS_ID        , ";
$sql .= "NEWS_DATE        , ";
$sql .= "NEWS_VALUE ,    ";
$sql .= "NEWS_link     ";
$sql .= "FROM NEWS_MASTER ";
$sql .= "WHERE NEWS_VALUE is not null ";

$sql .= $KEY != NULL ? "AND NEWS_VALUE like '%{$KEY}%' " : "";
$sql .= $NEWS_ID != NULL ? "AND NEWS_ID = {$NEWS_ID} " : "";
$sql .= "ORDER BY NEWS_ID DESC OFFSET $OFFSET_NUM  LIMIT $LIMIT_NUM";

$result = pg_query($dbconn, $sql);

$NUM = pg_numrows($result);
?>

ニュース<br>

<form>

    <a href=news.php>新規登録</a>　ID検索<input type=text name=news_id value="">　テキスト検索<input type=text name=key
                                                                                               value="<?= $KEY ?>">　<input
            type=submit value="検索">

</form>

<br>

<?php page_navi_view($LAST_PAGE, $P_NUM, NULL); ?>

<table border="1" width="670" cellpadding=5 cellspacing="0">
    <tr>
        <td nowrap>ID</td>
        <td nowrap>日付</td>
        <td>内容</td>
        <td nowrap>処理</td>
    </tr>

    <?php
    for ($i = 0; $i < $NUM; $i++) {
        $NEWS_ID = pg_result($result, $i, 'NEWS_ID');
        $NEWS_DATE = pg_result($result, $i, 'NEWS_DATE');
        $NEWS_VALUE = substr(strip_tags(pg_result($result, $i, 'NEWS_VALUE')), 0, 500);
        $NEWS_link = pg_result($result, $i, 'NEWS_link');
        ?>
        <tr valign=top>
            <td><?= $NEWS_ID; ?>&nbsp;</td>
            <td nowrap><?= $NEWS_DATE; ?>&nbsp;</td>
            <td><?= $NEWS_VALUE; ?>&nbsp;</td>
            <td>
                <form action="news.php" method="post">
                    <input type=submit value="編集" name=submit>
            </td>
            <input type=hidden name=news_id value=<?= $NEWS_ID; ?>></form>
        </tr>
    <?php } ?>
</table>

<?php page_navi_view($LAST_PAGE, $P_NUM, NULL); ?>

<?php require_once $ROOT_PATH . 'admin/inc/admin_end.inc'; ?>
<?php require_once $INC_PATH . 'html_foot.inc'; ?>
