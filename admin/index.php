<?php require_once '../inc/func.inc';?>
<?php
require_once $INC_PATH.'html_head.inc';
require_once $ROOT_PATH.'admin/inc/admin_start.inc';
?>
過去のことば一覧<BR><BR>
<?php
define('LIST_NUM',20);
$P_NUM = isset($_GET['p_num'])?$_GET['p_num']:1;
kotoba_list_view($P_NUM,NULL,NULL,NULL);
?>
<?php require_once $ROOT_PATH.'admin/inc/admin_end.inc';;?>
<?php require_once $INC_PATH.'html_foot.inc';?>
