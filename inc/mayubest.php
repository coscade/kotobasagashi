<?php
require_once '../inc/func.inc';

$dbconn = dbconn();

$KOTOBA = NULL;
$SOURCE = NULL;

//ここから、ことばのIDを5個選んで書き込んでください。
//例：$KOTOBA[0] = select_kotoba(ことばのID);
$KOTOBA[0] = select_kotoba(1595);
$KOTOBA[1] = select_kotoba(1658);
$KOTOBA[2] = select_kotoba(1646);
$KOTOBA[3] = select_kotoba(1682);
$KOTOBA[4] = select_kotoba(1666);
$KOTOBA[5] = select_kotoba(1768);
$KOTOBA[6] = select_kotoba(1912);
$KOTOBA[7] = select_kotoba(1919);
$KOTOBA[8] = select_kotoba(1929);
$KOTOBA[9] = select_kotoba(1959);

//ここまで。

for ($i = 0; $i < count($KOTOBA); $i++) {
    $SOURCE[$i] = select_source($KOTOBA[$i]['SOURCE_ID']);
    $KOTOBA[$i][KOTOBA_VALUE] = nl2br($KOTOBA[$i][KOTOBA_VALUE]);
    $KOTOBA[$i][KOTOBA_DATE] = date("Y年n月j日", strtotime($KOTOBA[$i][KOTOBA_DATE]));
}

$CONTENTS_TITLE = date("Y年m月d日", strtotime($KOTOBA['KOTOBA_DATE'])) . "<br>■2006年「今日のことば」まゆのベスト１０■";
require_once $_SERVER["DOCUMENT_ROOT"] . '/inc/head_set_2column2.inc';
?><br>
<div id="kihon"><font color=#669933><strong>
            特に私が好きなことば、影響を受けたことばを選んでみました。</font></strong><br>
    昨年は、「夢に向かう」「やる気を出す」「自分の人生を生きる」などが、<br>
    多かったように思います。<br><br>

    みなさまは、何か特にこころに残ったことばありましたか？<br>
    よろしければ、みなさまが影響を受けたことばを教えていただけると<br>
    嬉しいです。ぜひ、教えてくださいませ！<br>

    メールはコチラへ→<A href="/mail.php?title=%A4%AA%CC%E4%B9%E7%A4%BB%A4%CF%A4%B3%A4%C1%A4%E9">「メールを送る」</A><br><br>

    <?php
    for ($i = 0; $i <= 9; $i++) {
        ?>

        <div id="kotobamidashi">
            <img src="/img/point_ko.gif" alt="" width="25" height="20" border="0"/>
            <a href=/kotoba/view.php?kid=<?= $KOTOBA[$i][KOTOBA_ID]; ?>><?= $KOTOBA[$i][KOTOBA_DATE]; ?>のことば</a>
        </div>

        <div id="kotobanakami">

            <?= $KOTOBA[$i][KOTOBA_VALUE]; ?>
            <br>
            <table border="0"  >
                <tr>
                    <td width="9"><img src="/img/list_imd.gif" alt="" width="9" height="9" border="0"></td>
                    <td width="5"><img src="/img/1pix0000.gif" alt="" width="5" height="1" border="0"/></td>
                    <br>
                    <td width="60"><span class="sidemenu">出典元</span></td>
                    <td id="kihon"><a
                                href=/book/view.php?sid=<?= $SOURCE[$i][source_id]; ?>><?= $SOURCE[$i][source_name]; ?></a>
                    </td>
                </tr>
                <tr>
                    <td width="9"><img src="/img/list_imd.gif" alt="" width="9" height="9" border="0"></td>
                    <td width="5"><img src="/img/1pix0000.gif" alt="" width="5" height="1" border="0"/></td>
                    <td width="60"><span class="sidemenu">著者名</span></td>
                    <td id="kihon"><?= $SOURCE[$i][source_author]; ?> </td>
                </tr>
            </table>
        </div>
        <br>

        <?php
    }
    ?>
</div>


<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/inc/foot_set_2column2.inc' ?>
