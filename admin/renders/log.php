<?php
        session_start();
        include "../../php/db/db_manipulation.php";
        $logs = display_log();
        echo "
        <span id=\"status\"></span>
        <a class=\"btn green\" onclick=\"cleara('log')\">Изчисти лога</a><br><br>";
        echo "<a class=\"btn green\" href=\"../../admin/log.txt\" download>Изтегли лога</a><br><br>";
        echo "
        <table border='1' >
        <tr>
        <td> <b>Username</b></td>
        <td><b>IP</b></td>
        <td  ><b>Logged on</b></td>
        <td  ><b>OS</b></td></td>
        <td  ><b>Browser</b></td></td>
        ";
        foreach ($logs as $log) {
                echo "<tr>";
                echo "<td  >" . $log["username"] . "</td>";
                echo "<td  >" . $log["ip"] . "</td>";
                echo "<td  >" . $log["logged_on"] . "</td>";
                echo "<td  >" . $log["OS"] . "</td>";
                echo "<td  >" . $log["Browser"] . "</td>";
                echo "</tr>";
        }
        echo "</table>";
?>

