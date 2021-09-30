<?php
    include "config.php";

    function connect(){
        global $config;
        $host = $config['DB_HOST'];
        $dbname = $config['DB_DATABASE'];
        $username = $config['DB_USERNAME'];
        $pass = $config['DB_PASSWORD'];
        try{
            $connection = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $pass, [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]);
            return $connection;
        } catch(PDOException $error){
            die ("Неуспешен опит за свързване с базата.");
        }
    }
?>