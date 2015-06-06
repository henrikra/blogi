<?php

include_once('database.php');
include_once('helpers.php');

$postId = e($_POST['postId']);

if( !empty($_POST['postId']) && !empty($_POST['commentAuthor']) && !empty($_POST['commentContent'])){
	$sql = "INSERT INTO postcomment (postId, commentAuthor, commentContent, commentReply) VALUES (:postId, :commentAuthor, :commentContent, :commentReply);";

	$stmt = $handler->prepare($sql);
	
	$commentAuthor = e($_POST['commentAuthor']);
	$commentContent = e($_POST['commentContent']);
	
	$stmt->bindParam(':postId', $postId, PDO::PARAM_INT);
	$stmt->bindParam(':commentAuthor', $commentAuthor, PDO::PARAM_STR);
	$stmt->bindParam(':commentContent', $commentContent, PDO::PARAM_STR);
	
	if(empty($_POST['commentReply'])){
		$commentReply = NULL;
	} else {
		$commentReply = e($_POST['commentReply']);
	}
	
	$stmt->bindParam(':commentReply', $commentReply, PDO::PARAM_STR);
	
	$stmt->execute();
	header('Location: post.php?postId=' . $postId . '#comments');
	
} else {
	
	echo 'You have to insert your name and comment';
	header('Location: post.php?postId=' . $postId . '#add-comment');
	
}

?>