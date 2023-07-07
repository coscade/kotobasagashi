﻿<?php
require_once '../inc/func.inc';
$CONTENTS_TITLE = '■男女の違いが書いてある　必見！「20冊のおすすめ本」■<br><span id="kihon" bold>　　～この本を読んで、もっとよく違いを知ろう！～</span>';
require_once $_SERVER["DOCUMENT_ROOT"] . '/inc/head_set_1column.inc';
$dbconn = dbconn();

function view_danjyo_books($num, $source_id)
{
    global $URL;
    global $dbconn;

    $sql_num = "select count(source_id) as num from source_master where source_id = {$source_id}";
    $result = pg_query($dbconn, $sql_num);
    $count = pg_result($result, 0, 'num');

    if ($count == 1) {
        $sql = "select ";
        $sql .= "source_name      , ";
        $sql .= "source_subtitle  , ";
        $sql .= "source_author    , ";
        $sql .= "source_translator, ";
        $sql .= "source_rec_level,  ";
        $sql .= "source_asin  ";
        $sql .= "from       ";
        $sql .= "source_master       ";
        $sql .= "where       ";
        $sql .= "source_id = {$source_id} ";

        $result = pg_query($dbconn, $sql);

        $source_name = pg_result($result, 0, 'source_name');
        $source_subtitle = pg_result($result, 0, 'source_subtitle');
        $source_author = pg_result($result, 0, 'source_author');
        $source_translator = pg_result($result, 0, 'source_translator');
        $source_rec_level = pg_result($result, 0, 'source_rec_level');
        $source_asin = pg_result($result, 0, 'source_asin');

        echo <<< EOM
     <tr valign="top" bgcolor="#F6FFDF" id="kihon">
      <td width="1%" id="kihon" bold >{$num}&nbsp;</td>
      <td width="39%"><a href="/book/view.php?sid={$source_id}">{$source_name}&nbsp;</a></td>
      <td width="39%">{$source_subtitle}&nbsp;</td>
      <td width="1%" nowrap>
EOM;
        echo view_source_rec_level($source_rec_level);
        echo <<< EOM
      </td>
      <td width="20%"><A href="http://www.amazon.co.jp/exec/obidos/ASIN/{$source_asin}/aaaaea00-22" target="_blank">{$source_author}</a>&nbsp;</td>
     </tr>
EOM;
    }
}

?>
    <table border="0" width="0" cellpadding="10" cellspacing="0">
        <tr>
            <td id="kihon">
                <img src="/img/point_ko2.gif" alt="" width="22" height="17" border="0">
                <a href=01.php id=greenlink>男女の違いについて</a>
                <img src="/img/point_ko2.gif" alt="" width="22" height="17" border="0">
                <a href=04.php id=greenlink>25の行動</a>
                <img src="/img/point_ko.gif" alt="" width="22" height="17" border="0">
                <a href=table.php id=greenlink>「一目でわかる男女の比較表」</a>
                <img src="/img/point_ko.gif" alt="" width="22" height="17" border="0">
                <a href=weekly.php id=greenlink>今週の「男女の違い」</a>
                <img src="/img/point_ko.gif" alt="" width="22" height="17" border="0">
            </td>
        </tr>
    </table>

    <table border="0" width="709" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <div id="yomimokujioo">
                    <img src="/img/point_ko.gif" alt="" width="22" height="17" border="0" id="danjyo_leaf">
                    「男女の違いについて」書いてある本ベスト２０
                </div>
            </td>
        </tr>
    </table>

    <img src="/img/1pix0000.gif" alt="" width="1" height="20" border="0">
    <table border="0" cellpadding=0 cellspacing=0>
        <tr>
            <td bgcolor="#6DA14B">
                <table border="0" width="709" cellpadding="3" cellspacing="1">
                    <tr align="center" bgcolor="#EEF2AF" id="kihon">
                        <td>&nbsp;</td>
                        <td>本の題名</td>
                        <td>本の副題</td>
                        <td>おすすめ度</td>
                        <td>Amazonへは<br>コチラから</td>
                    </tr>
                    <?php view_danjyo_books(1, 678); ?>
                    <?php view_danjyo_books(2, 392); ?>
                    <?php view_danjyo_books(3, 373); ?>
                    <?php view_danjyo_books(4, 393); ?>
                    <?php view_danjyo_books(5, 679); ?>
                    <?php view_danjyo_books(6, 336); ?>
                    <?php view_danjyo_books(7, 681); ?>
                    <?php view_danjyo_books(8, 783); ?>
                    <?php view_danjyo_books(9, 420); ?>
                    <?php view_danjyo_books(10, 1068); ?>
                    <?php view_danjyo_books(11, 680); ?>
                    <?php view_danjyo_books(12, 682); ?>
                    <?php view_danjyo_books(13, 761); ?>
                    <?php view_danjyo_books(14, 442); ?>
                    <?php view_danjyo_books(15, 608); ?>
                    <?php view_danjyo_books(16, 775); ?>
                    <?php view_danjyo_books(17, 782); ?>
                    <?php view_danjyo_books(18, 669); ?>
                    <?php view_danjyo_books(19, 684); ?>
                    <?php view_danjyo_books(20, 685); ?>
                </table>
            </td>
        </tr>
    </table>
    <br>
    ※もっと本を知りたい場合は、
    <a href="/book/list.php?sc=1"><strong>「男女・恋愛」</strong></a>をどうぞ。<br><br>

<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/inc/foot_set_1column.inc'; ?>