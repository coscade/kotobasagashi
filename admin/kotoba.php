<?php require_once '../inc/func.inc' ?>
<?php require_once 'inc/admin_start.inc' ?>
<?php
require_once $INC_PATH . 'conf.inc';
require_once $ROOT_PATH . 'class/inquiry.inc';
$cs_id = NULL;
$CM_ID = isset($_POST['cm_id']) ? $_POST['cm_id'] : NULL;
$KOTOBA_ID = isset($_POST['kid']) ? $_POST['kid'] : NULL;
$source_id = isset($_POST['source_id']) ? $_POST['source_id'] : NULL;
$dbconn = dbconn();
$sql = "SELECT cm_id,cm_name";
$sql .= " FROM category_master";
$result = pg_query($dbconn, $sql);
$num = pg_num_rows($result);

if ($CM_ID != "" && $CM_ID != 0) {
    $sql_cs = " select   ";
    $sql_cs .= " cs_id ,  ";
    $sql_cs .= " cs_name  ";
    $sql_cs .= " from category_sub";
    $sql_cs .= " where cm_id = $CM_ID";
    $result_cs = pg_query($dbconn, $sql_cs);
    $num_cs = pg_num_rows($result_cs);
    for ($i_cs = 0; $i_cs < $num_cs; $i_cs++) {
        $CATEGORY_S['cs_id'] = pg_result($result_cs, $i_cs, 'CS_ID');
        $CATEGORY_S['cs_name'] = pg_result($result_cs, $i_cs, 'CS_NAME');
        $cs_id[$CATEGORY_S['cs_id']] = $CATEGORY_S['cs_name'];
        $a[$CATEGORY_S['cs_id']] = $CATEGORY_S['cs_name'];
    }
} else {
    $cs_id['0'] = '';
}
$form = new Inquiry();
$form->set_form($KOTOBA);
$form->set_action();
$form->get_form_value();
$form->set_check();
if ($form->action == 'exec') {
    if ($KOTOBA_ID != NULL) {
        $form->db_update($dbconn, 'KOTOBA_MASTER', "KOTOBA_ID = {$KOTOBA_ID}");
    } else {
        $form->db_insert($dbconn, 'KOTOBA_MASTER');
    }
} elseif ($form->action == 'edit') {
    foreach ($form->form as $key => $value) {
        $form->form[$key]['value'] = $KOTOBA[$key];
    }
}
?>
<form action="kotoba.php" name="input_form" method="post">
    <input type="hidden" name="source_id" value="<?= $source_id ?>">
    <table class="detail">
        <tr>
            <th>カテゴリー</th>
            <td>
                <SELECT name="cm_id" OnChange="change_cm_id2()">
                    <OPTION value="0">▼選択してください
                        <?php
                        for ($i = 0;$i < $num;$i++){
                        $CATEGORY['cm_id'] = pg_result($result, $i, 'CM_ID');
                        $CATEGORY['cm_name'] = pg_result($result, $i, 'CM_NAME');
                        ?>
                    <OPTION value="<?= $CATEGORY['cm_id']; ?>"
                        <?php if ($CM_ID == $CATEGORY['cm_id']) {
                            echo 'selected';
                        } ?>
                    >
                        <?= $CATEGORY['cm_name'] ?>
                        <?php } ?>
                </SELECT>
            </td>
        </tr>
        <tr>
            <th>サブカテゴリー</th>
            <td><?php $form->view_form('cs_id') ?></td>
        </tr>
        <tr>
            <th>言葉</th>
            <td><?php $form->view_form('kotoba_value') ?></td>
        </tr>
        <tr>
            <th>感想</th>
            <td><?php $form->view_form('comment') ?></td>
        </tr>
        <tr align="left">
            <th>表示日</th>
            <td><?php $form->view_form('kotoba_date') ?></td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <?php
                if ($form->action == 'input' || ($form->action == 'confirm' && !$form->check) || $form->action == 'edit') {
                    echo "<input type=submit name=submit value=確認>";
                } elseif ($form->action == 'confirm' && $form->check) {
                    echo "<input type=submit name=submit value=送信>　<input type=submit name=submit value=修正>";
                }
                ?>
            </td>
        </tr>
    </table>
    <br>
    <br>
    <INPUT type="hidden" name="confirm" value="1">
</form>
<form action="kotoba.php" name="change_cm_form" method="post">
    <input type="hidden" name="source_id">
    <input type="hidden" name="cm_id">
    <input type="hidden" name="cs_id">
    <input type="hidden" name="kotoba_value">
    <input type="hidden" name="comment">
    <input type="hidden" name="kotoba_date_y">
    <input type="hidden" name="kotoba_date_m">
    <input type="hidden" name="kotoba_date_d">
</form>
<?php require_once 'inc/admin_end.inc' ?>
