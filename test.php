<?php require_once 'inc/func.inc';?>
<?php
$TITLE = isset($_GET['title'])?$_GET['title']:NULL;
if($TITLE == NULL){
  $TITLE  = isset($_POST['title'])?$_POST['title']:NULL;
}
  $MAIL   = isset($_POST['mail'])?$_POST['mail']:NULL;
  $NAME   = isset($_POST['name'])?$_POST['name']:NULL;
  $MESSAGE   = isset($_POST['message'])?$_POST['message']:NULL;
  $SUBMIT = isset($_POST['onsubmit'])?1:NULL;

  if(strstr($MESSAGE , 'http://')){
  	$SUBMIT = 0;
  }


if($SUBMIT==1){

  $BODY = "
ユーザーからメールが送られました。

カテゴリ：『{$TITLE}』
メールアドレス：『{$MAIL}』
ニックネーム：『{$NAME}』

メッセージ
{$MESSAGE}

";

//  mb_send_mail("kamata@neta.jp", $TITLE, $BODY);
//  mb_send_mail("nqi04343@nifty.com", $TITLE, $BODY);
}

$CONTENTS_TITLE = "■
メールを送る■";
require_once $INC_PATH.'head_set_1column.inc';
?>

<style type="text/css"><!--
div#mail {
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
<div id=mail>
<div id=kihon>
<?if($SUBMIT == NULL){?>
<table border=0 width=100% cellspacing=0 cellpadding=5><form acton=mail.php method=post name="form">
  <tr>
    <td><?=$TITLE?>&nbsp;</td><input type=hidden name=title value="<?=$TITLE?>">
  </tr>
  <tr>
    <td>「今日のことば」の感想、思い、ご意見など何でも気軽にどうぞ！<br><br>
《注意》　URL（http://～）が書き込みされますと、いたずら<br>メール防止のために拒否されますので、相互リンクの<br>依頼のときなどは、最初はテキストのみでお送りください。<br>
こちらの方からのちほど、メールをお送りいたします。<br>
お手数かけますが、よろしくお願いいたします。<br><br>

　　　　<img src=../img/point_ko2.gif alt= width=22 height=17 border=0>
メールアドレス ：<input type=text name=mail size=30 value="<?=$MAIL?>"><br>
　　　　<img src=../img/point_ko2.gif alt= width=22 height=17 border=0>
ニックネーム  　：<input type=text name=name size=30 value="<?=$NAME?>"></td>
  </tr>
  <tr>
    <td><textarea name=message rows=10 cols=70><?=$MESSAGE?></textarea></td>
  </tr>
  <tr>
    <td align=center><input type=submit value=送信></td>
  </tr><input type="hidden" name="onsubmit" value="1"></form>
</table>
<?}else{?>
<table border=0 width=100% cellspacing=0 cellpadding=5>
  <tr>
    <td>主催者宛にメールを送りました。<P>ありがとうございました！&nbsp;</td>
  </tr>
</table>
<?}?>
</div>
</div>
</div>

<?php require_once $INC_PATH.'foot_set_1column.inc';?>
