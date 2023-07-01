<?php
require_once '../inc/func.inc';
require_once $INC_PATH.'html_head.inc';
require_once $ROOT_PATH.'admin/inc/admin_start.inc';

?>
<?php

$KID = isset($_POST['kid'])?$_POST['kid']:NULL;

$dbconn = dbconn();

$sql  = "DELETE FROM KOTOBA_MASTER  ";
$sql .=" WHERE KOTOBA_ID = '$KID'";

pg_query($dbconn , $sql);


?>

<br><br><BR>
<BR>
<CENTER>
ことばの削除が完了しました<br>
<br>


<form action='<?php echo $URL."admin/";?>' method=post>
<input type=submit value=戻る>
</form>
</CENTER>
<?php require_once $ROOT_PATH.'admin/inc/admin_end.inc';;?>
<?php require_once $INC_PATH.'html_foot.inc';?>
