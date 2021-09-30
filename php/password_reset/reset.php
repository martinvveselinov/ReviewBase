<?php
    include "../db/db_manipulation.php";
	if(empty($_GET['email'] || !isset($_GET['email']))){ 
        echo "Моля, въведете имейл, на който да изпратим код за смяна на паролата!";
    }
    else{
        $email=$_GET['email'];
        if(registered($email)){
            $token = bin2hex(random_bytes(10));
            reset_request($email, $token);
            echo "Кодът е изпратен на адрес $email";
        }
        else{
            echo "Този имейл не е регистриран!";
        }
    } 
?>