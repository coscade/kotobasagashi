<?php require_once '../inc/func.inc'; ?>
<?php
require_once $INC_PATH . 'html_head.inc';
require_once $ROOT_PATH . 'admin/inc/admin_start.inc';

$P_NUM = isset($_GET['p_num']) ? $_GET['p_num'] : 1;
$KEY = isset($_GET['key']) ? $_GET['key'] : NULL;
define('LIST_NUM', 20);

$dbconn = dbconn();

$sql1 = "SELECT count(*) from READING_MASTER";
$result1 = pg_query($dbconn, $sql1);
$REC_CNT = pg_result($result1, 0, 0);
$LAST_PAGE = ($REC_CNT - ($REC_CNT % LIST_NUM)) / LIST_NUM + 1;
$OFFSET_NUM = ($P_NUM - 1) * LIST_NUM;
$LIMIT_NUM = LIST_NUM;

$sql = "SELECT ";
$sql .= "READING_ID        , ";
$sql .= "B.SOURCE_NAME AS READING_TITLE      , ";
$sql .= "B.SOURCE_AUTHOR AS READING_AUTHOR    , ";
$sql .= "READING_DATE ";
$sql .= "FROM READING_MASTER AS A INNER JOIN SOURCE_MASTER AS B ON A.SOURCE_ID = B.SOURCE_ID ";
$sql .= $KEY != NULL ? "WHERE READING_NAME~'{$KEY}' OR READING_AUTHOR~'{$KEY}' " : "";
$sql .= "ORDER BY READING_DATE DESC OFFSET $OFFSET_NUM  LIMIT $LIMIT_NUM";

$result = pg_query($dbconn, $sql);

$NUM = pg_numrows($result);
?>

今読んでいる本<br><br>


<a href=reading.php>新規登録</a>

<br><br>
<?php page_navi_view($LAST_PAGE, $P_NUM, NULL); ?>

<table border="1" width="700" cellpadding=5 >
    <tr>
        <td width=20>ID</td>
        <td width=200>出典名</td>
        <td width=200>著者</td>
        <td width=100>登録日時</td>
        <td width=50>詳細</td>
    </tr>

    <?php
    for ($i = 0; $i < $NUM; $i++) {
        $READING_ID = pg_result($result, $i, 'READING_ID');
        $READING_TITLE = pg_result($result, $i, 'READING_TITLE');
        $READING_AUTHOR = pg_result($result, $i, 'READING_AUTHOR');
        $READING_DATE = pg_result($result, $i, 'READING_DATE');
        ?>
        <tr valign=top>
            <td><?= $READING_ID; ?>&nbsp;</td>
            <td><?= $READING_TITLE; ?>&nbsp;</td>
            <td><?= $READING_AUTHOR; ?>&nbsp;</td>
            <td><?= $READING_DATE; ?>&nbsp;</td>
            <td>
                <form action="reading.php" method="post">
                    <input type=submit value="編集" name=submit><input type=hidden name=reading_id
                                                                       value=<?= $READING_ID; ?>>
                </form>
            </td>
        </tr>
    <?php } ?>
</table>

<?php page_navi_view($LAST_PAGE, $P_NUM, NULL); ?>

<?php require_once $ROOT_PATH . 'admin/inc/admin_end.inc'; ?>
<?php require_once $INC_PATH . 'html_foot.inc'; ?>
