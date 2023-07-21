<?php
require_once '../inc/func.inc';
$CONTENTS_TITLE = '■本から読み解く「男女の違い」」月２回ＵＰ予定■<br><span id="kihon"bold>　　　～さて、どんな違いがあるの？～</span>';
require_once $_SERVER["DOCUMENT_ROOT"] . '/inc/head_set_1column.inc';

$DANJYO_ID = isset($_GET['danjyo_id']) ? $_GET['danjyo_id'] : NULL;
$DANJYO = select_danjyo($DANJYO_ID);

$dbconn = dbconn();

$sql = "SELECT DANJYO_ID, DANJYO_TITLE FROM DANJYO_MASTER ORDER BY DANJYO_ID desc";
$result = pg_query($dbconn, $sql);
$NUM = pg_num_rows($result);

?>

    <style type="text/css"><!--

        div#danjyo_main {
            margin: 0;
            padding: 6px;
            text-align: left;
            background-image: url(../img/kotoba_now_bg.jpg);
            background-repeat: no-repeat;
            border-left: 1px solid #C1DF7D;
            border-top: 1px solid #C1DF7D;
            border-right: 1px solid #95AD5E;
            border-bottom: 1px solid #95AD5E;
        }

        #danjyotable_man {
            font-size: 12px;
            line-height: 120%;
            background: #D7E0EB;
        }

        #danjyotable_woman {
            font-size: 12px;
            line-height: 120%;
            background: #EBD8E2;
        }

        .danjyotable_male {
            font-size: 12px;
            color: #829BBA;
            font-weight: bold;
        }

        .danjyotable_female {
            font-size: 12px;
            color: #BB82A0;
            font-weight: bold;
        }

        .danjyotable_marugreen {
            color: #23673D;
        }

        #danjyo_leaf {
            vertical-align: middle;
        }

        --></style>

    <div align="center">
        <table border="0" width="0" cellpadding="10" cellspacing="0">
            <tr>
                <td id="kihon" nowrap>
                    <img src="/img/point_ko2.gif" alt="" width="22" height="17" border="0">
                    <a href="01.php" id="greenlink">男女の違いについて</a>
                    <img src="/img/point_ko2.gif" alt="" width="22" height="17" border="0">
                    <a href="books.php" id="greenlink">20冊のおすすめ本</a>
                    <img src="/img/point_ko.gif" alt="" width="22" height="17" border="0">
                    <a href="table.php" id="greenlink">「一目でわかる男女の比較表」</a>
                    <img src="/img/point_ko.gif" alt="" width="22" height="17" border="0">
                    <a href="04.php" id="greenlink">25の行動</a>
                    <img src="/img/point_ko.gif" alt="" width="22" height="17" border="0">
                </td>
            </tr>
        </table>
    </div>

    <table border="0" cellpadding="0" cellspacing="4" width="95%">
        <tr valign="top">
            <td>
                <?php
                for ($i = 0; $i < $NUM; $i++) {
                    $ID = pg_result($result, $i, 'DANJYO_ID');
                    $TITLE = pg_result($result, $i, 'DANJYO_TITLE');
                    echo '<a href="weekly.php?danjyo_id=' . $ID . '" id="greenlink">' . $TITLE . '</a><br>';
                }
                ?>
            </td>
            <td width=20><img src="/img/1pix0000.gif" alt="" width="20" height="1" border="0"></td>
            <td bgcolor="#ECFFDF" id="kihon">

                <div align="right">
                    <table border="0" width="500" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <div id="yomimokujioo">
                                    <img src="/img/point_ko.gif" alt="" width="22" height="17" border="0">
                                    <?= $DANJYO['danjyo_title'] ?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>

                <div id="danjyo_main">
                    <?= nl2br(str_replace("<br>", "", $DANJYO['danjyo_value'])) ?>
                </div>

                <br><br>
                <div align="center">
                    <div id="yomionegaim">お願い</div>
                    <div id="yomionegai">
                        「男女の違いについて」何か感じることがありましたら、<br>
                        ぜひ、メールをください。　<? form_mail("「男女の違いについて」"); ?>メールはコチラ</a>
                        へ。<br>
                    </div>
                </div>
            </td>
        </tr>
    </table>

<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/inc/foot_set_1column.inc'; ?>