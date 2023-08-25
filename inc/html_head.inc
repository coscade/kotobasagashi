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
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ことばの贈りもの～「ことば探し」<?= $PAGE_TITLE ?></title>
    <link rel="stylesheet" href="/css/kotoba00.css">
    <link rel="stylesheet" href="/css/app.css">
    <script language=JavaScript src=/js/main.js></script>
</head>
<body>
<div id="pagetop"></div>
<header>
    <h1><a href="/"><img src="/img/top_title01.jpg" alt="ことば探し"></a></h1>
    <div>
    </div>
</header>

