<?php 
    session_start();
    include_once "../../php/db/db_manipulation.php";
    
    $comment = $_POST["comment"];
    $user = $_SESSION['uname'];
    $fn = getID($user);
    $theme = getTheme($user, $fn);
    $version = getVersion($fn, 'ref');
	if($version != 0){
		$version = $version['version'];
	}
	else $version = 0;
    $theme_id = getThemeID($fn);
 	$target_dir = "./ref/";
	$target_file = $target_dir . $fn . "_ref_" . $version;
	$refFileType = strtolower(pathinfo(basename($_FILES["referat"]["name"]),PATHINFO_EXTENSION));
	$target_file .= "." . $refFileType;
	if(strlen(basename($_FILES["referat"]["name"])) == 0){
		echo "Не е избран файл!";
	}  
	elseif ($_FILES["referat"]["size"] = 0) {
        echo "Не е избран файл!";
	}
	elseif ($_FILES["referat"]["size"] > 10000000) {
	 echo "Файлът е прекалено голям. Максималният размер е 10MB.";
	}

	elseif($refFileType != "zip") {
		echo "Разрешените формати са ZIP.";
	}		
  	else{
  	    if(valid($_FILES["referat"]["tmp_name"])){
            if(!move_uploaded_file($_FILES["referat"]["tmp_name"], $target_file)){
                echo "Възникна проблем при качването на файла. Моля, опитайте отново!";
            }
            else{
                addFile('ref', $user, $fn, $theme_id, $version, $comment, $target_file);  	        
  	        }
  	    }
  	    else{
  	        echo " Моля, проверете съдържанието на архива!";
  	    }

  	}
  	
  	function valid($file){
    $zip = new ZipArchive;
    $res = $zip->open($file);
    if ($res) {
        $legitImage=explode('.',$zip->statIndex(0)['name']);
        $extensions = array("js", "JS", "html", "HTML", "JPG", "jpg", "png", "PNG", "css", "CSS", "txt", "TXT", "pdf", "PDF", "gif", "GIF");
        $cnt = 0;
        for($i = 0; $i < $zip->numFiles; $i++)
        {  
            $curr = $zip->getNameIndex($i);
            $path_parts = pathinfo("./" . $curr);
            if(count($path_parts) >= 4){
                if(!in_array($path_parts['extension'], $extensions)){
                    return false;    
                }
                else if($path_parts['extension'] === "js" || $path_parts['extension'] === "JS"){
                    ++$cnt;
                    if($cnt > 4){
                        echo "Файлът съдържа прекалено много скриптове и няма да бъде приет!";
                        return false;
                    }
                }
            }
        }
        $zip->close();
        return true;
    }
    else{
        echo "Възникна проблем при качването!";
        return false;
    }
}
?>
