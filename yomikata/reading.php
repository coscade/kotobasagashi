<?php
require_once '../inc/func.inc';
$CONTENTS_TITLE = "■今日の「おすすめ本」■";
require_once $INC_PATH . 'head_set_1column2.inc';

$READING_ID = isset($_GET['reading_id']) ? $_GET['reading_id'] : NULL;
$READING = select_reading($READING_ID);

$dbconn = dbconn();

$sql = "select reading_id, reading_date, reading_title from reading_master order by reading_date desc";
$result = pg_query($dbconn, $sql);
$NUM = pg_num_rows($result);

$P_NUM = isset($_GET['p_num']) ? $_GET['p_num'] : 1;
define('LIST_NUM', 30);
?>

    <style type="text/css"><!--

        div#now {
            width: 550;
            margin: 0;
            padding: 6px;
            text-align: left;
            background-image: url(../img/kotoba_now_bg.jpg);
            background-repeat: no-repeat;
            border-left: 1px solid #C1DF7D;
            border-top: 1px solid #C1DF7D;
            border-right: 1px solid #95AD5E;
            border-bottom: 1px solid #95AD5E;
        }

        #now_date {
            font-size: 16px;
            font-weight: bold;
            line-height: 150%;
            color: #1D6504;
            border-bottom: 1px solid #C1DF7D;
        }

        #now_greentext {
            font-size: 14px;
            font-weight: bold;
            line-height: 150%;
            color: #1D6504;
        }

        #danjyo_leaf {
            vertical-align: middle;
        }

        --></style>

<?php require 'top_menu.inc'; ?>

    <table>
        <tr valign="top">
            <td width="150">

                <?php
                $sql_all = "SELECT COUNT(*) AS COUNT from reading_master";
                $result_all = pg_query($dbconn, $sql_all);
                $REC_CNT = pg_result($result_all, 0, 'COUNT');
                $LAST_PAGE = ($REC_CNT - ($REC_CNT % LIST_NUM)) / LIST_NUM + 1;
                $OFFSET_NUM = ($P_NUM - 1) * LIST_NUM;
                $LIMIT_NUM = LIST_NUM;
                $sql = "select A.READING_ID, A.READING_DATE, B.SOURCE_NAME from reading_master AS A inner JOIN SOURCE_MASTER AS B ON A.SOURCE_ID = B.SOURCE_ID ";
                $sql .= "ORDER BY A.reading_date DESC OFFSET $OFFSET_NUM  LIMIT $LIMIT_NUM";
                $result = pg_query($dbconn, $sql);
                $NUM = pg_num_rows($result);
                $FROM_NUM = $OFFSET_NUM + 1;
                $TO_NUM = $FROM_NUM + (LIST_NUM - 1);
                $QUERY = "";
                $QUERY .= NULL;
                ?>
                <?php page_navi_view_side($LAST_PAGE, $P_NUM, $QUERY) ?>
                <ul>
                    <?php for ($i = 0; $i < $NUM; $i++) { ?>
                        <li>
                            <a href="/yomikata/reading.php?reading_id=<?= pg_result($result, $i, 'READING_ID') ?>&p_num=<?= $P_NUM ?>">
                                <?= date("Y年n日j日", strtotime(pg_result($result, $i, 'READING_DATE'))) ?></a><br>
                            <?= pg_result($result, $i, 'SOURCE_NAME') ?><br><br>
                        </li>
                    <?php } ?>
                </ul>
                <?php page_navi_view_side($LAST_PAGE, $P_NUM, $QUERY) ?>

            </td>
            <td>

                <div id="now">
                    <table border="0" cellpadding="0" cellspacing="4" width="100%">
                        <tr>
                            <td colspan="3"
                                id="now_date"><?= date("Y年n月j日", strtotime($READING['reading_date'])) ?></td>
                        </tr>
                        <tr>
                            <td width="1%" id="kihon" nowrap>
                                <img src="/img/point_bo.gif" width="22" height="15" border="0" id="danjyo_leaf">タイトル
                            </td>
                            <td width=1% id="kihon">：</td>
                            <td width=98% id="now_greentext"><?= $READING['reading_title'] ?></td>
                        </tr>
                        <tr>
                            <td width=1% id="kihon"><img src=/img/point_bo.gif width=22 height=15 border="0"
                                                         id=danjyo_leaf>著者
                            </td>
                            <td width=1% id="kihon">：</td>
                            <td width=98% id=now_greentext><?= $READING['reading_author'] ?></td>
                        </tr>
                        <tr>
                            <td width=1% id="kihon"><img src=/img/point_bo.gif width=22 height=15 border="0"
                                                         id=danjyo_leaf>出版社
                            </td>
                            <td width="1%" id="kihon">：</td>
                            <td width="98%" id="now_greentext"><?= $READING['reading_company'] ?></td>
                        </tr>
                        <tr>
                            <td width="1%" id="kihon" nowrap>
                                <img src="/img/point_bo.gif" width="22" height="15" border="0" id="danjyo_leaf">おすすめ度
                            </td>
                            <td width="1%" id="kihon">：</td>
                            <td width="98%" id="now_greentext">
                                <?php view_source_rec_level($READING['source_rec_level']) ?>
                                <a href="/" onclick="window.open('/popup.php', '', 'width=300,height=300')" target="_blank">
                                    ※おすすめ度について
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td colspan=3 id="kihon">
                                <img src="/img/1pix0000.gif" alt="" width="1" height="20" border="0"><br>
                                <?php if ($READING['reading_asin'] != "") { ?>
                                    <table border="0" cellpadding=2 cellspacing="0" width=120 align="right">
                                        <tr>
                                            <td align=center>
                                                <iframe style="width:120px;height:240px;" marginwidth="0"
                                                        marginheight="0" scrolling="no" frameborder="0"
                                                        src="https://rcm-fe.amazon-adsystem.com/e/cm?ref=qf_sp_asin_til&t=aaaaea00-22&m=amazon&o=9&p=8&l=as1&IS2=1&detail=1&asins=<?= $READING['reading_asin'] ?>&linkId=dc50fe5693b9a0d2d8b1d7ee561eba63&bc1=000000&lt1=_blank&fc1=333333&lc1=0066c0&bg1=ffffff&f=ifr"></iframe>
                                            </td>
                                        </tr>
                                    </table>
                                <?php } ?>
                                <?= nl2br($READING['reading_value']) ?>
                            </td>
                        </tr>
                    </table>
                </div>

                <?php
                if ($READING['source_id']) {
                    $sql = "SELECT ";
                    $sql .= "KOTOBA_ID, ";
                    $sql .= "CS_ID       , ";
                    $sql .= "SOURCE_ID   , ";
                    $sql .= "KOTOBA_DATE , ";
                    $sql .= "KOTOBA_VALUE, ";
                    $sql .= "COMMENT      ";
                    $sql .= "FROM KOTOBA_MASTER ";
                    $sql .= "WHERE SOURCE_ID = {$READING['source_id']} ";
                    $sql .= "ORDER BY KOTOBA_DATE DESC";
                    $result = pg_query($dbconn, $sql);
                    $NUM = pg_numrows($result);
                    ?>
                    <?php if ($NUM != 0) { ?>
                        <table class="list">
                            <tr>
                                <th bgcolor="#d9df7d" width="45%">この本からのことば</th>
                                <th bgcolor="#d9df7d" width="45%">感想</th>
                                <th bgcolor="#d2ee91" width="10%">掲載日</th>
                            </tr>
                            <?php for ($i = 0; $i < $NUM; $i++) { ?>
                                <tr>
                                    <td>
                                        <a href="/kotoba/view.php?kid=<?= pg_result($result, $i, 'KOTOBA_ID') ?>">
                                            <?= mb_substr(strip_tags(pg_result($result, $i, 'KOTOBA_VALUE')), 0, 80) ?>
                                        </a>
                                    </td>
                                    <td><?= mb_substr(strip_tags(pg_result($result, $i, 'COMMENT')), 0, 80) ?></td>
                                    <td nowrap="nowrap"><?= pg_result($result, $i, 'KOTOBA_DATE') ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    <?php } ?>
                <?php } ?>
            </td>
        </tr>
    </table>

<?php require_once $INC_PATH . 'foot_set_1column2.inc'; ?>