<?php require_once '../inc/func.inc' ?>
<?php require_once 'inc/admin_start.inc' ?>
<?php
$CONFIRM = isset($_POST['confirm']) ? $_POST['confirm'] : NULL;
$CS_ID = isset($_POST['cs_id']) ? $_POST['cs_id'] : NULL;
$KOTOBA_DATE = isset($_POST['kotoba_date']) ? $_POST['kotoba_date'] : NULL;
$SOURCE_NAME = isset($_POST['source_name']) ? $_POST['source_name'] : NULL;
$SOURCE_AUTHOR = isset($_POST['source_author']) ? $_POST['source_author'] : NULL;
$SOURCE_TRANSLATOR = isset($_POST['source_translator']) ? $_POST['source_translator'] : NULL;
$SOURCE_COMPANY = isset($_POST['source_company']) ? $_POST['source_company'] : NULL;
$SOURCE_VALUE = isset($_POST['source_value']) ? $_POST['source_value'] : NULL;
$KOTOBA_LEVEL = isset($_POST['kotoba_level']) ? $_POST['kotoba_level'] : NULL;
$KOTOBA_VALUE = isset($_POST['kotoba_value']) ? $_POST['kotoba_value'] : NULL;
$COMMENT = isset($_POST['comment']) ? $_POST['comment'] : NULL;
$SITUATION = isset($_POST['situation']) ? $_POST['situation'] : NULL;
$dbconn = dbconn();
$chk_sql = "SELECT COUNT(*) FROM KOTOBA_MASTER WHERE KOTOBA_VALUE = '$KOTOBA_VALUE'";
$chk_result = pg_exec($dbconn, $chk_sql);
if (pg_fetch_result($chk_result, 0, 0) == 0) {
    $sql = "INSERT INTO KOTOBA_MASTER( ";
    $sql .= " CS_ID,";
    $sql .= " KOTOBA_DATE,";
    $sql .= " KOTOBA_VALUE,";
    $sql .= " COMMENT )";
    $sql .= " VALUES(";
    $sql .= " '$CS_ID',";
    $sql .= " '$KOTOBA_DATE',";
    $sql .= " '$KOTOBA_VALUE',";
    $sql .= " '$COMMENT' )";
    pg_query($dbconn, $sql);
}
?>
ことばの登録が完了しました。
<form action="<?= "/admin/" ?>">
    <input type="submit" value="戻る">
</form>
<?php require_once 'inc/admin_end.inc' ?>
