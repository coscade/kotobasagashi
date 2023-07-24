<?php require_once '../inc/func.inc' ?>
<?php require_once 'inc/admin_start.inc' ?>
<h2>感想承認</h2>
<?php
define('LIST_NUM', 20);
$P_NUM = isset($_GET['p_num']) ? $_GET['p_num'] : 1;
$P_NUM = ($P_NUM == null) ? 1 : $P_NUM;

function comment_list_view($P_NUM)
{
    $FILE = "kc_admit_2_confirm.php";
    $dbconn = dbconn();
    $sql_all = "SELECT COUNT(*) AS COUNT FROM KOTOBA_COMMENT ";
    $result_all = pg_query($dbconn, $sql_all);
    $REC_CNT = pg_result($result_all, 0, 'COUNT');
    $LAST_PAGE = ($REC_CNT - ($REC_CNT % LIST_NUM)) / LIST_NUM + 1;
    $OFFSET_NUM = ($P_NUM - 1) * LIST_NUM;
    $LIMIT_NUM = LIST_NUM;
    $sql = "SELECT ";
    $sql .= " KC_ID, ";
    $sql .= " KOTOBA_ID, ";
    $sql .= " KC_VALUE, ";
    $sql .= " KC_NAME, ";
    $sql .= " KC_MAIL,";
    $sql .= " KC_DELETE_KEY,";
    $sql .= " KC_IP,";
    $sql .= " KC_FLAG,";
    $sql .= " to_char(KC_TIMESTAMP,'yyyy-mm-dd hh24:mi:ss') as KC_TIMESTAMP";
    $sql .= " FROM KOTOBA_COMMENT ";
    $sql .= " ORDER BY KC_TIMESTAMP DESC ,KC_FLAG ASC OFFSET {$OFFSET_NUM} LIMIT {$LIMIT_NUM}";

    $sql = "SELECT ";
    $sql .= " KOTOBA_COMMENT.KC_ID, ";
    $sql .= " KOTOBA_COMMENT.KOTOBA_ID, ";
    $sql .= " KOTOBA_COMMENT.KC_VALUE, ";
    $sql .= " KOTOBA_COMMENT.KC_NAME, ";
    $sql .= " KOTOBA_COMMENT.KC_MAIL,";
    $sql .= " KOTOBA_COMMENT.KC_DELETE_KEY,";
    $sql .= " KOTOBA_COMMENT.KC_IP,";
    $sql .= " KOTOBA_COMMENT.KC_FLAG,";
    $sql .= " to_char(KOTOBA_COMMENT.KC_TIMESTAMP,'yyyy-mm-dd hh24:mi:ss') as KC_TIMESTAMP , ";
    $sql .= " KOTOBA_DATE ";
    $sql .= " FROM KOTOBA_COMMENT inner JOIN KOTOBA_MASTER ON KOTOBA_COMMENT.KOTOBA_ID = KOTOBA_MASTER.KOTOBA_ID ";
    $sql .= " ORDER BY KOTOBA_COMMENT.KC_TIMESTAMP DESC ,KOTOBA_COMMENT.KC_FLAG ASC OFFSET $OFFSET_NUM  LIMIT $LIMIT_NUM";
    $result = pg_query($dbconn, $sql);
    $NUM = pg_num_rows($result);
    $FROM_NUM = $OFFSET_NUM + 1;
    $TO_NUM = $FROM_NUM + (LIST_NUM - 1);
    $NEXT_P = $P_NUM + 1;
    $PRE_P = $P_NUM - 1;
    echo '全' . $REC_CNT . '件中&nbsp;&nbsp;&nbsp;' . $FROM_NUM . '件目から' . $TO_NUM . '件目まで表示';
    kc_navi_view($PRE_P, $LAST_PAGE, $NEXT_P, $P_NUM);
    echo '<table class="list">';
    for ($i = 0; $i < $NUM; $i++) {
        $COMMENT['KC_ID'] = pg_result($result, $i, 'KC_ID');
        $COMMENT['KOTOBA_ID'] = pg_result($result, $i, 'KOTOBA_ID');
        $COMMENT['KC_VALUE'] = pg_result($result, $i, 'KC_VALUE');
        $COMMENT['KC_NAME'] = pg_result($result, $i, 'KC_NAME');
        $COMMENT['KC_MAIL'] = pg_result($result, $i, 'KC_MAIL');
        $COMMENT['KC_DELETE_KEY'] = pg_result($result, $i, 'KC_DELETE_KEY');
        $COMMENT['KC_IP'] = pg_result($result, $i, 'KC_IP');
        $COMMENT['KC_FLAG'] = pg_result($result, $i, 'KC_FLAG');
        $COMMENT['KC_TIMESTAMP'] = pg_result($result, $i, 'KC_TIMESTAMP');
        $COMMENT['KOTOBA_DATE'] = pg_result($result, $i, 'KOTOBA_DATE');
        echo <<< EOM
<tr valign="top"><td>
  <a href="/kotoba/view.php?kid={$COMMENT['KOTOBA_ID']}" target="_blank">{$COMMENT['KOTOBA_DATE']}</a>の言葉について↓<br>
   {$COMMENT['KC_VALUE']}....
  </td><td nowrap>
  <a href="{$FILE}?kc_id={$COMMENT['KC_ID']}&p_num={$P_NUM}">{$COMMENT['KC_TIMESTAMP']}</a>
  </td><TD>
EOM;
        if ($COMMENT['KC_FLAG'] == 0) {
            echo '未承認';
        } else if ($COMMENT['KC_FLAG'] == 2) {
            echo '非承認';
        } else {
            echo '承認済';
        }
        echo "</TD></tr>";
    }
    echo "</table>";
    kc_navi_view($PRE_P, $LAST_PAGE, $NEXT_P, $P_NUM);
}
function kc_navi_view($PRE_P, $LAST_PAGE, $NEXT_P, $P_NUM)
{
    global $_SERVER;
    $FILE = "{$_SERVER['PHP_SELF']}?p_num=";
    echo '<div class="pager">';
    if ($PRE_P > 0) {
        echo '<a href="' . $FILE . $PRE_P . '" id="categorylink">前のページへ</aA>';
    } else {
        echo '<a href="' . $FILE . $LAST_PAGE . '" id="categorylink">最後のページへ</a>';
    }
    echo "<br>";
    for ($j = 1; $j <= $LAST_PAGE; $j++) {
        echo '<a href="' . $FILE . $j . '" id="categorylink">' . $j . '</a> ';
    }
    echo "<br>";
    if ($NEXT_P > 1 && $P_NUM != $LAST_PAGE) {
        echo '<a href="' . $FILE . $NEXT_P . '" id="categorylink">次のページへ</a>';
    } else if ($P_NUM == $LAST_PAGE) {
        echo '<a href="' . $FILE . '1" id="categorylink">最初のページへ</a>';
    }
    echo '</div>';
}

comment_list_view($P_NUM);
?>
<?php require_once 'inc/admin_end.inc' ?>
