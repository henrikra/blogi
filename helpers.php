<?php

function e($string) {
	return htmlentities($string, ENT_QUOTES, 'UTF-8', false);
}

function getExcerpt($str, $startPos=0, $maxLength=100) {
	if(strlen($str) > $maxLength) {
		$excerpt = substr($str, $startPos, $maxLength-3);
		$lastSpace = strrpos($excerpt, ' ');
		$excerpt = substr($excerpt, 0, $lastSpace);
		$excerpt .= '...</p>'; // Lisätty lopetusmerkki, koska exerpt katkaisee paragraafin kesken.
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

function getTags($postId) {
	global $handler;
	$sql = "SELECT * FROM tag INNER JOIN posttag ON tag.tagId = posttag.tagId WHERE posttag.postID = :postId;";
	$stmt = $handler->prepare($sql);
	
	$stmt->bindParam(':postId', $postId, PDO::PARAM_INT);
	$stmt->execute();
	
	$tags = ' / <i class="fa fa-tags"></i> ';
	$counter = 0;
	while($r2 = $stmt->fetch(PDO::FETCH_OBJ)) :
		$tags .= '<a href="index.php?tagId=' . $r2->tagId . '">' . $r2->tagName . '</a>, ';
		$counter++;
	endwhile;
	if ($counter > 0) {
		echo substr($tags, 0, -2);
	}
}

function createParagraphs($text) {
	/* Change Windows newline-marks to Unix-format*/
	$text = preg_replace('~\r\n?~', "\n", $text);
	
	/*** make paragraphs ***/	
	/* Replace Unix-style newline marks with <p></p> */
	/* And add <p> to beginning and </p> to end of the text */
	$text = '<p>' . str_replace( chr(10) . chr(10), '</p><p>', $text) . '</p>';
	return $text;
}

function commentCount($postId) {
	global $handler;
	$sql = "SELECT COUNT(*) AS commentCount FROM postcomment WHERE postId = :postId";
	$stmt = $handler->prepare($sql);
	
	$stmt->bindParam('postId', $postId, PDO::PARAM_INT);
	$stmt->execute();
	
	$count = $stmt->fetch(PDO::FETCH_OBJ)->commentCount;
	return $count;
}

function printMetaInfo($r) {
	
	/* Print calendar icon and formatted dateTime */
	echo '<i class="fa fa-calendar"></i>' . ' ';
	echo formatDate($r->postDatetime);
	
	/* Print author icon and authorname */
	echo ' / ' . '<i class="fa fa-user"></i>' . ' ';
	echo $r->author;
	
	/* Print tags icon and tags */
	getTags($r->postId);
	
	/* Print comments icon and comments-info */
	echo ' / <i class="fa fa-comments"></i> ';
	echo '<a href="post.php?postId=' . $r->postId . '#comments">';
	echo commentCount($r->postId) . ' Comments';
	echo '</a>';
}

?>