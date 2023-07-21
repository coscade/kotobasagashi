<?php
require_once 'inc/func.inc';
$sql = "SELECT ";
$sql .= "A.news_id , ";
$sql .= "A.news_date , ";
$sql .= "A.news_value , ";
$sql .= "A.news_link  ";
$sql .= "FROM ";
$sql .= "news_master AS A ";
$sql .= "order by ";
$sql .= "A.news_date desc ";
$sql .= "LIMIT 10 ";

$result = pg_query($dbconn, $sql);
$NUM = pg_numrows($result);
?>
    <html>
    <body BGCOLOR="#FFFFFF" TEXT="#333333" LINK="#258FB8" VLINK="#258FB8" ALINK="#996600" LEFTMARGIN="0" TOPMARGIN="0"
          MARGINWIDTH="0"
          MARGINHEIGHT="0">
    <table width="490" cellspacing="0" cellpadding="5" border="1" bordercolor="dddddd">
        <?php for ($i = 0; $i < $NUM; $i++) { ?>
            <?php $news_list[$i] = pg_fetch_array($result, $i); ?>
            <tr>
                <td nowrap align=center>
                    <font size="2"><?= date("y年m月d日", strtotime($news_list[$i]['news_date'])) ?><br><br>
                        <a href="<?= $news_list[$i]['news_link'] ?>" target=_top>＞＞</a>
                </td>
                <td><font size="2"><?= nl2br($news_list[$i]['news_value']) ?></td>
            </tr>
        <?php } ?>
    </table>
    </body>
    </html>
<?php
if (isset($dbconn)) {
    if (pg_connection_status($dbconn) == true) {
        pg_clode($dbconn);
    }
}
?>