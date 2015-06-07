<?php
session_start();

include_once('database.php');
include_once('helpers.php');

$errors = [];

/* testaan, tuleeko pyyntö formilta */
if (isset($_POST['author']) && isset($_POST['title']) && isset($_POST['content'])) {
	$author = e($_POST['author']);
	$title = e($_POST['title']);
	$content = e($_POST['content']);
	
	/* laitetaan fields taulukkoon add_postista sisältö */
	$fields = [
		'author' => $author,
		'title' => $title,
		'content' => $content
	];
	
}




if( !empty($_POST['author']) && !empty($_POST['title']) && !empty($_POST['content'])) {
	$sql = 'INSERT INTO post(author, title, content, imageLocation) VALUES (:author, :title, :content, :imageLocation)';

	$stmt = $handler->prepare($sql);
	
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
		
		$tag = e($tag);
		
		$stmt->bindParam(':postId', $postId, PDO::PARAM_STR);
		$stmt->bindParam(':tag', $tag, PDO::PARAM_STR);
		
		$stmt->execute();
	}
	/* Redirecting to main page*/
	header('Location: index.php');
} else {
	
	/* Redirecting back to add_post with PART OF inserted values */
	/* Currently PART OF means: author, title, content*/
	
	$_SESSION['fields'] = $fields;
	
	$errors[] = 'Kaikki kentät kuvaa ja tageja lukuunottamatta ovat pakollisia';
	$_SESSION['errors'] = $errors;
	header('Location: add_post.php');
}

?>