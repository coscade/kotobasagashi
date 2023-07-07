<?php
require_once '../inc/func.inc';
$CONTENTS_TITLE = '■「夫婦関係を考えるおすすめ本　３３冊」■<br><span id="kihon"bold>　～今、悩んでいる人も、うまくいっている人にもおすすめ～</span>';
require_once $_SERVER["DOCUMENT_ROOT"] . '/inc/head_set_1column.inc';
$dbconn = dbconn();

function view_danjyo_books($num, $source_id, $info)
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
    <tr valign=top bgcolor=#F6FFDF id="kihon">
        <td width=1% id="kihon"bold >{$num}&nbsp;</td>
        <td width=39%><a href=/book/view.php?sid={$source_id}>{$source_name}&nbsp;</a></td>
        <td width=39%>{$info}&nbsp;</td>
        <td width=1% nowrap>
EOM;
        echo view_source_rec_level($source_rec_level);
        echo <<< EOM
        </td>
        <td width=20%><A href=http://www.amazon.co.jp/exec/obidos/ASIN/{$source_asin}/aaaaea00-22 target=_blank>{$source_author}</a>&nbsp;</td>
    </tr>
EOM;
    }
}

?>
    <div align=center>

<?php require_once('top_menu.inc') ?>

    <div align="right">
    <table border="0" width="709" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <div id="yomimokujioo"><img src="/img/point_ko2.gif" alt="" width="22" height="17" border="0">「夫婦関係を考えるおすすめ本　３３冊」……<br><br>
                    　パートナーのことがわからない、どうしたらうまくいくの？　悩んでいるなら…<br>
                    　以下の本、どれか一冊でも、読んでみることをおすすめします。<br>
                    　きっと、気づきがあり、なるほどと思うことがあり、光がみえてくるはずです。
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
                        <td>本の題名と詳しい紹介</td>
                        <td>こんな方におすすめ＆内容</td>
                        <td>おすすめ度</td>
                        <td>Amazonへは<br>コチラから</td>
                    </tr>
                    <?php view_danjyo_books(1, 392, '必読書！夫婦のあり方を見直して見たい方'); ?>
                    <?php view_danjyo_books(2, 393, '必読書！夫と妻の心理を知りたい方'); ?>
                    <?php view_danjyo_books(3, 896, "おすすめ！夫はなぜ変わらないのか…と思っている方"); ?>
                    <?php view_danjyo_books(4, 468, '夫を信頼してみよう。賢い妻を目指したい方'); ?>
                    <?php view_danjyo_books(5, 1102, 'わがまま夫、俺様夫、幼稚な夫など、夫は未熟？と思う方におすすめ'); ?>
                    <?php view_danjyo_books(6, 899, '疲れたわぁ、もっと楽しい結婚生活をしたいわぁと思っている方におすすめ。気楽読めます'); ?>
                    <?php view_danjyo_books(7, 1009, '夫婦のあり方を、ちょっと見つめ直して見たい方。'); ?>
                    <?php view_danjyo_books(8, 611, '男性の「浮気心理」を知りたい方。男性に本音を取材している本'); ?>
                    <?php view_danjyo_books(9, 952, '人間心理から夫婦関係を知りたい方に。やや専門的。'); ?>
                    <?php view_danjyo_books(10, 1140, '今のままではいけない、何とかしたいと思う方に'); ?>
                    <?php view_danjyo_books(11, 1001, '夫に正しく尽くす本。夫婦関係を良くしたい方に'); ?>
                    <?php view_danjyo_books(12, 756, '１６年間の夫婦実態調査から導き出した、結婚の法則。結婚を見直してみたい方におすすめ'); ?>
                    <?php view_danjyo_books(13, 986, 'うまく結婚を続けるためのコツ、方法を具体的に知りたい方'); ?>
                    <?php view_danjyo_books(14, 674, 'どうしても夫にイライラしてしまう方に。中高年夫婦向け'); ?>
                    <?php view_danjyo_books(15, 872, "結婚って…何？と疑問に思っている方。新婚～１０年目位の方におすすめ"); ?>
                    <?php view_danjyo_books(16, 669, '男女の違いから夫婦関係のあり方を見つめたい方'); ?><?php view_danjyo_books(17, 688, '取材本。離婚した男性の本音を知りたい方'); ?>
                    <?php view_danjyo_books(18, 885, '夫の言葉に太刀打ちできない、言葉の暴力に悩んでいる方におすすめ'); ?>
                    <?php view_danjyo_books(19, 1011, '定年後の夫婦のあり方を考えたい方におすすめ。５０代以降の方におすすめ'); ?>
                    <?php view_danjyo_books(20, 943, '夫婦間の中での男女の違いを感じる方'); ?>
                    <?php view_danjyo_books(21, 1181, '愛を深めるための７つのルールを教えてくれます。やや専門的'); ?>
                    <?php view_danjyo_books(22, 981, '取材本。夫の不倫に悩んでいる方'); ?>
                    <?php view_danjyo_books(23, 864, '夫婦の実態を知りたい方'); ?>
                    <?php view_danjyo_books(24, 997, '夫婦で結婚生活を考えて見たい方。少し専門的'); ?>
                    <?php view_danjyo_books(25, 882, '取材本。夫の実態、本音を知りたい方'); ?>
                    <?php view_danjyo_books(26, 909, '夫婦会話のコツを知りたい方'); ?>
                    <?php view_danjyo_books(27, 949, '夫と妻の「基本的心理」を知りたい方'); ?>
                    <?php view_danjyo_books(28, 966, '妻の変化に気づかない男性向けの本'); ?>
                    <?php view_danjyo_books(29, 969, 'Q&A形式で答える、夫婦関係の心理'); ?>
                    <?php view_danjyo_books(30, 994, '子供が生まれてからの夫婦に変化について知りたい方。調査などからわかった実態。少し専門的'); ?>
                    <?php view_danjyo_books(31, 1004, '実例本。夫と妻の日常心理を知りたい方'); ?>
                    <?php view_danjyo_books(32, 973, '熟年夫婦の会話のコツ'); ?>
                    <?php view_danjyo_books(33, 894, '言っちゃいけないことば集'); ?>
                </table>
            </td>
        </tr>
    </table>
    <br>
    ※もっと本を知りたい場合は、<a href="/book/list.php?sc=2"><strong>「愛・夫婦・結婚」</strong></a>をどうぞ。
    <br><br>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/inc/foot_set_1column.inc'; ?>