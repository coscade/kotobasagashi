<div id="bottom_nave">
    ▼<a href="/">「ことば探し」トップページへ</a>　▲<a href="#pagetop">このページのトップへ</a>
</div>

<div id="bottom_banner">
    <iframe src="http://rcm-fe.amazon-adsystem.com/e/cm?t=aaaaea00-22&o=9&p=16&l=bn1&mode=books-jp&browse=466304&fc1=000000&lt1=_blank&lc1=3366FF&bg1=FFFFFF&f=ifr"
            width="468" height="336"></iframe>
</div>

<footer>
    <hr>
    <small>&copy; 2005 ことば探し. All Rights Reserved.</small>
</footer>

<img src="/img/top_leaf.gif" alt="" id="top_leaf">
<img src="/img/bottom_leaf.gif" alt="" id="bottom_leaf">

</body>
</html>
<?php
if (isset($dbconn)) {
    if (pg_connection_status($dbconn) == true) {
        pg_clode($dbconn);
    }
}
?>