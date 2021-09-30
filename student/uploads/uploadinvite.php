<?php
    session_start();
    include "../../renders/header.html";
    include "../../php/db/db_manipulation.php";
    $id = getID($_SESSION['uname']);
    $theme = getTheme($_SESSION['uname'], $id);
?>
</div>
<h4>Избраната тема е <?php
    echo $theme; ?>
</h4>
<p> Поканата трябва да включва час, дата, тема, както и място на провеждане на презентацията. <br>
Качи .png/jpg/jpeg/gif или видео, представляващо поканата ти. Името трябва да е referat_pokana.*
 </p>
<div class="form_holder">
<h3>Качи нова покана за презентацията</h3>
<span id="error"></span>
<form id="myForm" method="post" enctype="multipart/form-data">
	<input type="file" name="image" id="image">
	<input type="text" name="comment" id="comment">
	<button type="button" onclick="upload('inv')">Качи</button>
</form>
</div>
<h3>История на ревизиите</h3>
<h5>*редовете представляват различните версии - първият ред е първата качена, последният - последната</h5>
<?php
    $history = history($id, 'inv');
    $i = 0;
   	if(count($history) > 0){
		echo "<table class=\"table-fill\">
			<thead>
				<tr>
					<th class=\"text-center\">Дата на качване</th>
					<th class=\"text-center\">Коментар</th>
					<th class=\"text-center\">Брой рецензии</th>
					<th class=\"text-center\">Брой корекции</th>
					<th class=\"text-center\">Средна оценка</th>
					<th class=\"text-center\">Преглед</th>
				</tr>
			</thead>
			<tbody class=\"table-hover\">";
		foreach ($history as $version) {
			$invite = "'" . $version['file'] . "'";
			echo "<tr>
				<td class=\"text-center\">" . $version['uploaded'] . "</td>
				<td class=\"text-center\">" . $version['comment'] . "</td>
				<td class=\"text-center\">0</td>
				<td class=\"text-center\">0</td>
				<td class=\"text-center\">средна оценка</td>
				<td class=\"text-center\">
					<a class=\"btn green\" onclick=\"view($i, $invite)\">Преглед</a>
				</td>
				<td class=\"text-center\">
					<img id=\"$i\" width=\"300\" height=\"300\"  style=\"display: none;\">
				</td>
			</tr>";
			++$i;
		}
		echo "	</tbody>
			</table>";
   }
   else{
       echo "Все още няма качена версия!";
   }
?>
            </div>
        </div>
    <script src="../../js/upload.js"></script>
    </body>
</html>