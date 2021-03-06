<?php
    session_start();
    include "../validate.php";
    
    $username_max_len = 32;
    $username_reg = '/^[a-zA-Z0-9]+$/';
    $fn_max_len = 6;
    $fn_reg = '/^[0-9]+$/';
    $pass_min_len = 8;
    $errors = array();
    $username = $_GET['name'];
    $fn = $_GET['fn'];
    $email = $_GET['mail'];
    $password = $_GET['pass'];
    $password2 = $_GET['pass2'];

    validateUsername($username, $username_max_len, $username_reg, $errors);
    validateFN($fn, $fn_max_len, $fn_reg, $errors);
    validatePassword($password, $pass_min_len, $errors);
    confirmPassword($password, $password2, $errors);
    validateEmail($email, $errors);
    if(count($errors) == 0 ){
        $hash = password_hash($password, PASSWORD_DEFAULT);
        register($username, $fn, $hash, $email);
        $_SESSION['registered'] = 1;
    }
    else{
        foreach($errors as $error){
            echo $error . "<br>";
        }
        echo "<br>";
    }
?>