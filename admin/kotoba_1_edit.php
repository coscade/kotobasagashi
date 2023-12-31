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

$sql_cm = "SELECT cm_id,cm_name";
$sql_cm .= " FROM category_master";

$result_cm = pg_query($dbconn, $sql_cm);
$num_cm = pg_num_rows($result_cm);


$CM_ID = "";
$CS_ID = "";

//初期表示の場合
if ($P_TYPE == "0") {
    $KID = isset($_GET['kid']) ? $_GET['kid'] : NULL;

    $sql = "SELECT SOURCE_ID,K.CS_ID,S.CM_ID,KOTOBA_DATE,";
    $sql .= " KOTOBA_VALUE,COMMENT";
    $sql .= " FROM KOTOBA_MASTER K,CATEGORY_MASTER M,CATEGORY_SUB S";
    $sql .= " WHERE KOTOBA_ID = $KID AND M.CM_ID = S.CM_ID";
    $sql .= " AND S.CS_ID = K.CS_ID";

    $result = pg_query($dbconn, $sql);

    $KOTOBA_ID = $KID;
    $SOURCE_ID = pg_result($result, 0, 'SOURCE_ID');
    $CS_ID = pg_result($result, 0, 'CS_ID');
    $CM_ID = pg_result($result, 0, 'CM_ID');
    $KOTOBA_DATE = pg_result($result, 0, 'KOTOBA_DATE');
    $KOTOBA_VALUE = pg_result($result, 0, 'KOTOBA_VALUE');
    $COMMENT = pg_result($result, 0, 'COMMENT');

    //戻るから来た場合
} else if ($P_TYPE == "1") {

    $KID = isset($_POST['kid']) ? $_POST['kid'] : NULL;
    $SOURCE_ID = isset($_POST['source_id']) ? $_POST['source_id'] : NULL;
    $CS_ID = isset($_POST['cs_id']) ? $_POST['cs_id'] : NULL;
    $CM_ID = isset($_POST['cm_id']) ? $_POST['cm_id'] : NULL;
    $KOTOBA_DATE = isset($_POST['kotoba_date']) ? $_POST['kotoba_date'] : NULL;
    $KOTOBA_VALUE = isset($_POST['kotoba_value']) ? $_POST['kotoba_value'] : NULL;
    $COMMENT = isset($_POST['comment']) ? $_POST['comment'] : NULL;
} else if ($P_TYPE == "2") {
    $KID = isset($_POST['kid']) ? $_POST['kid'] : NULL;
    $SOURCE_ID = isset($_POST['source_id']) ? $_POST['source_id'] : NULL;
    $CM_ID = isset($_POST['cm_id']) ? $_POST['cm_id'] : NULL;
    $KOTOBA_DATE = isset($_POST['kotoba_date']) ? $_POST['kotoba_date'] : NULL;
    $KOTOBA_VALUE = isset($_POST['kotoba_value']) ? $_POST['kotoba_value'] : NULL;
    $COMMENT = isset($_POST['comment']) ? $_POST['comment'] : NULL;

}

$SOURCE = select_source($SOURCE_ID);

$sql_cs = "SELECT cs_id,cs_name";
$sql_cs .= " FROM category_sub";
$sql_cs .= " WHERE cm_id = $CM_ID";

$result_cs = pg_query($dbconn, $sql_cs);
$num_cs = pg_num_rows($result_cs);
?>

<form action="kotoba_2_edit_confirm.php" name="input_form" method="post">

    <table class="detail">
        <tr>
            <th>カテゴリー</th>
            <td>
                <SELECT name="cm_id" OnChange="change_cm_id()">
                    <OPTION value="0">▼選択してください
                        <?php
                        for ($i = 0;
                        $i < $num_cm;
                        $i++){
                        $CATEGORY['cm_id'] = pg_result($result_cm, $i, 'CM_ID');
                        $CATEGORY['cm_name'] = pg_result($result_cm, $i, 'CM_NAME');
                        ?>
                    <OPTION value="<?= $CATEGORY['cm_id'] ?>"
                        <?php if ($CM_ID == $CATEGORY['cm_id']) {
                            echo 'selected';
                        } ?>
                    ><?= $CATEGORY['cm_name'] ?>
                        <?php } ?>
                </SELECT>
            </td>
        </tr>
        <tr>
            <th>サブカテゴリー</th>
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
                    <INPUT type="hidden" name="cs_id" value="0">                    &nbsp;
                <?php } ?>
            </td>
        </tr>
        <tr>
            <th>言葉</th>
            <td>
            <textarea name="kotoba_value" rows=15 cols=70
                      warp=soft><?= str_replace('<br>', "\n", $KOTOBA_VALUE); ?></textarea>
            </td>
        </tr>
        <tr>
            <th>感想</th>
            <td>
                <textarea name="comment" rows=20 cols=70
                          warp=soft><?= str_replace('<br>', "\n", $COMMENT); ?></textarea>
            </td>
        </tr>
        <tr>
            <th>表示日</th>
            <td>
                <input type="date" name="kotoba_date" value="<?= $KOTOBA_DATE; ?>" size="20">
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <INPUT type="button" value="登録" onClick="submit_kotoba_regist_form()">                &nbsp;
                <INPUT type="button" value="削除" onClick="submit_kotoba_delete_form()">                &nbsp;
                <input type="button" value="戻る" onclick="back_mypage()">
            </td>
        </tr>
    </table>
    <INPUT type="hidden" name="confirm" value=1>
    <INPUT type="hidden" name="kid" value=<?= $KID; ?>>
    <input type="hidden" name="source_id" value="<?= $SOURCE['source_id']; ?>">
</FORM>

<form action="source.php" name="source" method="get">
    <table class="detail">
        <tr>
            <th colspan=2>出典</th>
        </tr>
        <tr>
            <th width=100>出典名</th>
            <td><?= $SOURCE['source_name']; ?></td>
        </tr>
        <tr>
            <th>作者</th>
            <td><?= $SOURCE['source_author']; ?></td>
        </tr>
        <tr>
            <th>訳者</th>
            <td><?= $SOURCE['source_translator']; ?></td>
        </tr>
        <tr>
            <th>出版社</th>
            <td><?= $SOURCE['source_company']; ?></td>
        </tr>
        <tr align="center">
            <td colspan=2>出典元の<input type=submit value="編集" name=submit></td>
        </tr>
    </table>
    <input type="hidden" name="source_id" value="<?= $SOURCE['source_id']; ?>">
</form>

<br><br>

<form action="kotoba_2_delete_confirm.php" name="delete_form" method="post">
    <input type="hidden" name="confirm" value=1>
    <input type="hidden" name="kid" value=<?= $KID; ?>>
</form>

<form action="kotoba_1_edit.php" name="change_cm_form" method="post">
    <input type="hidden" name="kid" value=<?= $KID; ?>>
    <input type="hidden" name="source_id">
    <input type="hidden" name="cm_id">
    <input type="hidden" name="cs_id">
    <input type="hidden" name="kotoba_value">
    <input type="hidden" name="comment">
    <input type="hidden" name="kotoba_date">
    <input type="hidden" name="p_type" value="2">
</form>
<?php require_once 'inc/admin_end.inc' ?>
