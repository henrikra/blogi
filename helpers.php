<?php

function e($string) {
	return htmlentities($string, ENT_QUOTES, 'UTF-8', false);
}

function getExcerpt($str, $startPos=0, $maxLength=100) {
	if(strlen($str) > $maxLength) {
		$excerpt = substr($str, $startPos, $maxLength-3);
		$lastSpace = strrpos($excerpt, ' ');
		$excerpt = substr($excerpt, 0, $lastSpace);
		$excerpt .= '...';
	} else {
		$excerpt = $str;
	}
	
	return $excerpt;
}

function formatDate($date) {
	return date('D j.n.Y \- H:i', strtotime($date));
}

function getComments($row) {
	global $commentLevel, $handler;
	$commentLevel++;
	
	$replyTo = '';
	
	// Etsitään lapsen vanhempi
	if($row->commentReply != null) {
		$sql = "SELECT commentAuthor FROM postcomment WHERE commentId = :commentId";
		$stmt = $handler->prepare($sql);
		
		$parentId = $row->commentReply;
		
		$stmt->bindParam(':commentId', $parentId, PDO::PARAM_INT);
		$stmt->execute();
		if($stmt->rowCount() > 0) {
			$parent = $stmt->fetch(PDO::FETCH_OBJ);
			$replyTo = '<span class="reply-to">@' . $parent->commentAuthor . ': </span>';
		}
	}
	
	// Kommentti template
	echo '<div class="comment">';
	echo '<div class="comment-meta">';
	echo '<span class="comment-author">';
	echo '<i class="fa fa-user"></i> ' . $row->commentAuthor;
	echo '</span>';
	echo '<span class="comment-date"> &bull; ' . formatDate($row->commentDatetime) . '</span>';
	echo '</div>';
	echo '<div class="comment-content">';
	echo $replyTo . $row->commentContent;
	echo '</div>';
	// Ei aseteta vastauslinkkiä jos liian syvä kommenttitaso
	if($commentLevel < 5) {
		echo '<a class="reply-btn" data-reply-id="' . $row->commentId . '">Vastaa</a>';
	}
	
	// Etsitään kommentin vastaukset
	$sql = "SELECT commentId, commentAuthor, commentDatetime, commentContent, commentReply FROM postcomment WHERE commentReply = :commentReply";
	$stmt = $handler->prepare($sql);
	
	$commentReply = $row->commentId;
	
	$stmt->bindParam(':commentReply', $commentReply, PDO::PARAM_INT);
	$stmt->execute();
	
	if($stmt->rowCount() > 0) {
		echo '<div class="comment-replies">';
		
		// Rekursiolla käydään vastaukset läpi
		while($r = $stmt->fetch(PDO::FETCH_OBJ)) : 
			getComments($r);
			$commentLevel--;
		endwhile;
		
		echo '</div>';
	}
	echo '</div>';
}


?>