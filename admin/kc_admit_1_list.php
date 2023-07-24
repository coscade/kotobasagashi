<?php require_once '../inc/func.inc' ?>
<?php require_once 'inc/admin_start.inc' ?>
<h2>感想承認</h2>
<?php
define('LIST_NUM', 20);
$P_NUM = isset($_GET['p_num']) ? $_GET['p_num'] : 1;
$P_NUM = ($P_NUM == null) ? 1 : $P_NUM;
comment_list_view($P_NUM);
?>
<?php require_once 'inc/admin_end.inc' ?>
