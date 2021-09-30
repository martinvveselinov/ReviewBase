<?php
session_start();
include "../../php/db/db_manipulation.php";
    if (isset($_GET['theme_no'])) {
        $theme_no = $_GET['theme_no'];
        $user = $_SESSION['uname'];
        $id = getID($user);
        if(isFree($theme_no)){
            reserve($id, $theme_no, hasChosen($id));
        }
    }
?>