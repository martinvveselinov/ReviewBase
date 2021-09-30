<?php
    session_start();
    include "../../renders/header.html";
    include "../../php/db/db_manipulation.php";
    $id = getID($_SESSION['uname']);
    $theme = getTheme($_SESSION['uname'], $id);
?>

</div>
<h4>Избраната тема е <?php
    echo $theme; ?></h4>
<p> Презентацията трябва да бъде .pdf или .pptx формат.</p>


<div class="form_holder">
<h3>Качи нова презентация</h3>
<center><span id="error"></span></center>
<form id="myForm" method="post" enctype="multipart/form-data">
	<input type="file" name="present" id="present">
	<input type="text" name="comment" id="comment">
	<button type="button" onclick="upload('pres')">Качи</button>
</form>
</div>

<h3>История на ревизиите</h3>
<h5>*редовете представляват различните версии - първият ред е първата качена, последният - последната</h5>
<?php
    $history = history($id, 'pres');
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
        $presentation = $version['file'];
        echo "<tr>
		    <td class=\"text-center\">" . $version['uploaded'] . "</td>
		    <td class=\"text-center\">" . $version['comment'] . "</td>
		    <td class=\"text-center\">0</td>
		    <td class=\"text-center\">0</td>
		    <td class=\"text-center\">средна оценка</td>
	        <td class=\"text-center\">
    	        <a class=\"btn green\" href=\"$presentation\" download>Изтегли</a>
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
