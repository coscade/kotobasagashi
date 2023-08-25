<?php
require_once 'inc/func.inc';
$afm_id = isset($_GET['afm_id']) ? $_GET['afm_id'] : 1;
$afm_random = get_table_data($dbconn, "v_afm_random", "", "");
//$afm_random = get_table_data($dbconn, "afm_master", "afm_id", $afm_id);

$CONTENTS_TITLE = "■アファメーション■";
require_once $_SERVER["DOCUMENT_ROOT"] . '/inc/head_set_2column2.inc';

$sql = "SELECT ";
$sql .= "count(AFM_ID) AS AFM_NUM ";
$sql .= "FROM ";
$sql .= "AFM_MASTER ";
$result = @pg_query($dbconn, $sql);
$AFM_NUM = @pg_result($result, 0, 'AFM_NUM');

?>

    <style type="text/css"><!--

        div#table_back {
            width: 450;
            margin: 0;
            padding: 6px;
            text-align: left;
            background-image: url(/img/kotoba_about_bg.jpg);
            background-repeat: no-repeat;
            background-color: #EFFDE6;
            border-left: 1px solid #C1DF7D;
            border-top: 1px solid #C1DF7D;
            border-right: 1px solid #95AD5E;
            border-bottom: 1px solid #95AD5E;
        }

        --></style>

    <div >
    <span class="naiyou">アファメーション登録数：<b><a href="/afm.php"><?= $AFM_NUM ?></a></b>件</span>
    <br>

    <table border="0"   width=530>
        <tr>
            <td bgcolor=#cc6699 align=center >
                <font color=#ffffff><B>★<?= $afm_random['afm_value'] ?>★</B></font>
            </td>
        </tr>
    </table>

    <br><br>
    <strong>
        （今日のアファメーションが気に入ったら、毎日、何度も何度も<br>
        　口に出して言ってみてください。<br>
        　ただし、焦らず、急がず、自分を責めずに、繰り返しで）
    </strong>
    <br>
    <font color=#2A7F3A><br>
        <B>
            ◆自分にぴったりのアファメーションを見つけたい→<a href=#category>カテゴリから探す</a><br>
            <form action="afm_list.php">
                　　◆アファメーションを文字で検索する：
                <input type=text name=keyword size=20>
                <input type=submit value="検索">
            </form>
        </B>
    </font>
    <br>

    <div id=table_back>
        <b><img src=../img/point_ko2.gif alt=width=22 height=17 border="0">アファメーションを毎日言おう！</b><br>
        <br>
        　「ことば探し」では、新鮮なアファメーション例を毎日お届けします。<br><br><B>
            　その中からあなたにぴったりのアファメーションを見つけてください。<br>
            　そして、あなただけのアファメーションを創りだしてください。<br>
            　そして、あなたの「夢」をかなえてください。<br>
            　なりたいあなたになってください。<br>
            　「ことば探し」はそれをお手伝いします。<br>
            <br>

            <b><img src=../img/point_ko2.gif alt=width=22 height=17 border="0">「アファメーション」とは</b><br>
            <br>
            <font color=#DF1F97>
                　「自分の夢をかなえる」「自分を元気にしてくれる」<br>
                　「理想の自分になる」ために、自分にかけてあげる、<br>
                　魔法のことば、おまじないなのです。<br>
            </font>
            <br><B>
                　肯定的な「自己宣言」「誓い」「念仏」「祈り」「成功キーワード」<br>
                　「心からの強い思い」「自己暗示」「口ぐせ」</B>などとも言われています。<br>
            　<br>
            　このようなことばを、毎日何度も繰り返して自分に言いきかせることで<br>
            　自分の脳に働きかけ、その脳の実現能力をフルに使い、<br>
            　その通りになっていくと言われているものです。<br>
            　これは「言ったもの勝ち」なのです。<br><br>

            　最初は、ちょっと抵抗があるかもしれませんし、違和感があるかも<br>
            　しれませんが、何度も言ってみてください。<br>
            　なじむまで、それが自分のものになるまでは、少し時間がかかるかも<br>
            　しれません。今までにない考え方だとなおさら…<br><br>

            　実は私は、ひとつの自分のためのアファメーションをつくり、<br>
            　それがなじむまで試行錯誤しつつ、４ヶ月ほどかかりました。<br>
            　そして、それからも、もっと自分にピッタリなもの、抵抗のないもの、<br
                    　すんなり言えるもの、何より、自分の気持ちにいちばん合ったものを、<br>　探し続けてきました。<br>
            　そして、今は、自分にあったアファメーションを毎日言い続けています。<br>

            <br><B>
                　「あせらず、あわてず、あきらめず」探して、<br>
                　そして、言い続けてください。<br>
                　これはとても効き目がある「魔法のことば、おまじないなの」です。</B><br><br><br>

            <B><img src=../img/point_ko2.gif alt=width=22 height=17 border="0">自分をポジティブに洗脳させよう<br></B><br>

            　よく、宗教などでの「洗脳」ということばを聞きますが、<br>
            　これと同じで、何度も繰り返して言うこには、とても強い力があります。<br>
            　この洗脳、悪い意味ばかりに使われますが、<B><br>
                　自分で自分をいい方に「洗脳」することも可能なのです。</B><br>
            　気がつかずに自分を「悪い方」に洗脳していることは多いものです。<br>
            　ポジティブな方に自分を「洗脳」していく、こんなことばです。<br>
            　これが、アファメーションを言う目的といってもいいでしょう。<br>
            <br>
            　つまり<br>
            　<font color=#DF1F97><B>「脳の持つ力を利用して、なりたい自分になっていこう」</B></font><br>
            　と言うことなのです。<br>
            　このことばを脳に植え付けるために、何度も何度も繰り返して<br>
            　自分に言いきかせる必要があるのです。<br><br>
            　<B>毎日、毎日、何度も、何度もです。<br>
                　もちろん、見えるところに書いて、貼っておくのもいいですし、<br>
                　パソコンのトップ画面でいつも見れるようにしておくのもいいです。<br>
                　ともかく、１日に何度もそのことばに触れることが大切なのです。<br>
                　脳や深い潜在意識にもしっかりと植え付けるためにです。<br></B><br>

            　例えば「お金がどんどん入ってきて、嬉しい限りです」という<br>
            　アファメーションをカードに書いて、サイフの中に入れておき<br>
            　お金を支払うときに、いつもそのカードをみたりするのも効果的です。<br>
            <br>
            <br>

            <b><img src=../img/point_ko2.gif alt=width=22 height=17 border="0">知らずに使っている「否定語」はすぐにやめましょう！</b><br>
            <br>
            　毎日の暮らしの中では、どうしても「否定語」が多くなります。<br>
            　気がつかずに「ああ、ダメだ」とか「自分って大ばか」とか<br>
            　「あれもこれもうまくいかない」「運がない」などと言っている<br>
            　ことはありませんか？<br>
            　これでは、潜在意識にそんなことばを植え付けてしまいます。<br>
            　すると、そのさらにその通りになっていってしまいます。
            <br><br><B>
                　否定的なことば、つまり「否定語」も、毎日使っていると、<br>
                　そのことば通りになっていくので注意しましょう。<br></B>
            　否定語も、何度も使うことにより脳にインプットされてしまう<br>
            　からです。極力、使うのはよしましょう。<br>
            <br><B><font color=#DF1F97>
                    　１日に何度も繰り返すことばは、「肯定的」なことば、<br>
                    　「ポジティブ」なことばにすることがとてもとても大切です。<br><br></font></B
            <br>
            　このような「肯定的」「ポジティブ」なアファメーションを、<br>
            　毎日、何度も何度も繰り返して唱えて、<br><B>
                　「成功した人、理想の自分になれた人、夢をかなえた人、<br>
                　　幸せになった人、病気を克服した人、元気になった人」<br></B>
            　が世界中にたくさんいて、その人達が、アファメーションを言うことの<br>
            　効果に驚き、そして世界的に広まっています。<br>
            　<B><font color=#DF1F97>そうです、今度は、あなたが試してみる番です。<br></font></B>
            <br><br>


            <b><img src=../img/point_ko2.gif alt=width=22 height=17 border="0">夢はかないます！自分を信じて取り組みましょう。</b><br>
            <br>
            　試すのに、お金もかかりませんし、とても簡単ですし、いつでも<br>
            　出来ることです。ただ、何度も繰り返してことばを言うだけです。<br>
            <br><B><font color=#DF1F97>
                    　人によっては、すぐに効果が現れて来る人もいます。<br>
                    　しかし、効果が現れてくるのに時間がかかる人もあります。<br>
                    　あせらず、あわてず、そして、決してあきらめずの精神で行きましょう。<br>
                    <br></font></B>
            　何十年間も、自分の体に染みついた否定的なことばから、肯定的な<br>
            　ことばに変えることは、時間がかかります。<br>
            　それがなじんだり、何となく違和感がなくなるのにも時間が必要です。<br>
            　ゆっくりとすぐにあきらめたりせずに、取り組んでみてください。<br>
            　１ヶ月や２ヶ月やって効果がないからとやめるともったいです。<br>
            　もっとじっくりと長期的な気持ちで続けましょう。
            　必ずや、効果があります。<br>
            　（もし、なかったら、アファメーションが違っているのかも…）<br>
            <br><B>
                　言うのはただですし、そんなに手間でもかかりません。<br>
                　その効果を信じて、ただ時間のあるときに、唱えるだけですので、<br>
                　ぜひ、継続することをおすすめします。<br></B>
            <br>
            　自分のための、自分にぴったりの「肯定的なことば」アファメーションを<br>
            　何度も繰り返して言ってみましょう<br>
            　きっと、あなたの人生は、変わっていくことでしょう。<br>
            <br><br>


            <b><img src=../img/point_ko2.gif alt=width=22 height=17 border="0">アファメーションを選ぶとき（探すとき）のポイント</b><br>
            <br><B>
                　◎選ぶときには、「自分にぴったりと来るもの」を選んでください。<br>
                　　 もしも、何か「ズレ」のようなものを感じたら、自分流に変えてください。<br>
                　◎そして、言葉にして「うん、いいな、ぴったりくる」と思うものを<br>
                　　 選んでください。<br>
                　◎何度もそのことばを言ってみて、違和感がないかどうか、確かめて<br>
                　　 見てください。<br>
                　◎ことばにして言ってみて「心地よい、わくわくする、落ち着く、元気になる」<br>
                　　 など、自分にぴたりとくることばを探してください。<br></B><br>
            <B><font color=#DF1F97>
                    　なにより、違和感がなく、抵抗なく言えることが大事です。<br>
                    　そんなアファメーションを選んで、あるいは探してみてください。<br>
                    <br></font></B>
            　例えば、「金持ちになりたい」と思っていても、実は、よくよく<br>
            　深堀して考えてみると、<br>
            　「別荘を持って楽しく暮らしたい」ということだったりすることが<br>
            　あります。そんなときには、<br>
            　「お金をたくさん得て、ステキな別荘を買い優雅な生活をしています」<br>
            　と言うふうにアレンジしてみてください。<br>
            　（注／全くオリジナルにアファメーションを作る時には、はずせない<br>
            　　　　ポイントがあるので、それを読んでから作ってみてくださいね）<br>
            <br>
            <br>
            <b><img src=../img/point_ko2.gif alt=width=22 height=17 border="0">オリジナルなアファメーションを作るときのポイント</b><br>
            <br><B><font color=#DF1F97>
                    １）必ず現在形で言う（すでに夢が実現しているとして口に出す）<br></font></B>
            　　実現するにの、一番力をもっている〆ことばは①です。<br>
            　　しかし、抵抗があるようなら、②、③でも大丈夫です。<br><B>
                　　①すでに～しています（実現していることとして言う）<br>
                　　②私は今、～しています（現在形で言う）<br>
                　　③～しつつあります。（断言するのが抵抗ある方はこのいい方で）</B><br>
            　　※しかし、抵抗がなくなったら③→②にいい方を変えてください。<br>
            <br>

            　　なぜ、あたかも「もう実現しているかのように言うのがいいか」、<br>
            　　それは、例えば「作家になりたい」と言っているばかりでは、<br>
            　　作家になるためにどうしたらいいか、どんな準備が必要かなど、<br>
            　　方法論を考えてしまい、一歩が踏み出せなかったりします。<br>
            　　しかし「自分がもう作家だ！」と言い切ってしまえば、やることは<br>
            　　もう書くしかありません。書き始めるしかありません。<br>
            　　そうです、あれこれと考えたり、準備するより、そう言い切った方が、<br>
            　　早道なのです。書き始められるのです。<br>
            　　ですので、もうなっているかのように、実現しているかのように、<br>
            　　言い切った方がいいのです。<br><br>
            <B><font color=#DF1F97>
                    ２）必ず、肯定的なことを言う<br></font></B>
            　　<B>文章全体が、否定的になっていないか確かめてください。</B><br>
            　　例えば、<br>
            　　私は○○をしたいけれど、頑張れるまでやってみます。<br>
            　　ではなく、<br>
            　　私は○○をしたいので、思い切り頑張ります。<br>
            　　或いは、<br>
            　　私は○○をしたいので、とても頑張っています。<br><br>

            　　あたかも、すでに夢がかなっているかのように言い切ってください。<br>
            　　これが効果的です。<br><br>
            <B><font color=#DF1F97>
                    ３）短めに、短いほど効果的<br></font></B><B>
                　　言いやすい、覚えやすければ、長さは自分に合わせてください。</B><br>
            　　ただし、センテンスが長すぎて、何をいわんとしているのか、<br>
            　　わからないようなアファメーションはやめましょう。<br>
            　　自分の無意識にぴしっと伝わることばにしてください。<br>
            <br><B><font color=#DF1F97>
                    ４）自分の感情と矛盾するようなアファメーションにはしない<br></font></B>
            　　つまり、自分は本当は、○○をしたいと思っているのに、<br>
            　　誰かに期待されて▲▲をしなくてはならないときに、<br>
            　　「私は▲▲をとてもうまくやっています」などと言わないこと。<br>

            　<B>　人の期待に応えるアファメーションや、<br>
                　　見栄からくるアファメーションでは、効果がのぞめません。<br>
                　　（心の中で、葛藤が生じてしまって、潜在意識が迷うからです）<br>
                　　本当は、したくないことをアファメーションにしても<br>
                　　効果はありません。<br></B>
            　　言っていて<B>「うんうんそうそう、そうなると本当に嬉しい！」</B><br>
            　　と心から思うことにしてください。<br>
            <br><B><font color=#DF1F97>
                    ５）アファメーションを信じる<br></font></B><B>
                　　そして、アファメーションの力を心から信じましょう。<br></B>
            　　最初はなんだか恥ずかしかったり、否定的な考えも頭に浮かんで<br>
            　　来ますが、いい続けましょう。逆に言えば、言い続けたいものに<br>
            　　することが大切です。<br>
            　　どうしても「自分がかなえたい、実現したい内容」にすることが<br>
            　　大切です。<br>
            　　そして、その実現を心から信じることが大切です。<br>
            　　<br>
            <br>
            <b><img src=../img/point_ko2.gif alt=width=22 height=17 border="0">アファメーションを言うタイミングはいつがいいか？</b><br>
            <br>
            　基本的にはいつでも、言えるときでいいです。<br>
            　言えるときには、いつもで言いましょう。<br>
            　誰かがいて、恥ずかしかったら、小声でどうぞ（笑）<br>
            <br><B><font color=#DF1F97>
                    　★少なくても、毎日１０～３０回以上は唱えてください。<br>
                    　多ければ多いほど効果があがります。★<br>
                    　トイレの中、一人の時間、歩いているとき、夜寝る前、<br>
                    　夕飯の準備をしながら、掃除や洗濯をしながら…<br>
                    　いつでも、どこでも、唱えて見ましょう。<br></B></font>
            <br>
            　しかし、実は、アファメーションを繰り返すのは、眠りにつく前が<br>
            　最も効果的と言われています。眠りにつく前はリラックスしていて、<br>
            　脳がクリアになっており、潜在意識に伝わって行きやすいのです。<br>
            　「羊が何匹…」という代わりに<br>
            　「私は●●で成功する、私は●●で成功する、私は●●で成功する…」<br>
            　と唱えて眠りについてください。（すでに成功している、でもいいですね）<br>
            <br>
            <br>
            <b><img src=../img/point_ko2.gif alt=width=22 height=17 border="0">アファメーションはちょっとまだ抵抗があるなぁ…という方に。</b><br>
            <br>
            それでは、せめて朝起きたときと、夜寝る前に、<br>
            こんなことばを言ってみてください。<br>
            どれか気に入ったことばを繰り返し言ってみてくださいね。<br>
            <br>
            ◆朝起きたら…<br></B><B><font color=#DF1F97>
                <br>
                　・最高の一日になるぞ<br>
                　・すごく、いい予感がする<br>
                　・今日は奇跡が起こる日です<br>
                　・今日は楽しい日になるぞ<br>
                　・今日の仕事はうまくいくぞ<br>
                　・今日も元気で健康だ<br>
                　・今日は輝いている<br>
                　・今日も気持ちいい目覚めだ<br>
                　・よし、いくぞ、そしてやるぞ。<br>
                　・さっ今日も、笑顔でいこう<br>
                　・おてんとうさま、どうもありがとう。<br>
                　・今日も素晴らしい日になるぞ<br>
                　・私はなんて幸せなんだろう<br>
                　・生きてることはすばらしい<br>
                　・きっと今日はステキな１日になるぞ<br>
                　・○○さんときっとうまくいくぞ<br>
                　・今日は、何が起こるか、とても楽しみだ<br>
                　・今日も、ありがとうでいくぞ<br></font></B>
        <br><B>
            ◇夜寝る前に…<br></B>
        <br><B><font color=#DF1F97>
                　・今日も一日ありがとう。○○さん、ありがとう<br>
                　・今日も一日いい日だったな<br>
                　・私は幸せ者<br>
                　・明日はもっといい日になる<br>
                　・今日もぐっすりと眠れるぞ<br>
                　・今日も幸せだった<br>
                　・今日も一日よく頑張った、お疲れさま<br>
                　・私はなんて幸せなんだろう<br>
                　・万事OK<br>
                　・すべてはうまくいっている<br>
                　・今日もいい夢をみるぞ<br>
                　・今日の楽しい日だった<br>
                　・すべてのものに、ありがとう<br>
                　・おとうさん、おかあさんありがとう<br>
                　・私の体、ご苦労様、ゆっくりと休んでね<br>
                　・天の恵みに感謝します<br></font></B><br>

        ぜひ、こんなふうに、自分に言いきかせてみてください。<br>
        きっと、一日がステキに過ごせるし、一日の終わりはきっと<br>
        とてもやすらかなものになるでしょう。<br><br><br>
        <b><img src=../img/point_ko2.gif alt=width=22 height=17 border="0">自分の思いを信じよう</b><br><br>

        　多くの夢をかなえた人、成功者がこう言っています。<br><br>
        <strong><font color=#CC0000>
                ★ロイ・ユージン・デービィス<br></font></strong>
        「人はまず最初に己の願望はきっと成就すると強く信じるならば、<br>
        　どんな人物にもなり得るし、いかなることでも成し遂げることができ、<br>
        　さらにこの世においてどんなものも所有できると言われている。<br>
        　あなたはこのことを信じるだろうか？<br>
        　信じるならば後は簡単である。<br>
        　もしあなたが自分の願望はすでに実現したも同様であるという確信を<br>
        　心にいだいて、その明確に描かれた夢の方向に踏み出すことができる<br>
        　ならば、あなたは間違いなく平凡な夢の持ち主には知るよしもない、<br>
        　確乎とした成功にめぐり会うのである」<br><br><strong><font
                    color=#CC0000>★「成功哲学」を体系化した有名なナポレオン・ヒル氏<br></font></strong>
        常に、こんな「人生を無駄にしないため」のアファメーションを持っていたようです。<br>ちょっとすごいですが、紹介します。<A href=/book/view.php?sid=1490
                                                                               target=_blank　><strong><u>「自己実現」</A></strong></u>
        より<br><br>
        　①時間こそ私の最大の財産です。睡眠時間以外の時間はすべて自己修養の<br>
        　　ために使うよう、時間の収支決算を明確にします。<br>
        　②今後は怠情による時間の無駄づかいは、長短にかかわらず、すべて罪悪と<br>
        　　みなし、時間を有効に活用して償います。<br>
        　③まいた種子は刈り取ることを肝に銘じ、自分のためばかりでなく他人の<br>
        　　ためにもなる種子をだけをまいて、代償の法則に身をゆだねます。<br>
        　④毎日、ある程度の心の平和が得られるような時間の使い方をします。<br>
        　　心の平和が得られない時は、まいた種子を考え直すようにします。<br>
        　⑤私の思考習慣が、長い時間のうちに私の周囲の状況をつくり、私の人生に<br>
        　　影響を与えていることをよくわきまえ、望ましい状況ばかりを考えるよう<br>
        　　にし、恐怖や挫折など望ましくないことを思いわずらう時間などはつくら<br>
        　　ないようにします。<br>
        　⑥この世で私に与えられた時間には限りあり、しかも不明確であることを<br>
        　　よくわきまえ、どんな場合にもできるかぎり有効に使う努力をします。<br>
        　　周囲の人によい影響を与え、その人たちが見習って時間を最善に使える<br>
        　　ようにします。<br>
        　⑦ついに、私に与えられた時間が切れるとき、私は自分名を刻んだ記念碑を<br>
        　　残したいと思います。石の記念碑ではなく仲間たちの心の記念碑に、私の<br>
        　　生き方が世の中を少しはよくしたと、私の名が残されるように望みます。<br>
        　⑧私は生涯、毎日この誓いを繰り返します。これが私の性格を向上させ、<br>
        　　他人の人生にもよい影響を与えることを信じます。
        　　


        　<br><br>


        <B><font color=#DF1F97>
                ★ぜひ、あなたにぴったりのアファメーションを見つけて、<br>
                　毎日言ってみてください。<br>
                ★きっと効果があるはずです。<br><br></font></B>

    </div><br>
    <b><img src=../img/point_ko2.gif alt=width=22 height=17 border="0">あなたにぴったりの★アファメーション★を探してみよう！</b><br>
    <br>
    <form action="afm_list.php"><font color=#2A7F3A><B>
                　　◆アファメーションを文字で検索：<input type=text name=keyword size=20><input type=submit value="検索"></font></B>
        <br>
    </form><B>
    <a name=category>
        <img src=../img/point_ko2.gif alt=width=22 height=17 border="0">
        カテゴリから探してみよう！<br></B><br>
<?php
$sql = "SELECT ";
$sql .= "A.afm_category_main_id , ";
$sql .= "A.afm_category_main_name  ";
$sql .= "FROM ";
$sql .= "afm_category_main AS A ";
$sql .= "WHERE ";
$sql .= "A.afm_category_main_id > 0 ";
$sql .= "order by ";
$sql .= "A.afm_category_main_id asc ";

$result = pg_query($dbconn, $sql);
$NUM = pg_numrows($result);

for ($i = 0; $i < $NUM; $i++) {
    $afm_category_main_list[$i] = pg_fetch_array($result, $i);
    ?>
    <b><?= nl2br($afm_category_main_list[$i]['afm_category_main_name']) ?></b>

    <table width="100%"  cellpadding="2" border="0" bordercolor="dddddd">
        <?php
        $sql = "SELECT ";
        $sql .= "A.afm_category_sub_id , ";
        $sql .= "A.afm_category_sub_name,  ";
        $sql .= "COUNT(B.afm_category_sub_id) AS afm_num  ";
        $sql .= "FROM ";
        $sql .= "afm_category_sub AS A ";
        $sql .= "LEFT JOIN ";
        $sql .= "afm_relation AS B ";
        $sql .= "ON ";
        $sql .= "A.afm_category_sub_id = B.afm_category_sub_id ";
        $sql .= "WHERE ";
        $sql .= "A.afm_category_main_id = {$afm_category_main_list[$i]['afm_category_main_id']} ";
        $sql .= "GROUP BY ";
        $sql .= "A.afm_category_sub_id, ";
        $sql .= "A.afm_category_sub_name ";
        $sql .= "ORDER BY ";
        $sql .= "A.afm_category_sub_id asc ";

        $result2 = pg_query($dbconn, $sql);
        $NUM2 = pg_numrows($result2);

        for ($j = 0; $j < $NUM2; $j++) {
            $afm_category_sub_list[$j] = pg_fetch_array($result2, $j);

            ?>
            <tr>
                <td >
                    <a href="afm_list.php?afm_category_sub_id=<?= nl2br($afm_category_sub_list[$j]['afm_category_sub_id']) ?>"
                       id="categorylink"><?= nl2br($afm_category_sub_list[$j]['afm_category_sub_name']) ?></a>
                    (<?= $afm_category_sub_list[$j]['afm_num'] ?>件)
                </td>
            </tr>
        <?php } ?>
    </table>
    <br>
<?php } ?>


<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/inc/foot_set_2column2.inc' ?>