<?php
require_once '../inc/func.inc';
$CONTENTS_TITLE = "■「おすすめの本」一覧■";
require_once $_SERVER["DOCUMENT_ROOT"] . '/inc/head_set_1column.inc';
$dbconn = dbconn();

function view_yomikata_books($num, $source_id, $info)
{
    global $URL;
    global $dbconn;

    $sql_num = "select count(source_id) as num from source_master where source_id = {$source_id}";
    $result = pg_query($dbconn, $sql_num);
    $count = pg_result($result, 0, 'num');

    if ($count == 1) {
        $sql = "select ";
        $sql .= "source_name      , ";
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

<?php require 'top_menu.inc'; ?>

    <br>

    <table border="0" cellpadding=0 cellspacing=0>
        <tr>
            <td bgcolor=#6DA14B>
                <table border="0" width=709 cellpadding=3 cellspacing=1>
                    <tr align=center bgcolor=#EEF2AF id="kihon"bold>
                        <td>&nbsp;</td>
                        <td>こんな方、ときにおすすめ</td>
                        <td>本の題名</td>
                        <td>おすすめ度</td>
                        <td>Amazonへは<br>コチラから</td>
                    </tr>
                    <?php view_yomikata_books(1, 671, "楽しい世界をみてみたい"); ?>
                    <?php view_yomikata_books(2, 686, "スゴイを実感したい"); ?>
                    <?php view_yomikata_books(3, 672, '熱い気持を実感したい'); ?>
                    <?php view_yomikata_books(4, 673, '深く、楽しい世界を知りたい'); ?>
                    <?php view_yomikata_books(5, 687, 'わがままな男性に悩んでいる女性'); ?>
                    <?php view_yomikata_books(6, 368, '女性がわからないと悩んでいる男性'); ?>
                    <?php view_yomikata_books(7, 674, '夫婦間のことでもやもやしている女性'); ?>
                    <?php view_yomikata_books(8, 688, '夫婦間のことがどうもわからない男性'); ?>
                    <?php view_yomikata_books(9, 689, '営業で勝ち抜きたい'); ?>
                    <?php view_yomikata_books(10, 690, '〃'); ?>
                    <?php view_yomikata_books(11, 691, '人生を勝ち抜きたい'); ?>
                    <?php view_yomikata_books(12, 818, '〃'); ?>
                    <?php view_yomikata_books(13, 346, '考え方をプラス思考にしてバリバリやっていきたい'); ?>
                    <?php view_yomikata_books(14, 508, 'コミュニケーション能力を身につけたい'); ?>
                    <?php view_yomikata_books(15, 693, 'やっぱり賢いといったら哲学！と思う'); ?>
                    <?php view_yomikata_books(16, 694, 'ちょっと生き詰まってるとき'); ?>
                    <?php view_yomikata_books(17, 695, '心配性でいつも切ない思いをしている'); ?>
                    <?php view_yomikata_books(18, 696, '〃'); ?>
                    <?php view_yomikata_books(19, 415, '病気と心の関係を知りたい'); ?>
                    <?php view_yomikata_books(20, 697, '他の国の生活を知りたいとき（フランス）'); ?>
                    <?php view_yomikata_books(21, 487, '他の国の生活を知りたいとき（イギリス）'); ?>
                    <?php view_yomikata_books(22, 37, 'ほしいものを手に入れたいとき'); ?>
                    <?php view_yomikata_books(23, 36, '〃'); ?>
                    <?php view_yomikata_books(24, 347, 'アーティストになりたい'); ?>
                    <?php view_yomikata_books(25, 703, 'イメージを視覚化して成功したい'); ?>
                    <?php view_yomikata_books(26, 604, '成功するための心構え、法則をしりたい。'); ?>
                    <?php view_yomikata_books(27, 704, '寂しいとき、心に風がヒューとふいているとき'); ?>
                    <?php view_yomikata_books(28, 419, '深い深い感動にふれたいとき'); ?>
                    <?php view_yomikata_books(29, 479, '癒されながら…愛について考えてみたい'); ?>
                    <?php view_yomikata_books(30, 430, '許すことを覚えたい'); ?>
                    <?php view_yomikata_books(31, 705, '冒険を味わいたいとき'); ?>
                    <?php view_yomikata_books(32, 706, 'ほのぼの＋わくわくしたいとき'); ?>
                    <?php view_yomikata_books(33, 707, '〃'); ?>
                    <?php view_yomikata_books(34, 709, '〃'); ?>
                    <?php view_yomikata_books(35, 708, '懐かしさや、ワクワク感を取り戻したいとき'); ?>
                    <?php view_yomikata_books(36, 710, 'まか不思議な世界を体験したいとき'); ?>
                    <?php view_yomikata_books(37, 711, '最近お気に入りの料理本'); ?>
                    <?php view_yomikata_books(38, 712, '〃'); ?>
                    <?php view_yomikata_books(39, 713, '〃'); ?>
                    <?php view_yomikata_books(40, 42, '過去の偉人たちがどう生きてきたか知りたい'); ?>
                    <?php view_yomikata_books(41, 714, '〃'); ?>
                    <?php view_yomikata_books(42, 27, '深い人間理解をしたいとき'); ?>
                    <?php view_yomikata_books(43, 588, 'わかりやすく人間心理を知りたい'); ?>
                    <?php view_yomikata_books(44, 715, 'わかりやすく人間心理を知りたい'); ?>
                    <?php view_yomikata_books(45, 716, '自分を知りたいとき'); ?>
                    <?php view_yomikata_books(46, 294, '〃'); ?>
                    <?php view_yomikata_books(47, 547, '人間というのももっと知りたい'); ?>
                    <?php view_yomikata_books(48, 718, '働く人の心と病気を知りたい'); ?>
                    <?php view_yomikata_books(49, 719, '老人の心理を知りたい'); ?>
                    <?php view_yomikata_books(50, 678, '男女の違いを感じる'); ?>
                    <?php view_yomikata_books(51, 392, '男女の違いを理解したい'); ?>
                    <?php view_yomikata_books(52, 373, '〃'); ?>
                    <?php view_yomikata_books(53, 641, '成功した方の本'); ?>
                    <?php view_yomikata_books(54, 640, '〃'); ?>
                    <?php view_yomikata_books(55, 507, '〃'); ?>
                    <?php view_yomikata_books(56, 721, '〃'); ?>
                    <?php view_yomikata_books(57, 720, '〃'); ?>
                    <?php view_yomikata_books(58, 722, '〃'); ?>
                    <?php view_yomikata_books(59, 726, '手軽に人生の教訓を得たい'); ?>
                    <?php view_yomikata_books(60, 727, '〃'); ?>
                    <?php view_yomikata_books(61, 296, '漫画を読みながら、生きるヒントを得たい'); ?>
                    <?php view_yomikata_books(62, 302, '〃'); ?>
                    <?php view_yomikata_books(63, 728, '手軽に、男女の違いを知りたい'); ?>
                    <?php view_yomikata_books(64, 730, '速読を身につけたい'); ?>
                    <?php view_yomikata_books(65, 729, '〃'); ?>
                    <?php view_yomikata_books(66, 375, '私がタイトルだけで買ってしまった本'); ?>
                    <?php view_yomikata_books(67, 732, '〃'); ?>
                    <?php view_yomikata_books(68, 7, '〃'); ?>
                    <?php view_yomikata_books(69, 733, '〃'); ?>
                    <?php view_yomikata_books(70, 734, '〃'); ?>
                    <?php view_yomikata_books(71, 735, '〃'); ?>
                    <?php view_yomikata_books(72, 521, '〃'); ?>
                    <?php view_yomikata_books(73, 736, 'まゆの人生を変えた本'); ?>
                    <?php view_yomikata_books(74, 319, '〃'); ?>

                    <?php view_yomikata_books(75, 823, '【参考図書'); ?>
                    <?php view_yomikata_books(76, 820, '【参考図書'); ?>
                    <?php view_yomikata_books(77, 822, '【参考図書'); ?>

                    <?php view_yomikata_books(78, 731, '【参考図書】'); ?>
                    <?php view_yomikata_books(79, 725, '【参考図書】'); ?>
                    <?php view_yomikata_books(80, 723, '【参考図書】'); ?>
                    <?php view_yomikata_books(81, 737, '【参考図書】'); ?>
                    <?php view_yomikata_books(82, 738, '【参考図書】'); ?>
                    <?php view_yomikata_books(83, 739, '【参考図書】'); ?>
                    <?php view_yomikata_books(84, 740, '【参考図書】'); ?>
                    <?php view_yomikata_books(85, 821, '【参考図書】'); ?>
                    <?php view_yomikata_books(86, 824, '【参考図書】'); ?>
                    <?php view_yomikata_books(87, 741, '【参考図書】'); ?>
                    <?php view_yomikata_books(88, 742, '【参考図書】'); ?>
                    <?php view_yomikata_books(89, 743, '【参考図書】'); ?>
                    <?php view_yomikata_books(90, 825, '【参考図書】'); ?>
                </table>
            </td>
        </tr>
    </table>
    <br><br>

<?php require_once $INC_PATH . 'foot_set_1column.inc'; ?>