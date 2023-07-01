<?php require_once '../inc/func.inc';?>
<?php
$CONFIRM = isset($_POST['confirm'])?$_POST['confirm']:NULL;
$KOTOBA_DATE = isset($_POST['kotoba_date'])?$_POST['kotoba_date']:NULL;
$SOURCE_NAME = isset($_POST['source_name'])?$_POST['source_name']:NULL;
$SOURCE_AUTHOR = isset($_POST['source_author'])?$_POST['source_author']:NULL;
$SOURCE_TRANSLATOR = isset($_POST['source_translator'])?$_POST['source_translator']:NULL;
$SOURCE_COMPANY = isset($_POST['source_company'])?$_POST['source_company']:NULL;
$SOURCE_VALUE = isset($_POST['source_value'])?$_POST['source_value']:NULL;
$KOTOBA_LEVEL =isset($_POST['kotoba_level'])?$_POST['kotoba_level']:NULL;
$KOTOBA_VALUE = isset($_POST['kotoba_value'])?$_POST['kotoba_value']:NULL;
$COMMENT = isset($_POST['comment'])?$_POST['comment']:NULL;
$SITUATION = isset($_POST['situation'])?$_POST['situation']:NULL;
$CM_ID = isset($_POST['cm_id'])?$_POST['cm_id']:NULL;
$CS_ID = isset($_POST['cs_id'])?$_POST['cs_id']:NULL;


$error_msg = NULL;

   if($KOTOBA_DATE == NULL){
   	$error_msg .= '日付が入力されていません。<br>';
   }
   if($SOURCE_VALUE == NULL){
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
<CENTER>
<?php if($CONFIRM=='1' && $error_msg==NULL){?>
入力内容は以下のデータで正しいですか？<br>
正しければ「登録完了」ボタンをクリックしてください。<br><br>

<FONT class=info>
<TABLE border="1" cellpadding="5" cellspacing="0" width=500 bgcolor=eeeeee>
<TR>
<TH colspan="2" align="center" bgcolor="#C0C0C0">ことば登録</TH>
</TR>
<TR>
<TD>
カテゴリー
</TD>
<TD>
<?php echo $CM_NAME;?>
&nbsp;
</TD>
</TR>
<TR>
<TD>
サブカテゴリー
</TD>
<TD>
<?php echo $CS_NAME;?>
&nbsp;
</TD>
</TR>


<tr><td>
言葉
</td><td>
<?php echo $KOTOBA_VALUE;?>
</td></tr>

<tr><td>
感想
</td><td>
<?php echo $COMMENT;?>
</td></tr>

<tr><td>
本の内容
</td><td>
<?php echo $SOURCE_VALUE;?>
</td></tr>

<tr><td>
日付
</td><td>
<?php echo $KOTOBA_DATE;?>
</td></tr>

<tr><td>
出典
</td><td>
<?php echo $SOURCE_NAME;?>
</td></tr>

<tr><td>
作者
</td><td>
<?php echo $SOURCE_AUTHOR;?>
</td></tr>

<tr><td>
訳者
</td><td>
<?php echo $SOURCE_TRANSLATOR;?>
</td></tr>

<tr><td>
出版社
</td><td>
<?php echo $SOURCE_COMPANY;?>
</td></tr>

<tr><td>
評価
</td><td>
<?php echo $KOTOBA_LEVEL;?>
</td></tr>

<tr>
<td colspan=2 align=center><input type=button value=編集完了 onClick=submit_user_edit_form('exec');>&nbsp;<input type=button value=戻る onClick=submit_user_edit_form('back')></td>
</tr>
</table>
<?php }else if($error_msg != NULL){?>
<br><br>
<FONT color="#FF0000">
<?php echo $error_msg;?>
</FONT>
<br><br><br>
<input type=button value=戻る onClick=submit_user_edit_form('back')>
<?php }?>
</CENTER>
<br><br>

</font>
<FORM name="exec_form" action="kotoba_3_exec.php" method="post">
<INPUT type="hidden" name="cs_id" value="<?php echo $CS_ID;?>">
<INPUT type="hidden" name="kotoba_date" value="<?php echo $KOTOBA_DATE;?>">
<INPUT type="hidden" name="source_name" value="<?php echo $SOURCE_NAME;?>">
<INPUT type="hidden" name="source_author" value="<?php echo $SOURCE_AUTHOR;?>">
<INPUT type="hidden" name="source_translator" value="<?php echo $SOURCE_TRANSLATOR;?>">
<INPUT type="hidden" name="source_company" value="<?php echo $SOURCE_COMPANY;?>">
<INPUT type="hidden" name="source_value" value="<?php echo $SOURCE_VALUE;?>">
<INPUT type="hidden" name="kotoba_level" value="<?php echo $KOTOBA_LEVEL;?>">
<INPUT type="hidden" name="kotoba_value" value="<?php echo $KOTOBA_VALUE;?>">
<INPUT type="hidden" name="comment" value="<?php echo $COMMENT;?>">
<INPUT type="hidden" name="situation" value="<?php echo $SITUATION;?>">
</FORM>
<FORM name=back_form action="kotoba_1_input.php" method="post">
<INPUT type="hidden" name="cm_id" value="<?php echo $CM_ID;?>">
<INPUT type="hidden" name="cs_id" value="<?php echo $CS_ID;?>">
<INPUT type="hidden" name="confirm" value="<?php echo $CONFIRM;?>">
<INPUT type="hidden" name="kotoba_date" value="<?php echo $KOTOBA_DATE;?>">
<INPUT type="hidden" name="source_name" value="<?php echo $SOURCE_NAME;?>">
<INPUT type="hidden" name="source_author" value="<?php echo $SOURCE_AUTHOR;?>">
<INPUT type="hidden" name="source_translator" value="<?php echo $SOURCE_TRANSLATOR;?>">
<INPUT type="hidden" name="source_company" value="<?php echo $SOURCE_COMPANY;?>">
<INPUT type="hidden" name="source_value" value="<?php echo $SOURCE_VALUE;?>">
<INPUT type="hidden" name="kotoba_level" value="<?php echo $KOTOBA_LEVEL;?>">
<INPUT type="hidden" name="kotoba_value" value="<?php echo $KOTOBA_VALUE;?>">
<INPUT type="hidden" name="comment" value="<?php echo $COMMENT;?>">
<INPUT type="hidden" name="situation" value="<?php echo $SITUATION;?>">
<INPUT type="hidden" name="p_type" value="1">
</FORM>


<?php require_once $ROOT_PATH.'admin/inc/admin_end.inc';;?>
<?php require_once $INC_PATH.'html_foot.inc';?>
