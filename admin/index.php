<?php require_once '../inc/func.inc' ?>
<?php require_once 'inc/admin_start.inc' ?>
<h2>過去のことば一覧</h2>
<a href="/admin/kotoba_1_input.php">新規登録</a>
<?php
define('LIST_NUM', 20);
$P_NUM = isset($_GET['p_num']) ? $_GET['p_num'] : 1;
kotoba_list_view($P_NUM, NULL, NULL, NULL);
?>
<?php require_once 'inc/admin_end.inc' ?>
