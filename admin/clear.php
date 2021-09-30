<?php
    include "../php/db/db_manipulation.php";
    if (isset($_GET['type'])) {
		$type=$_GET['type'];
		switch ($type) {
			case 'pres':
				clear('pres');
				break;
			case 'ref':
				clear('ref');
				break;
			case 'inv':
				clear('inv');
				break;
			case 'log':
				clear('log');
				break;
		}
    }
?>