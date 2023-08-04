<?php require_once '../inc/func.inc' ?>
<?php require_once 'inc/admin_start.inc' ?>
<?php
require_once $INC_PATH . 'conf.inc';
require_once $ROOT_PATH . 'class/inquiry.inc';

$SOURCE_ID = isset($_GET['source_id']) ? $_GET['source_id'] : NULL;

$dbconn = dbconn();

$form = new Inquiry();

$form->set_form($SOURCE);
$form->set_action();
$form->get_form_value();
$form->set_check();

if ($form->action == 'exec') {
    if ($form->mode == 'delete') {
        $form->db_delete($dbconn, 'SOURCE_MASTER', "SOURCE_ID = {$SOURCE_ID}");
    } elseif ($SOURCE_ID != NULL) {
        $form->db_update($dbconn, 'SOURCE_MASTER', "SOURCE_ID = {$SOURCE_ID}");
    } else {
        $oid = $form->db_insert($dbconn, 'SOURCE_MASTER');
        $sql = "SELECT SOURCE_ID FROM SOURCE_MASTER WHERE OID = {$oid}";
        $result = pg_query($dbconn, $sql);
        $SOURCE_ID = pg_result($result, 0, "SOURCE_ID");
    }
    echo "
  <SCRIPT LANGUAGE='JavaScript'>
  location.href= '/admin/source.php?source_id={$SOURCE_ID}';
  </SCRIPT>
  ";
} elseif (($form->action == 'edit') || (($form->action == 'input') && ($SOURCE_ID != NULL))) {
    $SOURCE = select_source($SOURCE_ID);
    foreach ($form->form as $key => $value) {
        $form->form[$key]['value'] = $SOURCE[$key];
    }
}
?>
<form action="source.php?source_id=<?= $SOURCE_ID ?>" method="post">
    <table class="detail">
        <tr>
            <th>本のカテゴリ</th>
            <td><?= $form->view_form('source_category') ?></td>
        </tr>
        <tr>
            <th>出典名</th>
            <td><?= $form->view_form('source_name') ?></td>
        </tr>
        <tr>
            <th>副題</th>
            <td><?= $form->view_form('source_subtitle') ?></td>
        </tr>
        <tr>
            <th>著者</th>
            <td><?= $form->view_form('source_author') ?></td>
        </tr>
        <tr>
            <th>訳者</th>
            <td><?= $form->view_form('source_translator') ?></td>
        </tr>
        <tr>
            <th>出版社</th>
            <td><?= $form->view_form('source_company') ?></td>
        </tr>
        <tr>
            <th>ASIN</th>
            <td><?= $form->view_form('source_asin') ?></td>
        </tr>
        <tr>
            <th>本の内容</th>
            <td><?= $form->view_form('source_value') ?></td>
        </tr>
        <tr>
            <th>本の評価</th>
            <td><?= $form->view_form('source_rec_level') ?></td>
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
                }
                ?>
            </td>
        </tr>
    </table>
</form>

<?php if ($SOURCE_ID) { ?>
    <h2>参照していることば</h2>
    <table class="list">
        <tr>
            <th>ことば</th>
            <th width="400">感想</th>
            <th width="100">掲載日</th>
            <th width="40">詳細</th>
        </tr>
        <?php
        $sql = "SELECT ";
        $sql .= "KOTOBA_ID, ";
        $sql .= "CS_ID       , ";
        $sql .= "SOURCE_ID   , ";
        $sql .= "KOTOBA_DATE , ";
        $sql .= "KOTOBA_VALUE, ";
        $sql .= "COMMENT      ";
        $sql .= "FROM KOTOBA_MASTER ";
        $sql .= "WHERE SOURCE_ID = $SOURCE_ID ";
        $sql .= "ORDER BY KOTOBA_DATE DESC";
        $result = pg_query($dbconn, $sql);
        $NUM = pg_numrows($result);
        for ($i = 0; $i < $NUM; $i++) {
            $KOTOBA_ID = pg_result($result, $i, 'KOTOBA_ID');
            $CS_ID = pg_result($result, $i, 'CS_ID');
            $SOURCE_ID = pg_result($result, $i, 'SOURCE_ID');
            $KOTOBA_DATE = pg_result($result, $i, 'KOTOBA_DATE');
            $KOTOBA_VALUE = mb_substr(strip_tags(pg_result($result, $i, 'KOTOBA_VALUE')), 0, 50);
            $COMMENT = mb_substr(strip_tags(pg_result($result, $i, 'COMMENT')), 0, 50);
            ?>
            <tr valign=top>
                <td><?= $KOTOBA_VALUE ?></td>
                <td><?= $COMMENT ?></td>
                <td><?= $KOTOBA_DATE; ?></td>
                <td><a href="kotoba_1_edit.php?kid=<?= $KOTOBA_ID ?>">詳細</a></td>
            </tr>
        <?php } ?>
    </table>
<?php } ?>
<form action="kotoba.php" method="post">
    <input type="hidden" name="submit" value="修正">
    <input type="hidden" name="source_id" value="<?= $SOURCE_ID ?>">
    <input type="submit" value="ことばの追加">
</form>
<?php require_once 'inc/admin_end.inc' ?>
