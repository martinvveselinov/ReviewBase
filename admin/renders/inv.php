<?php
session_start();
include "../../php/db/db_manipulation.php";
$i = 0;
$invitations = display_upl('inv');
if(count($invitations) > 0){
    echo "<span id=\"status\"></span>
<button class=\"btn green\" onclick=\"cleara('inv')\">Изчисти качвания</button>";
echo "
<table class=\"table-fill\">
		<thead>
			<tr>
				<th class=\"text-center\">Потребител</th>
				<th class=\"text-center\">Тема</th>
				<th class=\"text-center\">Версия</th>
				<th class=\"text-center\">Дата на качване</th>
				<th class=\"text-center\">Коментар</th>
				<th class=\"text-center\">Брой рецензии</th>
				<th class=\"text-center\">Брой корекции</th>
				<th class=\"text-center\">Средна оценка</th>
				<th class=\"text-center\">Преглед</th>
			</tr>
		</thead>
		<tbody class=\"table-hover\">";
    

    foreach ($invitations as $invitation) {
        $id = $invitation['user_id'];
        $username = getName($id);
        $theme = getTheme($username, $id);
        $file = "../../student/uploads" . substr($invitation['file'], 1);
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
    	            <img id=\"$i\" width=\"300\" height=\"300\" style=\"display: none\">
    	        </td>
    	        
            </tr>";
              
            ++$i;
    
        }
    echo "	</tbody>
		</table>";
}
else{
		echo "Все още няма качени покани!";
	}
?>