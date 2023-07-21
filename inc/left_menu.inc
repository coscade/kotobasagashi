<!--↓左メニュー-->
<div id="leftfortop">
    <h2><a href="/" id="whitelink">TOP</a></h2>
</div>

<div id="left">
    <ul>
        <li><a href="/ChargeMenu.php" id="greenlink">いろいろ相談室<br>
                「楽になろっ！」</a></li>
        <li><a href="/kotoba/view.php" id="categorylink"><b>押してみて！　今日の<br>「ことば占い」</b></a></li>
        <li><a href="/afm.php" id="greenlink">アファメーションとは？</a></li>
        <li><a href="/mujicard.php" id="greenlink">「無地のカード」ページ</li>
        <li><a href="/oraclecards.php" id="greenlink">オラクルカードの<br>ページへようこそ</li>
    </ul>
</div>

<div id="leftyomikata">
    <h2><a href="/yomikata/01.php" id="whitelink">本の読み方＆<br>おすすめの本</a></h2>
</div>

<div id="left">
    <ul>
        <li>
            <a href="/yomikata/reading.php?" id="greenlink">今日のおすすめ本↓<br>
                「素直な自分表現アサーティブ」岩舩 展子著,渋谷 武子著</A>
            <img src="/img/newgs.gif" alt="" width="27" height="15" border="0"><br><br>
        </li>
        <li>
            <a href="/yomikata/books2.php" id="greenlink">
                夫婦関係を考える<br>「おすすめ本３３冊」</strong><A href="/yomikata/books2.php"></A><br>
            </a>
        </li>
        <li><a href="/danjyo/books.php" id="greenlink">男女の違い必読<br>「おすすめ本２０冊」」</A></li>
        <li>
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
        </li>
    </ul>
</div>

<div id="searchwords">
    <h2><a href="/kotoba/list.php" id="whitelink">今日のことば検索</a></h2>
</div>

<div id="left">
    <ul>
        <li><a href="/kotoba/calendar.php" id="categorylink"><b>日付順で見る<br>（過去のことば）</b></a></li>
        <li><a href="/kotoba/list.php" id="categorylink"><b>全て見る
                    (※探したい<br>「ことば」はコチラから)</a></li>
    </ul>
</div>

<div align="center">
    <form action="/kotoba/list.php" method=get>
        <input name=key type=text size=16 value="<?= isset($_GET['key']) ? $_GET['key'] : ""; ?>" class="nyuryoku">
        <input value=検索 type=submit>
    </form>
</div>

<div id="leftdanjyo">
    <h2><a href="/danjyo/01.php" id="whitelink">必見！本から読み<br>とく「男女の違い」</a></h2>
</div>

<div id="left">
    <ul>
        <li>
            <a href="/danjyo/weekly.php" id="greenlink">男女の違いって？↓<br>「自分を見つめて、自分の感情を知ろう…その方法」</a>
        </li>
        <li><a href="/book/list.php?sc=1" id="greenlink">男女・恋愛の本一覧</A></li>
        <li><a href="/book/list.php?sc=2" id="greenlink">愛・夫婦・結婚の本<br>一覧</A></li>
    </ul>
</div>

<div id="searchbooks">
    <h2><a href="/book/list.php" id="whitelink">本の検索</a></h2>
</div>

<div align="center">
    <form action="/book/list.php" method=get>
        <input name=key type=text size=16 value="<?= isset($_GET['key']) ? $_GET['key'] : ""; ?>" class="nyuryoku">
        <input value=検索 type=submit>
    </form>
</div>

<div id="left">
    <ul>
        <li><a href="/about.php" id="greenlink">このページについて</a></li>
        <li><a href="/owner.php" id="greenlink">主催者について</a>
        <li><a href="/mm.php" id="greenlink">メルマガ登録と解除</a></li>
        <li><a href="/map.php" id="greenlink">サイトマップ</a></li>
    </ul>
</div>

<div id="leftcontact">
    <ul>
        <li>
            <h2><? form_mail("お問合せはこちら"); ?>お問合せ<br>主催者へのメール</a></h2>
        </li>
        <li>
            <h2>転載する場合は<br>「ことば探し」の明記<br>お願いいたします。<br>
                転載した場合は、<br>ご一報お願いいたします。無断掲載禁止
            </h2>
        </li>
    </ul>
</div>

<div id="counter">
    <img src="/img/cnt_left.gif" alt="" width="14" height="40" border="0">
    <? make_counter(); ?>
    <img src="/img/cnt_righ.gif" alt="" width="39" height="40" border="0">
</div>
<br>
<!--↑左メニュー-->
