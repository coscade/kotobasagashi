function pageBack(){
    history.back();
}
function submit_user_edit_form(next_page){
    if(next_page=='exec'){
        document.exec_form.submit();
    }else if(next_page=='back'){
        document.back_form.submit();
    }
}
function submit_user_regist_form(next_page){
    if(next_page=='exec'){
        document.exec_form.submit();
    }else if(next_page=='back'){
        document.back_form.submit();
    }
}
function back_mypage(){
    location.href = "";
}

function check_number(check_str){
    
    if(check_str!=""){
      flag = isNaN(check_str);
      if(flag){
           return false;
      }else{
           return true;
      }
    }else{
               return true;
    }
}

function submit_deal_regist_form(){
    
    var check_flag = true;
    err_str = "";

    if(!check_number(document.input_form.card_num.value)){
       check_flag = false;
       err_str += 'Please input number to [CARD NUMBER]\n';
    }

    alert(check_number(document.input_form.card_num.value));

    if(!check_flag){
       alert(err_str);
    }else{
       document.input_form.submit();
    }    

}

function submit_kotoba_regist_form(){
    
    var check_flag = true;
    err_str = "";

    if(check_number(document.input_form.kotoba_date.value)){
       check_flag = false;
       err_str += '表示日を入力してください。';
    }

    if(check_number(document.input_form.kotoba_value.value)){
       check_flag = false;
       err_str += 'ことばの内容を入力してください。';
    }

    if(check_number(document.input_form.comment.value)){
       check_flag = false;
       err_str += 'コメントを入力してください。';
    }

    if(!check_flag){
       alert(err_str);
    }else{
       document.input_form.submit();
    }    

}

function submit_kotoba_delete_form(){
  document.delete_form.submit();
}

function change_cm_id(){
  document.change_cm_form.source_id.value = document.input_form.source_id.value;
  document.change_cm_form.cm_id.value = document.input_form.cm_id.value;
  document.change_cm_form.cs_id.value = document.input_form.cs_id.value;
  document.change_cm_form.kotoba_value.value = document.input_form.kotoba_value.value;
  document.change_cm_form.comment.value = document.input_form.comment.value;
// alert("test");
  document.change_cm_form.kotoba_date.value = document.input_form.kotoba_date.value;
  document.change_cm_form.submit();
}

function change_cm_id2(){
  document.change_cm_form.source_id.value = document.input_form.source_id.value;
  document.change_cm_form.cm_id.value = document.input_form.cm_id.value;
  document.change_cm_form.cs_id.value = document.input_form.cs_id.value;
  document.change_cm_form.kotoba_value.value = document.input_form.kotoba_value.value;
  document.change_cm_form.comment.value = document.input_form.comment.value;
// alert("test");
  document.change_cm_form.kotoba_date_y.value = document.input_form.kotoba_date_y.value;
  document.change_cm_form.kotoba_date_m.value = document.input_form.kotoba_date_m.value;
  document.change_cm_form.kotoba_date_d.value = document.input_form.kotoba_date_d.value;
  document.change_cm_form.submit();
}

function submit_comment_confirm(){
  document.comment_form.submit();
}
function submit_comment_regist_form(next_page){
    if(next_page=='exec'){
        document.exec_form.submit();
    }else if(next_page=='back'){
        document.back_form.submit();
    }
}
function submit_admit_form(status){
    if(status=='ok'){
        document.ok_form.submit();
    }else if(status=='ng'){
        document.ng_form.submit();
    }else if('back'){
  document.back_form.submit();
    }
}
