<?php
require_once '../inc/func.inc';
require_once $_SERVER["DOCUMENT_ROOT"] . '/inc/conf.inc';
require_once $_SERVER["DOCUMENT_ROOT"] . '/class/inquiry.inc';

$dbconn = dbconn();
$form = new Inquiry();
$form->set_form($EVAL);
$form->set_action();
$form->get_form_value();
$form->set_check();
$form->form['eval_ip']['value'] = $_SERVER['REMOTE_ADDR'];

// クッキーにセットしてあったら実行しない。
if (!$_COOKIE["KotobaEval"]) {
    if ($form->action == 'exec') {
        $form->db_insert($dbconn, 'EVAL_MASTER');
        $sql = "SELECT COUNT(EVAL_ID) AS EVAL_POINT, EVAL_VALUE FROM EVAL_MASTER WHERE KOTOBA_ID = {$form->form['kotoba_id']['value']} AND EVAL_VALUE = {$form->form['eval_value']['value']} GROUP BY EVAL_VALUE";
        $result = pg_query($dbconn, $sql);
        $COUNT = pg_result($result, 0, 'EVAL_POINT');
        $EVAL_VALUE = pg_result($result, 0, 'EVAL_VALUE');
        $sql2 = "UPDATE KOTOBA_MASTER SET EVAL_{$EVAL_VALUE} = $COUNT WHERE KOTOBA_ID = {$form->form['kotoba_id']['value']}";
        pg_query($dbconn, $sql2);
    }
}

$ret_url = "/kotoba/view.php?kid={$form->form['kotoba_id']['value']}&t=c";

// クッキーに8時間セット。
setcookie("KotobaEval", date("Y/m/d H:i:s"), time() + 3600 * 8);

if ($_COOKIE["KotobaEval"]) {
    echo '
  <SCRIPT LANGUAGE="JavaScript">
  <!--
  alert("一日に一回の規制にさせていただきました。\nどうぞ、よろしくお願いいたします。\nいつも、ありがとうございます。　<(_ _)>");
  location.href= "' . $ret_url . '";
  -->
  </SCRIPT>
  ';
} else {
    echo "
  <SCRIPT LANGUAGE='JavaScript'>
  <!--
  alert('ありがとうございます。ことばを評価しました。');
  location.href= '{$ret_url}';
  -->
  </SCRIPT>
  ";
}
