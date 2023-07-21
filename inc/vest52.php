<?php
require '../../php/libs/Smarty.class.php';
require_once '../inc/func.inc';

$dbconn = dbconn();
$KOTOBA = NULL;
$SOURCE = NULL;

$smarty = new Smarty;
$smarty->template_dir = '../templates';
$smarty->compile_dir = '../templates_c';
$smarty->config_dir = '../configs';
//$smarty->cache_dir = 'キャッシュのパス';

//$smarty->compile_check = true;
//$smarty->debugging = true;

$smarty->assign("Title", "ことばの贈りもの～「ことば探し」");
$smarty->assign("Name", "■「今日のことば」９月人気ベスト５！■");

//ここから、ことばのIDを5個選んで書き込んでください。
//例：$KOTOBA[0] = select_kotoba(ことばのID);
$KOTOBA[0] = select_kotoba(1436);
$KOTOBA[1] = select_kotoba(1438);
$KOTOBA[2] = select_kotoba(1447);
$KOTOBA[3] = select_kotoba(1459);
$KOTOBA[4] = select_kotoba(1435);
//ここまで。

for ($i = 0; $i < count($KOTOBA); $i++) {
    $SOURCE[$i] = select_source($KOTOBA[$i]['SOURCE_ID']);
    $KOTOBA[$i][KOTOBA_VALUE] = nl2br($KOTOBA[$i][KOTOBA_VALUE]);
    $KOTOBA[$i][KOTOBA_DATE] = date("Y年n月j日", strtotime($KOTOBA[$i][KOTOBA_DATE]));
}
$smarty->assign("KOTOBA", $KOTOBA);
$smarty->assign("SOURCE", $SOURCE);
$smarty->display('kotoba/vest5.tpl');

?>
