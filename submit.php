<?php
include_once('database.php');

function e($string) {
	return htmlentities($string, ENT_QUOTES, 'UTF-8', false);
}

if( !empty($_POST['author']) && !empty($_POST['title']) && !empty($_POST['content'])) {
	$sql = 'INSERT INTO post(author, title, content, imageLocation) VALUES (:author, :title, :content, :imageLocation)';

	$stmt = $handler->prepare($sql);

	$author = e($_POST['author']);
	$title = e($_POST['title']);
	$content = e($_POST['content']);
	
	$stmt->bindParam(':author', $author, PDO::PARAM_STR);
	$stmt->bindParam(':title', $title, PDO::PARAM_STR);
	$stmt->bindParam(':content', $content, PDO::PARAM_STR);
	
	/*** Preparing picture ***/
	
	/* If picture exits */
	if(!empty($_FILES['image']['name'])) {
		$imageName = $_FILES['image']['name'];
		
		$tmp_location = $_FILES['image']['tmp_name'];
		$wanted_location = 'uploads/' . $imageName;
		
		move_uploaded_file($tmp_location, $wanted_location);
		
		$stmt->bindParam(':imageLocation', $wanted_location, PDO::PARAM_STR);
	} else {
		/* If picture does not exist */
		$n = null;
		$stmt->bindParam(':imageLocation', $n, PDO::PARAM_STR);
		// Function bindParam wants a reference (variable) for 2nd parameter.
	}

	
	/* Executing SQL query */
	$stmt->execute();
	
	$postId = $handler->lastInsertId();
	$sql = 'INSERT INTO posttag (postId, tagId) VALUES (:postId, :tag)';
	
	foreach($_POST['tags'] as $tag) {
		/* Yhdistetään kysely yhteyteen*/
		$stmt = $handler->prepare($sql);
				
		$stmt->bindParam(':postId', $postId, PDO::PARAM_STR);
		$stmt->bindParam(':tag', $tag, PDO::PARAM_STR);
		
		$stmt->execute();
	}
	/* Redirecting to main page*/
	header('Location: index.php');
} else {
	/* Redirecting back to blank form */
	header('Location: add_post.php');
}

?>