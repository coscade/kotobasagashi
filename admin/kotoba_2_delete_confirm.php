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
<h2>ことば削除</h2>
<?php if ($CONFIRM == '1' && $error_msg == NULL) { ?>
    以下のデータを削除してよろしいですか？<br>
    よろしければ「削除完了」ボタンをクリックしてください。<br><br>
    <TABLE class="detail">
        <tr>
            <td>日付</td>
            <td><?= $KOTOBA_DATE ?></td>
        </tr>
        <tr>
            <th>言葉</th>
            <td><?= $KOTOBA_VALUE ?></td>
        </tr>
        <tr>
            <th>コメント</th>
            <td><?= $COMMENT ?></td>
        </tr>
        <tr>
            <td colspan=2>
                <input type="button" value="削除完了" onClick="submit_user_edit_form('exec');">&nbsp;
                <input
                        type="button" value="戻る" onClick="submit_user_edit_form('back')">
            </td>
        </tr>
    </table>
<?php } else if ($error_msg != NULL) { ?>
    <div>
        <?= $error_msg ?>
    </div>
    <input type="button" value="戻る" onClick="submit_user_edit_form('back')">
<?php } ?>

<FORM name="exec_form" action="kotoba_3_delete_exec.php" method="post">
    <INPUT type="hidden" name="kid" value="<?= $KID ?>">
</FORM>
<FORM name=back_form action="kotoba_1_edit.php" method="GET">
    <INPUT type="hidden" name="kid" value="<?= $KID ?>">
    <INPUT type="hidden" name="p_type" value="0">
</FORM>
<?php require_once 'inc/admin_end.inc' ?>
