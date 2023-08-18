<?php
if (!isset($afm_random)) {
    $afm_random = get_table_data($dbconn, "v_afm_random", "", "");
}

// 最近登録の本新着5件
$sql = "SELECT ";
$sql .= "source_asin AS source_asin ";
$sql .= "FROM SOURCE_MASTER ";
$sql .= "WHERE source_asin IS NOT NULL ";
$sql .= "ORDER BY ";
$sql .= "source_id DESC ";
$sql .= "LIMIT 5 ";
$result = pg_query($dbconn, $sql);
for ($i = 0; $i < pg_numrows($result); $i++) {
    $arrival_book_list[$i + 1] = pg_result($result, $i, 'source_asin');
}

?>
<!--↓全体-->
<table width="901" border="0" cellspacing=0>
    <tr valign="top">
        <td width="10"><img src="/img/1pix0000.gif" width="10" height="1" border="0"/></td>
        <td width="731">
            <div id="header">
                <h1><a href="/"><img src="/img/top_title01.jpg" alt="ことば探し"></a></h1>
                <div>
                    <marquee behavior="slide" scrolldelay="50" scrollamount="6">
                        <a href="/afm.php?afm_id=<?= $afm_random['afm_id'] ?>">★<?= $afm_random['afm_value'] ?>★</a>
                    </marquee>
                </div>
            </div>
