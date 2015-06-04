<?php
include_once('database.php');

function e($string) {
	return htmlentities($string, ENT_QUOTES, 'UTF-8', false);
}

if( !empty($_POST['author']) && !empty($_POST['title']) && !empty($_POST['content'])) {
	$sql = 'INSERT INTO post(author, title, content) VALUES (:author, :title, :content)';

	$stmt = $handler->prepare($sql);

	$stmt->bindParam(':author', e($_POST['author']), PDO::PARAM_STR);
	$stmt->bindParam(':title', e($_POST['title']), PDO::PARAM_STR);
	$stmt->bindParam(':content', e($_POST['content']), PDO::PARAM_STR);

	$stmt->execute();
	header('Location: index.php');
} else {
	header('Location: add_post.php');
}

?>