<?php
if(!$afm_random)
{
	$afm_random = get_table_data($dbconn, "v_afm_random", "", "");
}

// 最近登録の本新着5件
$sql  = "SELECT ";
$sql .= "source_asin AS source_asin ";
$sql .= "FROM SOURCE_MASTER ";
$sql .= "WHERE source_asin IS NOT NULL ";
$sql .= "ORDER BY ";
$sql .= "source_id DESC ";
$sql .= "LIMIT 5 ";
$result = pg_query($dbconn,$sql);
for($i=0;$i<pg_numrows($result);$i++)
{
	$arrival_book_list[$i+1] = pg_result($result,$i,'source_asin');
}

?>
<!--↓全体-->
<table width=901 border=0 cellspacing=0 cellpadding=0>
<tr valign=top>
<td width=10><img src=<?=$URL?>img/1pix0000.gif alt= width=10 height=1 border=0 /></td>
<td width=731>
<!--↓コンテンツ-->
<table width=731 border=0 cellspacing=0 cellpadding=0>
	<tr>
		<td width=170><a href=<?=$URL?>><img src=<?=$URL?>img/top_title01.jpg alt=ことば探し width=170 height=64 border=0 /></a></td>
		<td width=561 background=<?=$URL?>img/top_title02.jpg valign=top><table width=561 border=0 cellspacing=0 cellpadding=10><tr><td valign=top><marquee behavior=slide scrolldelay=50 scrollamount=6><a href=<?=$URL?>afm.php?afm_id=<?=$afm_random['afm_id']?>><font color=ffffff size=2>★<?=$afm_random['afm_value']?>★</font></a></marquee></td></tr></table></td>
	</tr>
</table>
