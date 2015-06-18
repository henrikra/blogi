<?php

class Token {
	
	/* Generate random 32 character string*/
	public static function generate() {
		// Save string to session and return it
		return $_SESSION['token'] = base64_encode(openssl_random_pseudo_bytes(32));
	}
	
	/* Check if paramater has same value that SESSION has*/
	public static function check($token) {
		if(isset($_SESSION['token']) && $token === $_SESSION['token']) {
			// unset token so that it cannot be used again
			unset($_SESSION['token']);
			return true;
		}
		return false;
	}
}

?>