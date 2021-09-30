<?php
    session_start();
    include "../db/db_manipulation.php";
    
    $theme = $_GET['theme'];
    $ref = $_GET['ref'];
    $pres = $_GET['pres'];
    $inv = $_GET['inv'];
    $avg = (floatval($ref) + floatval($pres) + floatval($inv))/3.0;

    setGrade($theme, floatval($ref), floatval($pres), floatval($inv), floatval($avg));
?>