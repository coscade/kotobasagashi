<?php
require_once 'inc/func.inc';

$afm_category_sub_id = isset($_GET['afm_category_sub_id']) ? $_GET['afm_category_sub_id'] : NULL;
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : NULL;

$CONTENTS_TITLE = "アファメーション一覧";
require_once $INC_PATH . 'head_set_2column.inc';

if ($afm_category_sub_id) {
    $sql = "SELECT ";
    $sql .= "A.afm_category_main_name ,   ";
    $sql .= "B.afm_category_sub_name    ";
    $sql .= "FROM ";
    $sql .= "afm_category_main AS A ";
    $sql .= "INNER JOIN ";
    $sql .= "afm_category_sub AS B ";
    $sql .= "ON ";
    $sql .= "A.afm_category_main_id = B.afm_category_main_id ";
    $sql .= "WHERE ";
    $sql .= "B.afm_category_sub_id = {$afm_category_sub_id} ";

    $result = pg_query($dbconn, $sql);
    $afm_list[$i] = pg_fetch_array($result, 0);

    $afm_category_main_name = pg_result($result, 0, 'afm_category_main_name');
    $afm_category_sub_name = pg_result($result, 0, 'afm_category_sub_name');
}

?>
    <div id="kihon">

    <br>

    <a href=afm.php>アファメーションページトップ</a>

    <br>

    <form action="afm_list.php">
        文字列検索：<input type=text name=keyword size=20 value="<?= $keyword ?>"><input type=submit value="検索">
    </form>
    <br>

    <?php if ($afm_category_sub_id) { ?>

        『<?= $afm_category_main_name ?>』　>>　『<?= $afm_category_sub_name ?>』

    <?php } ?>

    <br>

    <table border="0" cellpadding="0" cellspacing="0" width=530>
        <tr valign=top>
            <td bgcolor=#6da14b>
                <table border="0" cellpadding=5 cellspacing=1 width=100%>
                    <tr align=center>
                        <td id="kihonbold" bgcolor=#d2ee91>アファメーション</td>
                    </tr>
                    <?php
                    $sql = "SELECT ";
                    $sql .= "A.afm_id , ";
                    $sql .= "A.afm_value ";
                    $sql .= "FROM ";
                    $sql .= "afm_master AS A ";
                    $sql .= ($afm_category_sub_id != NULL) ? "INNER JOIN " : "";
                    $sql .= ($afm_category_sub_id != NULL) ? "afm_relation AS B " : "";
                    $sql .= ($afm_category_sub_id != NULL) ? "ON " : "";
                    $sql .= ($afm_category_sub_id != NULL) ? "A.afm_id = B.afm_id " : "";
                    $sql .= "WHERE ";
                    $sql .= "A.afm_id <> 0 ";
                    $sql .= ($afm_category_sub_id != NULL) ? "AND B.afm_category_sub_id = '{$afm_category_sub_id}' " : "";
                    $sql .= ($keyword != NULL) ? "AND A.afm_value~*'{$keyword}' " : "";
                    $sql .= "order by ";
                    $sql .= "A.afm_value asc ";

                    $result = pg_query($dbconn, $sql);
                    $NUM = pg_numrows($result);

                    for ($i = 0; $i < $NUM; $i++) {
                        $afm_list[$i] = pg_fetch_array($result, $i);

                        ?>
                        <tr valign=top>
                            <td id="kihon" bgcolor=#f6ffdf><?= nl2br($afm_list[$i][afm_value]) ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </td>
        </tr>
    </table>

<?php require_once $INC_PATH . 'foot_set_2column.inc'; ?>