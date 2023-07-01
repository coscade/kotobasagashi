<?php require_once '../inc/func.inc';?>
<?
$KID = isset($_POST['kid'])?$_POST['kid']:NULL;
$CM_ID = isset($_POST['cm_id'])?$_POST['cm_id']:NULL;
$CS_ID = isset($_POST['cs_id'])?$_POST['cs_id']:NULL;
$CONFIRM = isset($_POST['confirm'])?$_POST['confirm']:NULL;
$KOTOBA_DATE = isset($_POST['kotoba_date'])?$_POST['kotoba_date']:NULL;
$KOTOBA_VALUE = isset($_POST['kotoba_value'])?$_POST['kotoba_value']:NULL;
$COMMENT = isset($_POST['comment'])?$_POST['comment']:NULL;

$error_msg = NULL;

   if($KOTOBA_DATE == NULL){
   	$error_msg .= '日付が入力されていません。<br>';
   }
   if($KOTOBA_VALUE == NULL){
   	$error_msg .= 'ことばが入力されていません。<br>';
   }
   if($COMMENT == NULL){
   	$error_msg .= 'コメントが入力されていません。<br>';
   }


require_once $INC_PATH.'html_head.inc';
require_once $ROOT_PATH.'admin/inc/admin_start.inc';
$dbconn = dbconn();

        $sql = "SELECT cm_id,cm_name";
        $sql .=" FROM category_master";
        $sql .=" WHERE cm_id = $CM_ID";

        $result = pg_query($dbconn,$sql);

        $CM_NAME = pg_result($result,0,'CM_NAME');

        $sql_cs = "SELECT cs_id,cs_name";
        $sql_cs .=" FROM category_sub";
        $sql_cs .=" WHERE cs_id = $CS_ID";

        $result_cs = pg_query($dbconn,$sql_cs);
        $num_cs = pg_num_rows($result_cs);

        $CS_NAME = pg_result($result_cs,0,'CS_NAME');

?>
<?if($CONFIRM=='1' && $error_msg==NULL){?>
入力内容は以下のデータで正しいですか？<BR>
正しければ「登録完了」ボタンをクリックしてください。<BR><BR>

<FONT class=info>
<TABLE border="1" cellpadding="5" cellspacing="0" width=700 bgcolor=eeeeee>
<TR>
<TH colspan="2" align="center" bgcolor="#C0C0C0">ことば登録</TH>
</TR>
<TR>
<TD>
カテゴリー
</TD>
<TD>
<?echo $CM_NAME;?>
&nbsp;
</TD>
</TR>
<TR>
<TD>
サブカテゴリー
</TD>
<TD>
<?echo $CS_NAME;?>
&nbsp;
</TD>
</TR>
<tr><td>
言葉
</td><td>
<?echo nl2br($KOTOBA_VALUE);?>
</td></tr>

<tr><td>
感想
</td><td>
<?echo nl2br($COMMENT);?>
</td></tr>

<tr><td>
日付
</td><td>
<?echo $KOTOBA_DATE;?>
</td></tr>

<tr>
<td colspan=2 align=center><input type=button value=編集完了 onClick=submit_user_edit_form('exec');>&nbsp;<input type=button value=戻る onClick=submit_user_edit_form('back')></td>
</tr>
</table>
<?}else if($error_msg != NULL){?>
<BR><BR>
<FONT color="#FF0000">
<? echo $error_msg;?>
</FONT>
<BR><BR><BR>
<input type=button value=戻る onClick=submit_user_edit_form('back')>
<?}?>
<br><br>

</font>
<FORM name='exec_form' action='kotoba_3_edit_exec.php' method='post'>
<INPUT type='hidden' name='kid' value='<?echo $KID;?>'>
<INPUT type='hidden' name='cs_id' value='<?echo $CS_ID;?>'>
<INPUT type='hidden' name='kotoba_date' value='<?echo $KOTOBA_DATE;?>'>
<INPUT type='hidden' name='kotoba_value' value='<?echo $KOTOBA_VALUE;?>'>
<INPUT type='hidden' name='comment' value='<?echo $COMMENT;?>'>
</FORM>
<FORM name=back_form action='kotoba_1_edit.php' method='post'>
<INPUT type='hidden' name='kid' value='<?echo $KID;?>'>
<INPUT type='hidden' name='cm_id' value='<?echo $CM_ID;?>'>
<INPUT type='hidden' name='cs_id' value='<?echo $CS_ID;?>'>
<INPUT type='hidden' name='confirm' value='<?echo $CONFIRM;?>'>
<INPUT type='hidden' name='kotoba_date' value='<?echo $KOTOBA_DATE;?>'>
<INPUT type='hidden' name='kotoba_value' value='<?echo $KOTOBA_VALUE;?>'>
<INPUT type='hidden' name='comment' value='<?echo $COMMENT;?>'>
<INPUT type='hidden' name='p_type' value='1'>
</FORM>


<?php require_once $ROOT_PATH.'admin/inc/admin_end.inc';;?>
<?php require_once $INC_PATH.'html_foot.inc';?>
