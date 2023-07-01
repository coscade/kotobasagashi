﻿<?php require_once '../inc/func.inc';?>
<?
$KC_ID = isset($_GET['kc_id'])?$_GET['kc_id']:NULL;
$P_NUM = isset($_GET['p_num'])?$_GET['p_num']:NULL;

require_once $INC_PATH.'html_head.inc';
require_once $ROOT_PATH.'admin/inc/admin_start.inc';

$dbconn = dbconn();

	$sql = "SELECT ";
	$sql .=" KC.KC_VALUE, ";
	$sql .=" KC.KC_NAME, ";
	$sql .=" KC.KC_MAIL,";
	$sql .=" KC.KC_DELETE_KEY,";
	$sql .=" KC.KC_IP,";
	$sql .=" KC.KC_FLAG,";
	$sql .=" KC.KC_TIMESTAMP,";
        $sql .=" KM.KOTOBA_VALUE";
	$sql .=" FROM KOTOBA_COMMENT KC,KOTOBA_MASTER KM";
	$sql .=" WHERE KC.KC_ID=$KC_ID AND KC.KOTOBA_ID=KM.KOTOBA_ID";
        
	$result = pg_query($dbconn,$sql);

        $COMMENT['KC_VALUE'] = pg_result($result,0,'KC_VALUE');
        $COMMENT['KC_NAME'] = pg_result($result,0,'KC_NAME');
        $COMMENT['KC_MAIL'] = pg_result($result,0,'KC_MAIL');
        $COMMENT['KC_DELETE_KEY'] = pg_result($result,0,'KC_DELETE_KEY');
        $COMMENT['KC_IP'] = pg_result($result,0,'KC_IP');
        $COMMENT['KC_FLAG'] = pg_result($result,0,'KC_FLAG');
        $COMMENT['KC_TIMESTAMP'] = pg_result($result,0,'KC_TIMESTAMP');
	$COMMENT['KOTOBA_VALUE'] = pg_result($result,0,'KOTOBA_VALUE');

?>
<CENTER>
以下の感想を承認しますか？<BR>
よろしければ「承認」ボタンをクリックしてください。<BR><BR>

<FONT class=info>
<TABLE border="1" cellpadding="5" cellspacing="0" width=500 bgcolor=eeeeee>
<TR>
<TH colspan="2" align="center" bgcolor="#C0C0C0">感想承認</TH>
</TR>
<TR>
<TD colspan="2">
<?echo $COMMENT['KOTOBA_VALUE'];?>
&nbsp;
</TD>
</TR>
<TR>
<TD>
名前
</TD>
<TD>
<?echo $COMMENT['KC_NAME'];?>
&nbsp;
</TD>
</TR>
<tr><td>
メールアドレス
</td><td>
<?echo $COMMENT['KC_MAIL'];?>&nbsp;
</td></tr>

<tr><td>
感想
</td><td>
<?echo $COMMENT['KC_VALUE'];?>
</td></tr>

<tr><td>
削除キー
</TD>
<TD>
<?echo $COMMENT['KC_DELETE_KEY'];?>
</td></tr>

<tr><td>
投稿者ホスト
</td><td>
<?echo $COMMENT['KC_IP'];?>
</td></tr>

<tr><td>
承認状態
</td><td>
<?if($COMMENT['KC_FLAG']==0){
echo '未承認';
}else if($COMMENT['KC_FLAG']==2){
echo '非承認';
}else{
echo '承認済';
}?>
</td></tr>

<tr><td>
投稿日時
</td><td>
<?echo $COMMENT['KC_TIMESTAMP'];?>
</td></tr>



<tr>
<td colspan=2 align=center><input type=button value="承認" 
onClick=submit_admit_form('ok');>&nbsp;
<input type=button value="非承認"
onClick=submit_admit_form('ng');>
<BR><BR>
<input type=button value=戻る onClick=submit_admit_form('back')></td>
</tr>
</table>
<BR><BR>
<FONT color="#FF0000">
</FONT>
<BR><BR><BR>
</CENTER>
<br><br>

</font>
<FORM name="ok_form" action="kc_admit_3_exec.php" method="post">
<INPUT type="hidden" name="kc_id" value="<?echo $KC_ID;?>">
<INPUT type="hidden" name="kc_flag" value="1">
</FORM>
<FORM name="ng_form" action="kc_admit_3_exec.php" method="post">
<INPUT type="hidden" name="kc_id" value="<?echo $KC_ID;?>">
<INPUT type="hidden" name="kc_flag" value="2">
</FORM>
<FORM name="back_form" action="kc_admit_1_list.php" method="get">
<INPUT type="hidden" name="p_num" value="<?echo $P_NUM;?>">
</FORM>


<?php require_once $ROOT_PATH.'admin/inc/admin_end.inc';;?>
<?php require_once $INC_PATH.'html_foot.inc';?>
