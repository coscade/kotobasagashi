<?php
require_once '../inc/func.inc';
$CMID = isset($_GET['cmid']) ? $_GET['cmid'] : NULL;
$CSID = isset($_GET['csid']) ? $_GET['csid'] : NULL;
$KEY = isset($_GET['key']) ? $_GET['key'] : NULL;
define('LIST_NUM', 30);
$P_NUM = isset($_GET['p_num']) ? $_GET['p_num'] : 1;

$dbconn = dbconn();

if ($CMID != NULL && $CSID == NULL) {
    $sqlcm = "SELECT ";
    $sqlcm .= "CM_ID, ";
    $sqlcm .= "CM_NAME ";
    $sqlcm .= "FROM CATEGORY_MASTER WHERE CM_ID = $CMID";
    $resultcm = pg_query($dbconn, $sqlcm);
    $CM_NAME = pg_result($resultcm, 0, 'CM_NAME');
    $CM_ID = pg_result($resultcm, 0, 'CM_ID');
} elseif ($CMID == NULL && $CSID != NULL) {
    $sqlcs = "SELECT ";
    $sqlcs .= "CATEGORY_SUB.CM_ID, ";
    $sqlcs .= "CM_NAME, ";
    $sqlcs .= "CS_NAME ";
    $sqlcs .= "FROM CATEGORY_MASTER,CATEGORY_SUB WHERE CATEGORY_MASTER.CM_ID = CATEGORY_SUB.CM_ID AND CS_ID = $CSID";
    $resultcs = pg_query($dbconn, $sqlcs);
    $CM_ID = pg_result($resultcs, 0, 'CM_ID');
    $CM_NAME = pg_result($resultcs, 0, 'CM_NAME');
    $CS_NAME = pg_result($resultcs, 0, 'CS_NAME');
} else {
    $CM_ID = NULL;
}

if ($CM_ID != NULL) {
    $sql_cs_list = " SELECT CS_NAME,CS_ID";
    $sql_cs_list .= " FROM CATEGORY_SUB";
    $sql_cs_list .= " WHERE CM_ID = '$CM_ID'";
    $resultcslist = pg_query($dbconn, $sql_cs_list);
    $num_cslist = pg_num_rows($resultcslist);
} elseif ($CMID == NULL && $CSID == NULL) {
    $sql_cm_list = " SELECT CM_NAME,CM_ID";
    $sql_cm_list .= " FROM CATEGORY_MASTER";
    $resultcmlist = pg_query($dbconn, $sql_cm_list);
    $num_cmlist = pg_num_rows($resultcmlist);
}

$CONTENTS_TITLE = "■「今日のことば」検索■";
require_once $INC_PATH . 'head_set_2column.inc';
?>
    <div id="kihon">


        カテゴリ：
        <?php
        if ($CMID != NULL && $CSID == NULL) {
            echo "<a href=list.php>TOP</a>　＞　<a href=list.php?cmid={$CMID}>{$CM_NAME}</a><br><br>";
        } elseif ($CMID == NULL && $CSID != NULL) {
            echo "<a href=list.php>TOP</a>　＞　<a href=list.php?cmid={$CM_ID}>{$CM_NAME}</a>　＞　<a href=list.php?csid={$CSID}>{$CS_NAME}</a><br><br>";
        } elseif ($CMID == NULL && $CSID == NULL) {
            echo "<a href=list.php>TOP</a>（全てのカテゴリから表示）<br><br>";
        }
        ?>


        <div id=categoryleft>
            <table border="0"  cellspan="0">
                <tr>
                    <?php
                    if ($CM_ID != NULL) {
                        for ($i = 0; $i < $num_cslist; $i++) {
                            $CS_ID = pg_result($resultcslist, $i, 'CS_ID');
                            $CS_NAME = pg_result($resultcslist, $i, 'CS_NAME');
                            echo (is_int($i / 3)) ? "<tr>" : "";
                            echo "<td><a href=list.php?csid={$CS_ID} id="categorylink">{$CS_NAME}</a></td><td>｜</td>";
                            echo (is_int($i + 1 / 3)) ? "</tr>\n" : "";
                        }
                    } elseif ($CMID == NULL && $CSID == NULL) {
                        for ($i = 0; $i < $num_cmlist; $i++) {
                            $CM_ID = pg_result($resultcmlist, $i, 'CM_ID');
                            $CM_NAME = pg_result($resultcmlist, $i, 'CM_NAME');
                            echo (is_int($i / 3)) ? "<tr>" : "";
                            echo "<td><a href=list.php?cmid={$CM_ID} id="categorylink">{$CM_NAME}</a></td><td>｜</td>";
                            echo (is_int($i + 1 / 3)) ? "</tr>\n" : "";
                        }
                    }
                    ?>
                </tr>
            </table>
        </div>

        <br>

        <?php
        kotoba_list_view($P_NUM, $CMID, $CSID, $KEY);
        ?>
    </div>

<?php
require_once $INC_PATH . 'foot_set_2column.inc';
?>