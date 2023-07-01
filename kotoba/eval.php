<?php
require_once '../inc/func.inc';
require_once $INC_PATH.'conf.inc';
require_once $ROOT_PATH.'class/inquiry.inc';

$dbconn = dbconn();

$form = new Inquiry();

$form->set_form($EVAL);
$form->set_action();
$form->get_form_value();
$form->set_check();

$form->form['eval_ip']['value'] = $_SERVER['REMOTE_ADDR'];

// クッキーにセットしてあったら実行しない。
if(!$_COOKIE["KotobaEval"]){
	if($form->action == 'exec'){
	    $form->db_insert($dbconn,'EVAL_MASTER');
	    
	    $sql = "SELECT COUNT(EVAL_ID) AS EVAL_POINT, EVAL_VALUE FROM EVAL_MASTER WHERE KOTOBA_ID = {$form->form['kotoba_id']['value']} AND EVAL_VALUE = {$form->form['eval_value']['value']} GROUP BY EVAL_VALUE";
	    $result = pg_query($dbconn,$sql);
	    $COUNT = pg_result($result,0,'EVAL_POINT');
	    $EVAL_VALUE = pg_result($result,0,'EVAL_VALUE');

	    $sql2 = "UPDATE KOTOBA_MASTER SET EVAL_{$EVAL_VALUE} = $COUNT WHERE KOTOBA_ID = {$form->form['kotoba_id']['value']}";
	    pg_query($dbconn,$sql2);

	//    $sql3 = "SELECT EVAL_1,EVAL_2,EVAL_3 FROM KOTOBA_MASTER WHERE KOTOBA_ID = {$form->form['kotoba_id']['value']}";
	//    $result3 = pg_query($dbconn,$sql3);
	//    $EVAL_1 = pg_result($result3,0,'EVAL_1');
	//    $EVAL_2 = pg_result($result3,0,'EVAL_2');
	//    $EVAL_3 = pg_result($result3,0,'EVAL_3');
	//    echo $form->form['eval_value']['value'] . ":eval_value:<br>";
	//    echo $EVAL_1 . ":eval_1:<br>";
	//    echo $EVAL_2 . ":eval_2:<br>";
	//    echo $EVAL_3 . ":eval_3:<br>";
	}
}


if(($_SERVER['HTTP_REFERER'] == $URL) || ($_SERVER['HTTP_REFERER'] == "{$URL}index.php")){
	$ret_url = $URL;
}else{
	$ret_url = "{$URL}kotoba/view.php?kid={$form->form['kotoba_id']['value']}&t=c";
}

// クッキーに8時間セット。
setcookie ("KotobaEval", date("Y/m/d H:i:s"), time()+3600*8);

//echo $ret_url;

if($_COOKIE["KotobaEval"]){
  echo '
  <SCRIPT LANGUAGE="JavaScript">
  <!--
  alert("一日に一回の規制にさせていただきました。\nどうぞ、よろしくお願いいたします。\nいつも、ありがとうございます。　<(_ _)>");
  location.href= "' . $ret_url . '";
  -->
  </SCRIPT>
  ';
}else{
  echo "
  <SCRIPT LANGUAGE='JavaScript'>
  <!--
  alert('ありがとうございます。ことばを評価しました。');
  location.href= '{$ret_url}';
  -->
  </SCRIPT>
  ";
}

?>