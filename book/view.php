<?php
require_once '../inc/func.inc';

$SOURCE_ID = isset($_GET['sid'])?$_GET['sid']:1;
$dbconn = dbconn();

$SOURCE = select_source($SOURCE_ID);
$cs = $SOURCE['source_category'];


$CONTENTS_TITLE = "■本の検索■";
$PAGE_TITLE = " - 『{$SOURCE['source_name']}』";

require_once $INC_PATH.'head_set_2column2.inc';

?>

<BR><BR>

<table border=0 cellpadding=0 cellspacing=5 width=530>
  <tr>
    <td width="100" id=kihonbold nowrap=nowrap align=right>出典名：</td>
    <td width="310" id=kihon><?echo $SOURCE['source_name'];?></td>
    <td width="120" rowspan=8 valign=top>
<?php if($SOURCE['source_asin'] !=""){?>
			<table border=0 cellpadding=2 cellspacing=0 width=120 align=right>
				<tr>
					<td align=center>					
						<iframe style="width:120px;height:240px;" marginwidth="0" marginheight="0" scrolling="no" frameborder="0" src="https://rcm-fe.amazon-adsystem.com/e/cm?ref=qf_sp_asin_til&t=aaaaea00-22&m=amazon&o=9&p=8&l=as1&IS2=1&detail=1&asins=<?=$SOURCE['source_asin']?>&linkId=dc50fe5693b9a0d2d8b1d7ee561eba63&bc1=000000&lt1=_blank&fc1=333333&lc1=0066c0&bg1=ffffff&f=ifr"></iframe>					
					</td>
				</tr>
			</table>
<?php }?>
    </td>
  </tr>
  <tr>
    <td id=kihonbold nowrap=nowrap align=right>おすすめ度：</td>
    <td id=kihon><?view_source_rec_level($SOURCE['source_rec_level']);?>&nbsp;<font size=1><a href=./ onclick="window.open('<?=$URL?>popup.php', '', 'width=300,height=300');" target=_blank>※おすすめ度について</a></font></td>
  </tr>
  <tr>
    <td id=kihonbold nowrap=nowrap align=right width=100>本のカテゴリ：</td>
    <td id=kihon><?echo $source_category[$cs];?></td>
  </tr>
  <tr>
    <td id=kihonbold nowrap=nowrap align=right>副題：</td>
    <td id=kihon><?echo $SOURCE['source_subtitle'];?>&nbsp;</td>
  </tr>
  <tr>
    <td id=kihonbold nowrap=nowrap align=right>著者：</td>
    <td id=kihon><?echo $SOURCE['source_author'];?>&nbsp;</td>
  </tr>
  <tr>
    <td id=kihonbold nowrap=nowrap align=right>訳者：</td>
    <td id=kihon><?echo $SOURCE['source_translator'];?>&nbsp;</td>
  </tr>
  <tr>
    <td id=kihonbold nowrap=nowrap align=right>出版社：</td>
    <td id=kihon><?echo $SOURCE['source_company'];?>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr valign=top>
    <td id=kihonbold nowrap=nowrap align=right>本の内容：</td>
    <td id=kihon colspan="2"><?echo nl2br(str_replace("<br>","",$SOURCE['source_value']));?>&nbsp;</td>
  </tr>
</table>

<br>

<?php
if($SOURCE_ID){
  $sql = "SELECT ";
  $sql .="KOTOBA_ID, ";
  $sql .="CS_ID       , ";
  $sql .="SOURCE_ID   , ";
  $sql .="KOTOBA_DATE , ";
  $sql .="KOTOBA_VALUE, ";
  $sql .="COMMENT      ";
  $sql .="FROM KOTOBA_MASTER ";
  $sql .="WHERE SOURCE_ID = $SOURCE_ID ";
  $sql .="ORDER BY KOTOBA_DATE DESC";

  $result = pg_query($dbconn,$sql);

  $NUM = pg_numrows($result);
  if($NUM != 0){
?>
<div id=maintitle>■この本から紹介している「今日のことば」■</div><br>

<table border=0 cellpadding=0 cellspacing=0 width=530>
<tr valign=top>
<td bgcolor=#6da14b>
<table border=0 cellpadding=5 cellspacing=1 width=100%>
  <tr align=center>
    <td id=kihonbold bgcolor=#d9df7d width=45%>この本からのことば</td>
    <td id=kihonbold bgcolor=#d9df7d width=45%>感想</td>
    <td id=kihonbold bgcolor=#d2ee91 width=10%>掲載日</td>
  </tr>
<?php
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

<?php
    }
?>
</table>
</td>
</tr>
</table>

<?php
  }
}
?>


<?php require_once $INC_PATH.'foot_set_2column2.inc';?>
