<?php
include_once('database.php'); 
include_once('helpers.php');

if(!empty($_POST['tag'])){
	$tag = e($_POST['tag']);
	
	$sql = 'INSERT INTO tag (tagName) VALUES (:tag)';
	
	$stmt = $handler->prepare($sql);
	$stmt->bindParam(':tag', $tag, PDO::PARAM_STR);
	$stmt->execute();
	
	header('Location: index.php');
	
} else {
	header('Location: add_tag.php');
}
	
?>