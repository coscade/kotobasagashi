<nav>
    <h2 id="leftfortop"><a href="/">TOP</a></h2>
    <ul>
        <li><a href="/ChargeMenu.php">いろいろ相談室<br>「楽になろっ！」</a></li>
        <li><a href="/kotoba/view.php" id="categorylink">押してみて！　今日の<br>「ことば占い」</a></li>
        <li><a href="/afm.php">アファメーションとは？</a></li>
        <li><a href="/mujicard.php">「無地のカード」ページ</a></li>
        <li><a href="/oraclecards.php">オラクルカードの<br>ページへようこそ</a></li>
    </ul>

    <h2 id="leftyomikata"><a href="/yomikata/01.php">本の読み方＆<br>おすすめの本</a></h2>
    <ul>
        <li>
            <a href="/yomikata/reading.php?">今日のおすすめ本↓<br>
                「がんばっても報われない本当の理由」心屋 仁之助著
                <img src="/img/newgs.gif" alt="" width="27" height="15">
            </a>
        </li>
        <li>
            <a href="/yomikata/books2.php">夫婦関係を考える<br>
                「おすすめ本３３冊」
                <a href="/yomikata/books2.php"></a>
            </a>
        </li>
        <li><a href="/danjyo/books.php">男女の違い必読<br>「おすすめ本２０冊」」</a></li>
    </ul>
    <script charset="utf-8" type="text/javascript">
        amzn_assoc_ad_type = "responsive_search_widget";
        amzn_assoc_tracking_id = "aaaaea00-22";
        amzn_assoc_marketplace = "amazon";
        amzn_assoc_region = "JP";
        amzn_assoc_placement = "";
        amzn_assoc_search_type = "search_box";
        amzn_assoc_width = 120;
        amzn_assoc_height = 90;
        amzn_assoc_default_search_category = "";
        amzn_assoc_default_search_key = "";
        amzn_assoc_theme = "light";
        amzn_assoc_bg_color = "FFFFFF";
    </script>
    <script src="//z-fe.amazon-adsystem.com/widgets/q?ServiceVersion=20070822&Operation=GetScript&ID=OneJS&WS=1&MarketPlace=JP"></script>

    <h2 id="searchwords"><a href="/kotoba/list.php">今日のことば検索</a></h2>
    <ul>
        <li><a href="/kotoba/calendar.php" >日付順で見る<br>（過去のことば）</a></li>
        <li><a href="/kotoba/list.php" >全て見る(※探したい<br>「ことば」はコチラから)</a></li>
    </ul>

    <div>
        <form action="/kotoba/list.php" method="get">
            <input name="key" type="text" size="16" value="<?= isset($_GET['key']) ? $_GET['key'] : "" ?>"
                   class="nyuryoku">
            <input value="検索" type="submit">
        </form>
    </div>

    <h2 id="leftdanjyo"><a href="/danjyo/01.php">必見！本から読み<br>とく「男女の違い」</a></h2>
    <ul>
        <li>
            <a href="/danjyo/weekly.php">男女の違いって？↓<br>「自分を見つめて、自分の感情を知ろう…その方法」</a>
        </li>
        <li><a href="/book/list.php?sc=1">男女・恋愛の本一覧</a></li>
        <li><a href="/book/list.php?sc=2">愛・夫婦・結婚の本<br>一覧</a></li>
    </ul>

    <h2 id="searchbooks"><a href="/book/list.php">本の検索</a></h2>
    <div align="center">
        <form action="/book/list.php" method="get">
            <input name="key" type="text" size="16" value="<?= isset($_GET['key']) ? $_GET['key'] : ""; ?>" class="nyuryoku">
            <input value="検索" type="submit">
        </form>
    </div>

    <ul>
        <li><a href="/about.php">このページについて</a></li>
        <li><a href="/owner.php">主催者について</a>
        <li><a href="/mm.php">メルマガ登録と解除</a></li>
        <li><a href="/map.php">サイトマップ</a></li>
    </ul>

    <div id="leftcontact">
        <ul>
            <li>
                <?= form_mail("お問合せはこちら") ?>お問合せ<br>主催者へのメール</a>
            </li>
            <li>
                <h2>転載する場合は<br>
                    「ことば探し」の明記<br>
                    お願いいたします。<br>
                    転載した場合は、<br>
                    ご一報お願いいたします。無断掲載禁止
                </h2>
            </li>
        </ul>
    </div>
</nav>