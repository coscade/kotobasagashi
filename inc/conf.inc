<?php
$SOURCE['source_category'] = array('lavel'=>'カテゴリ' , 'type'=>'select');
$SOURCE['source_name'] = array('lavel'=>'出典名' , 'type'=>'text','size'=> 50,'max'=> 200);
$SOURCE['source_subtitle'] = array('lavel'=>'副題' , 'type'=>'text','size'=> 50,'max'=> 200);
$SOURCE['source_author'] = array('lavel'=>'著者' , 'type'=>'text','size'=> 50,'max'=> 200,'notnull'=>TRUE);
$SOURCE['source_translator'] = array('lavel'=>'訳者' , 'type'=>'text','size'=> 50,'max'=> 200);
$SOURCE['source_company'] = array('lavel'=>'出版社' , 'type'=>'text','size'=> 50,'max'=> 200);
$SOURCE['source_value'] = array('lavel'=>'内容' , 'type'=>'textarea','max'=> 1600,'rows'=> 5,'cols'=>70);
$SOURCE['source_rec_level'] = array('lavel'=>'おすすめ' , 'type'=>'select');
$SOURCE['source_asin'] = array('lavel'=>'ASIN' , 'type'=>'text','size'=> 10,'max'=> 10);


$KOTOBA['cs_id'] = array('lavel'=>'カテゴリ' , 'type'=>'select');
$KOTOBA['source_id'] = array('lavel'=>'出典ID' , 'type'=>'hidden');
$KOTOBA['kotoba_date'] = array('lavel'=>'日付' , 'type'=>'date','y_start'=>2005,'y_end'=>2030);
$KOTOBA['kotoba_value'] = array('lavel'=>'ことば' , 'type'=>'textarea','max'=> 2000,'rows'=>15,'cols'=>70);
$KOTOBA['comment'] = array('lavel'=>'感想' , 'type'=>'textarea','max'=> 2000,'rows'=>20,'cols'=>70);

$source_category = NULL;
$source_category['0'] = 'なし';
$source_category['1'] = '男女・恋愛';
$source_category['2'] = '愛・夫婦・結婚';
$source_category['3'] = '心・心理学、心の病';
$source_category['4'] = 'セルフ・自分を見直す';
$source_category['5'] = '人間・人間関係';
$source_category['6'] = '人生・生き方';
$source_category['7'] = '癒し系';
$source_category['8'] = '仕事・マーケティング';
$source_category['9'] = 'ポジティブシンキング';
$source_category['10'] = '成功法則・夢をかなえる';
$source_category['11'] = '考え方・ノウハウもの';
$source_category['12'] = '小説・ファンタジー';
$source_category['13'] = '病気・体';
$source_category['14'] = '詩集・哲学';
$source_category['15'] = '古典・悟り';
$source_category['16'] = 'エッセイ・ノンフィクション';
$source_category['17'] = '子供・家族';
$source_category['18'] = '社会の流れ・全般';
$source_category['19'] = 'ことば集・教訓';
$source_category['21'] = '絵本';
$source_category['20'] = 'その他';

$source_rec_level        = NULL;
$source_rec_level['0']   = '▼';
$source_rec_level['0.5'] = '0.5';
$source_rec_level['1']   = '1';
$source_rec_level['1.5'] = '1.5';
$source_rec_level['2']   = '2';
$source_rec_level['2.5'] = '2.5';
$source_rec_level['3']   = '3';
$source_rec_level['3.5'] = '3.5';
$source_rec_level['4']   = '4';
$source_rec_level['4.5'] = '4.5';
$source_rec_level['5']   = '5';


$COMMENT['kotoba_id'] = array('lavel'=>'ことばID' , 'type'=>'hidden');
$COMMENT['kc_value'] = array('lavel'=>'投稿内容' , 'type'=>'textarea','max'=> 1000,'rows'=> 5,'cols'=>50);
$COMMENT['kc_name'] = array('lavel'=>'投稿者名' , 'type'=>'text','size'=> 50,'max'=> 100);
$COMMENT['kc_mail'] = array('lavel'=>'投稿者アドレス' , 'type'=>'text','size'=> 50,'max'=> 100);
$COMMENT['kc_delete_key'] = array('lavel'=>'削除キー' , 'type'=>'text','size'=> 10,'max'=> 10);
$COMMENT['kc_ip'] = array('lavel'=>'IPアドレス' , 'type'=>'hidden');
$COMMENT['kc_sex'] = array('lavel'=>'性別' , 'type'=>'radio','title'=>array('1'=>'男','2'=>'女'));
$COMMENT['kc_age'] = array('lavel'=>'年齢' , 'type'=>'text','size'=> 3,'max'=> 3);

$EVAL['kotoba_id'] = array('lavel'=>'ことばID' , 'type'=>'hidden');
$EVAL['eval_value'] = array('lavel'=>'評価' , 'type'=>'hidden');
$EVAL['eval_ip'] = array('lavel'=>'評価IP' , 'type'=>'hidden');

$ANS['enq_id'] = array('lavel'=>'アンケートID' , 'type'=>'hidden');
$ANS['ans_value'] = array('lavel'=>'アンケート結果' , 'type'=>'hidden');
$ANS['ans_ip'] = array('lavel'=>'回答IP' , 'type'=>'hidden');
$ANS['ans_comment'] = array('lavel'=>'回答IP' , 'type'=>'textarea','max'=> 1000,'rows'=> 5,'cols'=>50);

$READING['reading_date'] = array('lavel'=>'日付' , 'type'=>'date','y_start'=>2004,'y_end'=>2030);
$READING['reading_title'] = array('lavel'=>'タイトル' , 'type'=>'text','size'=> 50,'max'=> 200);
$READING['reading_author'] = array('lavel'=>'著者' , 'type'=>'text','size'=> 50,'max'=> 200);
$READING['reading_company'] = array('lavel'=>'出版社' , 'type'=>'text','size'=> 50,'max'=> 200);
$READING['reading_value'] = array('lavel'=>'内容' , 'type'=>'textarea','max'=> 1600,'rows'=> 30,'cols'=>70);
$READING['source_id'] = array('lavel'=>'本ID' , 'type'=>'text','size'=> 50,'max'=> 200);

$DANJYO['danjyo_title'] = array('lavel'=>'タイトル' , 'type'=>'text','size'=> 50,'max'=> 200);
$DANJYO['danjyo_value'] = array('lavel'=>'内容' , 'type'=>'textarea','max'=> 12000,'rows'=> 30,'cols'=>70);

$AFM['afm_value'] = array('lavel'=>'内容' , 'type'=>'textarea','max'=> 1600,'rows'=> 5,'cols'=>70);

$NEWS['news_date']  = array('lavel'=>'日付' , 'type'=>'date','y_start'=>2004,'y_end'=>2030);
$NEWS['news_value'] = array('lavel'=>'内容' , 'type'=>'textarea','max'=> 1600,'rows'=> 5,'cols'=>70);
$NEWS['news_link']  = array('lavel'=>'リンク' , 'type'=>'text','size'=> 100,'max'=> 200);

?>