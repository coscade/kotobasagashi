<?php require_once '../inc/func.inc';?>
<?php
require_once $INC_PATH.'html_head.inc';
require_once $ROOT_PATH.'admin/inc/admin_start.inc';

$P_NUM = isset($_GET['p_num'])?$_GET['p_num']:1;
$KEY = isset($_GET['key'])?$_GET['key']:NULL;
define('LIST_NUM',20);

$dbconn = dbconn();

$sql1  = "SELECT count(*) from SOURCE_MASTER A LEFT JOIN READING_MASTER AS C ON A.SOURCE_ID = C.SOURCE_ID ";
$sql1 .= $KEY?"WHERE SOURCE_NAME~'{$KEY}' OR SOURCE_AUTHOR~'{$KEY}' ":"";

$result1 = pg_query($dbconn,$sql1);
$REC_CNT     = pg_result($result1,0,0);
$LAST_PAGE = ($REC_CNT-($REC_CNT%LIST_NUM))/LIST_NUM+1;

$OFFSET_NUM = ($P_NUM-1)*LIST_NUM;
$LIMIT_NUM = LIST_NUM;

$sql = "SELECT ";
$sql .="A.SOURCE_ID        , ";
$sql .="A.SOURCE_CATEGORY  , ";
$sql .="A.SOURCE_NAME      , ";
$sql .="A.SOURCE_AUTHOR    , ";
$sql .="A.SOURCE_TRANSLATOR, ";
$sql .="A.SOURCE_COMPANY   , ";
$sql .="A.SOURCE_VALUE     , ";
$sql .="A.SOURCE_REC_LEVEL , ";
$sql .="A.SOURCE_TIMESTAMP ,";
$sql .="B.COUNT ,";
$sql .="C.READING_ID ";
$sql .="FROM 
SOURCE_MASTER AS A LEFT JOIN 
(SELECT COUNT(KOTOBA_ID) AS COUNT ,SOURCE_ID AS SID FROM KOTOBA_MASTER GROUP BY SOURCE_ID) AS B ON B.SID = A.SOURCE_ID LEFT JOIN 
READING_MASTER AS C ON A.SOURCE_ID = C.SOURCE_ID ";

$sql .= $KEY != NULL?"WHERE A.SOURCE_NAME~'{$KEY}' OR A.SOURCE_AUTHOR~'{$KEY}' ":"";


$sql .="ORDER BY A.SOURCE_AUTHOR  OFFSET $OFFSET_NUM  LIMIT $LIMIT_NUM";

$result = pg_query($dbconn,$sql);

$NUM = pg_numrows($result);
?>

出展元一覧<br><br>


<form action=source_list.php method=get>
<input type=text name=key value="<?=$KEY?>">
<input type=submit value=検索>
</form>
<form action=source_list.php method=get>
<input type=hidden name=key value="">
<input type=submit value=全て表示>
</form>

<?page_navi_view($LAST_PAGE,$P_NUM,"&key=".urlencode($KEY));?>

<table border = "1" width = "700" cellpadding=5 cellspacing="0" >
  <tr>
    <td width=20>ID</td>
    <td width=200>出典名</td>
    <td width=200>著者</td>
    <td width=100>登録日時</td>
    <td width=30>登録数</td>
    <td width=30>奨度</td>
    <td width=50>詳細</td>
    <td width=10>今読本</td>
  </tr>

<?php
for($i=0;$i<$NUM;$i++){
$SOURCE_ID            = pg_result($result,$i,'SOURCE_ID');
$SOURCE_NAME          = pg_result($result,$i,'SOURCE_NAME');
$SOURCE_AUTHOR        = pg_result($result,$i,'SOURCE_AUTHOR');
$SOURCE_TIMESTAMP     = pg_result($result,$i,'SOURCE_TIMESTAMP');
$SOURCE_REC_LEVEL     = pg_result($result,$i,'SOURCE_REC_LEVEL');
$count     = pg_result($result,$i,'count');
$READING_ID     = pg_result($result,$i,'READING_ID');
?>
  <tr valign=top>
    <td><?= $SOURCE_ID;?>&nbsp;</td>
    <td><?= $SOURCE_NAME;?>&nbsp;</td>
    <td><?= $SOURCE_AUTHOR;?>&nbsp;</td>
    <td><?= $SOURCE_TIMESTAMP;?>&nbsp;</td>
    <td><?= $count;?>&nbsp;</td>
    <td><?= $SOURCE_REC_LEVEL;?>&nbsp;</td>
    <td><form action="source.php?source_id=<?= $SOURCE_ID;?>" method="post">
    <input type=submit value="編集" name=submit>
    </form></td>
    <td><?= $READING_ID;?>&nbsp;</td>
  </tr>
<?php }?>
</table>

<?page_navi_view($LAST_PAGE,$P_NUM,"&key=".urlencode($KEY));?>

<?php require_once $ROOT_PATH.'admin/inc/admin_end.inc';;?>
<?php require_once $INC_PATH.'html_foot.inc';?>
