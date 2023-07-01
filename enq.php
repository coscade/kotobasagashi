<?php
require_once 'inc/func.inc';
require_once 'class/inquiry.inc';

$dbconn = dbconn();

$ans_form = new Inquiry();

$ans_form->set_form($ANS);
$ans_form->set_action();
$ans_form->get_form_value();
$ans_form->set_check();

$ans_form->form['ans_ip']['value'] = $_SERVER['REMOTE_ADDR'];

if($ans_form->action == 'exec'){
  $ans_form->db_insert($dbconn,'ANS_MASTER');


  if($ans_form->form['ans_comment']['value'] != ""){
    $BODY = "
    アンケート結果

    メッセージ

    {$ans_form->form['ans_comment']['value']}
 
    ";
 
//    mb_send_mail("kamata@neta.jp", "アンケート結果", $BODY);
    mb_send_mail("mayu10080422@yahoo.co.jp", "アンケート結果", $BODY);
  }
  
  echo "
  <html>
    <body OnLoad=\"alert('アンケートにご協力ありがとうございました！');ans_form.submit();\">
      <form name=ans_form action=index.php method=post></form>
    </body>
  <html>
  ";
}else{


$sql = "SELECT ENQ_INFO , ENQ_{$ans_form->form['ans_value']['value']} FROM ENQ_MASTER WHERE ENQ_ID = {$ans_form->form['enq_id']['value']}";
$result = pg_query($dbconn,$sql);
$ENQ_INFO = pg_result($result,0,'ENQ_INFO');
$ENQ_ANS = pg_result($result,0,"enq_{$ans_form->form['ans_value']['value']}");

$CONTENTS_TITLE = "<div id=today>■アンケート■</div>";
require_once $INC_PATH.'head_set_1column.inc';

?>
<style type="text/css"><!--
div#enq {
width: 500px;
margin: 0;
padding: 6px;
text-align: left;
background: #EFFDE6;
border-left: 1px solid #C1DF7D;
border-top: 1px solid #C1DF7D;
border-right: 1px solid #95AD5E;
border-bottom: 1px solid #95AD5E;
}
--></style>

<div align=center>
<div id=enq>
<div id=kihon>


<br>

■アンケートにご協力ありがとうございます■

<br><br>

<form action=enq.php method=post>
<?$ans_form->view_form('enq_id');?>
<?$ans_form->view_form('ans_value');?>

■アンケート内容<br>
<?echo $ENQ_INFO;?>

<br><br>

■あなたの答え<br>
<?echo $ENQ_ANS;?>

<br><br>

<input type=submit name=submit value=送信>　<input type=button value=戻る onclick=pageBack()>


<br><br>

<table border=1 cellpadding=5 cellspacing=0 width=600 bgcolor=eeeeee>
  <tr>
    <td bgcolor=#c0c0c0>■もしよろしければその理由を教えてください。</td>
  </tr>
  <tr>
    <td><?$ans_form->view_form('ans_comment');?>&nbsp;</td>
  </tr>
</table>

</form>

</div>
</div>
</div>

<br><br>

<?php require_once $INC_PATH.'foot_set_1column.inc';?>

<?php }?>
