<?php
include "db_connection.php";

$connection = connect();
$grading_started = 0;
function clear($type){
    $table;
    if($type == 'pres'){
        $table = "presentations";
    }
    elseif($type == 'ref'){
        $table = "referats";
    }
    elseif($type == 'inv'){
        $table = "invitations";
    }
	elseif($type == 'log'){
		$table = "log_stats";
	}
    global $connection;;
    if($table != "log_stats"){

        $sql = "SELECT file FROM $table";
        $result = $connection->prepare($sql);
        $result-> execute() or die("Failed to execute the sql query.");
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            unlink($_SERVER['DOCUMENT_ROOT'] . "/puffinsecurity/student/uploads" . substr($row['file'], 1));
        }
    }
    else{
        unlink($_SERVER['DOCUMENT_ROOT'] . "/puffinsecurity/admin/log.txt");
    }
    $sql = "DELETE FROM $table";
    $result = $connection->prepare($sql);
    $result-> execute() or die("Failed to execute the sql query.");
}
function viewUploads(){
	$i = 0;
	$invitations = display_upl('inv');
	foreach ($invitations as $invitation) {
        $id = $invitation['user_id'];
        $username = getName($id);
        $theme = getTheme($username, $id);
        $file = "./uploads" . substr($invitation['file'], 1);
		echo "<tr>
    		    <td class=\"text-center\">" . $username . "</td>
    		    <td class=\"text-center\">" . $theme . "</td>
    		    <td class=\"text-center\">" . $invitation['version'] . "</td>
    		    <td class=\"text-center\">" . $invitation['uploaded'] . "</td>
    		    <td class=\"text-center\">" . $invitation['comment'] . "</td>
    		    <td class=\"text-center\">0</td>
    		    <td class=\"text-center\">0</td>
    		    <td class=\"text-center\">средна оценка</td>
    		    <td class=\"text-center\">
    		        <a class=\"btn green\" onclick=\"view('$i', '$file')\">Преглед</a>
    	        </td>
    	        <td class=\"text-center\">
    	            <img id=\"$i\" style=\"display: none\">
    	        </td>

            </tr>";

            ++$i;

	}
    echo "	</tbody>
		</table>";
}
function noThemes(){
    global $user_table;
    global $theme_table;
    global $connection;;
    $sql = "SELECT id FROM $user_table
            WHERE admin = 0 AND id NOT IN
            (SELECT user_id
            FROM $theme_table WHERE user_id IS NOT NULL)";
    $result = $connection->prepare($sql);
    $result-> execute() or die("Failed to execute the sql query.");
    $row = $result->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}
function getGrades(){
    global $grading_table;
    $sql = "SELECT * from $grading_table";
    global $connection;;
    $result = $connection->prepare($sql);
    $result-> execute() or die("Failed to execute the sql query.");
    $row = $result->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}
function register($username, $fn, $password, $email){
    global $user_table;
    global $connection;
    try {  
        $sql = "INSERT INTO " . $user_table . "(id, username, password, email) VALUES (:fn, :name, :password, :email)";
        $preparedSql = $connection->prepare($sql) or die("Failed to prepare insert sql query.");
        $preparedSql->bindParam(':name', $username);
        $preparedSql->bindParam(':password', $password);
        $preparedSql->bindParam(':fn', $fn);
        $preparedSql->bindParam(':email', $email);
        $preparedSql->execute() or die("Failed to execute sql insert query.");
        saveDevice($username);
        $_SESSION['uname'] = $username;
    }
    catch(PDOException $error) {
        echo $error->getMessage();
    }
}
function alreadyGraded($evaluated){
    global $grading_table;
    $sql = "SELECT * from $grading_table WHERE evaluated = :evaluated AND ref IS NOT NULL AND pres IS NOT NULL AND inv IS NOT NULL AND avg IS NOT NULL";
    global $connection;;
    $result = $connection->prepare($sql);
    $result->bindParam(":evaluated", $evaluated);
    $result-> execute() or die("Failed to execute the sql query.");
    if($result->rowCount() == 0){
        return false;
    }
    else{
        return true;
    }
}
function setGrade($theme, $ref, $pres, $inv, $avg){
    global $grading_table;
    $sql = "UPDATE $grading_table SET ref = :ref, pres = :pres, inv = :inv, avg = :avg WHERE evaluated = :theme";
    global $connection;;
    $result = $connection->prepare($sql);
    $result->bindParam(":ref", $ref);
    $result->bindParam(":pres", $pres);
    $result->bindParam(":inv", $inv);
    $result->bindParam(":avg", $avg);
    $result->bindParam(":theme", $theme);
    $result-> execute() or die("Failed to execute the sql query.");
}
function startGrading(){    
    if(gradingStarted()){
        exit();
    }
    else{
        $grading_started = 1;
        $themes = getAllThemes();
        $res1 = array();
        foreach($themes as $theme){
            array_push($res1, $theme['theme_name']);
        }
        $res = array();
        $first = $ele1 = array_shift($res1);
        while(count($res1)) {
            $ele2 = array_rand($res1);
            $res[$ele1] = $res1[$ele2];
            $ele1 = $res1[$ele2];
            array_splice($res1, $ele2, 1);
        }
        $res[$ele1] = $first;
        global $grading_table;
        global $connection;;
        $keys = array_keys($res);
        $i = 0;
        foreach($res as $evaluated){
            $sql = "INSERT INTO $grading_table(evaluator, evaluated) VALUES(:evaluator, :evaluated)";
            $result = $connection->prepare($sql);
            $result->bindParam(':evaluated', $evaluated);
            $result->bindParam(':evaluator',$keys[$i]);
            $result-> execute() or die("Failed to execute the sql query.");
            ++$i;
        }
    }
    
}
function toEvaluate($theme){
    global $grading_table;
    global $connection;
    $sql = "SELECT evaluated FROM $grading_table WHERE evaluator=:theme";
    $result = $connection->prepare($sql);
    $result->bindParam(':theme', $theme);
    $result->execute() or die("Failed to execute SEARCH sql query.");
	if($result->rowCount() > 0){
		$row = $result->fetchAll(PDO::FETCH_ASSOC);
		return $row[0];
	}
	else{
		return 0;
	}

}
function stopGrading(){
    global $grading_table;
    global $connection;
    $sql = "DELETE FROM $grading_table";
    $result = $connection->prepare($sql);
    $result-> execute() or die("Failed to execute the sql query.");
}
function gradingStarted(){
    global $grading_table;
    global $connection;;
    $sql = "SELECT * FROM $grading_table";
    $result = $connection->prepare($sql);
    $result-> execute() or die("Failed to execute the sql query.");
    if($result->rowCount() > 0){
        return true;
    }
    else return false;
}
function getAllThemes(){
    global $theme_table;
    global $connection;
    $sql = "SELECT theme_name FROM $theme_table WHERE user_id IS NOT NULL";
    $result = $connection->prepare($sql);
    $result->execute() or die("Failed to execute SEARCH sql query.");
    $row = $result->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}
function extraDevice($username){
    global $device_table;
    try {
        global $connection;
        saveDevice($username);
        $sql = "DELETE FROM add_device WHERE username = :username";
        $preparedSql = $connection->prepare($sql) or die("Failed to prepare insert sql query.");
        $preparedSql->bindParam(':username', $username);
        $preparedSql->execute() or die("Failed to execute sql insert query.");
    }
    catch(PDOException $error) {
        echo $error->getMessage();
    }
}
function token_matches($token, $username){
    global $new_device;
    global $connection;;
    $sql = "SELECT * FROM $new_device WHERE username = :username AND token = :token";
    $result = $connection->prepare($sql);
    $result->bindParam(':username', $username);
    $result->bindParam(':token', $token);
    $result-> execute() or die("Failed to execute the sql query.");
    if($result->rowCount() > 0){
        return true;
    }
    else return false;
}
function newDevice($username, $browser, $os){
    global $device_table;
    global $connection;;
    $sql = "SELECT * FROM $device_table WHERE username = :username AND browser = :browser AND os = :os";
    $result = $connection->prepare($sql);
    $result->bindParam(':username', $username);
    $result->bindParam(':browser', $browser);
    $result->bindParam(':os', $os);
    $result-> execute() or die("Failed to execute the sql query.");
    if($result->rowCount() == 0){
        return true;
    }
    else return false;
}
function getDevices($username){
    global $device_table;
    global $connection;;
    $sql = "SELECT device_no FROM $device_table WHERE username = :username";
    $result = $connection->prepare($sql);
    $result->bindParam(':username', $username);
    $result-> execute() or die("Failed to execute the sql query.");
    return $result->rowCount();
}
function saveDevice($username){
    try{
        global $device_table;
        global $connection;
        $id = getID($username);
        $os_browser = getOS_Browser();
        $browser = $os_browser[1];
        $os = $os_browser[0];
        $device_no = getDevices($username) + 1;
        $sql = "INSERT INTO $device_table(user_id, username, browser, os, device_no) VALUES(:id, :username, :browser, :os, :device_no)";
        $result = $connection->prepare($sql);
        $result->bindParam(':id', $id);
        $result->bindParam(':username', $username);
        $result->bindParam(':browser', $browser);
        $result->bindParam(':os', $os);
        $result->bindParam(':device_no', $device_no);
        $result-> execute() or die("Failed to execute the sql query.");
    }
    catch(PDOException $error){
        echo $error->getMessage();
    }
}
function history_pres($id){
    global $presentations_table;
    global $connection;
    $sql = "SELECT * FROM $presentations_table WHERE user_id=$id";
    $result = $connection->prepare($sql);
    $result->execute() or die("Failed to execute SEARCH sql query.");
    $row = $result->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}
function getIdByTheme($theme){
    global $theme_table;
    global $connection;;
    $sql = "SELECT user_id FROM $theme_table WHERE `theme_name` = :theme";
    $result = $connection->prepare($sql);
    $result->bindParam(":theme", $theme);
    $result-> execute() or die("Failed to execute the sql query.");
    $row= $result->fetch(PDO::FETCH_ASSOC);
    return $row['user_id'];
}
function hasChosen($id){
    global $theme_table;
    global $connection;;
    $sql = "SELECT user_id FROM $theme_table WHERE `user_id` = :id";
    $result = $connection->prepare($sql);
    $result->bindParam(":id", $id);
    $result-> execute() or die("Failed to execute the sql query.");
    return $result->rowCount() > 0;
}
function hasUpload($id, $table){
    global $connection;;
    $sql = "SELECT user_id FROM $table WHERE `user_id` = :id";
    $result = $connection->prepare($sql);
    $result->bindParam(":id", $id);
    $result-> execute() or die("Failed to execute the sql query.");
    return $result->rowCount() > 0;
}
function getThemeNo($theme){
    global $connection;;
    global $theme_table;
    $sql = "SELECT theme_no FROM $theme_table WHERE `theme_name` = :theme";
    $result = $connection->prepare($sql);
    $result->bindParam(":theme", $theme);
    $result-> execute() or die("Failed to execute the sql query.");
    $row= $result->fetch(PDO::FETCH_ASSOC);
    return $row['theme_no'];
}
function getThemeID($id){
    global $connection;
    global $theme_table;
    $sql = "SELECT theme_no FROM $theme_table WHERE `user_id` = :id";
    $result = $connection->prepare($sql);
    $result->bindParam(":id", $id);
    $result-> execute() or die("Failed to execute the sql query.");
    $row= $result->fetch(PDO::FETCH_ASSOC);
    return $row['theme_no'];
}
function getContent($type, $id){
    global $connection;
    $table;
    if($type == 'ref') $table = 'referats';
    else if($type == 'pres') $table = 'presentations';
    else if($type == 'inv') $table = 'invitations';
    $sql = "SELECT file FROM $table WHERE `theme` = :id ORDER BY version DESC LIMIT 1";
    $result = $connection->prepare($sql);
    $result->bindParam(":id", $id);
    $result-> execute() or die("Failed to execute the sql query.");
	if($result->rowCount() > 0){
		$row= $result->fetch(PDO::FETCH_ASSOC);
		return $row['file'];
	}
	else{
		return "undefined";
	}
}
function addFile($type, $username, $id, $theme_no, $version, $comment, $file){
    try{
        global $connection;
        $table;
        if($type == 'ref') $table = 'referats';
        else if($type == 'pres') $table = 'presentations';
        else if($type == 'inv') $table = 'invitations';
        //$version = 0;
        if(hasUpload($id, $table)){
            $last_version = $version + 1;
            $sql = "INSERT INTO $table (user_id, username, version, comment, theme, file) VALUES(:id, :username,  :version, :comment, :theme, :file)";
            $result = $connection->prepare($sql);
            $result->bindParam(":id", $id);
            $result->bindParam(":username", $username);
            $result->bindParam(":version", $last_version);
            $result->bindParam(":comment", $comment);
            $result->bindParam(":theme", $theme_no);
            $result->bindParam(":file", $file);
            if($result->execute()){
                echo "Файлът беше качен успешно!";
            }
			else{
				echo "Възникна проблем!";
			}
        }
        else{
            $version = 1;
            $sql = "INSERT INTO $table (user_id, username, version, comment, theme, file) VALUES(:id, :username, :version, :comment, :theme, :file)";
            $result = $connection->prepare($sql);
            $result->bindParam(":id", $id);
            $result->bindParam(":username", $username);
            $result->bindParam(":version", $version);
            $result->bindParam(":comment", $comment);
            $result->bindParam(":theme", $theme_no);
            $result->bindParam(":file", $file);
            try{
                $result->execute();
                echo "Файлът беше качен успешно!";
            }
            catch(PDOException $error) {
                echo $error->getMessage();
                echo "Възникна проблем!";
            }
        }
    }
    catch(PDOException $error) {
        echo $error->getMessage();
    }
}
function history($id, $type){
    $table;
    if($type == 'ref') $table = 'referats';
    else if($type == 'pres') $table = 'presentations';
    else if($type == 'inv') $table = 'invitations';
    global $connection;
    $sql = "SELECT * FROM $table WHERE user_id=$id";
    $result = $connection->prepare($sql);
    $result->execute() or die("Failed to execute SEARCH sql query.");
    $row = $result->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}
function getVersion($id, $type){
    global $connection;
    $table;
    if($type == 'ref') $table = 'referats';
    else if($type == 'pres') $table = 'presentations';
    else if($type == 'inv') $table = 'invitations';
    $sql = "SELECT version FROM $table WHERE `user_id` = :id ORDER BY version DESC LIMIT 1";
    $result = $connection->prepare($sql);
    $result->bindParam(":id", $id);
    $result-> execute() or die("Failed to execute the sql query.");
	if($result->rowCount() == 0){
		return 0;
	}
	else{
		$row= $result->fetch(PDO::FETCH_ASSOC);
		return $row;
	}
}
function getName($id){
    global $connection;;
    global $user_table;
    $sql = "SELECT username FROM $user_table WHERE `id` = :id";
    $result = $connection->prepare($sql);
    $result->bindParam(":id", $id);
    $result-> execute() or die("Failed to execute the sql query.");
    $row= $result->fetch(PDO::FETCH_ASSOC);
    return $row['username'];
}
function getThemeName($id){
    global $connection;;
    global $theme_table;
    $sql = "SELECT theme_name FROM $theme_table WHERE `user_id` = :id";
    $result = $connection->prepare($sql);
    $result->bindParam(":id", $id);
    $result-> execute() or die("Failed to execute the sql query.");
    $row= $result->fetch(PDO::FETCH_ASSOC);
    return $row['theme_name'];
}
function getTheme($username, $uid){
    global $connection;;
    global $theme_table;
    $sql = "SELECT theme_no, theme_name FROM $theme_table WHERE `user_id` = :id";
    $result = $connection->prepare($sql);
    $result->bindParam(":id", $uid);
    $result-> execute() or die("Failed to execute the sql query.");
	if($result->rowCount() > 0){
		$row= $result->fetch(PDO::FETCH_ASSOC);
		return $row['theme_no'] . " - " . $row['theme_name'];
	}
	else{
		return 0;
	}


}
function isFree($theme_id){
    global $connection;;
    global $theme_table;
    $sql = "SELECT * FROM $theme_table WHERE `theme_no` = :theme_no AND `user_id` IS NULL";
    $result = $connection->prepare($sql);
    $result->bindParam(":theme_no", $theme_id);
    $result-> execute() or die("Failed to execute the sql query.");
    return $result->rowCount() > 0 ? 1 : 0;
}
function reserve($id, $theme_id, $hasUpload){
    global $connection;;
    global $theme_table;
    $ql;
    if(!$hasUpload){
        $sql = "UPDATE $theme_table SET user_id = :user_id WHERE theme_no = :theme_no";
        $result = $connection->prepare($sql);
        $result->bindParam(":theme_no", $theme_id);
        $result->bindParam(":user_id", $id);
        $result-> execute() or die("Failed to execute the sql query.");
    }
    else{
        $sql = "UPDATE $theme_table SET user_id = NULL WHERE user_id = :user_id";
        $result = $connection->prepare($sql);
        $result->bindParam(":user_id", $id);
        $result-> execute() or die("Failed to execute the sql query.");
        $sql1="UPDATE $theme_table SET user_id = :user_id WHERE theme_no = :theme_no";
        $result1 = $connection->prepare($sql1);
        $result1->bindParam(":theme_no", $theme_id);
        $result1->bindParam(":user_id", $id);
        $result1-> execute() or die("Failed to execute the sql query.");
    }
}
function reset_request($email, $token){
    require_once "send_mail.php";
    try {
        global $connection;
        if(!requested($email)){
            $sql = "INSERT INTO password_reset (email, token) VALUES (:email, :token)";
            $preparedSql = $connection->prepare($sql) or die("Failed to prepare insert sql query.");
            $preparedSql->bindParam(':email', $email);
            $preparedSql->bindParam(':token', $token);
            $preparedSql->execute() or die("Failed to execute sql insert query.");
            send($email, $token);
        }
        else{
            $sql = "UPDATE password_reset SET token = :token WHERE email = :email";
            $preparedSql = $connection->prepare($sql) or die("Failed to prepare insert sql query.");
            $preparedSql->bindParam(':email', $email);
            $preparedSql->bindParam(':token', $token);
            $preparedSql->execute() or die("Fаiled to execute sql insert query.");
            send($email, $token);
        }
    }
    catch(PDOException $error) {
        echo $error->getMessage();
    }
}
function add_request($email, $username, $token){
    try {
        global $connection;
        if(!requested_device($username)){
            $sql = "INSERT INTO add_device (username, token) VALUES (:username, :token)";
            $preparedSql = $connection->prepare($sql) or die("Failed to prepare insert sql query.");
            $preparedSql->bindParam(':username', $username);
            $preparedSql->bindParam(':token', $token);
            $preparedSql->execute() or die("Failed to execute sql insert query.");
            send($email, $token);
        }
        else{
            $sql = "UPDATE add_device SET token = :token WHERE username = :username";
            $preparedSql = $connection->prepare($sql) or die("Failed to prepare insert sql query.");
            $preparedSql->bindParam(':username', $username);
            $preparedSql->bindParam(':token', $token);
            $preparedSql->execute() or die("Failed to execute sql insert query.");
            send($email, $token);
        }
    }
    catch(PDOException $error) {
        echo $error->getMessage();
    }
}
function password_reset($email, $newPass){
    try {
        global $connection;
        $sql = "UPDATE user SET password = :password WHERE email = :email";
        $preparedSql = $connection->prepare($sql) or die("Failed to prepare insert sql query.");
        $preparedSql->bindParam(':email', $email);
        $preparedSql->bindParam(':password', $newPass);
        $preparedSql->execute() or die("Failed to execute sql insert query.");
        $sql = "DELETE FROM password_reset WHERE email = :email";
        $preparedSql = $connection->prepare($sql) or die("Failed to prepare insert sql query.");
        $preparedSql->bindParam(':email', $email);
        $preparedSql->execute() or die("Failed to execute sql insert query.");
    }
    catch(PDOException $error) {
        echo $error->getMessage();
    }
}
function clear_token($email){
    try {
        global $connection;
        $sql = "DELETE FROM password_reset WHERE email = :email";
        $result = $connection->prepare($sql) or die("Failed to prepare insert sql query.");
        $preparedSql->bindParam(':email', $email);
        $result->execute() or die("Failed to execute sql insert query.");
    }
    catch(PDOException $error) {
        echo $error->getMessage();
    }
}
function requested($email){
    global $connection;
    $sql = "SELECT * FROM password_reset WHERE email = :email";
    $result = $connection->prepare($sql);
    $result->bindParam(':email', $email);
    $result->execute() or die("Failed to execute SEARCH sql query.");
    if($result->rowCount() > 0){
        return true;
    }
    else{
        return false;
    }
}
function requested_device($username){
    global $connection;
    $sql = "SELECT * FROM add_device WHERE username = :username";
    $result = $connection->prepare($sql);
    $result->bindParam(':username', $username);
    $result->execute() or die("Failed to execute SEARCH sql query.");
    if($result->rowCount() > 0){
        return true;
    }
    else{
        return false;
    }
}
function registered($email){
    global $user_table;
    global $connection;
    $sql = "SELECT email FROM " . $user_table . " WHERE email = :email";
    $result = $connection->prepare($sql);
    $result->bindParam(':email', $email);
    $result->execute() or die("Failed to execute SEARCH sql query.");
    if($result->rowCount() > 0){
        return true;
    }
    else{
        return false;
    }
}
function clearattempts($username){
    global $connection;
    $sql = "DELETE from `loginattempts` WHERE `username`='$username'";
    $result = $connection->prepare($sql);
    $result-> execute() or die("Failed to execute the sql query.");
}
function has_attempts($username){
    global $connection;
    $sql = "SELECT `username` FROM `loginattempts` WHERE `username` = '$username'";
    $result = $connection->prepare($sql);
    $result-> execute() or die("Failed to execute the sql query.");
    $cnt = $result->rowCount();
    if($cnt > 0) return true;
    else return false;
}
function attempt($username){
    global $connection;
    if(!has_attempts($username)){ //nqma neuspeshni opiti za vhod
        $sql = "INSERT INTO `loginattempts` (`username` ,`timestamp`)VALUES ('$username',CURRENT_TIMESTAMP)";
        $result = $connection->prepare($sql);
        $result-> execute() or die("Failed to execute the sql query.");
    }
    else{
        if(block_login($username)){
            $id = getID($username);
            lock($id);
            $sql = "UPDATE `loginattempts` SET timestamp=CURRENT_TIMESTAMP WHERE username=:username";
            $result = $connection->prepare($sql);
            $result->bindParam(':username', $username);
            $result-> execute() or die("Failed to execute the sql query.");
        }
        else{
            $sql = "UPDATE `loginattempts` SET attempt_no=attempt_no+1, timestamp=CURRENT_TIMESTAMP WHERE username=:username";
            $result = $connection->prepare($sql);
            $result->bindParam(':username', $username);
            $result-> execute() or die("Failed to execute the sql query.");
        }
    }
}
function lockout_ended($username){
    global $lockout_time;
    global $connection;
    $sql = "SELECT * FROM `loginattempts` WHERE `username` = '$username' AND `timestamp` >= DATE_SUB(NOW(), INTERVAL $lockout_time MINUTE)";
    $result = $connection->prepare($sql) or die ("failed");
    $result->execute() or die ("failed");
    $num = $result->rowCount();
    if($num > 0){
        return false;
    }
    else{
        return true;
    }
}
function block_login($username){
    global $login_attempts;
    global $connection;
    $sql = "SELECT `attempt_no` FROM `loginattempts` WHERE `username` = '$username'";
    $result = $connection->prepare($sql);
    $result-> execute() or die("Failed to execute the sql query.");
    $num = $result->fetch(PDO::FETCH_ASSOC);
    if($num['attempt_no'] >= $login_attempts-1){
        return true;
    }
    else{
        return false;
    }
}
function change_role($to, $id){
    global $user_table;
    global $connection;
    $sql = "UPDATE $user_table SET admin=$to WHERE id=$id";
    $result = $connection->prepare($sql);
    $result-> execute() or die("Failed to execute the sql query.");
    echo $to;
}
function lock($id){
    global $user_table;
    global $connection;
    $sql = "UPDATE $user_table SET ban=1 WHERE id=$id";
    $result = $connection->prepare($sql);
    $result-> execute() or die("Failed to execute the sql query.");
}
function unlock($username){
    global $user_table;
    global $connection;
    $sql = "UPDATE `user` SET `ban`=0 WHERE `username`='$username'";
    $result = $connection->prepare($sql);
    $result-> execute() or die("Failed to execute the sql query.");
}
function change_block($to, $id){
    global $user_table;
    global $connection;
    $sql = "UPDATE $user_table SET ban=$to WHERE id=$id";
    $result = $connection->prepare($sql);
    $result-> execute() or die("Failed to execute the sql query.");
    echo $to;
}
function getOS_Browser(){
    global $user_agent;
    $os_platform  = "Unknown OS Platform";
    $os_array     = array(
              '/windows nt 10/i'      =>  'Windows 10',
              '/windows nt 6.3/i'     =>  'Windows 8.1',
              '/windows nt 6.2/i'     =>  'Windows 8',
              '/windows nt 6.1/i'     =>  'Windows 7',
              '/windows nt 6.0/i'     =>  'Windows Vista',
              '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
              '/windows nt 5.1/i'     =>  'Windows XP',
              '/windows xp/i'         =>  'Windows XP',
              '/windows nt 5.0/i'     =>  'Windows 2000',
              '/windows me/i'         =>  'Windows ME',
              '/win98/i'              =>  'Windows 98',
              '/win95/i'              =>  'Windows 95',
              '/win16/i'              =>  'Windows 3.11',
              '/macintosh|mac os x/i' =>  'Mac OS X',
              '/mac_powerpc/i'        =>  'Mac OS 9',
              '/linux/i'              =>  'Linux',
              '/ubuntu/i'             =>  'Ubuntu',
              '/iphone/i'             =>  'iPhone',
              '/ipod/i'               =>  'iPod',
              '/ipad/i'               =>  'iPad',
              '/android/i'            =>  'Android',
              '/blackberry/i'         =>  'BlackBerry',
              '/webos/i'              =>  'Mobile'
        );
    foreach ($os_array as $regex => $value){
        if (preg_match($regex, $user_agent)){
            $os_platform = $value;
        }
    }
    $browser        = "Unknown Browser";
    $browser_array = array(
                '/msie/i'      => 'Internet Explorer',
                '/firefox/i'   => 'Firefox',
                '/safari/i'    => 'Safari',
                '/chrome/i'    => 'Chrome',
                '/edge/i'      => 'Edge',
                '/opera/i'     => 'Opera',
                '/netscape/i'  => 'Netscape',
                '/maxthon/i'   => 'Maxthon',
                '/konqueror/i' => 'Konqueror',
                '/mobile/i'    => 'Handheld Browser'
         );
    foreach ($browser_array as $regex => $value){
        if (preg_match($regex, $user_agent)){
            $browser = $value;
        }
    }
    $res = array($os_platform, $browser);
    return $res;
}
function logIP($username, $os_browser){
    global $connection;;
    global $log_table;
    $ip = "undefined";
    $register_globals = (bool) ini_get('register_gobals');
    if ($register_globals){
        $ip = getenv(REMOTE_ADDR);
    }
    else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    date_default_timezone_set('Europe/Sofia');
    $date = date('m/d/Y h:i:s a', time());
    $sql = "INSERT INTO $log_table(username, ip, logged_on, OS, Browser) VALUES(:name, :ip, CURRENT_TIMESTAMP, :os, :browser)";
    $result = $connection->prepare($sql);
    $result->bindParam(":name", $username);
    $result->bindParam(":ip", $ip);
    $result->bindParam(":os", $os_browser[0]);
    $result->bindParam(":browser", $os_browser[1]);
    $result-> execute() or die("Failed to execute the sql query.");
	$fileOpen = fopen('../../admin/log.txt', 'a');
	fputs($fileOpen, $name . "	" . $ip . "	" . $date . "	" . $os_browser[0] . "	" . $os_browser[1] . "\n");
	fclose($fileOpen);
}
function isAdmin($name){
    global $user_table;
    global $connection;
    $sql = "SELECT admin FROM " . $user_table . " WHERE username = :name";
    $result = $connection->prepare($sql);
    $result->bindParam(':name', $name);
    $result->execute() or die("Failed to execute SEARCH sql query.");
    $row = $result->fetch(PDO::FETCH_ASSOC);
    if($row['admin'] == 1){
        return true;
    }
    else{
        return false;
    }
}
function isBlocked($name){
    global $user_table;
    global $connection;
    $sql = "SELECT ban FROM " . $user_table . " WHERE username = :name";
    $result = $connection->prepare($sql);
    $result->bindParam(':name', $name);
    $result->execute() or die("Failed to execute SEARCH sql query.");
    $row = $result->fetch(PDO::FETCH_ASSOC);
    if($row['ban'] == 1){
        return true;
    }
    else{
        return false;
    }
}
function display_log(){
    global $log_table;
    global $connection;
    $sql = "SELECT username, ip, logged_on, OS, Browser FROM " . $log_table;
    $result = $connection->prepare($sql);
    $result->execute() or die("Failed to execute SEARCH sql query.");
    $row = $result->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}
function display(){
    global $user_table;
    global $connection;
    $sql = "SELECT id, username, password, email, admin, ban FROM " . $user_table;
    $result = $connection->prepare($sql);
    $result->execute() or die("Failed to execute SEARCH sql query.");
    $row = $result->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}
function display_upl($type){
    $table;
    if($type == 'ref') $table = 'referats';
    else if($type == 'pres') $table = 'presentations';
    else if($type == 'inv') $table = 'invitations';
 global $connection;
    $sql = "SELECT * FROM $table ORDER BY user_id, version ASC";
    $result = $connection->prepare($sql);
    $result->execute() or die("Failed to execute SEARCH sql query.");
    $row = $result->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}
function display_themes(){
    global $theme_table;
    global $connection;
    $sql = "SELECT theme_name, user_id FROM " . $theme_table;
    $result = $connection->prepare($sql);
    $result->execute() or die("Failed to execute SEARCH sql query.");
    $row = $result->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}
function existingField($type, $value){
    global $user_table;
    try{
        global $connection;
        $sql = "SELECT $type FROM " . $user_table . " WHERE $type = :value";
        $result = $connection->prepare($sql);
        $result->bindParam(":value", $value);
        $result-> execute() or die("Failed to execute the sql query.");
        return $result->rowCount() > 0;
    }
    catch(PDOException $error) {
        echo $error->getMessage();
    }
}
function getHash($username){
    global $user_table;
    global $connection;
    $sql = "SELECT password FROM " . $user_table . " WHERE username = :name";
    $result = $connection->prepare($sql);
    $result->bindParam(':name', $username);
    $result-> execute() or die("Failed to execute the sql query.");
    $row = $result->fetch(PDO::FETCH_ASSOC);
    return $row['password'];
}
function existing($name, $pass){
    global $user_table;
	global $connection;
    $sql = "SELECT * FROM " . $user_table . " WHERE username = :name";
    $result = $connection->prepare($sql);
    $result->bindParam(':name', $name);
    $result->execute() or die("Failed to execute account verify sql query.");
    if($result->rowCount() > 0){ // ima takova registrirano potrebitelsko ime
        $hash = getHash($name);
        if(password_verify($pass, $hash)){ // vuvedenata parola suvpada s hash-a v bazata
            return 1;
        }
        else{//ne suvpada
            return -1;
        }
    }
    else{//nqma takova potrebitelsko ime
        return 0;
    }
}
function getID($username){
    global $user_table;
    try {
        global $connection;
        $sql = "SELECT id FROM $user_table WHERE username=:username";
        $result = $connection->prepare($sql) or die("Failed to prepare select sql query.");
        $result->bindParam(':username', $username);
        $result->execute() or die("Failed to execute select sql query.");
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row['id'];
    }
    catch(PDOException $error) {
        echo $error->getMessage();
    }
}
function getEmail($token, &$errors){
    try {
		global $connection;
        $sql = "SELECT * FROM password_reset WHERE token=:token";
        $result = $connection->prepare($sql) or die("Failed to prepare select sql query.");
        $result->bindParam(':token', $token);
        $result->execute() or die("Failed to execute select sql query.");
        if($result->rowCount() > 0){
			$row = $result->fetch(PDO::FETCH_ASSOC);
			return $row['email'];
		}
		else{
			$errors['token'] = "Въведеният код не съвпада с получения на Вашия имейл адрес!1";
		}
    }
    catch(PDOException $error) {
        echo $error->getMessage();
    }
}
function getAccEmail($username){
    try {
        global $connection;
        $sql = "SELECT email FROM user WHERE username=:username";
        $result = $connection->prepare($sql) or die("Failed to prepare select sql query.");
        $result->bindParam(':username', $username);
        $result->execute() or die("Failed to execute select sql query.");
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row['email'];
    }
    catch(PDOException $error) {
        echo $error->getMessage();
    }
}
?>