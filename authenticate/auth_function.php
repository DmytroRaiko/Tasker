<?php

function check_reg_form_valid($form){
    $error = array();
    $emailPattern = '/^((?!\.)[\w\-_.]*[^.])(@\w+)(\.\w+(\.\w+)?[^.\W])$/';
    $passPattern = '/\w{6,40}/';
    if(!preg_match($emailPattern, $form['signup-email'])){
        $error['email_error'] = 'Email не відповідає шаблону';
    }
    if(!preg_match($passPattern, $form['signup-password'])){
        $error['pass_error'] = 'Пароль має бути не менше 6 символів і не містити спецсимволів';
    }
    if( $form['signup-password'] != $form['signup-repeat-password']){
        $error['rep_pass_error'] = 'Паролі не співпадають';
    }
    return $error;
    
}

?>