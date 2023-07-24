<?php require_once '../inc/func.inc' ?>
<?php require_once 'inc/admin_start.inc' ?>
<?php
require_once $INC_PATH . 'conf.inc';
require_once $ROOT_PATH . 'class/inquiry.inc';

$NEWS_ID = isset($_POST['news_id']) ? $_POST['news_id'] : NULL;

$form = new Inquiry();
$form->set_form($NEWS);
$form->set_action();
$form->get_form_value();
$form->set_check();

if ($form->action == 'exec') {
    if (isset($form->mode) && $form->mode == 'delete') {
        $form->db_delete($dbconn, 'NEWS_MASTER', "NEWS_ID = {$NEWS_ID}");
    } elseif ($NEWS_ID != NULL) {
        $form->db_update($dbconn, 'NEWS_MASTER', "NEWS_ID = {$NEWS_ID}");
    } else {
        $form->db_insert($dbconn, 'NEWS_MASTER');
    }
    header("Location:/admin/news_list.php", true, 301);
}

if (($form->action == 'edit') || (($form->action == 'input') && ($NEWS_ID != NULL))) {
    $NEWS = get_table_data($dbconn, "news_master", "news_id", $NEWS_ID);
    foreach ($form->form as $key => $value) {
        $form->form[$key]['value'] = $NEWS[$key];
    }
}
?>
<h2>ニュース詳細</h2>
<form action="news.php" method="post">
    <input type=hidden name=news_id value="<?= $NEWS_ID ?>">
    <table class="detail">
        <tr>
            <th>日付</th>
            <td><?php $form->view_form('news_date'); ?>&nbsp;</td>
        </tr>
        <tr>
            <th>内容</th>
            <td><?php $form->view_form('news_value'); ?>&nbsp;</td>
        </tr>
        <tr>
            <th>リンク</th>
            <td><?php $form->view_form('news_link'); ?>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">
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
<?php require_once 'inc/admin_end.inc' ?>
