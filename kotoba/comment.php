<?php require_once '../inc/func.inc'; ?>
<?php

$CONTENTS_TITLE = "■感想を書く■";
require_once $INC_PATH . 'head_set_1column.inc';

require_once $ROOT_PATH . 'class/inquiry.inc';

$dbconn = dbconn();

$form = new Inquiry();

$form->set_form($COMMENT);
$form->set_action();
$form->get_form_value();
$form->set_check();

$form->form['kotoba_id']['value'] = isset($_POST['kotoba_id']) ? $_POST['kotoba_id'] : NULL;
$form->form['kotoba_id']['value'] = ($form->form['kotoba_id']['value'] == NULL) ? $_GET['kid'] : $form->form['kotoba_id']['value'];
$form->form['kc_ip']['value'] = $_SERVER['REMOTE_ADDR'];

if ($form->action == 'exec') {
    $form->db_insert($dbconn, 'KOTOBA_COMMENT');
    echo "
  <SCRIPT LANGUAGE='JavaScript'>
  <!--
  location.href= '{$URL}kotoba/view.php?kid={$form->form['kotoba_id']['value']}&t=b';
  -->
  </SCRIPT>
  ";
}

$sql = "SELECT ";
$sql .= "KOTOBA_VALUE ";
$sql .= "FROM KOTOBA_MASTER ";
$sql .= "WHERE KOTOBA_ID = {$form->form['kotoba_id']['value']} ";
$result = pg_query($dbconn, $sql);
$KOTOBA['kotoba_value'] = pg_result($result, 0, 'KOTOBA_VALUE');
?>

<div align=center>

    <table border="0" width=530 cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <br><br>
                <!--↓ことば-->
                <div id="kotobamidashi"><img src="../img/point_ko.gif" alt="" width="22" height="15" border="0">「今日のことば」
                </div>
                <div id="kotobanakami">
                    <?= $KOTOBA['kotoba_value']; ?>
                </div>
                <!--↑ことば-->
                <br><br>
            </td>
        </tr>
        <tr>
            <td id=kihon>
                <!--↓感想投稿-->

                <form action=comment.php method=post>

                    <? $form->view_form('kotoba_id'); ?>
                    <? $form->view_form('kc_ip'); ?>

                    <div id="kansoumidashi"><img src="../img/point_ka.gif" alt="" width="22" height="15" border="0">感想投稿
                    </div>

                    <table border="0" cellpadding="1" cellspacing="0" width=100%>
                        <tr>
                            <td bgcolor=#C2DF7D>
                                <table border="0" cellpadding="5" cellspacing="0" width=100% bgcolor=eeeeee>
                                    <tr valign=top bgcolor=#EDFFDF>
                                        <td width=1% align=right id=kihonbold nowrap>名前</td>
                                        <td width=99% id=kihon><? $form->view_form('kc_name'); ?>&nbsp;<br>※ハンドルネームなど
                                        </td>
                                    </tr>
                                    <tr valign=top bgcolor=#EDFFDF>
                                        <td width=1% align=right id=kihonbold nowrap>メールアドレス：</td>
                                        <td width=99% id=kihon><? $form->view_form('kc_mail'); ?>&nbsp;<br>※投稿一覧には表示されません。
                                        </td>
                                    </tr>
                                    <tr valign=top bgcolor=#EDFFDF>
                                        <td width=1% align=right id=kihonbold nowrap>削除キー：</td>
                                        <td width=99%><? $form->view_form('kc_delete_key'); ?>&nbsp;</td>
                                    </tr>
                                    <tr valign=top bgcolor=#EDFFDF>
                                        <td width=1% align=right id=kihonbold nowrap>性別：</td>
                                        <td width=99% id=kihon><? $form->view_form('kc_sex'); ?>&nbsp;</td>
                                    </tr>
                                    <tr valign=top bgcolor=#EDFFDF>
                                        <td width=1% align=right id=kihonbold nowrap>年齢：</td>
                                        <td width=99%><? $form->view_form('kc_age'); ?>&nbsp;</td>
                                    </tr>
                                    <tr valign=top bgcolor=#EDFFDF>
                                        <td width=1% align=right id=kihonbold nowrap>感想：</td>
                                        <td width=99%><? $form->view_form('kc_value'); ?>&nbsp;</td>
                                    </tr>
                                    <tr bgcolor=#EDFFDF>
                                        <td colspan=2 align=center>

                                            <?php
                                            if ($form->action == 'input' || ($form->action == 'confirm' && !$form->check) || $form->action == 'edit') {
                                                echo "<input type=submit name=submit value=確認>　<input type=button value=戻る onclick=pageBack()>";
                                            } elseif ($form->action == 'confirm' && $form->check) {
                                                echo "<input type=submit name=submit value=送信>　<input type=submit name=submit value=修正>";
                                            }
                                            ?>

                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
            </td>
        </tr>
        <tr>
            <td id=kihon><br><br>
                <!--↓投稿にあたって-->
                <div id=toukoukiyaku>◆投稿に当たってのお願いと規約◆</div>
                <span id="kihonbold">「今日のことば」に対する「ご自分の感想や考え方」の投稿をお願いします。</span><br>
                誹謗、中傷、嫌がらせ、公序良俗に反する意見・感想、広告関連、名誉毀損、テーマに関係ないような書き込み等、管理人が適切でないと判断した場合には編集・削除させて頂きます。<br>
                この投稿で起きたトラブルに関して、管理人は一切の責任を負いかねます。<br>
                また、サーバー負荷の関係で、<span id="kihonbold">文字数は1000字まで、一日３回</span>までの投稿とさせて頂ております。<br>
                よろしくご理解のほどお願いいたします。<br>
                <!--↑投稿にあたって-->
            </td>
        </tr>

    </table>


    <br><br>


    </font>

    <?php require_once $INC_PATH . 'foot_set_1column.inc'; ?>
