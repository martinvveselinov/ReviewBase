<?php
    include "db/db_manipulation.php";
    $username_max_length = 32;
    $name_reg = '/^[a-zA-Z0-9]+$/';
    $fn_max_len = 6;
    $group_len_max = 3;
    $url_max_length = 1024;
    $fn_reg = '/^[0-9]+$/';
    //
    function validateUsername($username, int $username_max_len, String $reg, &$errors){
        if(!preg_match($reg, $username)) { 
            $errors['username'] = "Потребителското име може да съдържа само букви на латиница и цифри";
        }
        elseif(strlen($username) < 5){
            $errors['username'] = "Минималната дъжина на потребителското име е 5 символа!";
        }
        elseif(existingField('username', $username)){
            $errors['username'] = "Потребителското име е заето!";
        }
        
    }
    function validateEmail($email, &$errors){
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Моля, въведете валиден имейл адрес!";
        }
        elseif(existingField('email', $email)){
            $errors['email'] = "Този имейл е зает!";
        }
    }
    function confirmPassword($password, $password2, &$errors){
        if($password !== $password2){
            $errors['password2'] = "Двете пароли не съвпадат!";
        }
    }
    function validatePassword($password, int $pass_min_len, &$errors){
        if($password != ""){
            if (strlen($password) < $pass_min_len) {
                $errors['password'] = "Паролата трябва да съдържа поне 8 символа!";
            }
            elseif(!preg_match("#[0-9]+#",$password)) {
                $errors['password'] = "Паролата трябва да съдържа поне 1 цифра!";
            }
            elseif(!preg_match("#[A-Z]+#",$password)) {
                $errors['password'] = "Паролата трябва да съдържа поне 1 главна буква!";
            }
            elseif(!preg_match("#[a-z]+#",$password)) {
                $errors['password'] = "Паролата трябва да съдържа поне 1 малка буква!";
            }
            elseif(!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $password)) {
                $errors['password'] = "Паролата трябва да съдържа поне 1 специален символ!";
            }
        }
        else{
            $errors['password'] = "Моля, въведете парола!!";
        }
    }
    function validateFN($fn, int $fn_max_len, String $reg, &$errors){	
        if(preg_match($reg, $fn)){
            if(existingField('id', $fn)){
                $errors['fn'] = "Студент с такъв факултетен номер вече е регистриран!";
            }
            elseif(strlen($fn) > $fn_max_len){
                $errors['fn'] = "Максималната дължина на факултетния номер е $fn_max_len цифри!";
            }
        }
        elseif(!preg_match($reg, $fn)){
            $errors['fn'] = "Факултетният номер може да съдържа само цифри! Моля, въведете валиден ФН!";	
        }
    }
?>