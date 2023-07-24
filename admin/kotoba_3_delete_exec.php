<?php require_once '../inc/func.inc' ?>
<?php require_once 'inc/admin_start.inc' ?>
<?php
$KID = isset($_POST['kid']) ? $_POST['kid'] : NULL;
$dbconn = dbconn();
$sql = "DELETE FROM KOTOBA_MASTER ";
$sql .= " WHERE KOTOBA_ID = '$KID'";
pg_query($dbconn, $sql);
?>
<br><br><br><br>
ことばの削除が完了しました<br><br>
<form action='<?= $URL . "admin/"; ?>' method=post>
    <input type=submit value=戻る>
</form>
<?php require_once 'inc/admin_end.inc' ?>
