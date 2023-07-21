<?php
require_once '../inc/func.inc';
$SC = isset($_GET['sc']) ? $_GET['sc'] : NULL;
$REC_LEVEL = isset($_GET['rec_level']) ? $_GET['rec_level'] : NULL;
$KEY = isset($_GET['key']) ? $_GET['key'] : NULL;
$P_NUM = isset($_GET['p_num']) ? $_GET['p_num'] : 1;
$dbconn = dbconn();
define('LIST_NUM', 50);

$CONTENTS_TITLE = "■本の検索■";
require_once $_SERVER["DOCUMENT_ROOT"] . '/inc/head_set_2column.inc';
?>
    <div id="kihon">

        <div id="categoryleft">
            <table border="0" cellpadding="0" cellspan="0">
                <tr>
                    <td colspan=3>
                        <a href="list.php?sc=" id="categorylink">全て見る</a>
                    </td>
                </tr>
                <tr>
                    <?php
                    $i = 1;
                    foreach ($source_category as $key => $value) {
                        echo (is_int(($i - 1) / 3)) ? "<tr>" : "";
                        echo '<td><a href="list.php?sc=' . $key . '" id="categorylink">' . $value . '</a></td><td>｜</td>';
                        echo (is_int($i / 3)) ? "</tr>\n" : "";
                        $i++;
                    }
                    ?>
                </tr>
                <tr>
                    <td colspan="6" id="kihon"><b>おすすめ度で探す</b>
                        <form name="rec_form">
                            <?php if ($SC) echo '<input type="hidden" name="sc" value="' . $SC . '">'; ?>
                            <label for="rec0"><input type="radio" name="rec_level" value="0" id="rec0"
                                                     onClick="this.form.submit();"
                                                     <?php if (!$REC_LEVEL){ ?>checked<?php } ?>>全て</label>
                            <label for="rec1"><input type="radio" name="rec_level" value="1" id="rec1"
                                                     onClick="this.form.submit();"
                                                     <?php if ($REC_LEVEL == 1){ ?>checked<?php } ?>>1</label>
                            <label for="rec15"><input type="radio" name="rec_level" value="1.5" id="rec15"
                                                      onClick="this.form.submit();"
                                                      <?php if ($REC_LEVEL == 1.5){ ?>checked<?php } ?>>1.5</label>
                            <label for="rec2"><input type="radio" name="rec_level" value="2" id="rec2"
                                                     onClick="this.form.submit();"
                                                     <?php if ($REC_LEVEL == 2){ ?>checked<?php } ?>>2</label>
                            <label for="rec25"><input type="radio" name="rec_level" value="2.5" id="rec25"
                                                      onClick="this.form.submit();"
                                                      <?php if ($REC_LEVEL == 2.5){ ?>checked<?php } ?>>2.5</label>
                            <label for="rec3"><input type="radio" name="rec_level" value="3" id="rec3"
                                                     onClick="this.form.submit();"
                                                     <?php if ($REC_LEVEL == 3){ ?>checked<?php } ?>>3</label>
                            <label for="rec35"><input type="radio" name="rec_level" value="3.5" id="rec35"
                                                      onClick="this.form.submit();"
                                                      <?php if ($REC_LEVEL == 3.5){ ?>checked<?php } ?>>3.5</label>
                            <label for="rec4"><input type="radio" name="rec_level" value="4" id="rec4"
                                                     onClick="this.form.submit();"
                                                     <?php if ($REC_LEVEL == 4){ ?>checked<?php } ?>>4</label>
                            <label for="rec45"><input type="radio" name="rec_level" value="4.5" id="rec45"
                                                      onClick="this.form.submit();"
                                                      <?php if ($REC_LEVEL == 4.5){ ?>checked<?php } ?>>4.5</label>
                            <label for="rec5"><input type="radio" name="rec_level" value="5" id="rec5"
                                                     onClick="this.form.submit();"
                                                     <?php if ($REC_LEVEL == 5){ ?>checked<?php } ?>>5</label>
                        </form>
                    </td>
                </tr>
            </table>
        </div>

        <br>
        <?php book_list_view($P_NUM, $SC, $KEY, $REC_LEVEL) ?>
    </div>
    <br>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/inc/foot_set_2column.inc' ?>

