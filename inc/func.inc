<?php

//$INC_PATH     = '/home/vuser/1/0/0018401/www.kotobasagashi.net/inc/';
$INC_PATH = 'E:\www\kotobasagashi\inc\\';

//$ROOT_PATH    = '/home/vuser/1/0/0018401/www.kotobasagashi.net/';
$ROOT_PATH = 'E:\www\kotobasagashi\\';

$URL = '/';

//$DB_PASS      = 'Word3g4';

/*
// 旧DB
define('DB_NAME' , 'wXGN132');
define('DB_USER' , 'wXGN132');
define('DB_PASS' , 'Tt08Mk22');
define('DB_PORT' , '10035');
define('DB_HOST' , 'pgsql03.in.shared-server.net');
*/
// 2011/01/14 新DB
/*
define('DB_NAME' , 'Qnuh050');
define('DB_USER' , 'Qnuh050');
define('DB_PASS' , 'Tt08Mk22');
define('DB_PORT' , '10393');
define('DB_HOST' , 'pgsql12.in.shared-server.net');
*/

// 2023/07/01 ローカルDB
//define('DB_NAME', 'kotobasagashi');
//define('DB_USER', 'postgres');
//define('DB_PASS', '4657mr');
//define('DB_PORT', '5432');
//define('DB_HOST', 'localhost');

// 2023/07/02 aws
define('DB_NAME', 'kotobasagashi');
define('DB_USER', 'kotobasagashi');
define('DB_PASS', 'Tt08Mk22');
define('DB_PORT', '5432');
define('DB_HOST', '52.196.24.48');

require_once $INC_PATH . 'conf.inc';

function dbconn()
{
    $dbconn = pg_connect('host=' . DB_HOST . ' port=' . DB_PORT . ' user=' . DB_USER . ' dbname=' . DB_NAME . ' password= ' . DB_PASS);
    return $dbconn;
}

$dbconn = dbconn();

function error_check($error_msg)
{
    global $URL;
    global $inc_path;
    if ($error_msg != '') {

        require_once $inc_path . 'html_head.inc';
        echo "<img src={$URL}img/top.gif>";
        echo "<div align=center><table width=500 border=1><tr><td><font color=ff3333>";
        echo $error_msg;

        echo "</font></td></tr><tr align=center><td><FORM>
<INPUT type=button value=戻る onClick=pageBack()>
</FORM></td></tr></table>";
        echo "</body></html>";

        exit;
    }
}

//共通データ所得関数
function get_table_data($db, $table_name, $primary_name, $primary_id)
{
    // データアクセスクエリを記述
    $query = "SELECT ";
    $query .= "	A.* ";
    $query .= "FROM ";
    $query .= "	{$table_name} A ";
    $query .= $primary_name != "" ? "WHERE " : "";
    $query .= $primary_name != "" ? "	A.{$primary_name} = '{$primary_id}' " : "";

//echo $query;

    $result = pg_query($db, $query);

    $table_data = pg_fetch_array($result, 0);

    return $table_data;

}

function form_mail($inq)
{
    global $URL;
    echo "<a href='{$URL}mail.php?title=" . urlencode($inq) . "' id=greenlink>";
}


function kotoba_mail($to, $subject, $body, $headers)
{
    global $URL;
    $body .= "
---------------------------------------------------------------------------
ことば探し  info@kotobasagashi.net  $URL
                          copyright(c) 2004 kotobasagashi.net all rights reserved.";

    mb_send_mail($to, $subject, $body, $headers);
}


function page_title_view3($title, $column)
{
    global $URL;
    if ($column == 1) {
        $tablewidth = 700;
        $tdwidth = 561;
    } else {
        $tablewidth = 530;
        $tdwidth = 390;
    }

    echo <<< EOM
<div align=right>
<table width={$tablewidth} border="0" cellspacing=0 cellpadding=0>
  <tr valign=top>
    <td width={$tdwidth} id=maintitle>
      {$title}
    </td>
    <td width=140>
      <img src={$URL}img/top_leav.gif alt= width=140 height=49 border="0" />
    </td>
  </tr>
</table>
</div>
EOM;

}

function page_title_view($title, $column)
{
    global $URL;
    if ($column == 1) {
        $tablewidth = 700;
        $tdwidth = 561;
    } else {
        $tablewidth = 530;
        $tdwidth = 390;
    }
    echo <<< EOM
<div align=right>
<table width={$tablewidth} border="0" cellspacing=0 cellpadding=0>
  <tr valign=top>
    <td width={$tablewidth} id=maintitle>
      {$title}
    </td>
  </tr>
</table>
</div>
EOM;

}

function view_source_rec_level2($source_rec_level)
{
    global $URL;
    for ($i = 0; $i < 4; $i++) {
        echo ($i < $source_rec_level) ? '<img src={$URL}img/hyoka_book_small1.gif alt=★ border="0" height=19 width=17>' :
            '<img src={$URL}img/hyoka_book_small2.gif alt=☆ border="0" height=19 width=17>';
    }

    echo (5 == $source_rec_level) ? '<img src={$URL}img/hyoka_book_big1.gif alt=★ border="0" height=19 width=22>' :
        '<img src={$URL}img/hyoka_book_big2.gif alt=☆ border="0" height=22 width=22>';
}

function view_source_rec_level($source_rec_level)
{
    global $URL;
    for ($i = 0; $i < 4; $i++) {

        if ($i < floor($source_rec_level)) {
            echo '<img src="' . $URL . 'img/hyoka_book_small1.gif" alt="★" border="0" height="19" width="17">';
        } elseif ($i < $source_rec_level) {
            echo '<img src={$URL}img/hyoka_book_small3.gif alt=★ border="0" height=19 width=17>';
        } else {
            echo '<img src={$URL}img/hyoka_book_small2.gif alt=☆ border="0" height=19 width=17>';
        }
    }

    if (5 == $source_rec_level) {
        echo '<img src={$URL}img/hyoka_book_big1.gif alt=★ border="0" height=19 width=22>';
    } elseif (4.5 == $source_rec_level) {
        echo '<img src={$URL}img/hyoka_book_big3.gif alt=★ border="0" height=19 width=22>';
    } else {
        echo '<img src={$URL}img/hyoka_book_big2.gif alt=☆ border="0" height=22 width=22>';
    }
}


function page_navi_view($LAST_PAGE, $P_NUM, $QUERY)
{
//echo $QUERY;
    global $_SERVER;
    global $URL;
    $NEXT_P = $P_NUM + 1;
    $PRE_P = $P_NUM - 1;
    $FILE = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}?{$QUERY}&p_num=";

    echo '<table border="0" cellpadding=5 cellspacing=0 width=100%><tr valign=bottom><td nowrap><div id=kihon>';
    if ($PRE_P > 0) {
        echo '<img src={$URL}img/arrow_le.gif alt="" width=10 height=10 border="0"><a href={$FILE}{$PRE_P} id=categorylink>前のページへ</a>';
    } else {
        echo '<img src={$URL}img/arrow_le.gif alt="" width=10 height=10 border="0"><a href={$FILE}{$LAST_PAGE} id=categorylink>最後のページへ</a>';
    }
    echo "&nbsp;</div></td><td>";

    for ($j = 1; $j <= $LAST_PAGE; $j++) {
        if ($j == $P_NUM) {
            echo "<span class=thispage>{$j}</b></span>　";
        } else {
            echo "<a href={$FILE}{$j} id=categorylink>{$j}</a>　";
        }
    }

    echo "</td><td nowrap><div id=kihon>";
    if ($NEXT_P > 1 && $P_NUM != $LAST_PAGE) {
        echo '<a href={$FILE}{$NEXT_P} id=categorylink>次のページへ</a><img src={$URL}img/arrow_ri.gif alt="" width=10 height=10 border="0">';
    } else if ($P_NUM == $LAST_PAGE) {
        echo '<a href={$FILE}1 id=categorylink>最初のページへ</a><img src={$URL}img/arrow_ri.gif alt="" width=10 height=10 border="0">';
    }
    echo "&nbsp;</div></td></tr></table>";
}


function kotoba_list_view($P_NUM, $CMID, $CSID, $KEY)
{

    global $_SERVER;
    if (($_SERVER['SCRIPT_NAME'] == "/kotoba/kotoba/list.php") || ($_SERVER['SCRIPT_NAME'] == "/kotoba/list.php")) {
        $FILE = "view.php";
    } elseif (($_SERVER['SCRIPT_NAME'] == "/kotoba/admin/index.php") || ($_SERVER['SCRIPT_NAME'] == "/admin/index.php")) {
        $FILE = "kotoba_1_edit.php";
    } elseif (($_SERVER['SCRIPT_NAME'] == "/kotoba/kotoba/find.php") || ($_SERVER['SCRIPT_NAME'] == "/kotoba/find.php")) {
        $FILE = "view.php";
    }

    $dbconn = dbconn();

    $sql_all = "SELECT COUNT(*) AS COUNT FROM KOTOBA_MASTER";
    $sql_all .= ($CMID != NULL) ? " , CATEGORY_SUB WHERE KOTOBA_MASTER.CS_ID = CATEGORY_SUB.CS_ID AND CM_ID = {$CMID}" : "";
    $sql_all .= ($CSID != NULL) ? " WHERE CS_ID = {$CSID} " : "";
    $sql_all .= ($KEY != NULL) ? " WHERE KOTOBA_VALUE~'{$KEY}' " : "";

    $result_all = pg_query($dbconn, $sql_all);

    $REC_CNT = pg_result($result_all, 0, 'COUNT');
    $LAST_PAGE = ($REC_CNT - ($REC_CNT % LIST_NUM)) / LIST_NUM + 1;

    $OFFSET_NUM = ($P_NUM - 1) * LIST_NUM;
    $LIMIT_NUM = LIST_NUM;

    $sql = "SELECT ";
    $sql .= "KOTOBA_ID, ";
    $sql .= "KOTOBA_MASTER.CS_ID, ";
    $sql .= "KOTOBA_DATE, ";
    $sql .= "KOTOBA_VALUE ";
    $sql .= "FROM KOTOBA_MASTER ";
    $sql .= ($CMID != NULL) ? " , CATEGORY_SUB WHERE KOTOBA_MASTER.CS_ID = CATEGORY_SUB.CS_ID AND CM_ID = {$CMID}" : "";
    $sql .= ($CSID != NULL) ? "WHERE CS_ID = {$CSID} " : "";
    $sql .= ($KEY != NULL) ? " WHERE KOTOBA_VALUE~'{$KEY}' " : "";
    $sql .= "ORDER BY KOTOBA_DATE DESC OFFSET $OFFSET_NUM  LIMIT $LIMIT_NUM";
    $result = pg_query($dbconn, $sql);
    $NUM = pg_num_rows($result);

    $FROM_NUM = $OFFSET_NUM + 1;
    $TO_NUM = $FROM_NUM + (LIST_NUM - 1);

    echo '<div align=right>全' . $REC_CNT . '件中&nbsp;&nbsp;&nbsp;' . $FROM_NUM . '件目から' . $TO_NUM . '件目まで表示</div>';

    $QUERY = "key=" . urlencode($KEY) . "&";
    if ($CMID != NULL) {
        $QUERY .= "cmid={$CMID}";
    } elseif ($CSID != NULL) {
        $QUERY .= "csid={$CSID}";
    } else {
        $QUERY .= NULL;
    }

    page_navi_view($LAST_PAGE, $P_NUM, $QUERY);
    global $URL;

    echo <<< EOM
<table border="0" cellpadding=0 cellspacing=0 width=530>
  <tr>
    <td height=1><img src=1pix0000.gif alt="" width=1 height=1 border="0"></td>
  </tr>
  <tr valign=top>
    <td bgcolor=#6DA14B>
      <table border="0" cellpadding=5 cellspacing=1 width=100%>
EOM;

    for ($i = 0; $i < $NUM; $i++) {
        $KOTOBA['KOTOBA_ID'] = pg_result($result, $i, 'KOTOBA_ID');
        $KOTOBA['CS_ID'] = pg_result($result, $i, 'CS_ID');
        $KOTOBA['KOTOBA_DATE'] = pg_result($result, $i, 'KOTOBA_DATE');
        $KOTOBA['KOTOBA_VALUE'] = substr(strip_tags(pg_result($result, $i, 'KOTOBA_VALUE')), 0, 246);

        echo <<< EOM
  <tr bgcolor=#F6FFDF>
    <td width=99% id=kihon><img src={$URL}img/point_ko.gif alt= width=22 height=15 border="0">
      {$KOTOBA['KOTOBA_VALUE']}....&nbsp;
    </td>
    <td width=1% nowrap>
      <a href={$FILE}?kid={$KOTOBA['KOTOBA_ID']} id=categorylink>{$KOTOBA['KOTOBA_DATE']}</a>
    </td>
  </tr>
EOM;

    }

    echo "</table></td></tr></table>";
    page_navi_view($LAST_PAGE, $P_NUM, $QUERY);
}


function kc_navi_view($PRE_P, $LAST_PAGE, $NEXT_P, $P_NUM)
{
    global $_SERVER;

    $FILE = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}?p_num=";

    echo "<table border=1 cellpadding=5 cellspacing=0 width=100%><tr><td><div id=kihon>";

    if ($PRE_P > 0) {
        echo "<a href={$FILE}{$PRE_P} id=categorylink>前のページへ</aA>";
    } else {
        echo "<a href={$FILE}{$LAST_PAGE} id=categorylink>最後のページへ</a>";
    }

    echo "&nbsp;</div></td><td>";

    for ($j = 1; $j <= $LAST_PAGE; $j++) {
        echo "<a href={$FILE}{$j} id=categorylink>{$j}</a>　";
    }

    echo "</td><td><div id=kihon>";

    if ($NEXT_P > 1 && $P_NUM != $LAST_PAGE) {
        echo "<a href={$FILE}{$NEXT_P} id=categorylink>次のページへ</a>";
    } else if ($P_NUM == $LAST_PAGE) {
        echo "<a href={$FILE}1 id=categorylink>最初のページへ</a>";
    }

    echo "&nbsp;</div></td></tr></table>";
}


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

    echo "<table border=1 cellpadding=5 cellspacing=0 width=100%>";

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
<tr valign=top><td>
  <a href=/kotoba/view.php?kid={$COMMENT['KOTOBA_ID']} target=_blank>{$COMMENT['KOTOBA_DATE']}</a>の言葉について↓<br>
   {$COMMENT['KC_VALUE']}....
  &nbsp;
  </td><td nowrap>
  <a href={$FILE}?kc_id={$COMMENT['KC_ID']}&p_num=" . $P_NUM . ">{$COMMENT['KC_TIMESTAMP']}</a>
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


function kotoba_last_get()
{
    global $dbconn;
    $sql = "SELECT KOTOBA_ID FROM KOTOBA_MASTER ORDER BY KOTOBA_DATE DESC LIMIT 1 OFFSET 0";
    $result = pg_query($dbconn, $sql);
    $KOTOBA_ID = pg_result($result, 0, 'KOTOBA_ID');
    return $KOTOBA_ID;
}

function select_kotoba($KOTOBA_ID)
{
    global $dbconn;

    $sql = "SELECT ";
    $sql .= "KOTOBA_ID, ";
    $sql .= "CS_ID, ";
    $sql .= "SOURCE_ID, ";
    $sql .= "KOTOBA_DATE, ";
    $sql .= "KOTOBA_VALUE, ";
    $sql .= "EVAL_1, ";
    $sql .= "EVAL_2, ";
    $sql .= "EVAL_3, ";
    $sql .= "COMMENT ";
    $sql .= "FROM KOTOBA_MASTER WHERE KOTOBA_ID = {$KOTOBA_ID}";

    $result = pg_query($dbconn, $sql);

    $KOTOBA['KOTOBA_ID'] = pg_result($result, 0, 'KOTOBA_ID');
    $KOTOBA['CS_ID'] = pg_result($result, 0, 'CS_ID');
    $KOTOBA['SOURCE_ID'] = pg_result($result, 0, 'SOURCE_ID');
    $KOTOBA['KOTOBA_DATE'] = pg_result($result, 0, 'KOTOBA_DATE');
    $KOTOBA['KOTOBA_VALUE'] = pg_result($result, 0, 'KOTOBA_VALUE');
    $KOTOBA['EVAL_1'] = pg_result($result, 0, 'EVAL_1');
    $KOTOBA['EVAL_2'] = pg_result($result, 0, 'EVAL_2');
    $KOTOBA['EVAL_3'] = pg_result($result, 0, 'EVAL_3');
    $KOTOBA['COMMENT'] = pg_result($result, 0, 'COMMENT');

    return $KOTOBA;
}


function select_source($SOURCE_ID)
{
    global $dbconn;

    $sql = "SELECT ";
    $sql .= "SOURCE_ID        , ";
    $sql .= "SOURCE_CATEGORY  , ";
    $sql .= "SOURCE_NAME      , ";
    $sql .= "SOURCE_SUBTITLE  , ";
    $sql .= "SOURCE_AUTHOR    , ";
    $sql .= "SOURCE_TRANSLATOR, ";
    $sql .= "SOURCE_COMPANY   , ";
    $sql .= "SOURCE_VALUE     , ";
    $sql .= "SOURCE_REC_LEVEL , ";
//  $sql .="SOURCE_REC_LEVEL2 AS SOURCE_REC_LEVEL , ";
    $sql .= "SOURCE_ASIN , ";
    $sql .= "SOURCE_TIMESTAMP ";
    $sql .= "FROM SOURCE_MASTER WHERE SOURCE_ID = $SOURCE_ID";

    $result = pg_query($dbconn, $sql);

    $NUM = pg_numrows($result);

    if ($NUM) {
        $SOURCE['source_id'] = pg_result($result, 0, 'SOURCE_ID');
        $SOURCE['source_category'] = pg_result($result, 0, 'SOURCE_CATEGORY');
        $SOURCE['source_name'] = pg_result($result, 0, 'SOURCE_NAME');
        $SOURCE['source_subtitle'] = pg_result($result, 0, 'SOURCE_SUBTITLE');
        $SOURCE['source_author'] = pg_result($result, 0, 'SOURCE_AUTHOR');
        $SOURCE['source_translator'] = pg_result($result, 0, 'SOURCE_TRANSLATOR');
        $SOURCE['source_company'] = pg_result($result, 0, 'SOURCE_COMPANY');
        $SOURCE['source_value'] = pg_result($result, 0, 'SOURCE_VALUE');
        $SOURCE['source_rec_level'] = pg_result($result, 0, 'SOURCE_REC_LEVEL');
        $SOURCE['source_asin'] = pg_result($result, 0, 'SOURCE_ASIN');
        $SOURCE['source_timestamp'] = pg_result($result, 0, 'SOURCE_TIMESTAMP');
    } else {
        $SOURCE = [];
    }
    return $SOURCE;
}


function select_reading($READING_ID)
{
    $dbconn = dbconn();

    if ($READING_ID == "") {
        $sql2 = "SELECT READING_ID FROM READING_MASTER ORDER BY READING_DATE DESC OFFSET 0 LIMIT 1";
        $result2 = pg_query($dbconn, $sql2);
        $READING_ID = pg_result($result2, 0, 'READING_ID');
    }

    $sql = "SELECT ";
    $sql .= "READING_ID        , ";
    $sql .= "READING_DATE  , ";
    $sql .= "B.SOURCE_NAME      , ";
    $sql .= "B.SOURCE_AUTHOR  , ";
    $sql .= "B.SOURCE_COMPANY    , ";
    $sql .= "B.SOURCE_ASIN    , ";
    $sql .= "B.SOURCE_REC_LEVEL    , ";
//  $sql .="READING_VALUE, ";
    $sql .= "B.SOURCE_VALUE, ";
    // INSERT START[2005.06.14]
    $sql .= "A.SOURCE_ID, ";
    // INSERT END[2005.06.14]
    $sql .= "READING_TIMESTAMP ";
    $sql .= "FROM 
READING_MASTER AS A LEFT JOIN 
SOURCE_MASTER AS B ON A.SOURCE_ID = B.SOURCE_ID 
WHERE READING_ID = $READING_ID";

    $result = pg_query($dbconn, $sql);

    $READING['reading_id'] = pg_result($result, 0, 'READING_ID');
    $READING['reading_date'] = pg_result($result, 0, 'READING_DATE');
    $READING['reading_title'] = pg_result($result, 0, 'SOURCE_NAME');
    $READING['reading_author'] = pg_result($result, 0, 'SOURCE_AUTHOR');
    $READING['reading_company'] = pg_result($result, 0, 'SOURCE_COMPANY');
    $READING['reading_value'] = pg_result($result, 0, 'SOURCE_VALUE');
    $READING['reading_asin'] = pg_result($result, 0, 'SOURCE_ASIN');
    $READING['source_rec_level'] = pg_result($result, 0, 'SOURCE_REC_LEVEL');
    $READING['reading_timestamp'] = pg_result($result, 0, 'READING_TIMESTAMP');

    // INSERT START[2005.06.14]
    $READING['source_id'] = pg_result($result, 0, 'SOURCE_ID');
    // INSERT END[2005.06.14]

    return $READING;
}

function select_danjyo($DANJYO_ID)
{
    $dbconn = dbconn();

    if ($DANJYO_ID == "") {
        $sql2 = "SELECT DANJYO_ID FROM DANJYO_MASTER ORDER BY DANJYO_ID DESC OFFSET 0 LIMIT 1";
        $result2 = pg_query($dbconn, $sql2);
        $DANJYO_ID = pg_result($result2, 0, 'DANJYO_ID');
    }

    $sql = "SELECT ";
    $sql .= "DANJYO_ID        , ";
    $sql .= "DANJYO_TITLE      , ";
    $sql .= "DANJYO_VALUE, ";
    $sql .= "DANJYO_TIMESTAMP ";
    $sql .= "FROM DANJYO_MASTER WHERE DANJYO_ID = $DANJYO_ID";

    $result = pg_query($dbconn, $sql);

    $DANJYO['danjyo_id'] = pg_result($result, 0, 'DANJYO_ID');
    $DANJYO['danjyo_title'] = pg_result($result, 0, 'DANJYO_TITLE');
    $DANJYO['danjyo_value'] = pg_result($result, 0, 'DANJYO_VALUE');
    $DANJYO['danjyo_timestamp'] = pg_result($result, 0, 'DANJYO_TIMESTAMP');

    return $DANJYO;
}


function get_kotoba_all_num()
{
    global $dbconn;
    $sql = "SELECT COUNT(*) AS ALL_NUM FROM KOTOBA_MASTER";
    $result = pg_query($dbconn, $sql);
    $KOTOBA['ALL_NUM'] = pg_result($result, 0, 'ALL_NUM');
    return $KOTOBA['ALL_NUM'];
}

function get_kotoba_random_num($num)
{
    global $dbconn;
    srand((double)microtime() * 1000000);
    $id = rand(1, $num);
    $id2 = $id + 1;

    $sql = "SELECT KOTOBA_ID FROM KOTOBA_MASTER ORDER BY KOTOBA_DATE DESC LIMIT $id2 OFFSET $id";
    $result = pg_query($dbconn, $sql);
    $KOTOBA_ID = pg_result($result, 0, 'KOTOBA_ID');
    return $KOTOBA_ID;
}


function book_list_view($P_NUM, $SC, $KEY, $REC_LEVEL)
{
    global $URL;
    global $_SERVER;
    if ($_SERVER['SCRIPT_NAME'] == "/kotoba/book/list.php") {
        $FILE = "view.php";
    } elseif ($_SERVER['SCRIPT_NAME'] == "/kotoba/book/index.php") {
        $FILE = "kotoba_1_edit.php";
    } elseif ($_SERVER['SCRIPT_NAME'] == "/kotoba/book/find.php") {
        $FILE = "view.php";
    }

    if ($REC_LEVEL) $REC_LEVEL2 = $REC_LEVEL + 1;

    $dbconn = dbconn();

    $sql_all = "SELECT COUNT(*) FROM SOURCE_MASTER ";
    $sql_all .= "WHERE SOURCE_NAME IS NOT NULL ";
    $sql_all .= ($SC != NULL) ? "AND SOURCE_CATEGORY = {$SC} " : "";
    $sql_all .= $KEY != NULL ? "AND SOURCE_NAME~'{$KEY}' OR SOURCE_AUTHOR~'{$KEY}' " : "";
    if ($REC_LEVEL) $sql_all .= "AND SOURCE_REC_LEVEL = {$REC_LEVEL} ";

    $result_all = pg_query($dbconn, $sql_all);
    $REC_CNT = pg_result($result_all, 0, 0);
    $LAST_PAGE = ($REC_CNT - ($REC_CNT % LIST_NUM)) / LIST_NUM + 1;
    $OFFSET_NUM = ($P_NUM - 1) * LIST_NUM;
    $LIMIT_NUM = LIST_NUM;

    $sql = "SELECT ";
    $sql .= "SOURCE_ID        , ";
    $sql .= "SOURCE_CATEGORY  , ";
    $sql .= "SOURCE_NAME      , ";
    $sql .= "SOURCE_SUBTITLE  , ";
    $sql .= "SOURCE_AUTHOR    , ";
    $sql .= "SOURCE_TRANSLATOR, ";
    $sql .= "SOURCE_COMPANY   , ";
    $sql .= "SOURCE_VALUE     , ";
    $sql .= "SOURCE_REC_LEVEL , ";
    $sql .= "SOURCE_TIMESTAMP , ";
    $sql .= "COUNT ";
    $sql .= "FROM SOURCE_MASTER LEFT JOIN (SELECT COUNT(KOTOBA_ID) AS COUNT ,SOURCE_ID AS SID FROM KOTOBA_MASTER GROUP BY SOURCE_ID) AS KOTOBA ON SID = SOURCE_ID ";
    $sql .= "WHERE SOURCE_NAME IS NOT NULL ";
    if ($REC_LEVEL) $sql .= "AND SOURCE_REC_LEVEL = {$REC_LEVEL} ";
    $sql .= $KEY != NULL ? "AND SOURCE_NAME~'{$KEY}' OR SOURCE_AUTHOR~'{$KEY}' " : "";
    $sql .= ($SC != NULL) ? "AND SOURCE_CATEGORY = {$SC} " : "";
    $sql .= "ORDER BY SOURCE_AUTHOR OFFSET $OFFSET_NUM  LIMIT $LIMIT_NUM";

    $result = pg_query($dbconn, $sql);
    $NUM = pg_num_rows($result);

    $FROM_NUM = $OFFSET_NUM + 1;
    $TO_NUM = $FROM_NUM + (LIST_NUM - 1);

    echo '<div align=right>全' . $REC_CNT . '件中&nbsp;&nbsp;&nbsp;' . $FROM_NUM . '件目から' . $TO_NUM . '件目まで表示</div>';

    $QUERY = "";
    if ($SC != NULL) {
        $QUERY = "sc={$SC}";
    } elseif ($KEY != NULL) {
        $QUERY .= "&key={$KEY}";
    } else {
        $QUERY = NULL;
    }
    if ($REC_LEVEL) {
        $QUERY .= "&rec_level={$REC_LEVEL}";
    }


    page_navi_view($LAST_PAGE, $P_NUM, $QUERY);

    echo <<< EOM
<table border="0" cellpadding=0 cellspacing=0 width=530>
<tr>
<td height=1><img src=1pix0000.gif alt='' width=1 height=1 border="0" /></td>
</tr>
<tr valign=top>
<td bgcolor=#6DA14B>

<table border="0" cellpadding=5 cellspacing=1 width=100%>
  <tr bgcolor=#EEF2AF>
    <td width=220 id=kihonbold>出典名</td>
    <td width=200 id=kihonbold>著者</td>
    <td width=50 id=kihonbold>オススメ度</td>
    <td width=30 id=kihonbold>ことば</td>
  </tr>
EOM;

    for ($i = 0; $i < $NUM; $i++) {
        $SOURCE_ID = pg_result($result, $i, 'SOURCE_ID');
        $SOURCE_NAME = pg_result($result, $i, 'SOURCE_NAME');
        $SOURCE_AUTHOR = pg_result($result, $i, 'SOURCE_AUTHOR');
        $SOURCE_TIMESTAMP = pg_result($result, $i, 'SOURCE_TIMESTAMP');
        $SOURCE_REC_LEVEL = pg_result($result, $i, 'SOURCE_REC_LEVEL');
        $count = pg_result($result, $i, 'count');

        echo <<< EOM
    <tr valign=top bgcolor=#F6FFDF id=kihon>
      <td><img src={$URL}img/point_bo.gif alt='' width=22 height=15 border="0"><a href=view.php?sid={$SOURCE_ID} id=categorylink>{$SOURCE_NAME}</a>&nbsp;</td>
      <td>{$SOURCE_AUTHOR}&nbsp;</td>
      <td align=center>";
        view_source_rec_level($SOURCE_REC_LEVEL);
        echo "</td>
      <td align=center>{$count}&nbsp;</td>
      </td>
    </tr>";
    }
    echo "</table>
</td>
</tr>
<tr>
<td height=1><img src=1pix0000.gif alt='' width=1 height=1 border="0" /></td>
</tr>
</table>
EOM;
    }
    page_navi_view($LAST_PAGE, $P_NUM, $QUERY);
}


//make_counter2はけしてもいい。
////////////////////////////////////////////////////////////
//	関数名：make_counter
//	作成者：加藤総一
//	作成日：2004/12/11
//	定数定義
$len = 8;                                                                    // カウンター桁数
//	$URL + $img_path ＋ $num ＋ $ext で 数値画像のパスを指定
$img_path = "{$URL}img/";                                                        // 画像フォルダ（絶対パス）
// カウンター画像配列（0～9 の画像名 ※ 拡張子は除く）
$arr_cnt = array("00000000", "10000000", "20000000", "30000000", "40000000", "50000000", "60000000", "70000000", "80000000", "90000000");
$ext = ".gif";                                                                // 画像拡張子
$other = " WIDTH=11 HEIGHT=40 BORDER=0 ";                                    // その他タグ
////////////////////////////////////////////////////////////
//  メイン処理
//  count.txt を読み込み → カウントアップ → 文字列画像作成
//  ※ count.txt にカウントを保存している。
////////////////////////////////////////////////////////////
function make_counter2()
{
    global $len, $img_path, $arr_cnt, $ext, $other, $INC_PATH;                                // グローバル変数
    $count = 0;
    $fp = fopen("{$INC_PATH}count.txt", "r+");                                                // 読み書きモードでオープン
    if ($fp) {                                                                    // ファイルオープン不可の時
        flock($fp, LOCK_EX);                                                    // 書き込みロック
        $count = @fgets($fp, 32);                                                // 32バイトorEOFまで取得
        $count = $count + 1;                                                    // カウントアップ
        fseek($fp, 0);                                                            // ポインタを先頭に戻す
        fputs($fp, $count);                                                    // 書き込み
        fclose($fp);                                                            // ファイルを閉じる
    }
    $count = sprintf("%0{$len}d", $count);                                        // カウンターを指定桁数の文字列に変換

// 各桁の画像タグ作成
    $i = 0;                                                                        // ループカウンター
    while ($i < $len) {
        $str = substr($count, $i, 1);                                                // 各桁の文字取得
        //	$img_path ＋ $num ＋ $ext で 数値画像のパスを指定
        echo("<IMG SRC=$img_path$arr_cnt[$str]$ext ALT=$str $other>");
        $i++;
    }
}


function make_counter()
{
    global $len, $img_path, $arr_cnt, $ext, $other, $INC_PATH, $URL;                                // グローバル変数
    $len = 8;                                                                    // カウンター桁数
    $img_path = "{$URL}img/";                                                        // 画像フォルダ（絶対パス）
    $arr_cnt = array("00000000", "10000000", "20000000", "30000000", "40000000", "50000000", "60000000", "70000000", "80000000", "90000000");
    $ext = ".gif";                                                                // 画像拡張子
    $other = " WIDTH=11 HEIGHT=40 BORDER=0 ";                                    // その他タグ
    $count = AccCount();
    $count = sprintf("%0{$len}d", $count);                                        // カウンターを指定桁数の文字列に変換

// 各桁の画像タグ作成
    $i = 0;                                                                        // ループカウンター
    while ($i < $len) {
        $str = substr($count, $i, 1);                                                // 各桁の文字取得
        //	$img_path ＋ $num ＋ $ext で 数値画像のパスを指定
        echo("<IMG SRC=$img_path$arr_cnt[$str]$ext ALT=$str $other>");
        $i++;
    }
}


function AccCount()
{
    global $ROOT_PATH;
    global $_SERVER;

    /*********************************************************/
    /*  概要　：アクセスカウンタ リロード対策済み（Ver1.10)  */
    /*  作成日：2003.07.24                                   */
    /*********************************************************/
    // アクセスカウンタファイル名
    define("ACC_CNT", "{$ROOT_PATH}log/AccCnt.dat");

    // アクセスカウンタログファイル名
    define("CNT_LOG", "{$ROOT_PATH}log/AccCntLog.dat");

    // アクセスカウンタ記憶時間
    define("REC_TIME", 60 * 60 * 8);

    // IPアドレス取得
    $IpAdr = $_SERVER['REMOTE_ADDR'];

    // アクセスカウンタログファイルを更新
    $now = time();
    $ret = UpDateAccLog($now, $IpAdr);

    // ファイルのオープン
    $fp = fopen(ACC_CNT, "r+");

    // ファイルのロック
    flock($fp, LOCK_EX) or exit("PHP ERROR!! Lock on COUNTER DATA");

    // カウンタ読み込み
    $count = (int)fgets($fp);

    // ログにIPアドレスが存在しない
    if ($ret == "0") {
        // カウンタインクリメント
        $count++;
    }

    // ファイルポインタをファイルの先頭に移動
    rewind($fp);

    // カウンタをファイルに書き込み
    fwrite($fp, (string)$count);

    // ロック解除
    flock($fp, LOCK_UN);

    // ファイルのクローズ
    fclose($fp);

    return $count;

}


/****************************************************/
/*  概要　：アクセスカウンタログファイルの更新      */
/*  引数　：$now･･･現在時間                         */
/*  戻り値："0"･･･ログファイルにIPアドレス存在する  */
/*          "1"･･･ログファイルにIPアドレス存在する  */
/*  作成日：2003.07.24                              */
/****************************************************/
function UpDateAccLog($now, $IpAdr)
{

    // 戻り値の初期化
    $ret = 0;

    // 登録件数取得
    $CtLog = file(CNT_LOG);

    // ファイルのオープン
    $fp = fopen(CNT_LOG, "w");

    // 排他的ロック
    flock($fp, LOCK_EX) or exit("PHP ERROR!! Lock on COUNTER LOG");

    // 記憶時間から過ぎているものを削除する。
    for ($i = 0; $i < sizeof($CtLog); $i++) {

        // IPアドレスとタイムスタンプを取得する
        list($LogIp, $tim_stmp) = explode("|", $CtLog[$i]);

        // 所定時間以上過ぎているログはファイルから削除する
        if (($now - $tim_stmp) < REC_TIME) {
            // 今のIPアドレスを更新するためSkipする
            if ($LogIp != $IpAdr) {
                fputs($fp, "$LogIp|$tim_stmp");
            } else {
                $ret = 1;
            }
        }
    }

    // 現在のIPアドレスとタイムスタンプを登録
    fputs($fp, "$IpAdr|$now\r\n");

    // ロック解除
    flock($fp, LOCK_UN);

    // ファイルのクローズ
    fclose($fp);

    return $ret;
}


function kotoba_list_view_side($P_NUM)
{

    global $_SERVER;
    if (($_SERVER['SCRIPT_NAME'] == "/kotoba/kotoba/list.php") || ($_SERVER['SCRIPT_NAME'] == "/kotoba/list.php")) {
        $FILE = "view.php";
    } elseif (($_SERVER['SCRIPT_NAME'] == "/kotoba/admin/index.php") || ($_SERVER['SCRIPT_NAME'] == "/admin/index.php")) {
        $FILE = "kotoba_1_edit.php";
    } elseif (($_SERVER['SCRIPT_NAME'] == "/kotoba/kotoba/find.php") || ($_SERVER['SCRIPT_NAME'] == "/kotoba/find.php")) {
        $FILE = "view.php";
    }

    $dbconn = dbconn();

    $sql_all = "SELECT COUNT(*) AS COUNT from reading_master";

    $result_all = pg_query($dbconn, $sql_all);

    $REC_CNT = pg_result($result_all, 0, 'COUNT');
    $LAST_PAGE = ($REC_CNT - ($REC_CNT % LIST_NUM)) / LIST_NUM + 1;


    $OFFSET_NUM = ($P_NUM - 1) * LIST_NUM;
    $LIMIT_NUM = LIST_NUM;

    $sql = "select A.READING_ID, A.READING_DATE, B.SOURCE_NAME from reading_master AS A inner JOIN SOURCE_MASTER AS B ON A.SOURCE_ID = B.SOURCE_ID ";
    $sql .= "ORDER BY A.reading_date DESC OFFSET $OFFSET_NUM  LIMIT $LIMIT_NUM";
    $result = pg_query($dbconn, $sql);
    $NUM = pg_num_rows($result);

    $FROM_NUM = $OFFSET_NUM + 1;
    $TO_NUM = $FROM_NUM + (LIST_NUM - 1);

//echo '<div align=right>全'.$REC_CNT.'件中&nbsp;&nbsp;&nbsp;'.$FROM_NUM.'件目から'.$TO_NUM.'件目まで表示</div>';

    $QUERY = "";
    $QUERY .= NULL;

    page_navi_view_side($LAST_PAGE, $P_NUM, $QUERY);
    global $URL;

    echo '<table border="0" cellpadding=0 cellspacing=0 width=100%>';
    for ($i = 0; $i < $NUM; $i++) {
        $KOTOBA['READING_ID'] = pg_result($result, $i, 'READING_ID');
        $KOTOBA['READING_DATE'] = date("Y年n日j日", strtotime(pg_result($result, $i, 'READING_DATE')));
        $KOTOBA['READING_TITLE'] = pg_result($result, $i, 'SOURCE_NAME');
        echo "
  <tr valign=top><td id=kihon><a href=reading.php?reading_id={$KOTOBA['READING_ID']}&p_num={$P_NUM} id=greenlink>{$KOTOBA['READING_DATE']}</a><br>
  {$KOTOBA['READING_TITLE']}</TD></tr>
  <tr><td><img src='{$URL}img/1pix0000.gif' height=10 width=1></td></td>";
    }
    echo "</table>";
    page_navi_view_side($LAST_PAGE, $P_NUM, $QUERY);
}

function page_navi_view_side($LAST_PAGE, $P_NUM, $QUERY)
{
    global $_SERVER;
    global $URL;
    $NOW_ROW_P = isset($P_NUM) ? floor($P_NUM / 4) : 0;
    if (isset($P_NUM)) {
        if ($P_NUM % 4 == 0) $NOW_ROW_P = $NOW_ROW_P - 1;
    }

    $NEXT_P = $P_NUM + 4;
    $PRE_P = $P_NUM - 4;
    $FILE = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}?{$QUERY}&p_num=";
    echo '<table border="0" cellpadding=5 cellspacing=0 width=100%><tr valign=bottom><td nowrap><div id=kihon>';
    if ($PRE_P > 0) {
        //$PRE=$NOW_ROW_P*4-4;
        echo '<a href={$FILE}{$PRE_P} id=categorylink><img src={$URL}img/arrow_le.gif alt="" width=10 height=10 border="0"></a>';
    } else {
        //echo '<a href={$FILE}{$LAST_PAGE} id=categorylink><img src={$URL}img/arrow_le.gif alt="" width=10 height=10 border="0"></a>';
    }
    echo "&nbsp;</div></td><td>";
    if ($LAST_PAGE > $NOW_ROW_P * 4 + 4) {
        for ($j = $NOW_ROW_P * 4 + 1; $j <= $NOW_ROW_P * 4 + 4; $j++) {
            if ($j == $P_NUM) {
                echo "<span class=thispage>{$j}</b></span>　";
            } else {
                echo "<a href={$FILE}{$j} id=categorylink>{$j}</a>　";
            }
        }
    } else {
        for ($j = $NOW_ROW_P * 4 + 1; $j <= $LAST_PAGE; $j++) {
            if ($j == $P_NUM) {
                echo "<span class=thispage>{$j}</b></span>　";
            } else {
                echo "<a href={$FILE}{$j} id=categorylink>{$j}</a>　";
            }
        }
    }
    echo "</td><td nowrap><div id=kihon>";
    if ($LAST_PAGE > 4 && $NEXT_P > 1 && $NOW_ROW_P * 4 + 4 < $LAST_PAGE) {
        if ($NEXT_P > $LAST_PAGE) {
            $NEXT_P = $LAST_PAGE;
        }
        echo '<a href={$FILE}{$NEXT_P} id=categorylink><img src={$URL}img/arrow_ri.gif alt="" width=10 height=10 border="0"></a>';
    } else if ($P_NUM == $LAST_PAGE) {
        //echo "<a href={$FILE}1 id=categorylink><img src={$URL}img/arrow_ri.gif alt='' width=10 height=10 border="0"></a>";
    }
    echo "&nbsp;</div></td></tr></table>";
}

?>

