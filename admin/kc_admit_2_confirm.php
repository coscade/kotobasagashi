<?php require_once '../inc/func.inc' ?>
<?php require_once 'inc/admin_start.inc' ?>
<?php
$KC_ID = isset($_GET['kc_id']) ? $_GET['kc_id'] : NULL;
$P_NUM = isset($_GET['p_num']) ? $_GET['p_num'] : NULL;
$dbconn = dbconn();
$sql = "SELECT ";
$sql .= " KC.KC_VALUE, ";
$sql .= " KC.KC_NAME, ";
$sql .= " KC.KC_MAIL,";
$sql .= " KC.KC_DELETE_KEY,";
$sql .= " KC.KC_IP,";
$sql .= " KC.KC_FLAG,";
$sql .= " KC.KC_TIMESTAMP,";
$sql .= " KM.KOTOBA_VALUE";
$sql .= " FROM KOTOBA_COMMENT KC,KOTOBA_MASTER KM";
$sql .= " WHERE KC.KC_ID=$KC_ID AND KC.KOTOBA_ID=KM.KOTOBA_ID";
$result = pg_query($dbconn, $sql);
$COMMENT['KC_VALUE'] = pg_result($result, 0, 'KC_VALUE');
$COMMENT['KC_NAME'] = pg_result($result, 0, 'KC_NAME');
$COMMENT['KC_MAIL'] = pg_result($result, 0, 'KC_MAIL');
$COMMENT['KC_DELETE_KEY'] = pg_result($result, 0, 'KC_DELETE_KEY');
$COMMENT['KC_IP'] = pg_result($result, 0, 'KC_IP');
$COMMENT['KC_FLAG'] = pg_result($result, 0, 'KC_FLAG');
$COMMENT['KC_TIMESTAMP'] = pg_result($result, 0, 'KC_TIMESTAMP');
$COMMENT['KOTOBA_VALUE'] = pg_result($result, 0, 'KOTOBA_VALUE');
?>
<h2>感想承認</h2>
以下の感想を承認しますか？<br>
よろしければ「承認」ボタンをクリックしてください。<br><br>
<TABLE class="detail">
    <tr>
        <td colspan="2"><?= $COMMENT['KOTOBA_VALUE'] ?></td>
    </tr>
    <tr>
        <th>名前</th>
        <td><?= $COMMENT['KC_NAME'] ?></td>
    </tr>
    <tr>
        <th>メールアドレス</th>
        <td><?= $COMMENT['KC_MAIL'] ?></td>
    </tr>
    <tr>
        <th>感想</th>
        <td><?= $COMMENT['KC_VALUE'] ?></td>
    </tr>
    <tr>
        <th>削除キー</th>
        <td><?= $COMMENT['KC_DELETE_KEY'] ?></td>
    </tr>
    <tr>
        <td>投稿者ホスト</td>
        <td><?= $COMMENT['KC_IP'] ?></td>
    </tr>
    <tr>
        <td>承認状態</td>
        <td>
            <?php if ($COMMENT['KC_FLAG'] == 0) {
                echo '未承認';
            } else if ($COMMENT['KC_FLAG'] == 2) {
                echo '非承認';
            } else {
                echo '承認済';
            } ?>
        </td>
    </tr>
    <tr>
        <td>投稿日時</td>
        <td><?= $COMMENT['KC_TIMESTAMP'] ?></td>
    </tr>
    <tr>
        <td colspan=2 align=center>
            <input type=button value="承認" onClick=submit_admit_form('ok');>&nbsp;
            <input type=button value="非承認" onClick=submit_admit_form('ng');>
            <br><br>
            <input type=button value=戻る onClick=submit_admit_form('back')>
        </td>
    </tr>
</table>
<FORM name="ok_form" action="kc_admit_3_exec.php" method="post">
    <INPUT type="hidden" name="kc_id" value="<?= $KC_ID ?>">
    <INPUT type="hidden" name="kc_flag" value="1">
</FORM>
<FORM name="ng_form" action="kc_admit_3_exec.php" method="post">
    <INPUT type="hidden" name="kc_id" value="<?= $KC_ID ?>">
    <INPUT type="hidden" name="kc_flag" value="2">
</FORM>
<FORM name="back_form" action="kc_admit_1_list.php" method="get">
    <INPUT type="hidden" name="p_num" value="<?= $P_NUM ?>">
</FORM>
<?php require_once 'inc/admin_end.inc' ?>
