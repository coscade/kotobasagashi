<?php

class Inquiry
{

    function Inquiry()
    {
        $this->mode = $this->get_mode();
    }

    function view_form($form_name)
    {
        if ($this->form[$form_name]['type'] == 'text') {
            $SIZE = $this->form[$form_name]['size'];
            if (((!$this->check) && $this->action == 'confirm') || $this->action == 'input' || $this->action == 'edit') {
                echo "<input type=text name={$form_name} size={$SIZE} value='{$this->form[$form_name]['value']}'>";
                $this->view_notnull($form_name);
                $this->view_confirm_error($form_name);
            } elseif ($this->check && $this->action == 'confirm') {
                echo "<span class='attention'>{$this->form[$form_name]['value']}</span>";
                echo "<input type=hidden name={$form_name} value='{$this->form[$form_name]['value']}'>";
            }
        } elseif (($this->form[$form_name]['type'] == 'textarea')) {
            $ROWS = $this->form[$form_name]['rows'];
            $COLS = $this->form[$form_name]['cols'];
            if (((!$this->check) && $this->action == 'confirm') || $this->action == 'input' || $this->action == 'edit') {
                echo "<textarea rows={$ROWS} cols={$COLS} name={$form_name}>{$this->form[$form_name]['value']}</textarea>";
                $this->view_confirm_error($form_name);
            } elseif ($this->check && $this->action == 'confirm') {
                echo "<span class='attention'>{$this->form[$form_name]['value']}</span>";
                echo "<input type=hidden name={$form_name} value='{$this->form[$form_name]['value']}'>";
            }
        } elseif ($this->form[$form_name]['type'] == 'checkbox') {
            if (((!$this->check) && $this->action == 'confirm') || $this->action == 'input' || $this->action == 'edit') {
                echo ($this->form[$form_name]['value']) ? "<input type=checkbox name={$form_name} checked>" : "<input type=checkbox name={$form_name}>";
                $this->view_confirm_error($form_name);
            } elseif ($this->check && $this->action == 'confirm') {
                echo "<span class='attention'>";
                echo ($this->form[$form_name]['value']) ? $this->form[$form_name]['title'][0] : $this->form[$form_name]['title'][1];
                echo "</span>";
                echo "<input type=hidden name={$form_name} value='{$this->form[$form_name]['value']}'>";
            }
        } elseif ($this->form[$form_name]['type'] == 'radio') {
            if (((!$this->check) && $this->action == 'confirm') || $this->action == 'input' || $this->action == 'edit') {
                $VALUE_TMP = $this->form[$form_name]['value'];
                foreach ($this->form[$form_name]['title'] as $key => $value) {
                    echo "<input type=radio name={$form_name} value='{$key}' ";
                    echo $this->form[$form_name]['value'] == $key ? "checked" : "";
                    echo ">{$value}　　";
                }
                $this->view_confirm_error($form_name);
            } elseif ($this->check && $this->action == 'confirm') {
                $key2 = $this->form[$form_name]['value'];
                echo "{$this->form[$form_name]['title'][$key2]}";
                echo "<input type=hidden name={$form_name} value='{$this->form[$form_name]['value']}'>";
            }
        } elseif ($this->form[$form_name]['type'] == 'select') {
            global ${$form_name};
            if (((!$this->check) && $this->action == 'confirm') || $this->action == 'input' || $this->action == 'edit') {
                echo "<select name='{$form_name}'>";
                foreach ($$form_name as $key => $value) {
                    echo "<option value='{$key}' ";
                    echo ($key == $this->form[$form_name]['value']) ? "selected" : "";
                    echo ">{$value}</option>";
                }
                echo "</select>";
                $this->view_confirm_error($form_name);
            } elseif ($this->check && $this->action == 'confirm') {
                $VALUE_TMP = $this->form[$form_name]['value'];
                echo ${$form_name}[$VALUE_TMP];
//        echo ${$form_name}[(int)$VALUE_TMP];
                echo "<input type='hidden' name='{$form_name}' value='{$this->form[$form_name]['value']}'>";
            }
        } elseif ($this->form[$form_name]['type'] == 'time') {
            if (((!$this->check) && $this->action == 'confirm') || $this->action == 'input' || $this->action == 'edit') {
                $START = strtotime($this->form[$form_name]['start']);
                $END = strtotime($this->form[$form_name]['end']);
                $INCREMENT = $this->form[$form_name]['increment'];
                echo "<select name={$form_name}>";
                echo "<option value=>▼</option>";
                for ($t = $START; $t < $END; $t = $t + ($INCREMENT * 60)) {
                    $T = date("H:i", $t);
                    echo "<option value='{$T}' ";
                    echo ($this->form[$form_name]['value'] == $T) ? "selected" : "";
                    echo ">{$T}</option>\n";
                }
                echo "</select>";
                $this->view_confirm_error($form_name);
            } elseif ($this->check && $this->action == 'confirm') {
                echo "<span class='attention'>{$this->form[$form_name]['value']}</span>";
                echo "<input type=hidden name={$form_name} value='{$this->form[$form_name]['value']}'>";
            }
        } elseif ($this->form[$form_name]['type'] == 'date') {

            // INSERT START[2005.06.14]
            if (isset($this->form[$form_name]['value'])) {
                // 日付データが存在する場合、年月日に分解
                $readingDate = NULL;
                if (is_string($this->form[$form_name]['value'])) {
                    $readingDate = GetDate(StrToTime($this->form[$form_name]['value']));
                } else {
                    $readingDate = GetDate($this->form[$form_name]['value']);
                }
                $this->form[$form_name]['value_y'] = $readingDate["year"]; //date("Y", $this->form[$form_name]['value']);
                $this->form[$form_name]['value_m'] = $readingDate["mon"];  //date("n", $this->form[$form_name]['value']);
                $this->form[$form_name]['value_d'] = $readingDate["mday"]; //date("j", $this->form[$form_name]['value']);
            }
            echo "<!--" . $this->form[$form_name]['value'] . "-->";
            echo "<!--" . $this->form[$form_name]['value_y'] . "-->";
            echo "<!--" . $this->form[$form_name]['value_m'] . "-->";
            echo "<!--" . $this->form[$form_name]['value_d'] . "-->";
            echo "<!--" . date("Y/n/j", strtotime($this->form[$form_name]['value'])) . "-->";
            echo "<!--" . date("Y", StrToTime($this->form[$form_name]['value'])) . "-->";
            echo "<!--" . date("n", StrToTime($this->form[$form_name]['value'])) . "-->";
            echo "<!--" . date("j", StrToTime($this->form[$form_name]['value'])) . "-->";
            echo "<br><!--" . GetType($this->form[$form_name]['value']) . "-->";
            // INSERT END [2005.06.14]

            $Y_START = $this->form[$form_name]['y_start'];
            $Y_END = $this->form[$form_name]['y_end'];
            if (((!$this->check) && $this->action == 'confirm') || $this->action == 'input' || $this->action == 'edit') {
                echo "<select name={$form_name}_y>\n";
                echo "<option value=>▼</option>\n";
                for ($y = $Y_START; $y <= $Y_END; $y++) {
                    echo "<option value={$y} ";
                    echo $this->form[$form_name]['value_y'] == $y ? "selected" : NULL;
                    echo ">{$y}</option>\n";
                }
                echo "</select>年";
                echo "<select name={$form_name}_m>";
                echo "<option value=>▼</option>";
                for ($m = 1; $m <= 12; $m++) {
                    echo "<option value={$m} ";
                    echo $this->form[$form_name]['value_m'] == $m ? "selected" : NULL;
                    echo ">{$m}</option>";
                }
                echo "</select>月";
                echo "<select name={$form_name}_d>";
                echo "<option value=>▼</option>";
                for ($d = 1; $d <= 31; $d++) {
                    echo "<option value={$d} ";
                    echo $this->form[$form_name]['value_d'] == $d ? "selected" : NULL;
                    echo ">{$d}</option>";
                }
                echo "</select>日";
                $this->view_confirm_error($form_name);
            } elseif ($this->check && $this->action == 'confirm') {
                if ($this->form[$form_name]['value']) {
                    echo "<span class='attention'>";
                    echo date("Y年n月j日", $this->form[$form_name]['value']);
                    echo "</span>";
                    echo "<input type=hidden name={$form_name} value='";
                    echo date("Y/n/j", $this->form[$form_name]['value']);
                    echo "'>";
                    echo "<input type=hidden name={$form_name}_y value='{$this->form[$form_name]['value_y']}'>";
                    echo "<input type=hidden name={$form_name}_m value='{$this->form[$form_name]['value_m']}'>";
                    echo "<input type=hidden name={$form_name}_d value='{$this->form[$form_name]['value_d']}'>";
                }
            }
        } elseif ($this->form[$form_name]['type'] == 'hidden') {
            if (!isset($this->form[$form_name]['value'])) {
                $this->form[$form_name]['value'] = isset($_POST[$form_name]) ? $_POST[$form_name] : NULL;
            }
            echo "<input type=hidden name={$form_name} value='{$this->form[$form_name]['value']}'>";
        }
    }

//フォーム情報をGET
    function get_form_value()
    {
        foreach ($this->form as $key => $value) {
            if ($this->form[$key]['type'] == 'checkbox') {
                $this->form[$key]['value'] = isset($_POST[$key]) ? 1 : FALSE;
            } elseif ($this->form[$key]['type'] == 'date') {
                // UPDATE START[2005.06.14] default today setting ...
                $this->form[$key]['value'] = isset($_POST[$key]) ? $_POST[$key] : NULL;
                // $this->form[$key]['value_y']= isset($_POST[$key.'_y'])?$_POST[$key.'_y']:NULL;
                // $this->form[$key]['value_m']= isset($_POST[$key.'_m'])?$_POST[$key.'_m']:NULL;
                // $this->form[$key]['value_d']= isset($_POST[$key.'_d'])?$_POST[$key.'_d']:NULL;
                $today = GetDate();
                $this->form[$key]['value_y'] = isset($_POST[$key . '_y']) ? $_POST[$key . '_y'] : $today["year"];
                $this->form[$key]['value_m'] = isset($_POST[$key . '_m']) ? $_POST[$key . '_m'] : $today["mon"];
                $this->form[$key]['value_d'] = isset($_POST[$key . '_d']) ? $_POST[$key . '_d'] : $today["mday"];
                // UPDATE END [2005.06.14]  default today setting ...

                if ($this->form[$key]['value_y'] != NULL || $this->form[$key]['value_m'] != NULL || $this->form[$key]['value_d'] != NULL) {
                    $this->form[$key]['value'] = mktime(0, 0, 0, $this->form[$key]['value_m'], $this->form[$key]['value_d'], $this->form[$key]['value_y']);
                }
            } else {
                $this->form[$key]['value'] = isset($_POST[$key]) ? $_POST[$key] : NULL;
            }
        }
    }

//必須だったら必須マーク出す
    function view_notnull($form_name)
    {
        if (isset($this->form[$form_name]['notnull'])) {
            echo "<font size=1 color=ff3333>※</font>";
        }
    }

//押されたボタンをGET
    function get_mode()
    {
        $SUBMIT = isset($_POST['submit']) ? $_POST['submit'] : '修正';
        if ($SUBMIT == "確認") {
            $mode = "";
        } elseif ($SUBMIT == "送信") {
            $mode = "";
        } elseif ($SUBMIT == "修正") {
            $mode = "rewrite";
        } elseif ($SUBMIT == '編集') {
            $mode = "edit";
        } elseif ($SUBMIT == '削除') {
            $mode = "delete";
        } elseif ($SUBMIT == '削除実行') {
            $mode = "delete";
        }
        return $mode;
    }

//押されたボタンをGET
    function get_action()
    {
        $SUBMIT = isset($_POST['submit']) ? $_POST['submit'] : '修正';
        if ($SUBMIT == "確認") {
            $action = "confirm";
        } elseif ($SUBMIT == "送信") {
            $action = "exec";
        } elseif ($SUBMIT == "修正") {
            $action = "input";
        } elseif ($SUBMIT == '編集') {
            $action = "edit";
        } elseif ($SUBMIT == '削除') {
            $action = "confirm";
            $mode = "delete";
        } elseif ($SUBMIT == '削除実行') {
            $action = "exec";
            $mode = "delete";
        }
        return $action;
    }


//入力内容チェック
    function check_confirm()
    {
        $check = TRUE;
        if ($this->action == 'confirm') {
            foreach ($this->form as $key => $value) {
                $this->form[$key]['error'] = NULL;
                if (isset($this->form[$key]['notnull'])) {
                    if ($this->form[$key]['value'] == NULL && $this->form[$key]['notnull'] == TRUE) {
                        $this->form[$key]['error'] .= "<font color=ff3333><b>必ず入力してください。<br></b></font>";
                        $check = FALSE;
                    }
                }
                if (isset($this->form[$key]['max'])) {
                    if ($this->form[$key]['max'] < mb_strlen($this->form[$key]['value'])) {
                        $this->form[$key]['error'] .= "<font color=ff0000><b>文字数が多すぎます。{$this->form[$key]['max']}文字以内で入力してください。</b></font><br>";
                        $check = FALSE;
                    }
                }
//大文字チェック
//半角チェック
//電話番号チェック
//郵便番号チェック
//メールアドレスチェック
            }
            return $check;
        } else {
            return TRUE;
        }
    }

//入力にエラーがあれば注意
    function view_confirm_error($form_name)
    {
        if (isset($this->form[$form_name]['error'])) {
            echo "<span class='attention'>{$this->form[$form_name]['error']}</span>";
        }
    }

//入力の注意書き表示
    function view_input_info($info)
    {
        if (((!$this->check) && $this->action == 'confirm') || $this->action == 'input') {
            echo $info;
        }
    }

//入力内容チェック結果をセット
    function set_check()
    {
        $this->check = $this->check_confirm();
    }

// フォーム定義セット
    function set_form($form)
    {
        $this->form = $form;
    }

//押されたボタンをセット
    function set_mode()
    {
        $this->mode = $this->get_mode();
    }

//押されたボタンをセット
    function set_action()
    {
        $this->action = $this->get_action();
    }

//DBに問い合わせ内容を書き込み
    function db_insert($dbconn, $TABLE)
    {
        $sql2 = "";
        $sql = "insert into {$TABLE} ";
        $sql .= "(";
        foreach ($this->form as $key => $value) {
            if ($this->form[$key]['value'] != NULL) {
                if ($this->form[$key]['type'] == 'date') {
                    $sql .= "{$key}, ";
                    $sql2 .= "'" . date("Y/n/j", $this->form[$key]['value']) . "', ";
                } else {
                    $sql .= "{$key}, ";
                    $sql2 .= "'{$this->form[$key]['value']}', ";
                }
            }
        }
        $sql .= ")values({$sql2})";

        $sql = str_replace(', )', ' )', $sql);
        $result = pg_query($dbconn, $sql);
        $oid = pg_last_oid($result);

        return $oid;
    }

//DBに問い合わせ内容を書き込み
    function db_update($dbconn, $TABLE, $QUERY)
    {
        $sql = "update {$TABLE} set ";
        foreach ($this->form as $key => $value) {
            if ($this->form[$key]['value'] != NULL) {
                if ($this->form[$key]['type'] == 'date') {
                    $sql .= " {$key} =  '" . date("Y/n/j", $this->form[$key]['value']) . "', ";
                } else {
                    $sql .= " {$key} =  '{$this->form[$key]['value']}', ";
                }
            }
        }
        $sql .= "where {$QUERY}";
        $sql = str_replace(', where', ' where', $sql);

        echo $sql;

        pg_query($dbconn, $sql);
        return TRUE;
    }

//DBに問い合わせ内容を削除
    function db_delete($dbconn, $TABLE, $QUERY)
    {
        $sql = "delete from {$TABLE} where {$QUERY}";
        pg_query($dbconn, $sql);
        return TRUE;
    }


}

?>