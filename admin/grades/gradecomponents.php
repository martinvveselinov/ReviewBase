<?php
session_start();
include "../../php/db/db_manipulation.php";
   if(!gradingStarted()){
       echo "Все още няма стартирана кампания по оценяване!";
   }
   else{   
        $grades = getGrades();
        echo "<table class=\"table-fill\">
				<thead>
					<tr>
						<th class=\"text-center\">Проверяващ - ФН</th>
						<th class=\"text-center\">Проверяващ - тема</th>
						<th class=\"text-center\">Проверяван - ФН</th>
						<th class=\"text-center\">Проверяван - тема</th>
						<th class=\"text-center\">Реферат</th>
						<th class=\"text-center\">Презентация</th>
						<th class=\"text-center\">Покана</th>
						<th class=\"text-center\">Средна оценка</th>
					</tr>
				</thead>
    			<tbody class=\"table-hover\">";
		foreach($grades as $grade){
			$evaluatorId = getIdByTheme($grade['evaluator']);
			$evaluatedId = getIdByTheme($grade['evaluated']);
			echo "
			<tr>
				<td class=\"text-center\"> " . $evaluatorId . "</td>
				<td class=\"text-center\"> " . $grade['evaluator'] . "</td>
				<td class=\"text-center\"> " . $evaluatedId .  "</td>
				<td class=\"text-center\"> " . $grade['evaluated'] . "</td>
				<td class=\"text-center\"> " . $grade['ref'] . "</td>
				<td class=\"text-center\"> " . $grade['pres'] . "</td>
				<td class=\"text-center\"> " . $grade['inv'] . "</td>
				<td class=\"text-center\"> " . $grade['avg'] . "</td>
			</tr>";
		}
		echo "</tbody></table>
			<table class=\"table-fill\">
    		<thead>
    			<tr>
    				<th class=\"text-center\">Без тема или без предаден реферат</th>
				</tr>
				</thead>
					<tbody class=\"table-hover\">";
		$nothemes = noThemes();
		foreach($nothemes as $notheme){
			echo "<tr>
			<td class=\"text-center\"> " . $notheme['id'] . "</td>
			</tr>";
		}
		echo "</tbody></table>";
    		}
?>