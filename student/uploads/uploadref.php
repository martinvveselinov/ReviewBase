<?php
    session_start();
    include "../../renders/header.html";
    include "../../php/db/db_manipulation.php";
    $id = getID($_SESSION['uname']);
    $theme = getTheme($_SESSION['uname'], $id);
?>
</div>
<h4>Избраната тема е <?php echo $theme; ?></h4>
<p>Качи ZIP файл в който е реферата и има файл с разширение .html или папка в която има файл с разширение .html. В архива може да има .html, .css, .pdf, изображения (png, gif, jpeg, jpg), както и до 4 .js файла.</p>
	<div class="form_holder">
		<h3>Качи нова версия на реферата</h3>
		<span id="error"></span>
		<form id="myForm" method="post" enctype="multipart/form-data">
			<input type="file" name="referat" id="referat">
			<input type="text" name="comment" id="comment">
			<button type="button" onclick="upload('ref')">Качи</button>
		</form>
	</div>
<h3>История на ревизиите</h3>
<h5>*редовете представляват различните версии - първият ред е първата качена, последният - последната</h5>
<?php
    $history = history($id, 'ref');
    $i = 0;
    //hasUpload($id, 'referats')
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
        $referat = $version['file'];
        $imgref = "img" . $i;
        echo "<tr>
		    <td class=\"text-center\">" . $version['uploaded'] . "</td>
		    <td class=\"text-center\">" . $version['comment'] . "</td>
		    <td class=\"text-center\">0</td>
		    <td class=\"text-center\">0</td>
		    <td class=\"text-center\">средна оценка</td>
		    <td class=\"text-center\">
		        <a class=\"btn green\" href=\"$referat\" download=\"$referat\">Download</a>
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
	<script>
		document.getElementById('homepage').class = "";
        document.getElementById('choose').class = "";
        document.getElementById('upload').classList.toggle("active");
        document.getElementById('grade').class = "";
        document.getElementById('logout').class = "";
	</script>
    <script src="../../js/upload.js">
	</script>
    </body>
</html>