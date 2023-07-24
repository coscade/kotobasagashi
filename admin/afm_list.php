<?php require_once '../inc/func.inc' ?>
<?php require_once 'inc/admin_start.inc' ?>
<?php
$P_NUM = isset($_GET['p_num']) ? $_GET['p_num'] : 1;
$KEY = isset($_GET['key']) ? $_GET['key'] : NULL;
$AFM_ID = isset($_GET['afm_id']) ? $_GET['afm_id'] : NULL;
define('LIST_NUM', 20);

$sql1 = "SELECT count(*) from AFM_MASTER";
$result1 = pg_query($dbconn, $sql1);
$REC_CNT = pg_result($result1, 0, 0);
$LAST_PAGE = ($REC_CNT - ($REC_CNT % LIST_NUM)) / LIST_NUM + 1;
$OFFSET_NUM = ($P_NUM - 1) * LIST_NUM;
$LIMIT_NUM = LIST_NUM;

$sql = "SELECT ";
$sql .= "AFM_ID        , ";
$sql .= "AFM_VALUE     ";
$sql .= "FROM AFM_MASTER ";
$sql .= "WHERE AFM_VALUE is not null ";

$sql .= $KEY != NULL ? "AND AFM_VALUE like '%{$KEY}%' " : "";
$sql .= $AFM_ID != NULL ? "AND AFM_ID = {$AFM_ID} " : "";
$sql .= "ORDER BY AFM_ID DESC OFFSET $OFFSET_NUM  LIMIT $LIMIT_NUM";

$result = pg_query($dbconn, $sql);

$NUM = pg_numrows($result);
?>
<h2>アファメーション</h2>
<form>
    <a href="afm.php">新規登録</a>　
    ID検索<input type="text" name="afm_id" value="">　
    テキスト検索<input type="text" name="key" value="<?= $KEY ?>">　
    <input type="submit" value="検索">
</form>
<?php page_navi_view($LAST_PAGE, $P_NUM, NULL); ?>
<table class="list">
    <tr>
        <th width="20">ID</th>
        <th>内容</th>
        <th width="50">処理</th>
    </tr>
    <?php
    for ($i = 0; $i < $NUM; $i++) {
        $AFM_ID = pg_result($result, $i, 'AFM_ID');
        $AFM_VALUE = mb_substr(strip_tags(pg_result($result, $i, 'AFM_VALUE')), 0, 100);
        ?>
        <tr>
            <td><?= $AFM_ID ?>&nbsp;</td>
            <td><?= $AFM_VALUE ?>&nbsp;</td>
            <td>
                <form action="afm.php" method="post">
                    <input type="submit" value="編集" name="submit">
                    <input type="hidden" name="afm_id" value="<?= $AFM_ID ?>">
                </form>
            </td>
        </tr>
    <?php } ?>
</table>
<?php page_navi_view($LAST_PAGE, $P_NUM, NULL) ?>
<?php require_once 'inc/admin_end.inc' ?>
