<?php require_once '../inc/func.inc' ?>
<?php require_once 'inc/admin_start.inc' ?>
<?php
$dbconn = dbconn();
$sql = "SELECT ";
$sql .= "ENQ_MASTER.ENQ_ID, ";
$sql .= "ENQ_TITLE, ";
$sql .= "ENQ_INFO, ";
$sql .= "ENQ_1, ";
$sql .= "COUNT1 ,";
$sql .= "ENQ_2, ";
$sql .= "COUNT2 ,";
$sql .= "ENQ_3, ";
$sql .= "COUNT3 ,";
$sql .= "ENQ_4, ";
$sql .= "COUNT4 ,";
$sql .= "ENQ_5, ";
$sql .= "COUNT5 ,";
$sql .= "ENQ_6, ";
$sql .= "COUNT6 ,";
$sql .= "ENQ_7, ";
$sql .= "COUNT7 ,";
$sql .= "ENQ_8, ";
$sql .= "COUNT8 ,";
$sql .= "ENQ_9, ";
$sql .= "COUNT9 ,";
$sql .= "ENQ_10, ";
$sql .= "COUNT10 ";
$sql .= "FROM ";
$sql .= "ENQ_MASTER ";
$sql .= "LEFT JOIN (SELECT COUNT(*) AS COUNT1 , ANS_VALUE, ENQ_ID FROM ANS_MASTER WHERE ANS_VALUE = 1  GROUP BY ENQ_ID ,ANS_VALUE) AS ANS_1  ON ENQ_MASTER.ENQ_ID = ANS_1.ENQ_ID ";
$sql .= "LEFT JOIN (SELECT COUNT(*) AS COUNT2 , ANS_VALUE, ENQ_ID FROM ANS_MASTER WHERE ANS_VALUE = 2  GROUP BY ENQ_ID ,ANS_VALUE) AS ANS_2  ON ENQ_MASTER.ENQ_ID = ANS_2.ENQ_ID ";
$sql .= "LEFT JOIN (SELECT COUNT(*) AS COUNT3 , ANS_VALUE, ENQ_ID FROM ANS_MASTER WHERE ANS_VALUE = 3  GROUP BY ENQ_ID ,ANS_VALUE) AS ANS_3  ON ENQ_MASTER.ENQ_ID = ANS_3.ENQ_ID ";
$sql .= "LEFT JOIN (SELECT COUNT(*) AS COUNT4 , ANS_VALUE, ENQ_ID FROM ANS_MASTER WHERE ANS_VALUE = 4  GROUP BY ENQ_ID ,ANS_VALUE) AS ANS_4  ON ENQ_MASTER.ENQ_ID = ANS_4.ENQ_ID ";
$sql .= "LEFT JOIN (SELECT COUNT(*) AS COUNT5 , ANS_VALUE, ENQ_ID FROM ANS_MASTER WHERE ANS_VALUE = 5  GROUP BY ENQ_ID ,ANS_VALUE) AS ANS_5  ON ENQ_MASTER.ENQ_ID = ANS_5.ENQ_ID ";
$sql .= "LEFT JOIN (SELECT COUNT(*) AS COUNT6 , ANS_VALUE, ENQ_ID FROM ANS_MASTER WHERE ANS_VALUE = 6  GROUP BY ENQ_ID ,ANS_VALUE) AS ANS_6  ON ENQ_MASTER.ENQ_ID = ANS_6.ENQ_ID ";
$sql .= "LEFT JOIN (SELECT COUNT(*) AS COUNT7 , ANS_VALUE, ENQ_ID FROM ANS_MASTER WHERE ANS_VALUE = 7  GROUP BY ENQ_ID ,ANS_VALUE) AS ANS_7  ON ENQ_MASTER.ENQ_ID = ANS_7.ENQ_ID ";
$sql .= "LEFT JOIN (SELECT COUNT(*) AS COUNT8 , ANS_VALUE, ENQ_ID FROM ANS_MASTER WHERE ANS_VALUE = 8  GROUP BY ENQ_ID ,ANS_VALUE) AS ANS_8  ON ENQ_MASTER.ENQ_ID = ANS_8.ENQ_ID ";
$sql .= "LEFT JOIN (SELECT COUNT(*) AS COUNT9 , ANS_VALUE, ENQ_ID FROM ANS_MASTER WHERE ANS_VALUE = 9  GROUP BY ENQ_ID ,ANS_VALUE) AS ANS_9  ON ENQ_MASTER.ENQ_ID = ANS_9.ENQ_ID ";
$sql .= "LEFT JOIN (SELECT COUNT(*) AS COUNT10, ANS_VALUE, ENQ_ID FROM ANS_MASTER WHERE ANS_VALUE = 10 GROUP BY ENQ_ID ,ANS_VALUE) AS ANS_10 ON ENQ_MASTER.ENQ_ID = ANS_10.ENQ_ID ";
$result = pg_query($dbconn, $sql);
$NUM = pg_numrows($result);
for ($i = 0; $i < $NUM; $i++) {
    $SUNANS[$i] = 0;
    $ENQ_ID[$i] = pg_result($result, $i, 'ENQ_ID');
    $ENQ_TITLE[$i] = pg_result($result, $i, 'ENQ_TITLE');
    $ENQ_INFO[$i] = pg_result($result, $i, 'ENQ_INFO');
    for ($j = 1; $j <= 10; $j++) {
        $ENQ[$i][$j] = pg_result($result, $i, "ENQ_{$j}");
        $COUNT[$i][$j] = pg_result($result, $i, "COUNT{$j}");
        $SUNANS[$i] = $COUNT[$i][$j] + $SUNANS[$i];
    }
}
?>
<h2>アンケート結果</h2>
<table class="list">
    <?php for ($k = 0; $k < $NUM; $k++) { ?>
        <tr>
            <td width="100"><?= $ENQ_TITLE[$k] ?></td>
            <td width="400"><?= $ENQ_INFO[$k] ?></td>
            <td >
                <table width="100%">
                    <?php
                    for ($l = 1; $l <= 10; $l++) {
                        $ANS_PAR[$l] = (int)($COUNT[$k][$l] / $SUNANS[$k] * 100);
                        if ($ANS_PAR[$l] != 0) {
                            ?>
                            <tr>
                                <td><?= $ENQ[$k][$l] ?></td>
                                <td><?= $COUNT[$k][$l] ?></td>
                                <td>
                                    <img src="/img/list_imf.gif" width=<?= $ANS_PAR[$l] ?>% height="8" border="1">
                                    <?= $ANS_PAR[$l] ?>%
                                </td>
                            </tr>
                        <?php }
                    } ?>
                </table>
            </td>
        </tr>
    <?php } ?>
</table>
<?php require_once 'inc/admin_end.inc' ?>
