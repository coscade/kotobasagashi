<?php require_once '../inc/func.inc';?>
<?
require_once $INC_PATH.'html_head.inc';
require_once $ROOT_PATH.'admin/inc/admin_start.inc';
require_once $INC_PATH.'conf.inc';
require_once $ROOT_PATH.'class/inquiry.inc';

$READING_ID = isset($_POST['reading_id'])?$_POST['reading_id']:NULL;


$dbconn = dbconn();

$form = new Inquiry();

$form->set_form($READING);
$form->set_action();
$form->get_form_value();
$form->set_check();

if($form->action == 'exec'){
  if($form->mode == 'delete'){
    $form->db_delete($dbconn,'READING_MASTER',"READING_ID = {$READING_ID}");
  }elseif($READING_ID!=NULL){
    $form->db_update($dbconn,'READING_MASTER',"READING_ID = {$READING_ID}");
  }else{
    $form->db_insert($dbconn,'READING_MASTER');
  }
  echo "
  <SCRIPT LANGUAGE='JavaScript'>
  <!--
  location.href= '{$URL}admin/reading_list.php';
  -->
  </SCRIPT>
  ";
}elseif(($form->action == 'edit')||(($form->action == 'input')&&($READING_ID != NULL))){
  $READING = select_reading($READING_ID);
  foreach( $form->form as $key => $value) {
    $form->form[$key]['value'] = $READING[$key];
  }
}

?>

<form action="reading.php" method="post">
<input type=hidden name=reading_id value="<?=$READING_ID?>">
<br>
<font class=info>
<table border = "1" width = "700" cellpadding=5 cellspacing="0" >
  <tr>
    <td>日付</td>
    <td><?$form->view_form('reading_date');?>&nbsp;</td>
  </tr>
  <tr>
    <td>本のID</td>
    <td><?$form->view_form('source_id');?>&nbsp;</td>
  </tr>
  <tr>
    <td>タイトル</td>
    <td><?$form->view_form('reading_title');?>&nbsp;</td>
  </tr>
  <tr>
    <td>著者</td>
    <td><?$form->view_form('reading_author');?>&nbsp;</td>
  </tr>
  <tr>
    <td>出版社</td>
    <td><?$form->view_form('reading_company');?>&nbsp;</td>
  </tr>
  <tr>
    <td>本の内容</td>
    <td><?$form->view_form('reading_value');?>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center">
<?

if($form->mode == 'delete'){
  echo"<input type=submit name=submit value=削除実行>　";
}elseif($form->action == 'input'||($form->action == 'confirm' && !$form->check) || $form->action=='edit'){
  echo"<input type=submit name=submit value=確認>　";
  echo"<input type=submit name=submit value=削除>　";
}elseif($form->action == 'confirm' && $form->check){
  echo"<input type=submit name=submit value=送信>　";
  echo"<input type=submit name=submit value=修正>　";
}elseif($form->mode == 'delete'){
  echo"<input type=submit name=submit value=削除実行>　";
}

?>
    </td>
  </tr>
</table>
</form>



<?php require_once $ROOT_PATH.'admin/inc/admin_end.inc';;?>
<?php require_once $INC_PATH.'html_foot.inc';?>
