<?php

include_once('database.php');
include_once('helpers.php');

if( !empty($_POST['postId']) && !empty($_POST['commentAuthor']) && !empty($_POST['commentContent'])){
	$sql = "INSERT INTO postcomment postId, commentAuthor, commentContent VALUES (:postId, :commentAuthor, :commentContent)";
	
	$stmt = $handler->$prepare($sql);
	
	$postId = e($_POST['postId']);
	$commentAuthor = e($_POST['commentAuthor']);
	$commentContent = e($_POST['commentContent']);
	
	$stmt->bindParam(':postId', $postId, PDO::PARAM_INT);
	$stmt->bindParam(':commentAuthor', $commentAuthor, PDO::PARAM_STR);
	$stmt->bindParam(':commentContent', $commentContent, PDO::PARAM_STR);
	
	$stmt->execute();
	
} else {
	
	echo 'You have to insert your name and comment';
	
}

//header('Location: post.php?');
?>