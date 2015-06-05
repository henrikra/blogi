<?php

function e($string) {
	return htmlentities($string, ENT_QUOTES, 'UTF-8', false);
}

function getExcerpt($str, $startPos=0, $maxLength=100) {
	if(strlen($str) > $maxLength) {
		$exerpt = substr($str, $startPos, $maxLength-3);
		$lastSpace = strrpos($excerpt, ' ');
		$excerpt = substr($excerpt, 0, $lastSpace);
		$excerpt .= '...';
	} else {
		$excerpt = $str;
	}
	
	return $excerpt;
}


?>