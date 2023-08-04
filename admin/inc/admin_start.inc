<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ことば探し管理画面</title>
    <link rel="stylesheet" href="/css/admin.css">
    <script language=JavaScript src=/js/main.js></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
</head>
<body>
<div id="admin">
    <nav>
        <h1><a href="/admin/">管理者メニューTOP</a></h1>
        <ul>
            <li>
                <form action="news_list.php" method="post">
                    <input type="submit" value='ニュース'>
                </form>
            </li>
            <li>
                <form action="afm_list.php" method="post">
                    <input type="submit" value='アファメーション'>
                </form>
            </li>
            <li>
                <form action="enq.php" method="post">
                    <input type="submit" value='アンケート結果'>
                </form>
            </li>
            <li>
                <form action="kc_admit_1_list.php" method="get">
                    <input type="submit" value='読者の感想'>
                </form>
            </li>
            <li>
                <form action="source.php" method="post">
                    <input type="submit" value='本の登録'>
                    <input type="hidden" name=submit value='修正'>
                </form>
            </li>
            <li>
                <form action="source_list.php" method="post">
                    <input type="submit" value='本リスト'>
                </form>
            </li>
            <li>
                <form action="reading_list.php" method="post">
                    <input type="submit" value='今読んでいる本'>
                </form>
            </li>
            <li>
                <form action="danjyo_list.php" method="post">
                    <input type="submit" value='今週の男女の違い'>
                </form>
            </li>
        </ul>
    </nav>
    <main>
