<?php require_once '../inc/func.inc'; ?>
<?php
require_once $INC_PATH . 'html_head.inc';
require_once $ROOT_PATH . 'admin/inc/admin_start.inc';
require_once $INC_PATH . 'conf.inc';
require_once $ROOT_PATH . 'class/inquiry.inc';

$DANJYO_ID = isset($_POST['danjyo_id']) ? $_POST['danjyo_id'] : NULL;


$dbconn = dbconn();

$form = new Inquiry();

$form->set_form($DANJYO);
$form->set_action();
$form->get_form_value();
$form->set_check();

if ($form->action == 'exec') {
    if ($form->mode == 'delete') {
        $form->db_delete($dbconn, 'DANJYO_MASTER', "DANJYO_ID = {$DANJYO_ID}");
    } elseif ($DANJYO_ID != NULL) {
        $form->db_update($dbconn, 'DANJYO_MASTER', "DANJYO_ID = {$DANJYO_ID}");
    } else {
        $form->db_insert($dbconn, 'DANJYO_MASTER');
    }
    echo "
  <SCRIPT LANGUAGE='JavaScript'>
  <!--
  location.href= '{$URL}admin/danjyo_list.php';
  -->
  </SCRIPT>
  ";
} elseif (($form->action == 'edit') || (($form->action == 'input') && ($DANJYO_ID != NULL))) {
    $DANJYO = select_danjyo($DANJYO_ID);
    foreach ($form->form as $key => $value) {
        $form->form[$key]['value'] = $DANJYO[$key];
    }
}

?>
今週の「ああ…こんなに違うのね」<br>
<form action="danjyo.php" method="post">
    <input type=hidden name=danjyo_id value="<?= $DANJYO_ID ?>">
    <br>
    <font class=info>
        <table border="1" width="700" cellpadding=5 cellspacing="0">
            <tr>
                <td>タイトル</td>
                <td><? $form->view_form('danjyo_title'); ?>&nbsp;</td>
            </tr>
            <tr>
                <td>内容</td>
                <td><? $form->view_form('danjyo_value'); ?>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <?php

                    if ($form->mode == 'delete') {
                        echo "<input type=submit name=submit value=削除実行>　";
                    } elseif ($form->action == 'input' || ($form->action == 'confirm' && !$form->check) || $form->action == 'edit') {
                        echo "<input type=submit name=submit value=確認>　";
                        echo "<input type=submit name=submit value=削除>　";
                    } elseif ($form->action == 'confirm' && $form->check) {
                        echo "<input type=submit name=submit value=送信>　";
                        echo "<input type=submit name=submit value=修正>　";
                    } elseif ($form->mode == 'delete') {
                        echo "<input type=submit name=submit value=削除実行>　";
                    }

                    ?>
                </td>
            </tr>
        </table>
</form>


<?php require_once $ROOT_PATH . 'admin/inc/admin_end.inc'; ?>
<?php require_once $INC_PATH . 'html_foot.inc'; ?>
