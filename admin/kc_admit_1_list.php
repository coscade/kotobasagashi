<?php require_once '../inc/func.inc';?>
<?
require_once $INC_PATH.'html_head.inc';
require_once $ROOT_PATH.'admin/inc/admin_start.inc';
?>
感想承認<BR><BR>
<?
define('LIST_NUM',20);
$P_NUM = isset($_GET['p_num'])?$_GET['p_num']:1;
$P_NUM = ($P_NUM==null)?1:$P_NUM;

comment_list_view($P_NUM);
?>
<?php require_once $ROOT_PATH.'admin/inc/admin_end.inc';?>
<?php require_once $INC_PATH.'html_foot.inc';?>
