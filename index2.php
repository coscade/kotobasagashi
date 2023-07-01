<?php
require_once 'inc/func.inc';
$T = isset($_GET['t'])?$_GET['t']:"a";
$dbconn = dbconn();
$LAST_KOTOBA_ID = kotoba_last_get();
$KOTOBA = select_kotoba($LAST_KOTOBA_ID);
$SOURCE = select_source($KOTOBA['SOURCE_ID']);

$sqlkc = "SELECT";
$sqlkc .= " KC_ID,KC_VALUE,KC_NAME,TO_CHAR(KC_TIMESTAMP,'YYYY年MM月DD日hh24時mi分') as KC_TIMESTAMP";
$sqlkc .= " FROM KOTOBA_COMMENT ";
$sqlkc .= " WHERE KC_FLAG='1' AND KOTOBA_ID='$LAST_KOTOBA_ID' ORDER BY KC_TIMESTAMP DESC";

$resultkc = pg_query($dbconn,$sqlkc);
$NUM_KC = pg_num_rows($resultkc);

//ことば登録数
$sqlnum  = "SELECT ";
$sqlnum .= "COUNT(KOTOBA_ID) AS KOTOBA_NUM ";
$sqlnum .= "FROM KOTOBA_MASTER ";
$resultnum = pg_query($dbconn,$sqlnum);
$KOTOBA_NUM = pg_result($resultnum,0,'KOTOBA_NUM');

//本登録数
$sqlnum  = "SELECT ";
$sqlnum .= "COUNT(SOURCE_ID) AS SOURCE_NUM ";
$sqlnum .= "FROM SOURCE_MASTER ";
$resultnum = pg_query($dbconn,$sqlnum);
$SOURCE_NUM = pg_result($resultnum,0,'SOURCE_NUM');

$sql  ="SELECT ";
$sql .="KOTOBA_ID AS LAST_KID ";
$sql .="FROM ";
$sql .="KOTOBA_MASTER ";
$sql .="WHERE ";
$sql .="KOTOBA_DATE < '{$KOTOBA['KOTOBA_DATE']}' ";
$sql .="ORDER BY ";
$sql .="KOTOBA_DATE DESC ";
$sql .="LIMIT 1 ";
$result = @pg_query($dbconn,$sql);
$LAST_KID = @pg_result($result,0,'LAST_KID');

$sql  ="SELECT ";
$sql .="KOTOBA_ID AS NEXT_KID ";
$sql .="FROM ";
$sql .="KOTOBA_MASTER ";
$sql .="WHERE ";
$sql .="KOTOBA_DATE > '{$KOTOBA['KOTOBA_DATE']}' ";
$sql .="ORDER BY ";
$sql .="KOTOBA_DATE ASC ";
$sql .="LIMIT 1 ";
$result = @pg_query($dbconn,$sql);
$NEXT_KID = @pg_result($result,0,'NEXT_KID');

$CONTENTS_TITLE = "■" . date("Y年m月d日",strtotime($KOTOBA['KOTOBA_DATE']))."■";
require_once $INC_PATH.'head_set_2column2.inc';

if($LAST_KID!=""){
	echo "<a href='../kotoba/view.php?kid={$LAST_KID}' id='greenlink'>前日のことばを見る</a>";
}
?><span class="naiyou">　　現在の登録件数　ことば：<b><a href="<?= $URL?>kotoba/list.php"><?=$KOTOBA_NUM;?></a></b>件</span>　<span class="naiyou">本：<b><a href="<?= $URL?>book/list.php"><?=$SOURCE_NUM;?></a></b>件</span>
<br>
<table width="530" border="0" cellspacing="0" cellpadding="0">
  <tr valign=top>
    <td>
<!--↓「今日のことば」-->
      <div id="kotobamidashi"><img src="<?= $URL?>img/point_ko.gif" alt="" width="25" height="20" border="0" />「今日のことば」</div>
      <div id="kotobanakami">
      <?= nl2br($KOTOBA['KOTOBA_VALUE']);?><br><br>
      <table border="0" cellspacing="0" cellpadding="0">
<?php if (($SOURCE['source_name'] != "")){?>
        <tr>
          <td width="9"><img src="<?= $URL?>img/list_imd.gif" alt="" width="9" height="9" border="0"></td>
          <td width="5"><img src="<?= $URL?>img/1pix0000.gif" alt="" width="5" height="1" border="0" /></td>
          <td nowrap><span class="sidemenu">出典元</span></td>
          <td id=kihon><a href=<?= $URL?>book/view.php?sid=<?= $SOURCE['source_id'];?>><?= $SOURCE['source_name'];?></a> <a href="http://www.amazon.co.jp/exec/obidos/ASIN/<?= $SOURCE['source_asin'];?>/aaaaea00-22/250-3071692-7411426?creative=1615&camp=243&adid=0YENTCV4RW688GXCBBX7&link_code=as1" target="_blank">amazonで見る</a></td>
        </tr>
        <tr>
          <td width="9"><img src="<?= $URL?>img/list_imd.gif" alt="" width="9" height="9" border="0"></td>
          <td width="5"><img src="<?= $URL?>img/1pix0000.gif" alt="" width="5" height="1" border="0" /></td>
          <td nowrap><span class="sidemenu">おすすめ度</span></td>
          <td id=kihon><?view_source_rec_level($SOURCE['source_rec_level']);?>&nbsp;<font size=1><a href=./ onclick="window.open('<?=$URL?>popup.php', '', 'width=300,height=300');" target=_blank>※おすすめ度について</a></font></td>
        </tr>
<?php }?>
        <tr>
          <td width="9"><img src="<?= $URL?>img/list_imd.gif" alt="" width="9" height="9" border="0"></td>
          <td width="5"><img src="<?= $URL?>img/1pix0000.gif" alt="" width="5" height="1" border="0" /></td>
          <td nowrap><span class="sidemenu">著者名</span></td>
          <td id=kihon><?= $SOURCE['source_author'];?></td>
        </tr>
      </table>
      </div>
      <br>
<!--↑今日のことば-->
<?php if($T=="b"){?>
<!--↓読者の感想-->
<?php
for($i=0;$i<$NUM_KC;$i++){
  $KC['KC_ID'] = pg_result($resultkc,$i,'KC_ID');
  $KC['KC_VALUE'] = pg_result($resultkc,$i,'KC_VALUE');
  $KC['KC_NAME'] = pg_result($resultkc,$i,'KC_NAME');
  $KC['KC_TIMESTAMP'] = pg_result($resultkc,$i,'KC_TIMESTAMP');
?>
        <div class="box">
       【<?= $KC['KC_NAME'];?>さん】
        <?= $KC['KC_TIMESTAMP'];?><br>
        <?= nl2br($KC['KC_VALUE']);?>
        </div>
<?php }?>
      <form action=comment.php method=post>
      <input type=hidden name=kotoba_id value=<?= $LAST_KOTOBA_ID;?>>
      <input type=hidden name=submit value=修正>
      <input type=submit value=感想を登録する>
      </form>
<!--↑読者の感想-->
<?php }else{?>
<!--↓感想-->
      <div id="kansoumidashi">
      <img src="<?= $URL?>img/point_ka.gif" alt="" width="25" height="20" border="0" />まゆの感想
      </div>
      <div id="kansounakami">
      <?= nl2br($KOTOBA['COMMENT']);?>
      </div>
<!--↑感想-->
<?php }?>
    </td>
    <td width="10"><img src="<?= $URL?>img/1pix0000.gif" alt="" width="10" height="1" border="0" /></td>
    <td width="140"><img src="<?= $URL?>img/1pix0000.gif" alt="" width="10" height="24" border="0" />
<!--↓右メニュー／ことば横-->
      <table width="140" border="0" cellspacing="0" cellpadding="0">
        <tr valign="top">
          <td width="5"><img src="<?= $URL?>img/list_ime.gif" alt="" width="5" height="10" border="0" /></td>
          <td width="5"><img src="<?= $URL?>img/1pix0000.gif" alt="" width="5" height="1" border="0" /></td>
          <td width="130"><a href="<?= $URL?>kotoba/comment.php?kid=<?= $KOTOBA['KOTOBA_ID'];?>" id="greenlink">「今日のことば」の<br>感想を送る→コチラ<br>（気軽に書き込んで<br>くださいね）</a><br><br></td>
        </tr>
        <tr valign="top">
          <td width="5"><img src="<?= $URL?>img/list_ime.gif" alt="" width="5" height="10" border="0 /"></td>
          <td width="5"><img src="<?= $URL?>img/1pix0000.gif" alt="" width="5" height="1" border="0" /></td>
          <td width="130"><a href="<?= $URL?>kotoba/view.php?kid=<?= $KOTOBA['KOTOBA_ID'];?>&t=b" id="greenlink">「今日のことば」の<br>感想を見る</a><span id=kihon>(感想<?=$NUM_KC?>件)<br><br></td>
        </tr>
        <tr valign="top">
          <td width="5"><img src="<?= $URL?>img/list_ime.gif" alt="" width="5" height="10" border="0 /"></td>
          <td width="5"><img src="<?= $URL?>img/1pix0000.gif" alt="" width="5" height="1" border="0" /></td>
          <td width="130"><span class="sidemenu">本日の<br>「今日のことば」は？</span></td>
        </tr>
        <tr valign="top">
          <td width="5"><img src="<?= $URL?>img/1pix0000.gif" alt="" width="5" height="10" border="0 /"></td>
          <td width="5"><img src="<?= $URL?>img/1pix0000.gif" alt="" width="5" height="1" border="0" /></td><form action="<?= $URL?>kotoba/eval.php" method="post">
          <td width="130"><div id="kotobatoukou">
            <input name="eval_value" type="radio" value="1">気に入った&nbsp;<br>
            <input name="eval_value" type="radio" value="2">そうでもない&nbsp;<br>
            <input name="eval_value" type="radio" value="3">どちらでもない&nbsp;<br>
            <input value="投稿する" type="submit"><br><br>
            「今月のベスト５」の<br>参考にしますので<br>ぜひ投稿お願いします。<br><br>
            <input type=hidden name=submit value=送信>
            <input type=hidden name=kotoba_id value=<?= $KOTOBA['KOTOBA_ID'];?>>
          </div></form></td>
        </tr>
<?php
$SUMEVAL = $KOTOBA['EVAL_1'] + $KOTOBA['EVAL_2'] + $KOTOBA['EVAL_3'];
if($SUMEVAL!=0){
  $EVAL1_PAR = (int)($KOTOBA['EVAL_1'] / $SUMEVAL * 100);
  $EVAL2_PAR = (int)($KOTOBA['EVAL_2'] / $SUMEVAL * 100);
  $EVAL3_PAR = (int)($KOTOBA['EVAL_3'] / $SUMEVAL * 100);
?>
        <tr valign="top">
          <td width="5"><img src="<?= $URL?>img/list_ime.gif" alt="" width="5" height="10" border="0" /></td>
          <td width="5"><img src="<?= $URL?>img/1pix0000.gif" alt="" width="5" height="1" border="0" /></td>
          <td width="130"><span class="sidemenu">投稿の結果</span><br></td>
        </tr>
        <tr valign="top">
          <td width="5"><img src="<?= $URL?>img/1pix0000.gif" alt="" width="5" height="10" border="0" /></td>
          <td width="5"><img src="<?= $URL?>img/1pix0000.gif" alt="" width="5" height="1" border="0" /></td>
          <td width="130" id=kihon>
            <table border="0" width=100% cellpadding=1 cellspacing=0>
              <tr>
                <td id=dokusyahyoka colspan=2><img src="1pix0000.gif" alt="" width="1" height="5" border="0"><br>気に入った： <?= $KOTOBA['EVAL_1'];?>pt</td>
              </tr>
              <tr>
                <td width=99%><img src="<?= $URL;?>img/list_imf.gif" width=<?= $EVAL1_PAR;?>% height="8" border=1></td>
                <td width=1% id=dokusyahyoka nowrap><?= $EVAL1_PAR;?>%</td>
              </tr>
              <tr>
                <td id=dokusyahyoka colspan=2><img src="1pix0000.gif" alt="" width="1" height="5" border="0"><br>そうでもない： <?= $KOTOBA['EVAL_2'];?>pt</td>
              </tr>
              <tr>
                <td width=99%><img src="<?= $URL;?>img/list_img.gif" width=<?= $EVAL2_PAR;?>% height="8" border=1></td>
                <td width=1% id=dokusyahyoka nowrap><?= $EVAL2_PAR;?>%</td>
              </tr>
              <tr>
                <td id=dokusyahyoka colspan=2><img src="1pix0000.gif" alt="" width="1" height="5" border="0"><br>どちらでもない： <?= $KOTOBA['EVAL_3'];?>pt</td>
              </tr>
              <tr>
                <td width=99%><img src="<?= $URL;?>img/list_imh.gif" width=<?= $EVAL3_PAR;?>% height="8" border=1></td>
                <td width=1% id=dokusyahyoka nowrap><?= $EVAL3_PAR;?>%</td>
              </tr>
            </table>
          </td>
        </tr>
<?php }?>
        <tr>
          <td colspan="3"><img src="<?= $URL?>img/1pix0000.gif" alt="" width="5" height="20" border="0" /></td>
        </tr>
        <tr valign="top">
          <td width="5"><img src="<?= $URL?>img/list_ime.gif" alt="" width="5" height="10" border="0" /></td>
          <td width="5"><img src="<?= $URL?>img/1pix0000.gif" alt="" width="5" height="1" border="0" /></td>
          <td width="130"><span class="sidemenu">メールマガジン(月～金)発行しています。</span><br></td>
        </tr>
        <tr valign="top">
          <td width="5"><img src="<?= $URL?>img/1pix0000.gif" alt="" width="5" height="10" border="0 /"></td>
          <td width="5"><img src="<?= $URL?>img/1pix0000.gif" alt="" width="5" height="1" border="0" /></td><form action="<?= $URL?>kotoba/eval.php" method="post">
          <td width="130"><div id="kotobatoukou">バックナンバー、購読<br>解除は<a href="http://blog.mag2.com/m/log/0000158973" target="_blank">コチラ</a>から<br>
          </div></td>
        </tr>

      </table>
<!--↑右メニュー／ことば横-->
    </td>
  </tr>
</table>

<br>

<table width="530" border=1 cellspacing="0" cellpadding=5>
  <tr bordercolor="#B2DF7D" bgcolor="#B2DF7D">
    <td><span class="sidemenu"><img src=../img/point_ko2.gif alt= width=22 height=17 border="0">「ことば探し」のお知らせ<img src=../img/point_ko.gif alt= width=22 height=17 border="0"></td>
  </tr>
  <tr bordercolor="#B2DF7D">
    <td id=kihon><iframe src="news.php" name="news" width="530" height="100" border=1></iframe></td>
  </tr>
</table>

<br>

<!--↓下４つのコンテンツ-->
<table width="530" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="260" height="30" colspan="3"><div id="danjyo"><h3><a href=danjyo/01.php>必見！本から読みとく「男女の違い」</a></h3></div></td>
    <td width="10" rowspan="9"><img src="<?= $URL?>img/1pix0000.gif" alt="" width="10" height="1" border="0" /></td>
    <td width="260" height="30" colspan="3"><div id="yomikata"><h3><a href=yomikata/01.php>本の読み方＆おすすめの本</a></h3></div></td>
  </tr>
  <tr>
    <td width="260" colspan="3" bgcolor="#B2DF7D"><img src="<?= $URL?>img/1pix0000.gif" alt="" width="1" height="1" border="0" /></td>
    <td width="260" colspan="3" bgcolor="#B2DF7D"><img src="<?= $URL?>img/1pix0000.gif" alt="" width="1" height="1" border="0" /></td>
  </tr>
  <tr valign="top">
    <td width="1" bgcolor="#B2DF7D"><img src="<?= $URL?>img/1pix0000.gif" alt="" width="1" height="1" border="0" /></td>
    <td width="258">
<!--↓下４つのコンテンツ／男女の違いについてまとめました-->
      <p class="naiyou"><strong>知っているか、いないかで<br>「全然違う男女の関係」</strong></p>
      <div id="links">
      <ul>
      <li><a href="danjyo/01.php" id="greenlink">「男と女の違い」を知ることを<br>おすすめするわけ</a></li>
      <li><a href="danjyo/books.php" id="greenlink">男女の違いが書いてある<br>必見！「20冊のおすすめ本」</a></li>
      <li><a href="danjyo/table.php" id="greenlink">一目でわかる男女の比較表</a></li>
      <li><a href="danjyo/04.php" id="greenlink">女性が気を配るともっと<br>「うまくいく！２５の行動」</a></li>
      <li><a href="danjyo/weekly.php" id="greenlink">『男女の違い』(月２回ＵＰ予定)</a></li>
      </ul>
      </div>
<!--↑下４つのコンテンツ／男女の違いについてまとめました-->
    </td>
    <td width="1" bgcolor="#B2DF7D"><img src="<?= $URL?>img/1pix0000.gif" alt="" width="1" height="1" border="0" /></td>
    <td width="1" bgcolor="#B2DF7D"><img src="<?= $URL?>img/1pix0000.gif" alt="" width="1" height="1" border="0" /></td>
    <td width="258">
<!--↓下４つのコンテンツ／まゆのお気軽本の読み方-->
      <p class="naiyou"><strong>まゆのお気軽で楽しいぼちぼち的<br>「本の読み方＆おすすめ本を紹介」</strong></p>
      <div id="links">
      <ul>
      <li><a href="yomikata/01.php" id="greenlink">「本の読み方」</a></li>
      <li><a href="yomikata/books.php" id="greenlink">本の読み方内で紹介している<br>読んでみて！「おすすめ本一覧」</a></li>
      <li><a href="yomikata/reading.php" id="greenlink">今日の「おすすめ本」(毎日UP)</a></li>


      <li><a href="yomikata/books2.php" id="greenlink">「夫婦関係を考えるおすすめ本　３２冊」</a></li><img src="http://www.kotobasagashi.net/img/up04.gif" alt="" width="25" height="13" border="0">


      </ul>
      </div>
<!--↑下４つのコンテンツ／まゆのお気軽本の読み方-->
      </td>
      <td width="1" bgcolor="#B2DF7D"><img src="<?= $URL?>img/1pix0000.gif" alt="" width="1" height="1" border="0" /></td>
  </tr>
  <tr>
      <td width="260" colspan="3" bgcolor="#B2DF7D"><img src="<?= $URL?>img/1pix0000.gif" alt="" width="1" height="1" border="0" /></td>
      <td width="260" colspan="3" bgcolor="#B2DF7D"><img src="<?= $URL?>img/1pix0000.gif" alt="" width="1" height="1" border="0" /></td>
  </tr>
  <tr>
      <td width="260" height="10" colspan="3"><img src="<?= $URL?>img/1pix0000.gif" alt="" width="1" height="10" border="0" /></td>
      <td width="260" height="10" colspan="3"><img src="<?= $URL?>img/1pix0000.gif" alt="" width="1" height="10" border="0" /></td>
  </tr>
  <tr>
<?php
$sqlenq = "SELECT ENQ_ID , ENQ_TITLE , ENQ_INFO, ENQ_1, ENQ_2, ENQ_3, ENQ_4, ENQ_4, ENQ_5 FROM ENQ_MASTER";
$resultenq = pg_query($dbconn,$sqlenq);
$ENQ_ID = pg_result($resultenq,0,'ENQ_ID');
$ENQ_TITLE = pg_result($resultenq,0,'ENQ_TITLE');
$ENQ_INFO = pg_result($resultenq,0,'ENQ_INFO');
?>
    <td width="260" height="30" colspan="3"><div id="question"><h3>アンケート　<?= $ENQ_TITLE;?></h3></div></td>
    <td width="260" height="30" colspan="3"><div id="bosyu"><h3>募集</h3></div></td>
  </tr>
  <tr>
    <td width="260" colspan="3" bgcolor="#B2DF7D"><img src="<?= $URL?>img/1pix0000.gif" alt="" width="1" height="1" border="0" /></td>
    <td width="260" colspan="3" bgcolor="#B2DF7D"><img src="<?= $URL?>img/1pix0000.gif" alt="" width="1" height="1" border="0" /></td>
  </tr>
  <tr valign="top">
    <td width="1" bgcolor="#B2DF7D"><img src="<?= $URL?>img/1pix0000.gif" alt="" width="1" height="1" border="0" /></td>
    <td width="258">
<!--↓下４つのコンテンツ／アンケート-->
      <form action="<?= $URL;?>enq.php" method="post">
      <p class="naiyou">
      <?= $ENQ_INFO;?>
      <div id="questionsentaku">
<?php
for($i=1;$i<=5;$i++){
  if($ENQ_{$i} = pg_result($resultenq,0,"ENQ_{$i}")){
    echo "<input name='ans_value' type='radio' value='{$i}'>{$ENQ_{$i}}&nbsp;";
  }
}
?>
      </div>
      <div id="questiontoukou">
      <input value="投稿する" type="submit">
      </div>
      <input type=hidden name=submit value=修正>
      <input type=hidden name=enq_id value=<?= $ENQ_ID;?>>
      </form>
<!--↑下４つのコンテンツ／アンケート-->
    </td>
    <td width="1" bgcolor="#B2DF7D"><img src="<?= $URL?>img/1pix0000.gif" alt="" width="1" height="1" border="0" /></td>
    <td width="1" bgcolor="#B2DF7D"><img src="<?= $URL?>img/1pix0000.gif" alt="" width="1" height="1" border="0" /></td>
    <td width="258">
<!--↓下４つのコンテンツ／募集-->
      <p class="naiyou">ぜひ、教えてください！</p>
      <div id="links">
      <ul>
      <li><?form_mail("あなたの「おすすめの本」を教えてください。<br>よろしければ理由も教えてくださいね。");?>あなたの「おすすめの本」</a></li>
      <li><?form_mail("あなたの「人生を変えた本」を教えてください。<br>よろしければ詳しく教えてくださいね。");?>あなたの「人生を変えた本」</a></li>
      </ul>
      </div>
<!--↑下４つのコンテンツ／募集-->
    </td>
    <td width="1" bgcolor="#B2DF7D"><img src="<?= $URL?>img/1pix0000.gif" alt="" width="1" height="1" border="0" /></td>
  </tr>
  <tr>
    <td width="260" bgcolor="#B2DF7D" colspan="3"><img src="<?= $URL?>img/1pix0000.gif" alt="" width="1" height="1" border="0" /></td>
    <td width="260" bgcolor="#B2DF7D" colspan="3"><img src="<?= $URL?>img/1pix0000.gif" alt="" width="1" height="1" border="0" /></td>
  </tr>
</table>
<!--↑下４つのコンテンツ-->



<?php require_once $INC_PATH.'foot_set_2column2.inc';?>