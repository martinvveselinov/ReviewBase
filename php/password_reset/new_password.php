<?php
    include "../validate.php";
    if (isset($_GET['token']) && isset($_GET['newPass'])) {
        $newPass = $_GET['newPass'];
        $pass_min_len = 8;
        $errors = array();
        validatePassword($newPass, $pass_min_len, $errors);
		
		$token = $_GET['token'];
		$email = getEmail($token, $errors);
		if(count($errors) == 0 ){
            $hash = password_hash($newPass, PASSWORD_DEFAULT);
			password_reset($email, $hash);
			echo "Упешно сменихте паролата си! Ще бъдете пренасочени към входната страница след 3 секунди!";
		}
		else{
			foreach($errors as $error){
				echo $error . "<br>";
			}
		}
	}
?>