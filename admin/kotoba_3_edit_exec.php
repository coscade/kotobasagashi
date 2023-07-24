<?php require_once '../inc/func.inc' ?>
<?php require_once 'inc/admin_start.inc' ?>
<?php
$KID = isset($_POST['kid']) ? $_POST['kid'] : NULL;
$CS_ID = isset($_POST['cs_id']) ? $_POST['cs_id'] : NULL;
$CONFIRM = isset($_POST['confirm']) ? $_POST['confirm'] : NULL;
$KOTOBA_DATE = isset($_POST['kotoba_date']) ? $_POST['kotoba_date'] : NULL;
$KOTOBA_VALUE = isset($_POST['kotoba_value']) ? $_POST['kotoba_value'] : NULL;
$COMMENT = isset($_POST['comment']) ? $_POST['comment'] : NULL;
$SITUATION = isset($_POST['situation']) ? $_POST['situation'] : NULL;
$dbconn = dbconn();
$chk_sql = "SELECT COUNT(*) FROM KOTOBA_MASTER WHERE KOTOBA_VALUE = '$KOTOBA_VALUE'";
$chk_result = pg_exec($dbconn, $chk_sql);
$sql = "UPDATE KOTOBA_MASTER SET ";
$sql .= " CS_ID = '$CS_ID',";
$sql .= " KOTOBA_DATE = '$KOTOBA_DATE',";
$sql .= " KOTOBA_VALUE = '$KOTOBA_VALUE',";
$sql .= " COMMENT= '$COMMENT'";
$sql .= " WHERE KOTOBA_ID = '$KID'";
pg_query($dbconn, $sql);
$sql = "SELECT SOURCE_ID FROM KOTOBA_MASTER WHERE KOTOBA_ID = '$KID'";
$result = pg_query($dbconn, $sql);
$SOURCE_ID = pg_result($result, 0, "SOURCE_ID");
?>
ことばの編集が完了しました。
<form action="source.php?source_id=<?= $SOURCE_ID ?>">
    <input type="submit" value="戻る">
</form>
<?php require_once 'inc/admin_end.inc' ?>
