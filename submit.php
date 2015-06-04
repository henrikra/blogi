<?php
include_once('database.php');

if( !empty($_POST['author']) && !empty($_POST['title']) && !empty($_POST['content'])) {
	$sql = 'INSERT INTO post(author, title, content) VALUES (:author, :title, :content)';

	$stmt = $handler->prepare($sql);

	$stmt->bindParam(':author', $_POST['author'], PDO::PARAM_STR);
	$stmt->bindParam(':title', $_POST['title'], PDO::PARAM_STR);
	$stmt->bindParam(':content', $_POST['content'], PDO::PARAM_STR);

	$stmt->execute();
	header('Location: index.php');
} else {
	header('Location: add_post.php');
}

?>