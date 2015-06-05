<?php
include_once('database.php');

function e($string) {
	return htmlentities($string, ENT_QUOTES, 'UTF-8', false);
}

if( !empty($_POST['author']) && !empty($_POST['title']) && !empty($_POST['content'])) {
	$sql = 'INSERT INTO post(author, title, content, imageLocation) VALUES (:author, :title, :content, :imageLocation)';

	$stmt = $handler->prepare($sql);

	$stmt->bindParam(':author', e($_POST['author']), PDO::PARAM_STR);
	$stmt->bindParam(':title', e($_POST['title']), PDO::PARAM_STR);
	$stmt->bindParam(':content', e($_POST['content']), PDO::PARAM_STR);
	
	/* Preparing picture */
	
	$imageName = $_FILES['image']['name'];
	echo $imageName;
	
	$tmp_location = $_FILES['image']['tmp_name'];
	$wanted_location = 'img\\uploads\\' . $imageName;
	
	move_uploaded_file($tmp_location, $wanted_location);
	
	$stmt->bindParam(':imageLocation', $wanted_location, PDO::PARAM_STR);

	/* Executing SQL query */
	$stmt->execute();
	
	/* Redirecting to main page*/
	header('Location: index.php');
} else {
	/* Redirecting back to blank form */
	header('Location: add_post.php');
}

?>