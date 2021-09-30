<?php

include 'db_manipulation.php';

    $user_table = "themes";

    try {

        $connection = connect();

        $themes = file_get_contents('../themes.txt');

        $res = explode("\n", $themes);

        var_dump($res);

        foreach ($res as $theme) {

            echo $theme . "<br>";

            $sql = "INSERT INTO $user_table(theme_name) VALUES(:name)";

            $preparedSql = $connection->prepare($sql) or die("Failed to prepare insert sql query.");

            $preparedSql->bindParam(':name', $theme);

            $preparedSql->execute() or die("Filed to execute sql insert query.");

        }   

    }

    catch(PDOException $error) {

        echo $error->getMessage();

    }

?>