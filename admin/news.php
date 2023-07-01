<?php require_once '../inc/func.inc';?>
<?php
require_once $INC_PATH.'html_head.inc';
require_once $ROOT_PATH.'admin/inc/admin_start.inc';
require_once $INC_PATH.'conf.inc';
require_once $ROOT_PATH.'class/inquiry.inc';

$NEWS_ID = isset($_POST['news_id'])?$_POST['news_id']:NULL;

$form = new Inquiry();

$form->set_form($NEWS);
$form->set_action();
$form->get_form_value();
$form->set_check();

if($form->action == 'exec'){
  if($form->mode == 'delete'){
    $form->db_delete($dbconn,'NEWS_MASTER',"NEWS_ID = {$NEWS_ID}");
  }elseif($NEWS_ID!=NULL){
    $form->db_update($dbconn,'NEWS_MASTER',"NEWS_ID = {$NEWS_ID}");
  }else{
    $form->db_insert($dbconn,'NEWS_MASTER');
  }
  echo "
  <SCRIPT LANGUAGE='JavaScript'>
  <!--
  location.href= '{$URL}admin/news_list.php';
  -->
  </SCRIPT>
  ";
}elseif(($form->action == 'edit')||(($form->action == 'input')&&($NEWS_ID != NULL))){
  $NEWS = get_table_data($dbconn, "news_master", "news_id", $NEWS_ID);
  foreach( $form->form as $key => $value) {
    $form->form[$key]['value'] = $NEWS[$key];
  }
}

?>
アファメーション<br>
<form action="news.php" method="post">
<input type=hidden name=news_id value="<?=$NEWS_ID?>">
<br>
<font class=info>
<table border = "1" width = "700" cellpadding=5 cellspacing="0" >
  <tr>
    <td>日付</td>
    <td><?$form->view_form('news_date');?>&nbsp;</td>
  </tr>
  <tr>
    <td>内容</td>
    <td><?$form->view_form('news_value');?>&nbsp;</td>
  </tr>
  <tr>
    <td>リンク</td>
    <td><?$form->view_form('news_link');?>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center">
<?php

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
