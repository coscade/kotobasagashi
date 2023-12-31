<?php
$ROOT_PATH = $_SERVER["DOCUMENT_ROOT"] . '/';

if ($_SERVER['SERVER_NAME'] == 'kotobasagashi.local') {
//    define('DB_NAME', 'kotobasagashi-dev');
    define('DB_NAME', 'kotobasagashi');
} elseif ($_SERVER['SERVER_NAME'] == 'kotobasagashi-dev.neta.jp') {
    define('DB_NAME', 'kotobasagashi-dev');
} else {
    define('DB_NAME', 'kotobasagashi');
}
define('DB_USER', 'kotobasagashi');
define('DB_PASS', 'Tt08Mk22');
define('DB_PORT', '5432');
define('DB_HOST', '52.196.24.48');

require_once $_SERVER["DOCUMENT_ROOT"] . '/inc/conf.inc';

function dbconn()
{
    $dbconn = pg_connect('host=' . DB_HOST . ' port=' . DB_PORT . ' user=' . DB_USER . ' dbname=' . DB_NAME . ' password= ' . DB_PASS);
    return $dbconn;
}

$dbconn = dbconn();

function error_check($error_msg)
{
    if ($error_msg != '') {
        require_once $_SERVER["DOCUMENT_ROOT"] . '/inc/html_head.inc';
        echo '<img src="/img/top.gif">';
        echo '<div align="center"><table width="500" border="1"><tr><td><font color="ff3333">';
        echo $error_msg;
        echo '</font></td></tr><tr align="center"><td><FORM><INPUT type="button" value="戻る" onClick="pageBack()"></FORM></td></tr></table>';
        echo '</body></html>';
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

    $result = pg_query($db, $query);

    $table_data = pg_fetch_array($result, 0);

    return $table_data;

}

function form_mail($inq)
{
    echo '<a href="/mail.php?title=' . urlencode($inq) . '" id="greenlink">';
}


function kotoba_mail($to, $subject, $body, $headers)
{
    $body .= "
---------------------------------------------------------------------------
ことば探し  info@kotobasagashi.net copyright(c) 2004 kotobasagashi.net all rights reserved.";

    mb_send_mail($to, $subject, $body, $headers);
}


function page_title_view3($title, $column)
{
    if ($column == 1) {
        $tablewidth = 700;
        $tdwidth = 561;
    } else {
        $tablewidth = 530;
        $tdwidth = 390;
    }

    echo <<< EOM
<div align="right">
<table width="{$tablewidth}">
  <tr valign="top">
    <td width="{$tdwidth}" id="maintitle">{$title}</td>
    <td width="140"></td>
  </tr>
</table>
</div>
EOM;

}

function page_title_view($title, $column)
{
    if ($column == 1) {
        $tablewidth = 700;
        $tdwidth = 561;
    } else {
        $tablewidth = 530;
        $tdwidth = 390;
    }

    echo <<< EOM
<div align="right">
<table width={$tablewidth}>
  <tr valign="top">
    <td width={$tablewidth} id="maintitle">
      {$title}
    </td>
  </tr>
</table>
</div>
EOM;
}

function view_source_rec_level2($source_rec_level)
{
    for ($i = 0; $i < 4; $i++) {
        echo ($i < $source_rec_level) ? '<img src="/img/hyoka_book_small1.gif" alt="★" height="19" width="17">' :
            '<img src="/img/hyoka_book_small2.gif" alt="☆" height="19" width="17">';
    }

    echo (5 == $source_rec_level) ? '<img src="/img/hyoka_book_big1.gif" alt="★" height="19" width="22">' :
        '<img src="/img/hyoka_book_big2.gif" alt="☆" height="22" width="22">';
}

function view_source_rec_level($source_rec_level)
{
    for ($i = 0; $i < 4; $i++) {
        if ($i < floor($source_rec_level)) {
            echo '<img src="/img/hyoka_book_small1.gif" alt="★" height="19" width="17">';
        } elseif ($i < $source_rec_level) {
            echo '<img src="/img/hyoka_book_small3.gif" alt="★" height="19" width="17">';
        } else {
            echo '<img src="/img/hyoka_book_small2.gif" alt="☆" height="19" width="17">';
        }
    }

    if (5 == $source_rec_level) {
        echo '<img src="/img/hyoka_book_big1.gif" alt="★" height="19" width="22">';
    } elseif (4.5 == $source_rec_level) {
        echo '<img src="/img/hyoka_book_big3.gif" alt="★" height="19" width="22">';
    } else {
        echo '<img src="/img/hyoka_book_big2.gif" alt="☆" height="22" width="22">';
    }
}


function page_navi_view($LAST_PAGE, $P_NUM, $QUERY)
{
    global $_SERVER;
    $NEXT_P = $P_NUM + 1;
    $PRE_P = $P_NUM - 1;
    $FILE = "{$_SERVER['PHP_SELF']}?{$QUERY}&p_num=";
    echo '<table cellpadding=5  width=100%><tr valign=bottom><td nowrap><div >';
    if ($PRE_P > 0) {
        echo '<img src="/img/arrow_le.gif" alt="" width="10" height="10"><a href="' . $FILE . $PRE_P . '" id="categorylink">前のページへ</a>';
    } else {
        echo '<img src="/img/arrow_le.gif" alt="" width="10" height="10"><a href="' . $FILE . $LAST_PAGE . '" id="categorylink">最後のページへ</a>';
    }
    echo '&nbsp;</div></td><td>';

    for ($j = 1; $j <= $LAST_PAGE; $j++) {
        if ($j == $P_NUM) {
            echo '<span class="thispage">' . $j . '</b></span>　';
        } else {
            echo '<a href="' . $FILE . $j . '" id="categorylink">' . $j . '</a>　';
        }
    }

    echo '</td><td nowrap><div >';
    if ($NEXT_P > 1 && $P_NUM != $LAST_PAGE) {
        echo '<a href="' . $FILE . $NEXT_P . '" id="categorylink">次のページへ</a><img src="/img/arrow_ri.gif" alt="" width="10" height="10">';
    } else if ($P_NUM == $LAST_PAGE) {
        echo '<a href="' . $FILE . '1" id="categorylink">最初のページへ</a><img src="/img/arrow_ri.gif" alt="" width="10" height="10">';
    }
    echo '&nbsp;</div></td></tr></table>';
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
    $sql .= "KOTOBA_MASTER.KOTOBA_ID, ";
    $sql .= "KOTOBA_MASTER.CS_ID, ";
    $sql .= "KOTOBA_MASTER.KOTOBA_DATE, ";
    $sql .= "KOTOBA_MASTER.KOTOBA_VALUE ";
    $sql .= "FROM KOTOBA_MASTER JOIN CATEGORY_SUB ON KOTOBA_MASTER.CS_ID = CATEGORY_SUB.CS_ID ";
    $sql .= ($CMID != NULL) ? " WHERE CATEGORY_SUB.CM_ID = {$CMID} " : "";
    $sql .= ($CSID != NULL) ? " WHERE KOTOBA_MASTER.CS_ID = {$CSID} " : "";
    $sql .= ($KEY != NULL) ? " WHERE KOTOBA_MASTER.KOTOBA_VALUE~'{$KEY}' " : "";
    $sql .= "ORDER BY KOTOBA_MASTER.KOTOBA_DATE DESC OFFSET {$OFFSET_NUM} LIMIT {$LIMIT_NUM}";

    $result = pg_query($dbconn, $sql);
    $NUM = pg_num_rows($result);

    $FROM_NUM = $OFFSET_NUM + 1;
    $TO_NUM = $FROM_NUM + (LIST_NUM - 1);

    echo '<div align="right">全' . $REC_CNT . '件中&nbsp;&nbsp;&nbsp;' . $FROM_NUM . '件目から' . $TO_NUM . '件目まで表示</div>';

    $QUERY = "key=" . urlencode($KEY) . "&";
    if ($CMID != NULL) {
        $QUERY .= "cmid={$CMID}";
    } elseif ($CSID != NULL) {
        $QUERY .= "csid={$CSID}";
    } else {
        $QUERY .= NULL;
    }

    page_navi_view($LAST_PAGE, $P_NUM, $QUERY);

    echo <<< EOM
      <table class="list">
EOM;

    for ($i = 0; $i < $NUM; $i++) {
        $KOTOBA['KOTOBA_ID'] = pg_result($result, $i, 'KOTOBA_ID');
        $KOTOBA['CS_ID'] = pg_result($result, $i, 'CS_ID');
        $KOTOBA['KOTOBA_DATE'] = pg_result($result, $i, 'KOTOBA_DATE');
        $KOTOBA['KOTOBA_VALUE'] = substr(strip_tags(pg_result($result, $i, 'KOTOBA_VALUE')), 0, 246);

        echo <<< EOM
  <tr bgcolor="#F6FFDF">
    <td width="99%" ><img src="/img/point_ko.gif" alt= width="22" height="15">
      {$KOTOBA['KOTOBA_VALUE']}....&nbsp;
    </td>
    <td width="1%" nowrap>
      <a href="{$FILE}?kid={$KOTOBA['KOTOBA_ID']}" id="categorylink">{$KOTOBA['KOTOBA_DATE']}</a>
    </td>
  </tr>
EOM;

    }

    echo "</table>";
    page_navi_view($LAST_PAGE, $P_NUM, $QUERY);
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
    $sql .= "B.SOURCE_VALUE, ";
    $sql .= "A.SOURCE_ID, ";
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
    $READING['source_id'] = pg_result($result, 0, 'SOURCE_ID');

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

    echo '<div align="right">全' . $REC_CNT . '件中&nbsp;&nbsp;&nbsp;' . $FROM_NUM . '件目から' . $TO_NUM . '件目まで表示</div>';

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
<table class="list">
  <tr bgcolor="#EEF2AF">
    <th width="220" >出典名</th>
    <th width="200" >著者</th>
    <th width="50" >オススメ度</th>
    <th width="30" >ことば</th>
  </tr>
EOM;

    for ($i = 0; $i < $NUM; $i++) {
        $SOURCE_ID = pg_result($result, $i, 'SOURCE_ID');
        $SOURCE_NAME = pg_result($result, $i, 'SOURCE_NAME');
        $SOURCE_AUTHOR = pg_result($result, $i, 'SOURCE_AUTHOR');
        $SOURCE_REC_LEVEL = pg_result($result, $i, 'SOURCE_REC_LEVEL');
        $count = pg_result($result, $i, 'count');

        echo <<< EOM
    <tr valign="top" bgcolor="#F6FFDF">
      <td><img src="/img/point_bo.gif" alt="" width="22" height="15"><a href="view.php?sid={$SOURCE_ID}" id="categorylink">{$SOURCE_NAME}</a></td>
      <td>{$SOURCE_AUTHOR}</td>
      <td align="center">
EOM;

        view_source_rec_level($SOURCE_REC_LEVEL);

        echo <<< EOM
        </td>
      <td align="center">{$count}&nbsp;</td>
    </tr>
EOM;
    }

    echo '</table>';

    page_navi_view($LAST_PAGE, $P_NUM, $QUERY);
}


function make_counter()
{
    global $len, $img_path, $arr_cnt, $ext, $other;                                // グローバル変数
    $len = 8;                                                                    // カウンター桁数
    $img_path = "/img/";                                                        // 画像フォルダ（絶対パス）
    $arr_cnt = array("00000000", "10000000", "20000000", "30000000", "40000000", "50000000", "60000000", "70000000", "80000000", "90000000");
    $ext = ".gif";                                                                // 画像拡張子
    $other = ' WIDTH="11" HEIGHT="40" BORDER="0" ';                                    // その他タグ
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
    $QUERY = "";
    $QUERY .= NULL;
    page_navi_view_side($LAST_PAGE, $P_NUM, $QUERY);
    echo '<table>';
    for ($i = 0; $i < $NUM; $i++) {
        $KOTOBA['READING_ID'] = pg_result($result, $i, 'READING_ID');
        $KOTOBA['READING_DATE'] = date("Y年n日j日", strtotime(pg_result($result, $i, 'READING_DATE')));
        $KOTOBA['READING_TITLE'] = pg_result($result, $i, 'SOURCE_NAME');

        echo <<< EOM
  <tr>
  <td >
  <a href="/yomikata/reading.php?reading_id={$KOTOBA['READING_ID']}&p_num={$P_NUM}" id="greenlink">{$KOTOBA['READING_DATE']}</a><br>
  {$KOTOBA['READING_TITLE']}<br><br>
  </td>
  </tr>
EOM;
    }
    echo "</table>";
    page_navi_view_side($LAST_PAGE, $P_NUM, $QUERY);
}

function page_navi_view_side($LAST_PAGE, $P_NUM, $QUERY)
{
    global $_SERVER;

    $NOW_ROW_P = isset($P_NUM) ? floor($P_NUM / 4) : 0;
    if (isset($P_NUM)) {
        if ($P_NUM % 4 == 0) $NOW_ROW_P = $NOW_ROW_P - 1;
    }

    $NEXT_P = $P_NUM + 4;
    $PRE_P = $P_NUM - 4;
    $FILE = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}?{$QUERY}&p_num=";
    echo '<table cellpadding="5"  width="100%"><tr valign="bottom"><td nowrap><div >';
    if ($PRE_P > 0) {
        echo '<a href="' . $FILE . $PRE_P . '" id="categorylink"><img src="/img/arrow_le.gif" alt="" width="10" height="10"></a>';
    } else {
    }
    echo "&nbsp;</div></td><td>";
    if ($LAST_PAGE > $NOW_ROW_P * 4 + 4) {
        for ($j = $NOW_ROW_P * 4 + 1; $j <= $NOW_ROW_P * 4 + 4; $j++) {
            if ($j == $P_NUM) {
                echo '<span class="thispage"><b>' . $j . '</b></span>　';
            } else {
                echo '<a href="' . $FILE . $j . '" id="categorylink">' . $j . '</a>　';
            }
        }
    } else {
        for ($j = $NOW_ROW_P * 4 + 1; $j <= $LAST_PAGE; $j++) {
            if ($j == $P_NUM) {
                echo '<span class="thispage"><b>' . $j . '</b></span>　';
            } else {
                echo '<a href="' . $FILE . $j . '" id="categorylink">' . $j . '</a>　';
            }
        }
    }
    echo '</td><td nowrap><div >';
    if ($LAST_PAGE > 4 && $NEXT_P > 1 && $NOW_ROW_P * 4 + 4 < $LAST_PAGE) {
        if ($NEXT_P > $LAST_PAGE) {
            $NEXT_P = $LAST_PAGE;
        }
        echo '<a href="' . $FILE . $NEXT_P . '" id="categorylink"><img src="/img/arrow_ri.gif" alt="" width="10" height="10"></a>';
    } else if ($P_NUM == $LAST_PAGE) {
    }
    echo "&nbsp;</div></td></tr></table>";
}

?>

