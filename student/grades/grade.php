<?php
	session_start();
	include "../../renders/header.html";
	include "../../php/db/db_manipulation.php";
?>
<h4>Кампания по оценяване</h4>
<?php
   if(!gradingStarted()){
       echo "Все още няма стартирана кампания по оценяване!";
   }
   else{
        $theme = getThemeName(getID($_SESSION['uname']));
		$evaluated;
		if(($evaluated = toEvaluate($theme)) != 0){
			$evaluated = $evaluated['evaluated'];
			if(alreadyGraded($evaluated)){
				echo "Този реферат вече е оценен!";
			}
			else{
				echo "Вие ще оценявате реферат на тема: <strong>" . $evaluated . "</strong><br><br><br>";
				$theme_no = getThemeNo($evaluated);
				$invitation = getContent('inv', $theme_no);
				$presentation = getContent('pres', $theme_no);
				$referat = getContent('ref', $theme_no);
				if($invitation === "undefined" || $presentation == "undefined" || $referat == "undefined"){
					echo "Студентът все още не е предал всички компоненти!";
				}
				else{
					$invitation = "../uploads" . substr($invitation, 1);
					$presentation = "../uploads" . substr($presentation, 1);
					$referat = "../uploads" . substr($referat, 1);					
					echo "<table class=\"table-fill\">
					<thead>
						<tr>
							<th class=\"text-center\">Реферат</th>
							<th class=\"text-center\">Презентация</th>
							<th class=\"text-center\">Покана</th>
						</tr>
					</thead>
					<tbody class=\"table-hover\">
						<tr>
							<td class=\"text-center\"> <a class=\"btn green\" href=\"$referat\" download>Изтегли</a></td>
							<td class=\"text-center\"> <a class=\"btn green\" href=\"$presentation\" download>Изтегли</a></td>
							<td class=\"text-center\"> <a class=\"btn green\" href=\"$invitation\" download><img src=\"$invitation\" width=\"300\" height=\"300\"></a></td>
						</tr>
						 <tr>
							<td id=\"ref\" class=\"text-center\">
								<input type=\"range\" name=\"gradeInputName1\" id=\"gradeInputId1\" value=\"5\" min=\"1\" max=\"10\" step=\"0.1\" oninput=\"gradeOutputId1.value = gradeInputId1.value\"><br>
								<output name=\"gradeOutputName1\" id=\"gradeOutputId1\">5</output>
							</td>
							<td id=\"ref\" class=\"text-center\">
								<input type=\"range\" name=\"gradeInputName2\" id=\"gradeInputId2\" value=\"5\" min=\"1\" max=\"10\" step=\"0.1\" oninput=\"gradeOutputId2.value = gradeInputId2.value\"><br>
								<output name=\"gradeOutputName2\" id=\"gradeOutputId2\">5</output>
							</td>
							<td id=\"ref\" class=\"text-center\">
								<input type=\"range\" name=\"gradeInputName3\" id=\"gradeInputId3\" value=\"5\" min=\"1\" max=\"10\" step=\"0.1\" oninput=\"gradeOutputId3.value = gradeInputId3.value\"><br>
								<output name=\"gradeOutputName3\" id=\"gradeOutputId3\">5</output>
							</td>
						</tr>
						<tr>
						</tr>
					</tbody>
				</table>";
				echo "<span id='status'></span>";
				echo "<a class=\"btn2 green\" onclick=\"grade('$evaluated', document.getElementById('gradeOutputId1').innerHTML, document.getElementById('gradeOutputId2').innerHTML, document.getElementById('gradeOutputId3').innerHTML)\">Запази оценка</a>";
				echo "<script src='../../js/upload.js'></script>";
				}
			}
		}
		else{
			echo "Вие не сте включен в кампанията по оценяване.";
		}
   }
?>
</div>
</div>
<script>
	document.getElementById('homepage').class = "";
	document.getElementById('choose').class = "";
	document.getElementById('upload').class="";
	document.getElementById('grade').classList.toggle("active");
	document.getElementById('logout').class = "";
</script>
</body>
</html>