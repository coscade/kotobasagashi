<?php require_once '../inc/func.inc' ?>
<?php require_once 'inc/admin_start.inc' ?>
<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/inc/conf.inc';
require_once $ROOT_PATH . 'class/inquiry.inc';

$AFM_ID = isset($_POST['afm_id']) ? $_POST['afm_id'] : NULL;
$AFM_CATEGORY_MAIN_ID = isset($_POST['afm_category_main_id']) ? $_POST['afm_category_main_id'] : NULL;
$AFM_CATEGORY_SUB_ID = isset($_POST['afm_category_sub_id']) ? $_POST['afm_category_sub_id'] : NULL;

//カテゴリに追加
if ($AFM_ID && $AFM_CATEGORY_MAIN_ID && $AFM_CATEGORY_SUB_ID && ($_POST['afm_category_select_exec'] == "カテゴリに追加する")) {
    $sql = "insert into ";
    $sql .= "AFM_RELATION ";
    $sql .= "values ";
    $sql .= "({$AFM_CATEGORY_SUB_ID},{$AFM_ID}) ";

    $result = pg_query($dbconn, $sql);
}

//カテゴリから削除
if ($AFM_ID && $AFM_CATEGORY_SUB_ID && isset($_POST['afm_category_delete_exec']) && $_POST['afm_category_delete_exec'] == "解除") {
    $sql = "delete from ";
    $sql .= "AFM_RELATION ";
    $sql .= "where ";
    $sql .= "afm_category_sub_id = {$AFM_CATEGORY_SUB_ID} ";
    $sql .= "AND ";
    $sql .= "afm_id = {$AFM_ID} ";

    $result = pg_query($dbconn, $sql);
}

$form = new Inquiry();
$form->set_form($AFM);
$form->set_action();
$form->get_form_value();
$form->set_check();

if ($form->action == 'exec') {
    if (isset($form->mode) && $form->mode == 'delete') {
        $form->db_delete($dbconn, 'AFM_MASTER', "AFM_ID = {$AFM_ID}");
    } elseif ($AFM_ID != NULL) {
        $form->db_update($dbconn, 'AFM_MASTER', "AFM_ID = {$AFM_ID}");
    } else {
        $form->db_insert($dbconn, 'AFM_MASTER');
    }
    header("Location:/admin/afm_list.php", true, 301);
} elseif (($form->action == 'edit') || (($form->action == 'input') && ($AFM_ID != NULL))) {
    $AFM = get_table_data($dbconn, "afm_master", "afm_id", $AFM_ID);
    foreach ($form->form as $key => $value) {
        $form->form[$key]['value'] = $AFM[$key];
    }
}
?>
<h2>アファメーション</h2>
<form action="afm.php" method="post">
    <input type="hidden" name="afm_id" value="<?= $AFM_ID ?>">
    <table class="detail">
        <tr>
            <th>内容</th>
            <td><?php $form->view_form('afm_value') ?>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <?php
                if (isset($form->mode) && $form->mode == 'delete') {
                    echo "<input type=submit name=submit value=削除実行>　";
                } elseif ($form->action == 'input' || ($form->action == 'confirm' && !$form->check) || $form->action == 'edit') {
                    echo "<input type=submit name=submit value=確認>　";
                    echo "<input type=submit name=submit value=削除>　";
                } elseif ($form->action == 'confirm' && $form->check) {
                    echo "<input type=submit name=submit value=送信>　";
                    echo "<input type=submit name=submit value=修正>　";
                } elseif (isset($form->mode) && $form->mode == 'delete') {
                    echo "<input type=submit name=submit value=削除実行>　";
                }

                ?>
            </td>
        </tr>
    </table>
</form>

<?php if ($AFM_ID) { ?>
    <h2>所属しているカテゴリ</h2>
    <table class="list">
        <tr>
            <th>ID</th>
            <th>カテゴリ</th>
            <th>処理</th>
        </tr>
        <?php
        $sql = "SELECT ";
        $sql .= "A.AFM_CATEGORY_SUB_ID , ";
        $sql .= "A.AFM_CATEGORY_SUB_NAME ";
        $sql .= "FROM ";
        $sql .= "AFM_CATEGORY_SUB AS A ";
        $sql .= "INNER JOIN ";
        $sql .= "AFM_RELATION AS B ";
        $sql .= "ON A.AFM_CATEGORY_SUB_ID = B.AFM_CATEGORY_SUB_ID  ";
        $sql .= "WHERE ";
        $sql .= "B.AFM_ID = {$AFM_ID} ";
        $result = pg_query($dbconn, $sql);
        $NUM = pg_numrows($result);
        for ($i = 0; $i < $NUM; $i++) {
            $afm_relation_list[$i] = pg_fetch_array($result, $i);
            ?>
            <tr>
                <td><?= $afm_relation_list[$i]['afm_category_sub_id'] ?></td>
                <td><?= $afm_relation_list[$i]['afm_category_sub_name'] ?></td>
                <td>
                    <form method=post name=afm_category_delete>
                        <input type="submit" name="afm_category_delete_exec" value="解除">
                        <input type="hidden" name="afm_id" value="<?= $AFM_ID ?>">
                        <input type="hidden" name="afm_category_sub_id"
                               value="<?= $afm_relation_list[$i]['afm_category_sub_id'] ?>">
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
<?php } ?>

<form method="post" name="afm_category_select">
    <select name="afm_category_main_id" OnChange="document.afm_category_select.submit()">
        <?php
        $sql = "SELECT ";
        $sql .= "A.AFM_CATEGORY_MAIN_ID , ";
        $sql .= "A.AFM_CATEGORY_MAIN_NAME ";
        $sql .= "FROM ";
        $sql .= "AFM_CATEGORY_MAIN AS A ";

        $result = pg_query($dbconn, $sql);
        $NUM = pg_numrows($result);

        for ($i = 0; $i < $NUM; $i++) {
            $afm_category_main[$i] = pg_fetch_array($result, $i);
            ?>
            <option value="<?= $afm_category_main[$i]['afm_category_main_id'] ?>" <?php if ($afm_category_main[$i]['afm_category_main_id'] == $AFM_CATEGORY_MAIN_ID) {
                echo "selected";
            } ?>><?= $afm_category_main[$i]['afm_category_main_name'] ?></option>
        <?php } ?>
    </select>

    <?php if ($AFM_CATEGORY_MAIN_ID) { ?>
        <select name="afm_category_sub_id">
            <?php
            $sql = "SELECT ";
            $sql .= "A.AFM_CATEGORY_SUB_ID , ";
            $sql .= "A.AFM_CATEGORY_SUB_NAME ";
            $sql .= "FROM ";
            $sql .= "AFM_CATEGORY_SUB AS A ";
            $sql .= "WHERE ";
            $sql .= "A.AFM_CATEGORY_MAIN_ID = {$AFM_CATEGORY_MAIN_ID}";

            $result = pg_query($dbconn, $sql);
            $NUM = pg_numrows($result);

            for ($i = 0; $i < $NUM; $i++) {
                $afm_category_sub[$i] = pg_fetch_array($result, $i);
                ?>
                <option value="<?= $afm_category_sub[$i]['afm_category_sub_id'] ?>" <?php if ($afm_category_sub[$i]['afm_category_sub_id'] == $AFM_CATEGORY_SUB_ID) {
                    echo "selected";
                } ?>><?= $afm_category_sub[$i]['afm_category_sub_name'] ?></option>
            <?php } ?>
        </select>
    <?php } ?>

    <input type="submit" name="afm_category_select_exec" value="カテゴリに追加する">
    <input type="hidden" name="afm_id" value="<?= $AFM_ID ?>">
</form>
<?php require_once 'inc/admin_end.inc' ?>
