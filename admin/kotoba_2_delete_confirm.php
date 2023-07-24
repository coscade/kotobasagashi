<?php require_once '../inc/func.inc' ?>
<?php require_once 'inc/admin_start.inc' ?>
<?php
$KID = isset($_POST['kid']) ? $_POST['kid'] : NULL;
$CONFIRM = isset($_POST['confirm']) ? $_POST['confirm'] : NULL;
$error_msg = NULL;
$dbconn = dbconn();

$sql = "SELECT KOTOBA_DATE,";
$sql .= " KOTOBA_VALUE,COMMENT";
$sql .= " FROM KOTOBA_MASTER";
$sql .= " WHERE KOTOBA_ID = $KID";

$result = pg_query($dbconn, $sql);

$KOTOBA_ID = $KID;
$KOTOBA_DATE = pg_result($result, 0, 'KOTOBA_DATE');
$KOTOBA_VALUE = pg_result($result, 0, 'KOTOBA_VALUE');
$COMMENT = pg_result($result, 0, 'COMMENT');
$SITUATION = "";

?>
<CENTER>
    <?php if ($CONFIRM == '1' && $error_msg == NULL){ ?>
    以下のデータを削除してよろしいですか？<br>
    よろしければ「削除完了」ボタンをクリックしてください。<br><br>

    <FONT class=info>
        <TABLE border="1" cellpadding="5"  width=500 bgcolor=eeeeee>
            <TR>
                <TH colspan="2" align="center" bgcolor="#C0C0C0">ことば削除</TH>
            </TR>

            <tr>
                <td>
                    日付
                </td>
                <td>
                    <?= $KOTOBA_DATE; ?>
                </td>
            </tr>

            <tr>
                <td>
                    言葉
                </td>
                <td>
                    <?= $KOTOBA_VALUE; ?>
                </td>
            </tr>

            <tr>
                <td>
                    コメント
                </td>
                <td>
                    <?= $COMMENT; ?>
                </td>
            </tr>

            <tr>
                <td colspan=2 align=center><input type=button value=削除完了 onClick=submit_user_edit_form('exec');>&nbsp;<input
                            type=button value=戻る onClick=submit_user_edit_form('back')></td>
            </tr>
        </table>
        <?php } else if ($error_msg != NULL) { ?>
            <br><br>
            <FONT color="#FF0000">
                <?= $error_msg; ?>
            </FONT>
            <br><br><br>
            <input type=button value=戻る onClick=submit_user_edit_form('back')>
        <?php } ?>
</CENTER>
<br><br>

</font>
<FORM name="exec_form" action="kotoba_3_delete_exec.php" method="post">
    <INPUT type="hidden" name="kid" value="<?= $KID; ?>">
</FORM>
<FORM name=back_form action="kotoba_1_edit.php" method="GET">
    <INPUT type="hidden" name="kid" value="<?= $KID; ?>">
    <INPUT type="hidden" name="p_type" value="0">
</FORM>
<?php require_once 'inc/admin_end.inc' ?>
