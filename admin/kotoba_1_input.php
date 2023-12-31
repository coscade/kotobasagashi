<?php require_once '../inc/func.inc' ?>
<?php require_once 'inc/admin_start.inc' ?>
<?php
$dbconn = dbconn();
//処理タイプ
$P_TYPE = isset($_GET['p_type']) ? $_GET['p_type'] : NULL;
if ($P_TYPE == "") {
    $P_TYPE = isset($_POST['p_type']) ? $_POST['p_type'] : NULL;
}
if ($P_TYPE == "") {
    $P_TYPE = "0";
}
$sql = "SELECT cm_id, cm_name FROM category_master ORDER BY cm_id ASC";
$res = pg_query($dbconn, $sql);
$cms = pg_fetch_all($res);

$sql = "SELECT cm_id, cs_id, cs_name FROM category_sub ORDER BY cm_id ASC , cs_id ASC";
$res = pg_query($dbconn, $sql);
$cs_list = pg_fetch_all($res);
foreach ($cs_list as $cs_data){
    $css[$cs_data['cm_id']][$cs_data['cs_id']] = $cs_data['cs_name'];
}

$CM_ID = "";
$CS_ID = "";
//初期表示の場合
if ($P_TYPE == "0") {
    $KOTOBA_DATE = date("Y/m/d");
    $SOURCE_NAME = "";
    $SOURCE_AUTHOR = "";
    $SOURCE_TRANSLATOR = "";
    $SOURCE_COMPANY = "";
    $SOURCE_VALUE = "";
    $KOTOBA_LEVEL = "";
    $KOTOBA_VALUE = "";
    $COMMENT = "";
    $SITUATION = "";
    //戻るから来た場合
} else if ($P_TYPE == "1") {
    $CM_ID = isset($_POST['cm_id']) ? $_POST['cm_id'] : NULL;
    $CS_ID = isset($_POST['cs_id']) ? $_POST['cs_id'] : NULL;
    $sql_cs = "SELECT cs_id,cs_name";
    $sql_cs .= " FROM category_sub";
    $sql_cs .= " WHERE cm_id = $CM_ID";
    $result_cs = pg_query($dbconn, $sql_cs);
    $num_cs = pg_num_rows($result_cs);
    $KOTOBA_DATE = isset($_POST['kotoba_date']) ? $_POST['kotoba_date'] : NULL;
    $SOURCE_NAME = isset($_POST['source_name']) ? $_POST['source_name'] : NULL;
    $SOURCE_AUTHOR = isset($_POST['source_author']) ? $_POST['source_author'] : NULL;
    $SOURCE_TRANSLATOR = isset($_POST['source_translator']) ? $_POST['source_translator'] : NULL;
    $SOURCE_COMPANY = isset($_POST['source_company']) ? $_POST['source_company'] : NULL;
    $SOURCE_VALUE = isset($_POST['source_value']) ? $_POST['source_value'] : NULL;
    $KOTOBA_LEVEL = isset($_POST['kotoba_level']) ? $_POST['kotoba_level'] : NULL;
    $KOTOBA_VALUE = isset($_POST['kotoba_value']) ? $_POST['kotoba_value'] : NULL;
    $COMMENT = isset($_POST['comment']) ? $_POST['comment'] : NULL;
    $SITUATION = isset($_POST['situation']) ? $_POST['situation'] : NULL;
} else if ($P_TYPE == "2") {
    $CM_ID = isset($_POST['cm_id']) ? $_POST['cm_id'] : NULL;
    $sql_cs = "SELECT cs_id,cs_name";
    $sql_cs .= " FROM category_sub";
    $sql_cs .= " WHERE cm_id = $CM_ID";
    $result_cs = pg_query($dbconn, $sql_cs);
    $num_cs = pg_num_rows($result_cs);
    $KOTOBA_DATE = isset($_POST['kotoba_date']) ? $_POST['kotoba_date'] : NULL;
    $SOURCE_NAME = isset($_POST['source_name']) ? $_POST['source_name'] : NULL;
    $SOURCE_AUTHOR = isset($_POST['source_author']) ? $_POST['source_author'] : NULL;
    $SOURCE_TRANSLATOR = isset($_POST['source_translator']) ? $_POST['source_translator'] : NULL;
    $SOURCE_COMPANY = isset($_POST['source_company']) ? $_POST['source_company'] : NULL;
    $SOURCE_VALUE = isset($_POST['source_value']) ? $_POST['source_value'] : NULL;
    $KOTOBA_LEVEL = isset($_POST['kotoba_level']) ? $_POST['kotoba_level'] : NULL;
    $KOTOBA_VALUE = isset($_POST['kotoba_value']) ? $_POST['kotoba_value'] : NULL;
    $COMMENT = isset($_POST['comment']) ? $_POST['comment'] : NULL;
    $SITUATION = isset($_POST['situation']) ? $_POST['situation'] : NULL;
}
?>
<form action="kotoba_2_confirm.php" name="input_form" method="post">
    <table class="detail">
        <tr>
            <th>カテゴリー</th>
            <td>
                <SELECT name="cm_id" id="cm_id">
                    <OPTION value="0">▼選択してください
                    <?php foreach ($cms as $cm){ ?>
                    <OPTION value="<?= $cm['cm_id'] ?>"<?= ($CM_ID == $cm['cm_id']) ? ' selected' : '' ?>><?= $cm['cm_name'] ?></OPTION>
                    <?php } ?>
                </SELECT>
                <script>
                    $('#cm_id').change(function(){
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
                <div id="cs">
                <?php foreach ($cms as $cm){ ?>
                <SELECT name="cs_id" class="cs<?=$cm['cm_id']?>" style="display: none">
                    <?php foreach ($css[$cm['cm_id']] as $cs_id => $cs_name){ ?>
                    <OPTION value="<?= $cs_id ?>"<?= ($CS_ID == $cs_id) ? ' selected' : '' ?>><?= $cs_name ?></OPTION>
                    <?php } ?>
                </SELECT>
                <?php } ?>
                </div>
            </td>
        </tr>
        <tr>
            <th>言葉</th>
            <td><textarea name="kotoba_value" rows="15" cols="70" warp="soft"><?= $KOTOBA_VALUE ?></textarea></td>
        </tr>
        <tr>
            <th>感想</th>
            <td>
                <textarea name="comment" rows="20" cols="70" warp="soft"><?= $COMMENT ?></textarea>
            </td>
        </tr>
        <tr>
            <th>本の内容</th>
            <td><textarea name="source_value" rows="15" cols="70" warp="soft"><?= $SOURCE_VALUE ?></textarea></td>
        </tr>
        <tr>
            <th>表示日</th>
            <td><input type="text" name="kotoba_date" value="<?= $KOTOBA_DATE ?>" size="20"></td>
        </tr>
        <tr>
            <th>出典</th>
            <td><input type="text" name="source_name" value="<?= $SOURCE_NAME ?>" size="20"></td>
        </tr>
        <tr>
            <th>作者</th>
            <td><input type="text" name="source_author" value="<?= $SOURCE_AUTHOR ?>" size="20"></td>
        </tr>
        <tr>
            <th>訳者</th>
            <td><input type="text" name="source_translator" value="<?= $SOURCE_TRANSLATOR ?>" size="20"></td>
        </tr>
        <tr>
            <th>出版社</th>
            <td><input type="text" name="source_company" value="<?= $SOURCE_COMPANY ?>" size="20"></td>
        </tr>
        <tr>
            <th>評価</th>
            <td>
                <select name="kotoba_level">
                    <option value="0" <?= $KOTOBA_LEVEL == NULL ? "selected" : "" ?>>▼評価
                    <option value="1" <?= $KOTOBA_LEVEL == 1 ? "selected" : "" ?>>1
                    <option value="2" <?= $KOTOBA_LEVEL == 2 ? "selected" : "" ?>>2
                    <option value="3" <?= $KOTOBA_LEVEL == 3 ? "selected" : "" ?>>3
                    <option value="4" <?= $KOTOBA_LEVEL == 4 ? "selected" : "" ?>>4
                    <option value="5" <?= $KOTOBA_LEVEL == 5 ? "selected" : "" ?>>5
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <INPUT type="button" value="登録" onClick="submit_kotoba_regist_form()">
                <input type="button" value="戻る" onclick="back_mypage()">
            </td>
        </tr>
    </table>
    <INPUT type="hidden" name="confirm" value="1">
</form>
<form action="kotoba_1_input.php" name="change_cm_form" method="post">
    <input type="hidden" name="cm_id">
    <input type="hidden" name="kotoba_value">
    <input type="hidden" name="comment">
    <input type="hidden" name="source_value">
    <input type="hidden" name="kotoba_date">
    <input type="hidden" name="source_name">
    <input type="hidden" name="source_author">
    <input type="hidden" name="source_translator">
    <input type="hidden" name="source_company">
    <input type="hidden" name="kotoba_level">
    <input type="hidden" name="p_type" value="2">
</form>
<?php require_once 'inc/admin_end.inc' ?>
