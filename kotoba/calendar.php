<?php
require_once '../inc/func.inc';
$YEAR = isset($_GET['y']) ? $_GET['y'] : date("Y", time());
$MONTH = isset($_GET['m']) ? $_GET['m'] : date("m", time());
$BEGIN_DATE = date("Y/m/d", mktime(0, 0, 0, $MONTH, 1, $YEAR));
$END_DATE = date("Y/m/d", mktime(0, 0, 0, $MONTH + 1, 1, $YEAR));
$dbconn = dbconn();
$CONTENTS_TITLE = "■「今日のことば」カレンダー　{$YEAR}年{$MONTH}月■";
require_once '../inc/head_set_2column2.inc';

$YEAR_START = 2001;
$YEAR_END = date("Y", time());
for ($y = $YEAR_END; $y >= $YEAR_START; $y--) {
    $MONTH_START = $y == 2001 ? 11 : 1;
    $MONTH_END = $y == date("Y", time()) ? date("m", time()) : 12;
    echo "<b>{$y}年　：　";
    for ($m = $MONTH_START; $m <= $MONTH_END; $m++) {
        echo "<a href=calendar.php?y={$y}&m={$m}>{$m}</a>　";
    }
    echo "<br>";
}
?>
<table class="list">
    <?php
    $sql = "SELECT ";
    $sql .= "KOTOBA_ID, ";
    $sql .= "KOTOBA_MASTER.CS_ID, ";
    $sql .= "CS_NAME, ";
    $sql .= "CM_NAME, ";
    $sql .= "KOTOBA_DATE, ";
    $sql .= "KOTOBA_VALUE ";
    $sql .= "FROM ";
    $sql .= "(KOTOBA_MASTER INNER JOIN CATEGORY_SUB ON KOTOBA_MASTER.CS_ID = CATEGORY_SUB.CS_ID) ";
    $sql .= "INNER JOIN CATEGORY_MASTER ON CATEGORY_SUB.CM_ID = CATEGORY_MASTER.CM_ID ";
    $sql .= "WHERE KOTOBA_DATE >= '{$BEGIN_DATE}' AND  KOTOBA_DATE < '{$END_DATE}' ";
    $sql .= "ORDER BY KOTOBA_DATE DESC";

    $result = pg_query($dbconn, $sql);
    $NUM = pg_num_rows($result);
    for ($i = 0; $i < $NUM; $i++) {
        $KOTOBA_ID = pg_result($result, $i, 'kotoba_id');
        $KOTOBA_DATE = pg_result($result, $i, 'kotoba_date');
        $KOTOBA_VALUE = nl2br(strip_tags(pg_result($result, $i, 'kotoba_value')));
        ?>
        <tr bgcolor="#F6FFDF">
            <td nowrap>
                <a href="view.php?kid=<?= $KOTOBA_ID ?>" id="categorylink"><?= $KOTOBA_DATE ?></a>
            </td>
            <td>
                <img src="/img/point_ko.gif" alt="" width="22" height="15">
                <?= $KOTOBA_VALUE ?>
            </td>
        </tr>
    <?php } ?>
</table>

<?php require_once($_SERVER["DOCUMENT_ROOT"] . '/inc/foot_set_2column2.inc') ?>

