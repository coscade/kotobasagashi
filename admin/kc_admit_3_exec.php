<?php require_once '../inc/func.inc' ?>
<?php require_once 'inc/admin_start.inc' ?>
<?php
$KC_ID = isset($_POST['kc_id']) ? $_POST['kc_id'] : NULL;
$KC_FLAG = isset($_POST['kc_flag']) ? $_POST['kc_flag'] : NULL;
$dbconn = dbconn();
$sql = "UPDATE KOTOBA_COMMENT ";
$sql .= " SET KC_FLAG = '$KC_FLAG'";
$sql .= " WHERE KC_ID = '$KC_ID'";
pg_query($dbconn, $sql);
?>
<br><br><br><br>
<?php if ($KC_FLAG == 1) { ?>
    感想を承認しました。
<?php } else if ($KC_FLAG == 2) { ?>
    感想を非承認しました。
<?php } ?>
<br><br>
<form action='<?= $URL . "admin/kc_admit_1_list.php?p_num=1"; ?>' method=post>
    <input type=submit value=戻る>
</form>
<?php require_once 'inc/admin_end.inc' ?>
