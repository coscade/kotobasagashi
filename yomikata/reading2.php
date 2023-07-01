<?
require_once '../inc/func.inc';
$CONTENTS_TITLE = "■今日の「おすすめ本」■";
require_once $INC_PATH.'head_set_1column2.inc';

$READING_ID = isset($_GET['reading_id'])?$_GET['reading_id']:NULL;
$READING = select_reading($READING_ID);

$dbconn = dbconn();

$sql = "select reading_id, reading_date, reading_title from reading_master order by reading_date desc";
$result = pg_query($dbconn,$sql);
$NUM = pg_num_rows($result);

$P_NUM = isset($_GET['p_num'])?$_GET['p_num']:1;
define('LIST_NUM',30);
?>

<style type="text/css"><!--

div#now {
width: 550;
margin: 0;
padding: 6px;
text-align: left;
background-image: url(../img/kotoba_now_bg.jpg); 
background-repeat: no-repeat;
border-left: 1px solid #C1DF7D;
border-top: 1px solid #C1DF7D;
border-right: 1px solid #95AD5E;
border-bottom: 1px solid #95AD5E;
}

#now_date {
	font-size: 16px;
	font-weight: bold;
	line-height: 150%;
	color: #1D6504;
	border-bottom: 1px solid #C1DF7D;
}

#now_greentext {
	font-size: 14px;
	font-weight: bold;
	line-height: 150%;
	color: #1D6504;
}

#danjyo_leaf {
	vertical-align:middle;
	}

--></style>

<div align=center>

<?require'top_menu.inc';?>


<table border=0 cellpadding=0 cellspacing=4 width=95%>
  <tr valign=top>
    <td id=kihon>
<?kotoba_list_view_side($P_NUM);?>
    </td>
    <td>

<div id=now>
<table border=0 cellpadding=0 cellspacing=4 width=100%>
<tr>
<td colspan=3 id=now_date><?=date("Y月n年j日",strtotime($READING['reading_date']))?></td>
</tr>
<tr>
<td width=1% id=kihon nowrap><img src=http://www.kotobasagashi.net/img/point_bo.gif width=22 height=15 border=0 id=danjyo_leaf>タイトル</td>
<td width=1% id=kihon>：</td>
<td width=98% id=now_greentext><?=$READING['reading_title']?></td>
</tr>



<tr>
<td width=1% id=kihon><img src=http://www.kotobasagashi.net/img/point_bo.gif width=22 height=15 border=0 id=danjyo_leaf>著者</td>
<td width=1% id=kihon>：</td>
<td width=98% id=now_greentext><?=$READING['reading_author']?></td>
</tr>

<tr>
<td width=1% id=kihon><img src=http://www.kotobasagashi.net/img/point_bo.gif width=22 height=15 border=0 id=danjyo_leaf>出版社</td>
<td width=1% id=kihon>：</td>
<td width=98% id=now_greentext><?=$READING['reading_company']?></td>
</tr>


<tr>
<td width=1% id=kihon nowrap><img src=http://www.kotobasagashi.net/img/point_bo.gif width=22 height=15 border=0 id=danjyo_leaf>おすすめ度</td>
<td width=1% id=kihon>：</td>
<td width=98% id=now_greentext><?view_source_rec_level($READING['source_rec_level']);?>&nbsp;<font size=1><a href=./ onclick="window.open('<?=$URL?>popup.php', '', 'width=300,height=300');" target=_blank>※おすすめ度について</a></font></td>
</tr>



<tr>

<tr>
<td colspan=3 id=kihon><img src="http://www.neta.jp/kotoba/img/1pix0000.gif" alt="" width="1" height="20" border="0"><br>
<?if($READING['reading_asin'] !=""){?>
<table border=0 cellpadding=2 cellspacing=0 width=120 align=right><tr><td align=center>
<iframe src="http://rcm-jp.amazon.co.jp/e/cm?t=aaaaea00-22&o=9&p=8&l=as1&asins=<?=$READING['reading_asin']?>&fc1=000000&IS2=1&lt1=_blank&lc1=0000ff&bc1=000000&bg1=ffffff&f=ifr" style="width:120px;height:240px;" scrolling="no" marginwidth="0" marginheight="0" frameborder="0"></iframe>
</td></tr>
</table>
<?}?>
<?=nl2br($READING['reading_value'])?>




</td>
</tr>
</table>
</div>


<?

if($READING['source_id']){
  $sql = "SELECT ";
  $sql .="KOTOBA_ID, ";
  $sql .="CS_ID       , ";
  $sql .="SOURCE_ID   , ";
  $sql .="KOTOBA_DATE , ";
  $sql .="KOTOBA_VALUE, ";
  $sql .="COMMENT      ";
  $sql .="FROM KOTOBA_MASTER ";
  $sql .="WHERE SOURCE_ID = {$READING['source_id']} ";
  $sql .="ORDER BY KOTOBA_DATE DESC";

  $result = pg_query($dbconn,$sql);

  $NUM = pg_numrows($result);
  if($NUM != 0){
?>
<br>
<table border=0 cellpadding=0 cellspacing=0 width=530>
<tr valign=top>
<td bgcolor=#6da14b>
<table border=0 cellpadding=5 cellspacing=1 width=100%>
  <tr align=center>
    <td id=kihonbold bgcolor=#d9df7d width=45%>この本からのことば</td>
    <td id=kihonbold bgcolor=#d9df7d width=45%>感想</td>
    <td id=kihonbold bgcolor=#d2ee91 width=10%>掲載日</td>
  </tr>
<?
    for($i=0;$i<$NUM;$i++){
    $KOTOBA_ID    = pg_result($result,$i,'KOTOBA_ID');
    $CS_ID        = pg_result($result,$i,'CS_ID');
    $SOURCE_ID    = pg_result($result,$i,'SOURCE_ID');
    $KOTOBA_DATE  = pg_result($result,$i,'KOTOBA_DATE');
    $KOTOBA_VALUE = ereg_replace('<br>','',strip_tags(pg_result($result,$i,'KOTOBA_VALUE')));
    $COMMENT      = ereg_replace('<br>','',strip_tags(pg_result($result,$i,'COMMENT')));
?>
  <tr valign=top>
    <td id=kihon bgcolor=#f6ffdf><a href=../kotoba/view.php?kid=<?echo $KOTOBA_ID;?>>
    <?echo substr($KOTOBA_VALUE,0,100);?></a></td>
    <td id=kihon bgcolor=#f6ffdf><?echo substr($COMMENT,0,100);?></td>
    <td id=kihon bgcolor=#f2fae5 nowrap=nowrap valign=middle><?echo $KOTOBA_DATE;?></td>
  </tr>

<?
    }
?>
</table>
</td>
</tr>
</table>

<?
  }
}
?>




    </td>
  </tr>
</table>

<br><br>


<script type="text/javascript"><!--
 amazon_ad_tag = "aaaaea00-22";  amazon_ad_width = "160";  amazon_ad_height = "600";  amazon_color_background = "CCFF99";  amazon_color_link = "336600";  amazon_color_price = "CC0000";  amazon_color_logo = "33FF00";  amazon_ad_link_target = "new";//--></script>
<script type="text/javascript" src="http://www.assoc-amazon.jp/s/ads.js"></script> 



<iframe src="http://rcm-jp.amazon.co.jp/e/cm?t=aaaaea00-22&o=9&p=14&l=bn1&mode=books-jp&browse=571582&fc1=006600&lt1=_blank&lc1=&bg1=CCFF66&f=ifr" marginwidth="0" marginheight="0" width="160" height="600" border="0" frameborder="0" style="border:none;" scrolling="no"></iframe>




<?require_once $INC_PATH.'foot_set_1column2.inc';?>