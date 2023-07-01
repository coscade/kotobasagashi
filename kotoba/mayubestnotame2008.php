<?
require_once '../inc/func.inc';

$dbconn = dbconn();

$KOTOBA = NULL;
$SOURCE = NULL;

//ここから、ことばのIDを5個選んで書き込んでください。
//例：$KOTOBA[0] = select_kotoba(ことばのID);

$KOTOBA[0] = select_kotoba(2976);
$KOTOBA[1] = select_kotoba(2975);
$KOTOBA[2] = select_kotoba(2971);
$KOTOBA[3] = select_kotoba(2966);
$KOTOBA[4] = select_kotoba(2962);
$KOTOBA[5] = select_kotoba(2960);
$KOTOBA[6] = select_kotoba(2957);
$KOTOBA[7] = select_kotoba(2954);
$KOTOBA[8] = select_kotoba(2952);
$KOTOBA[9] = select_kotoba(2949);
$KOTOBA[10] = select_kotoba(2947);
$KOTOBA[11] = select_kotoba(2945);
$KOTOBA[12] = select_kotoba(2934);

$KOTOBA[13] = select_kotoba(2932);
$KOTOBA[14] = select_kotoba(2920);
$KOTOBA[15] = select_kotoba(2913);
$KOTOBA[16] = select_kotoba(2908);
$KOTOBA[17] = select_kotoba(2903);
$KOTOBA[18] = select_kotoba(2899);
$KOTOBA[19] = select_kotoba(2895);
$KOTOBA[20] = select_kotoba(2887);
$KOTOBA[21] = select_kotoba(2881);

$KOTOBA[22] = select_kotoba(2854);
$KOTOBA[23] = select_kotoba(2851);
$KOTOBA[24] = select_kotoba(2846);
$KOTOBA[25] = select_kotoba(2842);
$KOTOBA[26] = select_kotoba(2837);
$KOTOBA[27] = select_kotoba(2834);
$KOTOBA[28] = select_kotoba(2832);
$KOTOBA[29] = select_kotoba(2828);

$KOTOBA[30] = select_kotoba(2819);
$KOTOBA[31] = select_kotoba(2814);
$KOTOBA[32] = select_kotoba(2811);
$KOTOBA[33] = select_kotoba(2807);
$KOTOBA[34] = select_kotoba(2801);
$KOTOBA[35] = select_kotoba(2797);
$KOTOBA[36] = select_kotoba(2795);
$KOTOBA[37] = select_kotoba(2784);
$KOTOBA[38] = select_kotoba(2781);
$KOTOBA[39] = select_kotoba(2778);
$KOTOBA[40] = select_kotoba(2777);
$KOTOBA[41] = select_kotoba(2775);
$KOTOBA[42] = select_kotoba(2774);
$KOTOBA[43] = select_kotoba(2767);
$KOTOBA[44] = select_kotoba(2764);
$KOTOBA[45] = select_kotoba(2756);
$KOTOBA[46] = select_kotoba(2750);
$KOTOBA[47] = select_kotoba(2739);
$KOTOBA[48] = select_kotoba(2736);
$KOTOBA[49] = select_kotoba(2730);
$KOTOBA[50] = select_kotoba(2727);

$KOTOBA[51] = select_kotoba(2708);
$KOTOBA[52] = select_kotoba(2707);
$KOTOBA[53] = select_kotoba(2706);
$KOTOBA[54] = select_kotoba(2697);
//ここまで。

for($i=0;$i<count($KOTOBA);$i++){
	$SOURCE[$i] = select_source($KOTOBA[$i]['SOURCE_ID']);
	$KOTOBA[$i][KOTOBA_VALUE] = nl2br($KOTOBA[$i][KOTOBA_VALUE]);
	$KOTOBA[$i][KOTOBA_DATE] = date("Y年n月j日",strtotime($KOTOBA[$i][KOTOBA_DATE]));
}

//$CONTENTS_TITLE = date("Y年m月d日",strtotime($KOTOBA['KOTOBA_DATE']))."<br>■２００７年「今日のことば」まゆのベスト１０■";
$CONTENTS_TITLE = "■２００９年「今日のことば」まゆのためのことば■";
require_once $INC_PATH.'head_set_2column.inc';
?><br>
<div id="kihon"> 


<?
for($i=0;$i<=70;$i++){
?>

<div id="kotobamidashi">
<img src="http://www.kotobasagashi.net/img/point_ko.gif" alt="" width="25" height="20" border=0 />
<a href=http://www.kotobasagashi.net/kotoba/view.php?kid=<?=$KOTOBA[$i][KOTOBA_ID];?>><?=$KOTOBA[$i][KOTOBA_DATE];?>のことば</a>
</div>

<div id="kotobanakami">

<?=$KOTOBA[$i][KOTOBA_VALUE];?>
<br>
<table border=0 cellspacing="0" cellpadding="0">
  <tr>
    <td width="9"><img src="http://www.kotobasagashi.net/img/list_imd.gif" alt="" width="9" height="9" border=0></td>
    <td width="5"><img src="http://www.kotobasagashi.net/img/1pix0000.gif" alt="" width="5" height="1" border=0 /></td><br>
    <td width="60"><span class="sidemenu">出典元</span></td>
    <td id=kihon><a href=http://www.kotobasagashi.net/book/view.php?sid=<?=$SOURCE[$i][source_id];?>><?=$SOURCE[$i][source_name];?></a></td>
  </tr>
  <tr>
    <td width="9"><img src="http://www.kotobasagashi.net/img/list_imd.gif" alt="" width="9" height="9" border=0></td>
    <td width="5"><img src="http://www.kotobasagashi.net/img/1pix0000.gif" alt="" width="5" height="1" border=0 /></td>
    <td width="60"><span class="sidemenu">著者名</span></td>
    <td id=kihon><?=$SOURCE[$i][source_author];?> </td>
  </tr>
</table>
</div>
<br>

<?
}
?>
</div>








<?php require_once $INC_PATH.'foot_set_2column.inc';?>
