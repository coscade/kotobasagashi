<?php
require_once '../inc/func.inc';

$KID = isset($_GET['kid']) ? $_GET['kid'] : NULL;
$T = isset($_GET['t']) ? $_GET['t'] : "a";

$dbconn = dbconn();

if ($KID == NULL) {
    $KOTOBA['ALL_NUM'] = get_kotoba_all_num();
    $KID = get_kotoba_random_num($KOTOBA['ALL_NUM']);
}

$sql = "SELECT ";
$sql .= "KOTOBA_ID, ";
$sql .= "KOTOBA_MASTER.SOURCE_ID, ";
$sql .= "CS_ID, ";
$sql .= "KOTOBA_DATE, ";
$sql .= "SOURCE_AUTHOR, ";
$sql .= "KOTOBA_VALUE, ";
$sql .= "COMMENT, ";
$sql .= "EVAL_1, ";
$sql .= "EVAL_2, ";
$sql .= "EVAL_3 ";
$sql .= "FROM KOTOBA_MASTER,SOURCE_MASTER WHERE KOTOBA_MASTER.SOURCE_ID = SOURCE_MASTER.SOURCE_ID AND KOTOBA_ID = $KID";

$result = pg_query($dbconn, $sql);

$KOTOBA['KOTOBA_ID'] = pg_result($result, 0, 'KOTOBA_ID');
$KOTOBA['SOURCE_ID'] = pg_result($result, 0, 'SOURCE_ID');
$KOTOBA['CS_ID'] = pg_result($result, 0, 'CS_ID');
$KOTOBA['KOTOBA_DATE'] = pg_result($result, 0, 'KOTOBA_DATE');
$KOTOBA['SOURCE_AUTHOR'] = pg_result($result, 0, 'SOURCE_AUTHOR');
$KOTOBA['KOTOBA_VALUE'] = pg_result($result, 0, 'KOTOBA_VALUE');
$KOTOBA['COMMENT'] = pg_result($result, 0, 'COMMENT');
$KOTOBA['EVAL_1'] = pg_result($result, 0, 'EVAL_1');
$KOTOBA['EVAL_2'] = pg_result($result, 0, 'EVAL_2');
$KOTOBA['EVAL_3'] = pg_result($result, 0, 'EVAL_3');

$sql = "SELECT ";
$sql .= "KOTOBA_ID AS LAST_KID ";
$sql .= "FROM ";
$sql .= "KOTOBA_MASTER ";
$sql .= "WHERE ";
$sql .= "KOTOBA_DATE < '{$KOTOBA['KOTOBA_DATE']}' ";
$sql .= "ORDER BY ";
$sql .= "KOTOBA_DATE DESC ";
$sql .= "LIMIT 1 ";
$result = @pg_query($dbconn, $sql);
$LAST_KID = @pg_result($result, 0, 'LAST_KID');

$sql = "SELECT ";
$sql .= "KOTOBA_ID AS NEXT_KID ";
$sql .= "FROM ";
$sql .= "KOTOBA_MASTER ";
$sql .= "WHERE ";
$sql .= "KOTOBA_DATE > '{$KOTOBA['KOTOBA_DATE']}' ";
$sql .= "ORDER BY ";
$sql .= "KOTOBA_DATE ASC ";
$sql .= "LIMIT 1 ";
$result = @pg_query($dbconn, $sql);
$NEXT_KID = @pg_result($result, 0, 'NEXT_KID');

$CS_ID = $KOTOBA['CS_ID'];

$sqlcs = "SELECT ";
$sqlcs .= "CATEGORY_SUB.CM_ID, ";
$sqlcs .= "CM_NAME, ";
$sqlcs .= "CS_NAME ";
$sqlcs .= " FROM CATEGORY_MASTER,CATEGORY_SUB WHERE ";
$sqlcs .= " CATEGORY_MASTER.CM_ID = CATEGORY_SUB.CM_ID AND CS_ID = $CS_ID";

$resultcs = pg_query($dbconn, $sqlcs);

$CM_ID = pg_result($resultcs, 0, 'CM_ID');
$CM_NAME = pg_result($resultcs, 0, 'CM_NAME');
$CS_NAME = pg_result($resultcs, 0, 'CS_NAME');

$sqlkc = "SELECT";
$sqlkc .= " KC_ID,KC_VALUE,KC_NAME,KC_SEX,KC_AGE,TO_CHAR(KC_TIMESTAMP,'YYYY年MM月DD日hh24時mi分') as KC_TIMESTAMP";
$sqlkc .= " FROM KOTOBA_COMMENT ";
$sqlkc .= " WHERE KC_FLAG='1' AND KOTOBA_ID='$KID' ORDER BY KC_TIMESTAMP DESC";

$resultkc = pg_query($dbconn, $sqlkc);
$NUM_KC = pg_num_rows($resultkc);

$SOURCE = select_source($KOTOBA['SOURCE_ID']);
$cs = $SOURCE['source_category'];


$CONTENTS_TITLE = date("■Y年m月d日", strtotime($KOTOBA['KOTOBA_DATE'])) . "の「今日のことば」■";
require_once $INC_PATH . 'head_set_2column.inc';
?>
<div id="kihon">
    <?php

    if ($LAST_KID != "") {
        echo "<a href='../kotoba/view.php?kid={$LAST_KID}' id='greenlink'>前日のことばを見る</a>";
    }

    if ($NEXT_KID != "") {
        echo "　　　　　　　　　　　　　　　　　　　　　　<a href='../kotoba/view.php?kid={$NEXT_KID}' id='greenlink'>次のことばを見る</a>";
    }
    echo "<br>";

    if (isset($KOTOBA['ALL_NUM'])) {
        echo "過去のことば{$KOTOBA['ALL_NUM']}件の中からランダム表示。（更新するたびに変わります。）<br><br>";
    }

    //echo "カテゴリ：<a href=list.php?cmid={$CM_ID}>{$CM_NAME}</a>　＞
    //<a href=list.php?csid={$CS_ID}>{$CS_NAME}</a><br><br>";
    ?>

    <table width="530" border="0" cellspacing="0" cellpadding="0">
        <tr valign=top>
            <td id="kihon">


                <!--↓今日のことば-->
                <div id="kotobamidashi"><img src="<?= $URL ?>img/point_ko.gif" alt="" width="25" height="20"
                                             border="0"/>「今日のことば」
                </div>
                <div id="kotobanakami">
                    <?= nl2br($KOTOBA['KOTOBA_VALUE']); ?><br><br>

                    <table border="0" cellspacing="0" cellpadding="0">
                        <?php if (($SOURCE['source_name'] != "")) { ?>
                            <tr>
                                <td width="9"><img src="<?= $URL ?>img/list_imd.gif" alt="" width="9" height="9"
                                                   border="0"></td>
                                <td width="5"><img src="<?= $URL ?>img/1pix0000.gif" alt="" width="5" height="1"
                                                   border="0"/></td>
                                <td width="60"><span class="sidemenu">出典元</span></td>
                                <td id="kihon"><a
                                            href=<?= $URL ?>book/view.php?sid=<?= $SOURCE['source_id']; ?>><?= $SOURCE['source_name']; ?></a>
                                </td>
                            </tr>
                            <tr>
                                <td width="9"><img src="<?= $URL ?>img/list_imd.gif" alt="" width="9" height="9"
                                                   border="0"></td>
                                <td width="5"><img src="<?= $URL ?>img/1pix0000.gif" alt="" width="5" height="1"
                                                   border="0"/></td>
                                <td nowrap><span class="sidemenu">おすすめ度</span></td>
                                <td id="kihon"><? view_source_rec_level($SOURCE['source_rec_level']); ?>&nbsp;<font
                                            size=1><a href=./ onclick="window.open('<?= $URL ?>popup.php', '',
                                        'width=300,height=300');" target=_blank>※おすすめ度について</a></font></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td width="9"><img src="<?= $URL ?>img/list_imd.gif" alt="" width="9" height="9" border="0">
                            </td>
                            <td width="5"><img src="<?= $URL ?>img/1pix0000.gif" alt="" width="5" height="1"
                                               border="0"/></td>
                            <td width="60"><span class="sidemenu">著者名</span></td>
                            <td id="kihon"><?= $SOURCE['source_author']; ?></td>
                        </tr>
                    </table>

                </div>
                <br>
                <!--↑今日のことば-->

                <?php if ($T == "b") { ?>
                    <!--↓読者の感想-->
                    <?php
                    for ($i = 0; $i < $NUM_KC; $i++) {
                        $KC['KC_ID'] = pg_result($resultkc, $i, 'KC_ID');
                        $KC['KC_VALUE'] = pg_result($resultkc, $i, 'KC_VALUE');
                        $KC['KC_NAME'] = pg_result($resultkc, $i, 'KC_NAME');
                        $KC['KC_SEX'] = pg_result($resultkc, $i, 'KC_SEX');
                        $KC['KC_AGE'] = pg_result($resultkc, $i, 'KC_AGE');
                        $KC['KC_TIMESTAMP'] = pg_result($resultkc, $i, 'KC_TIMESTAMP');
                        ?>
                        【<?= $KC['KC_NAME']; ?>】
                        　<?= ($KC['KC_SEX'] == 1) ? "男" : "女"; ?>性　<?= $KC['KC_AGE']; ?>歳　<?= $KC['KC_TIMESTAMP']; ?>
                        <div id="kotobanakami">
                            <?= nl2br($KC['KC_VALUE']); ?>
                        </div><br>
                    <?php } ?>
                    <form action=comment.php method=post>
                        <input type=hidden name=kotoba_id value=<?= $KID; ?>>
                        <input type=hidden name=submit value=修正>
                        <input type=submit value=感想を登録する>
                    </form>
                    <!--↑読者の感想-->
                <?php } else { ?>
                    <!--↓感想-->
                    <div id="kansoumidashi">
                        <img src="<?= $URL ?>img/point_ka.gif" alt="" width="22" height="15" border="0"/>まゆの感想
                    </div>
                    <div id="kansounakami">
                        <?= nl2br($KOTOBA['COMMENT']); ?>
                    </div>
                    <!--↑感想-->
                <?php } ?>

            </td>
            <td width="10">
                <img src="<?= $URL ?>img/1pix0000.gif" alt="" width="10" height="1" border="0"/>
            </td>
            <td width="140" valign="top">

                <!--↓右メニュー／ことば横-->
                <table width="140" border="0" cellspacing="0" cellpadding="0">
                    <tr valign="top">
                        <td width="5"><img src="<?= $URL ?>img/list_ime.gif" alt="" width="5" height="10" border="0"/>
                        </td>
                        <td width="5"><img src="<?= $URL ?>img/1pix0000.gif" alt="" width="5" height="1" border="0"/>
                        </td>
                        <td width="130"><a href="<?= $URL ?>kotoba/comment.php?kid=<?= $KOTOBA['KOTOBA_ID']; ?>"
                                           id="greenlink">「今日のことば」の<br>感想を送る→<br>気軽に書き込んで<br>くださいね。</a><br><br>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td width="5"><img src="<?= $URL ?>img/list_ime.gif" alt="" width="5" height="10" border="0 /">
                        </td>
                        <td width="5"><img src="<?= $URL ?>img/1pix0000.gif" alt="" width="5" height="1" border="0"/>
                        </td>
                        <br>
                        <td width="130"><a href="<?= $URL ?>kotoba/view.php?kid=<?= $KOTOBA['KOTOBA_ID']; ?>&t=b"
                                           id="greenlink">「今日のことば」の<br>感想を見る</a><span id="kihon">(感想<?= $NUM_KC ?>件)<br><br>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td width="5"><img src="<?= $URL ?>img/list_ime.gif" alt="" width="5" height="10" border="0 /">
                        </td>
                        <td width="5"><img src="<?= $URL ?>img/1pix0000.gif" alt="" width="5" height="1" border="0"/>
                        </td>
                        <td width="130"><span class="sidemenu">「今日のことば」は？</span></td>
                    </tr>
                    <tr valign="top">
                        <td width="5"><img src="<?= $URL ?>img/1pix0000.gif" alt="" width="5" height="10" border="0 /">
                        </td>
                        <td width="5"><img src="<?= $URL ?>img/1pix0000.gif" alt="" width="5" height="1" border="0"/>
                        </td>
                        <form action="<?= $URL ?>kotoba/eval.php" method="post">
                            <td width="130">
                                <div id="kotobatoukou">
                                    <input name="eval_value" type="radio" value="1">気に入った&nbsp;<br>
                                    <input name="eval_value" type="radio" value="2">そうでもない&nbsp;<br>
                                    <input name="eval_value" type="radio" value="3">どちらでもない&nbsp;<br>
                                    <input value="投稿する" type="submit"><br><br>
                                    ※参考にしますので<br>気軽に投稿お願いします<br><br>
                                    <input type=hidden name=submit value=送信>
                                    <input type=hidden name=kotoba_id value=<?= $KOTOBA['KOTOBA_ID']; ?>>
                                </div>
                        </form>
            </td>
        </tr>
        <?php
        $SUMEVAL = $KOTOBA['EVAL_1'] + $KOTOBA['EVAL_2'] + $KOTOBA['EVAL_3'];
        if ($SUMEVAL != 0) {
            $EVAL1_PAR = (int)($KOTOBA['EVAL_1'] / $SUMEVAL * 100);
            $EVAL2_PAR = (int)($KOTOBA['EVAL_2'] / $SUMEVAL * 100);
            $EVAL3_PAR = (int)($KOTOBA['EVAL_3'] / $SUMEVAL * 100);
            ?>
            <tr valign="top">
                <td width="5"><img src="<?= $URL ?>img/list_ime.gif" alt="" width="5" height="10" border="0"/></td>
                <td width="5"><img src="<?= $URL ?>img/1pix0000.gif" alt="" width="5" height="1" border="0"/></td>
                <td width="130"><span class="sidemenu">投稿の結果</span><br></td>
            </tr>
            <tr valign="top">
                <td width="5"><img src="<?= $URL ?>img/1pix0000.gif" alt="" width="5" height="10" border="0"/></td>
                <td width="5"><img src="<?= $URL ?>img/1pix0000.gif" alt="" width="5" height="1" border="0"/></td>
                <td width="130" id="kihon">
                    <table border="0" width=100% cellpadding=1 cellspacing=0>
                        <tr>
                            <td id=dokusyahyoka colspan=2><img src="1pix0000.gif" alt="" width="1" height="5"
                                                               border="0"><br>気に入った： <?= $KOTOBA['EVAL_1']; ?>pt
                            </td>
                        </tr>
                        <tr>
                            <td width=99%><img src="/img/list_imf.gif" width=<?= $EVAL1_PAR; ?>% height="8"
                                               border=1></td>
                            <td width=1% id=dokusyahyoka nowrap><?= $EVAL1_PAR; ?>%</td>
                        </tr>
                        <tr>
                            <td id=dokusyahyoka colspan=2><img src="1pix0000.gif" alt="" width="1" height="5"
                                                               border="0"><br>そうでもない： <?= $KOTOBA['EVAL_2']; ?>pt
                            </td>
                        </tr>
                        <tr>
                            <td width=99%><img src="/img/list_img.gif" width=<?= $EVAL2_PAR; ?>% height="8"
                                               border=1></td>
                            <td width=1% id=dokusyahyoka nowrap><?= $EVAL2_PAR; ?>%</td>
                        </tr>
                        <tr>
                            <td id=dokusyahyoka colspan=2><img src="1pix0000.gif" alt="" width="1" height="5"
                                                               border="0"><br>どちらでもない： <?= $KOTOBA['EVAL_3']; ?>pt
                            </td>
                        </tr>
                        <tr>
                            <td width=99%><img src="/img/list_imh.gif" width=<?= $EVAL3_PAR; ?>% height="8"
                                               border=1></td>
                            <td width=1% id=dokusyahyoka nowrap><?= $EVAL3_PAR; ?>%</td>
                        </tr>
                    </table>
                </td>
            </tr>
        <?php } ?>
        <tr>
            <td colspan="3"><img src="<?= $URL ?>img/1pix0000.gif" alt="" width="5" height="20" border="0"/></td>
        </tr>
        <tr valign="top">
            <td width="5"><img src="<?= $URL ?>img/list_ime.gif" alt="" width="5" height="10" border="0"/></td>
            <td width="5"><img src="<?= $URL ?>img/1pix0000.gif" alt="" width="5" height="1" border="0"/></td>
            <td width="130"><span class="sidemenu">メールマガジン(月～金)発行しています。</span><br></td>
        </tr>
        <tr valign="top">
            <td width="5"><img src="<?= $URL ?>img/1pix0000.gif" alt="" width="5" height="10" border="0 /"></td>
            <td width="5"><img src="<?= $URL ?>img/1pix0000.gif" alt="" width="5" height="1" border="0"/></td>
            <form action="<?= $URL ?>kotoba/eval.php" method="post">
                <td width="130">
                    <div id="kotobatoukou">バックナンバー、購読<br>解除は<a href="http://blog.mag2.com/m/log/0000158973"
                                                                   target="_blank">コチラ</a>から<br>
                    </div>
                </td>
        </tr>
    </table>
    <!--↑右メニュー／ことば横-->


    <!--↓右メニュー 本について-->
    <!--↑右メニュー 本について-->


    </td></tr></table>


    <?php require_once $INC_PATH . 'foot_set_2column.inc'; ?>
