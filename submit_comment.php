<?php

session_start();
include_once('database.php');
include_once('helpers.php');

$postId = e($_POST['postId']);

/*--- Spämmisesto ---*/
// Tarkastetaan, onko session aikana tehty aikaisempi kommentti
$ableToComment = true;
// Jos on tehty aikaisempi kommentti, tutkitaan onko kulunut riittävä aika siitä
if (isset($_SESSION['commentPostTime'])) {
	$commentPostTime = $_SESSION['commentPostTime'];
	$currentTime = time();
	$cooldownTime = 30;
	$ableToComment = $currentTime - $commentPostTime > $cooldownTime;
}

/*
$_SESSION['errors'][] = '!$hasCommented: ' . !$hasCommented;
$_SESSION['errors'][] = '$currentTime: ' . $currentTime;
$_SESSION['errors'][] = '$commentPostTime: ' . $commentPostTime;
$_SESSION['errors'][] = 'Spämmiesto :' . (!$hasCommented || $ableToComment);
*/

if( !empty($_POST['postId']) && !empty($_POST['commentAuthor']) && !empty($_POST['commentContent']) && $ableToComment){
		
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
	
	// Save comment's timestamp to session to prevent ableToComment
	$_SESSION['commentPostTime'] = time();
	
	header('Location: post.php?postId=' . $postId . '#comments');
	
} else {
	
	/*--- Deciding error message --*/
	// option 1: comments is ableToComment
	if(!$ableToComment){
		$_SESSION['errors'][] = 'Please post again after a short while.';
	// option 2: comment has not needed fields
	} else {
		/* Store error if name or comment is missing */
		$_SESSION['errors'][] = 'You have to insert your name and comment';
	}
	
	/* Store possibly filled value to session */
	$_SESSION['fields']['commentAuthor'] = e($_POST['commentAuthor']);
	$_SESSION['fields']['commentContent'] = e($_POST['commentContent']);
	
	/* Redict back to add-comment section */
	header('Location: post.php?postId=' . $postId . '#add-comment');
	
}

?>