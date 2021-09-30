<?php 
    session_start();
    include_once "../../php/db/db_manipulation.php";
    $comment = $_POST["comment"];
    $user = $_SESSION['uname'];
    $fn = getID($user);
    $theme = getTheme($user, $fn);
    $version = getVersion($fn, 'pres');
	if($version != 0){
		$version = $version['version'];
	}
		else $version = 0;
    $theme_id = getThemeID($fn);
 	$target_dir = "./pres/";	
	$target_file = $target_dir . $fn . "_pres_" . $version;
	$presentFileType = strtolower(pathinfo(basename($_FILES["present"]["name"]),PATHINFO_EXTENSION));
	$target_file .= "." . $presentFileType;
	if(strlen(basename($_FILES["present"]["name"])) == 0){
		echo "Не е избран файл!";
	}  
	elseif ($_FILES["present"]["size"] = 0) {
        echo "Не е избран файл!";
	}
	elseif ($_FILES["present"]["size"] > 10000000) {
	 echo "Файлът е прекалено голям. Максималният размер е 10MB.";
	}

	elseif($presentFileType != "pdf" && $presentFileType != "pptx" && $presentFileType != "ppt") {
		echo "Разрешените формати на презентацията са PDF и PPTX.";
	}		
  	else{
  	move_uploaded_file($_FILES["present"]["tmp_name"], $target_file);
      addFile('pres', $user, $fn, $theme_id, $version, $comment, $target_file);
  	}
?>
