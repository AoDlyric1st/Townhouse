<?php
$db = new mysqli('localhost', 'root','', 'RealEstate');
if ($db->connect_error){
	die('Ошибка подключения:'. $db->connect_error);
}
$db->set_charset('utf8mb4');
?>