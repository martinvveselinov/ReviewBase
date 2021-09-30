<?php
    session_start();
    include "../db/db_manipulation.php";
    if(!isset($_SESSION['uname'])){
        unset( $_SESSION['errorMessage'] );
        unset( $_SESSION['blocked'] );
        header("Location: ../../index.php");
    }
?>
<?php
	global $allowed_devices;
	if(isset($_POST)){
		unset( $_SESSION['errorMessage'] );
		unset( $_SESSION['blocked'] );
		$username = $_POST['name'];
		$password = $_POST['pass'];
		$os_browser = getOS_Browser();
		$os = $os_browser[0];
		$browser = $os_browser[1];
		$_SESSION['uname'] = $username;
		$blocked = isBlocked($username);
		$admin = isAdmin($username);
		switch (existing($username, $password)){
			case 1: //username+pass combination exists
				$location = ""; //depending on the role - admin page or user page
				if($admin){
					$_SESSION['role'] = 1;
					$location = "./logged_admin.php";
				}
				else{
					$_SESSION['role'] = 0;
					$location = "./logged_in.php";
				}
				if(!$blocked){ // the user is not blocked
					if(newDevice($username, $browser, $os)){ //check if this is a new device
						if(getDevices($username) >= $allowed_devices){
							header("Location: ../add_device/add_device.php");
							break;
						}
						else saveDevice($username);
					}
					clearattempts($username); //attempts are the failed login attempts, so on successfull login, clear the attempts
					logIP($username, $os_browser); //save the login to the log.txt file
					header('Location: ' . $location); //go to the location - user or admin	                
				}
				else{ //user is blocked (either banned or blocked due to failed login attempts)
					if(has_attempts($username)){ //there are failed attempts
						if(lockout_ended($username)){ //user has been blocked for login attempts and the lock time (15 mins) has passed
							unlock($username); // user is unlocked
							clearattempts($username); //attempts are cleared
							logIP($username,  $os_browser);
							header('Location: ' . $location);
						}
					}
					$_SESSION['blocked'] = 1;
					header("Location: ../../index.php");
				}
				break;
			case -1: //correct username, wrong password
				if(!$blocked){ //if user is not blocked, increase login attempts
					attempt($username);
					$_SESSION['errorMessage'] = 1;
				}
				else{//if user is blocked, set the session variable to display the error mesage
					$_SESSION['blocked'] = 1;
				}
				header("Location: ../../index.php");
				break;
			case 0: //wrong username
				$_SESSION['errorMessage'] = 1;
				header("Location: ../../index.php");
				break;
		}
	}
?>