<?php
require_once '../inc/func.inc';

$dbconn = dbconn();

$KOTOBA = NULL;
$SOURCE = NULL;

//ここから、ことばのIDを5個選んで書き込んでください。
//例：$KOTOBA[0] = select_kotoba(ことばのID);


$KOTOBA[0] = select_kotoba(2371);
$KOTOBA[1] = select_kotoba(2382);
$KOTOBA[2] = select_kotoba(2383);
$KOTOBA[3] = select_kotoba(2370);
$KOTOBA[4] = select_kotoba(2379);


//ここまで。

for ($i = 0; $i < count($KOTOBA); $i++) {
    $SOURCE[$i] = select_source($KOTOBA[$i]['SOURCE_ID']);
    $KOTOBA[$i][KOTOBA_VALUE] = nl2br($KOTOBA[$i][KOTOBA_VALUE]);
    $KOTOBA[$i][KOTOBA_DATE] = date("Y年n月j日", strtotime($KOTOBA[$i][KOTOBA_DATE]));
}

$CONTENTS_TITLE = date("Y年m月d日", strtotime($KOTOBA['KOTOBA_DATE'])) . "<br>■「今日のことば」２月の人気ベスト５■";
require_once $_SERVER["DOCUMENT_ROOT"] . '/inc/head_set_2column2.inc';
?>


<div >

    <?php
    for ($i = 0; $i <= 4; $i++) {
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
                    <td ><a
                                href=/book/view.php?sid=<?= $SOURCE[$i][source_id]; ?>><?= $SOURCE[$i][source_name]; ?></a>
                    </td>
                </tr>
                <tr>
                    <td width="9"><img src="/img/list_imd.gif" alt="" width="9" height="9" border="0"></td>
                    <td width="5"><img src="/img/1pix0000.gif" alt="" width="5" height="1" border="0"/></td>
                    <td width="60"><span class="sidemenu">著者名</span></td>
                    <td ><?= $SOURCE[$i][source_author]; ?> </td>
                </tr>
            </table>
        </div>
        <br>

        <?php
    }
    ?>
</div>


<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/inc/foot_set_2column2.inc' ?>
