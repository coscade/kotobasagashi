<?require_once '../inc/func.inc';?>
<?
require_once $INC_PATH.'html_head.inc';
require_once $ROOT_PATH.'admin/inc/admin_start.inc';

$P_NUM = isset($_GET['p_num'])?$_GET['p_num']:1;
$KEY = isset($_GET['key'])?$_GET['key']:NULL;
define('LIST_NUM',20);

$dbconn = dbconn();

$sql1    = "SELECT count(*) from DANJYO_MASTER";
$result1 = pg_query($dbconn,$sql1);
$REC_CNT     = pg_result($result1,0,0);
$LAST_PAGE=($REC_CNT-($REC_CNT%LIST_NUM))/LIST_NUM+1;
$OFFSET_NUM = ($P_NUM-1)*LIST_NUM; 
$LIMIT_NUM = LIST_NUM;

$sql = "SELECT ";
$sql .="DANJYO_ID        , ";
$sql .="DANJYO_TITLE      , ";
$sql .="DANJYO_VALUE     ";
$sql .="FROM DANJYO_MASTER ";
$sql .= $KEY != NULL?"WHERE DANJYO_NAME~'{$KEY}' OR DANJYO_AUTHOR~'{$KEY}' ":"";
$sql .="ORDER BY DANJYO_ID DESC OFFSET $OFFSET_NUM  LIMIT $LIMIT_NUM";

$result = pg_query($dbconn,$sql);

$NUM = pg_numrows($result);
?>

今週の「ああ…こんなに違うのね」<br>

<a href=danjyo.php>新規登録</a>

<br><br>
<?page_navi_view($LAST_PAGE,$P_NUM,NULL);?>

<table border = "1" width = "700" cellpadding=5 cellspacing="0" >
  <tr>
    <td width=300>タイトル</td>
    <td width=350>内容</td>
    <td width=50>処理</td>
  </tr>

<?
for($i=0;$i<$NUM;$i++){
$DANJYO_ID            = pg_result($result,$i,'DANJYO_ID');
$DANJYO_TITLE         = pg_result($result,$i,'DANJYO_TITLE');
$DANJYO_VALUE         = substr(strip_tags(pg_result($result,$i,'DANJYO_VALUE')),0,100);
?>
  <tr valign=top>
    <td><?echo $DANJYO_TITLE;?>&nbsp;</td>
    <td><?echo $DANJYO_VALUE;?>&nbsp;</td>
    <td><form action="danjyo.php" method="post">
    <input type=submit value="編集" name=submit><input type=hidden name=danjyo_id value=<?echo $DANJYO_ID;?>>
    </form></td>
  </tr>
<?}?>
</table>

<?page_navi_view($LAST_PAGE,$P_NUM,NULL);?>

<?require_once $ROOT_PATH.'admin/inc/admin_end.inc';;?>
<?require_once $INC_PATH.'html_foot.inc';?>
