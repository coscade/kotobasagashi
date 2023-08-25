<?php
if (!isset($afm_random)) {
    $afm_random = get_table_data($dbconn, "v_afm_random", "", "");
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
        <marquee behavior="slide" scrolldelay="50" scrollamount="6">
            <a href="/afm.php?afm_id=<?= $afm_random['afm_id'] ?>">★<?= $afm_random['afm_value'] ?>★</a>
        </marquee>
    </div>
</header>

