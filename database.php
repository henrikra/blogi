<?php

try {
	$handler = new PDO('mysql:host=127.0.0.1;dbname=blogi;charset=utf8', 'root', '');
	$handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
	echo $e->getMessage();
	die();
}

?>