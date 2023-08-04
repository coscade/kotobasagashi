<?php require_once '../inc/func.inc' ?>
<?php require_once 'inc/admin_start.inc' ?>
<?php
require_once $INC_PATH . 'conf.inc';
require_once $ROOT_PATH . 'class/inquiry.inc';

$source_id = isset($_POST['source_id']) ? $_POST['source_id'] : NULL;

$CM_ID = isset($_POST['cm_id']) ? $_POST['cm_id'] : NULL;
$CS_ID = isset($_POST['cs_id']) ? $_POST['cs_id'] : NULL;
$KOTOBA_ID = isset($_POST['kid']) ? $_POST['kid'] : NULL;
$dbconn = dbconn();

$sql = "SELECT cm_id, cm_name FROM category_master ORDER BY cm_id ASC";
$res = pg_query($dbconn, $sql);
$cms = pg_fetch_all($res);

$sql = "SELECT cm_id, cs_id, cs_name FROM category_sub ORDER BY cm_id ASC , cs_id ASC";
$res = pg_query($dbconn, $sql);
$cs_list = pg_fetch_all($res);
foreach ($cs_list as $cs_data) {
    $css[$cs_data['cm_id']][$cs_data['cs_id']] = $cs_data['cs_name'];
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

        $sql = "SELECT MAX(kotoba_id) AS kotoba_id FROM KOTOBA_MASTER";
        $res = pg_query($dbconn, $sql);
        $kid = pg_fetch_row($res)[0];
        header("Location:/admin/kotoba_1_edit.php?kid=" . $kid, true, 301);
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
                <SELECT name="cm_id" id="cm_id">
                    <OPTION value="0">▼選択してください
                        <?php foreach ($cms

                        as $cm){ ?>
                    <OPTION value="<?= $cm['cm_id'] ?>"<?= ($CM_ID == $cm['cm_id']) ? ' selected' : '' ?>><?= $cm['cm_name'] ?></OPTION>
                    <?php } ?>
                </SELECT>
                <script>
                    $('#cm_id').change(function () {
                        $('#cs select').each(function () {
                            if ($(this).hasClass('cs' + $('#cm_id').val())) {
                                $(this).prop('disabled', false);
                                $(this).show();
                                $(this).attr('required', true);
                            } else {
                                $(this).attr('required', false);
                                $(this).hide();
                                $(this).prop('disabled', true);
                            }
                        });
                    });
                </script>
            </td>
        </tr>
        <tr>
            <th>サブカテゴリー</th>
            <td>
                <?php if ($form->action == 'confirm') { ?>
                    <?php
                    $sql = "SELECT cs_name FROM category_sub WHERE cs_id = " . $form->form['cs_id']['value'];
                    $res = pg_query($dbconn, $sql);
                    $cs_name = pg_fetch_row($res)[0];
                    ?>
                    <?= $cs_name ?>
                    <input type="hidden" name="cs_id" value="<?= $form->form['cs_id']['value'] ?>">
                <?php } else { ?>
                    <div id="cs">
                        <?php foreach ($cms as $cm) { ?>
                            <SELECT name="cs_id" class="cs<?= $cm['cm_id'] ?>" style="display: none">
                                <?php foreach ($css[$cm['cm_id']] as $cs_id => $cs_name) { ?>
                                    <OPTION value="<?= $cs_id ?>"><?= $cs_name ?></OPTION>
                                <?php } ?>
                            </SELECT>
                        <?php } ?>
                    </div>
                <?php } ?>
            </td>
        </tr>
        <tr>
            <th>言葉</th>
            <td><?= $form->view_form('kotoba_value') ?></td>
        </tr>
        <tr>
            <th>感想</th>
            <td><?= $form->view_form('comment') ?></td>
        </tr>
        <tr align="left">
            <th>表示日</th>
            <td><?= $form->view_form('kotoba_date') ?></td>
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
