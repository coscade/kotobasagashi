<?php
require_once '../inc/func.inc';
$CONTENTS_TITLE = "■今日の「おすすめ本」■";
require_once $_SERVER["DOCUMENT_ROOT"] . '/inc/html_head.inc';

$READING_ID = isset($_GET['reading_id']) ? $_GET['reading_id'] : NULL;
$READING = select_reading($READING_ID);

$dbconn = dbconn();

$sql = "select reading_id, reading_date, reading_title from reading_master order by reading_date desc";
$result = pg_query($dbconn, $sql);
$NUM = pg_num_rows($result);

$P_NUM = isset($_GET['p_num']) ? $_GET['p_num'] : 1;
define('LIST_NUM', 30);
?>

<div id="content2">
    <nav>
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
    </nav>
    <main>
        <h1><?= $CONTENTS_TITLE ?></h1>
        <?php require 'top_menu.inc' ?>
        <div id="today_book">
            <h2>
                <?= date("Y年n月j日", strtotime($READING['reading_date'])) ?>
            </h2>           　
            <dl>
                <dt>タイトル</dt>
                <dd><?= $READING['reading_title'] ?></dd>
                <dt>著者</dt>
                <dd><?= $READING['reading_author'] ?></dd>
                <dt>出版社</dt>
                <dd><?= $READING['reading_company'] ?></dd>
                <dt>おすすめ度</dt>
                <dd><?= view_source_rec_level($READING['source_rec_level']) ?>
                    <a href="/" onclick="window.open('/popup.php', '', 'width=300,height=300')" target="_blank">
                        ※おすすめ度について
                    </a>
                </dd>
            </dl>
            <?php if ($READING['reading_asin'] ) { ?>
                <a href="https://www.amazon.co.jp/dp/<?= $READING['reading_asin'] ?>/ref=nosim?tag=aaaaea00-22" target="_blank" style="width:120px;float:right;">
                    <img src="https://images-na.ssl-images-amazon.com/images/P/<?= $READING['reading_asin'] ?>.09.LZZZZZZZ.jpg" style="width:100%;border: 1px solid black">
                </a>
            <?php } ?>
            <?= nl2br($READING['reading_value']) ?>
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

        <?php require_once $_SERVER["DOCUMENT_ROOT"] . '/inc/foot_set_2column.inc' ?>
