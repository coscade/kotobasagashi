<?php require_once '../inc/func.inc'; ?>
<?php
require_once $INC_PATH . 'html_head.inc';
require_once $ROOT_PATH . 'admin/inc/admin_start.inc';
$dbconn = dbconn();

//処理タイプ
$P_TYPE = isset($_GET['p_type']) ? $_GET['p_type'] : NULL;
if ($P_TYPE == "") {
    $P_TYPE = isset($_POST['p_type']) ? $_POST['p_type'] : NULL;
}

if ($P_TYPE == "") {
    $P_TYPE = "0";
}


$sql = "SELECT cm_id,cm_name";
$sql .= " FROM category_master";

$result = pg_query($dbconn, $sql);
$num = pg_num_rows($result);

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
    $SOURCE_TRANSLATOR = isset($_POST['source_translator']) ? $_POST['source_translator'] :
        NULL;
    $SOURCE_COMPANY = isset($_POST['source_company']) ? $_POST['source_company'] : NULL;
    $SOURCE_VALUE = isset($_POST['source_value']) ? $_POST['source_value'] : NULL;
    $KOTOBA_LEVEL = isset($_POST['kotoba_level']) ? $_POST['kotoba_level'] : NULL;
    $KOTOBA_VALUE = isset($_POST['kotoba_value']) ? $_POST['kotoba_value'] : NULL;
    $COMMENT = isset($_POST['comment']) ? $_POST['comment'] : NULL;
    $SITUATION = isset($_POST['situation']) ? $_POST['situation'] : NULL;
}

?>

<form action="kotoba_2_confirm.php" name="input_form" method="post">
    <font class=info>

        <br>
        <table border="1" width="700" cellpadding=5 cellspacing="0">

            <tr>
                <td>
                    カテゴリー
                </td>
                <td>
                    <SELECT name="cm_id" OnChange=change_cm_id()>
                        <OPTION value="0">▼選択してください
                            <?php
                            for ($i = 0;
                            $i < $num;
                            $i++){
                            $CATEGORY['cm_id'] = pg_result($result, $i, 'CM_ID');
                            $CATEGORY['cm_name'] = pg_result($result, $i, 'CM_NAME');
                            ?>
                        <OPTION value="<?= $CATEGORY['cm_id']; ?>"
                            <?php if ($CM_ID == $CATEGORY['cm_id']) {
                                echo 'selected';
                            } ?>
                        ><?= $CATEGORY['cm_name']; ?>
                            <?php } ?>
                    </SELECT>
                </td>
            </tr>
            <tr>
                <td>
                    サブカテゴリー
                </td>
                <td>
                    <?php if ($CM_ID != "" && $CM_ID != 0) { ?>
                        <SELECT name="cs_id">
                            <?php
                            for ($i_cs = 0;
                            $i_cs < $num_cs;
                            $i_cs++){
                            $CATEGORY_S['cs_id'] = pg_result($result_cs, $i_cs, 'CS_ID');
                            $CATEGORY_S['cs_name'] = pg_result($result_cs, $i_cs, 'CS_NAME');
                            ?>
                            <OPTION value="<?= $CATEGORY_S['cs_id']; ?>"
                                <?php if ($CS_ID == $CATEGORY_S['cs_id']) {
                                    echo 'selected';
                                } ?>
                            ><?= $CATEGORY_S['cs_name']; ?>
                                <?php } ?>
                        </SELECT>
                    <?php } else { ?>
                        &nbsp;
                    <?php } ?>
                </td>
            </tr>
            <tr>
                <td>言葉</td>
                <td>
                    <textarea name="kotoba_value" rows=15 cols=70 warp=soft><?= $KOTOBA_VALUE; ?></textarea>
                </td>
            </tr>

            <tr>
                <td>感想</td>
                <td>
                    <textarea name="comment" rows=20 cols=70 warp=soft><?= $COMMENT; ?></textarea>
                </td>
            </tr>

            <tr align="left">
                <td>本の内容</td>
                <td>
                    <textarea name="source_value" rows=15 cols=70 warp=soft><?= $SOURCE_VALUE; ?></textarea>
                </td>
            </tr>

            <tr align="left">
                <td>表示日</td>
                <td>
                    <input type="text" name="kotoba_date" value="<?= $KOTOBA_DATE; ?>" size="20">
                </td>
            </tr>

            <tr align="left">
                <td>出典</td>
                <td>
                    <input type="text" name="source_name" value="<?= $SOURCE_NAME; ?>" size="20">
                </td>
            </tr>

            <tr align="left">
                <td>作者</td>
                <td>
                    <input type="text" name="source_author" value="<?= $SOURCE_AUTHOR; ?>" size="20">
                </td>
            </tr>

            <tr align="left">
                <td>訳者</td>
                <td>
                    <input type="text" name="source_translator" value="<?= $SOURCE_TRANSLATOR; ?>" size="20">
                </td>
            </tr>

            <tr align="left">
                <td>出版社</td>
                <td>
                    <input type="text" name="source_company" value="<?= $SOURCE_COMPANY; ?>" size="20">
                </td>
            </tr>

            <tr align="left">
                <td>評価</td>
                <td>
                    <select name="kotoba_level">
                        <option value=0 <?= $KOTOBA_LEVEL == NULL ? "selected" : ""; ?>>▼評価
                        <option value=1 <?= $KOTOBA_LEVEL == 1 ? "selected" : ""; ?>>1
                        <option value=2 <?= $KOTOBA_LEVEL == 2 ? "selected" : ""; ?>>2
                        <option value=3 <?= $KOTOBA_LEVEL == 3 ? "selected" : ""; ?>>3
                        <option value=4 <?= $KOTOBA_LEVEL == 4 ? "selected" : ""; ?>>4
                        <option value=5 <?= $KOTOBA_LEVEL == 5 ? "selected" : ""; ?>>5
                    </select>
                </td>
            </tr>


            <TR>
                <TD colspan="2" align="center">
                    <INPUT type="button" value="登録" onClick="submit_kotoba_regist_form()">
                    &nbsp;
                    <input type="button" value="戻る" onclick="back_mypage()"></td>
            </tr>
        </table>
        <br>
        <br>
    </font>
    <INPUT type="hidden" name="confirm" value=1>
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
<?php require_once $ROOT_PATH . 'admin/inc/admin_end.inc'; ?>
<?php require_once $INC_PATH . 'html_foot.inc'; ?>
