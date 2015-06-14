<?php
session_start();

include_once('database.php');
include_once('helpers.php');

$errors = [];
$tags = [];
$tagNames = [];


$fileTooBig = false;
if ( !empty($_SERVER['CONTENT_LENGTH']) && empty($_FILES) && empty($_POST) ) {
	$errors[] = 'Image is too big! Max size is 0.5 MB';
	$fileTooBig = true;
} else {
	/* testaan, tuleeko pyyntö formilta */
	if (isset($_POST['author']) && isset($_POST['title']) && isset($_POST['content'])) {
		$author = e($_POST['author']);
		$title = e($_POST['title']);
		$content = e($_POST['content']);
		$imageName = null;
		
		if (!empty($_POST['imageNameHidden'])) {
			$imageName = $_POST['imageNameHidden'];
			if (!empty($_FILES['image']['name'])) {
				$imageName = null;
			}
		}
		
		/*** Preparing picture ***/
		
		/* If picture exits */
		
		if(!isset($imageName) && !empty($_FILES['image']['name'])) {
			
			$file_name = $_FILES['image']['name'];
			$file_size = $_FILES['image']['size'];
			$file_error = $_FILES['image']['error'];
			
			$uploadedImageName = $_FILES['image']['name'];
			
			$tmp_location = $_FILES['image']['tmp_name'];
			$wanted_location = 'uploads/' . $uploadedImageName;
			$maxBytes = 500000;
			if ($file_error !== UPLOAD_ERR_INI_SIZE && $file_size <= $maxBytes) {
				if (move_uploaded_file($tmp_location, $wanted_location)) {
					$imageName = $uploadedImageName;
				} else {
					$errors[] = 'Something went wrong';
				}
			} else {
				$errors[] = 'Image is too big! Max size is 0.5 MB';
			}
		}
		for ($x = 0; $x < sizeof($_POST['tagIds']); $x++) {
			if ($_POST['tagIds'][$x] === '') {
				$tagNames[] = e($_POST['tagNames'][$x]);
			} else {
				/* Lisätään $tags-taulukkoon kaikki alkiot, jota POST taulussa on */
				$tags[] = e($_POST['tagIds'][$x]);
			}
		}
		
		/* laitetaan fields taulukkoon add_postista sisältö */
		$fields = [
			'author' => $author,
			'title' => $title,
			'content' => $content,
			'tags' => $tags,
			'tagNames' => $tagNames,
			'imageName' => $imageName
		];
		
	}

	if(!empty($_POST['author']) && !empty($_POST['title']) && !empty($_POST['content']) && !empty($_POST['tagIds'])) {
		$allTextFieldsFilled = true;
	} else {
		$errors[] = 'Lukuunottamatta kuvatiedostoa, kaikki kentät ovat pakollisia';
	}
}

// Jos kaikki tarkistukset menivät läpi niin viedään kantaan
if( $allTextFieldsFilled && !$fileTooBig) {
	$sql = 'INSERT INTO post(author, title, content, imageLocation) VALUES (:author, :title, :content, :imageLocation)';

	$stmt = $handler->prepare($sql);
	
	$stmt->bindParam(':author', $author, PDO::PARAM_STR);
	$stmt->bindParam(':title', $title, PDO::PARAM_STR);
	$stmt->bindParam(':content', $content, PDO::PARAM_STR);
	
	if(!empty($_FILES['image']['name'])) {
		$stmt->bindParam(':imageLocation', $wanted_location, PDO::PARAM_STR);
	} else if (isset($imageName) && empty($_FILES['image']['name'])) {
		$imageName = 'uploads/' . $imageName;
		$stmt->bindParam(':imageLocation', $imageName, PDO::PARAM_STR);
	} else {
		/* If picture does not exist */
		$n = null;
		$stmt->bindParam(':imageLocation', $n, PDO::PARAM_STR);
		// Function bindParam wants a reference (variable) for 2nd parameter.
	}
	
	/* Executing SQL query */
	$stmt->execute();
	$postId = $handler->lastInsertId();
	
	// TAGS
	for ($x = 0; $x < sizeof($_POST['tagIds']); $x++) {
		// tarkistetaan onko tagi jo kannassa
		$query = $handler->prepare('SELECT * FROM tag WHERE tagName = :tagName;');
		$tagName = e($_POST['tagNames'][$x]);
		$query->bindParam(':tagName', $tagName, PDO::PARAM_INT);
		$query->execute();
		
		if ($query->rowCount() == 0) {
			$tag = e($_POST['tagNames'][$x]);
	
			$sql = 'INSERT INTO tag (tagName) VALUES (:tag)';
			
			$stmt = $handler->prepare($sql);
			$stmt->bindParam(':tag', $tag, PDO::PARAM_STR);
			$stmt->execute();
			
			$tagId = $handler->lastInsertId();
			
			$sql = 'INSERT INTO posttag (postId, tagId) VALUES (:postId, :tag)';
			
			$stmt = $handler->prepare($sql);
				
			$tag = e($tagId);
			
			$stmt->bindParam(':postId', $postId, PDO::PARAM_STR);
			$stmt->bindParam(':tag', $tag, PDO::PARAM_STR);
			
			$stmt->execute();
		} else {
			$sql = 'INSERT INTO posttag (postId, tagId) VALUES (:postId, :tag)';
			$stmt = $handler->prepare($sql);
			
			$tag = e($_POST['tagIds'][$x]);
			
			$stmt->bindParam(':postId', $postId, PDO::PARAM_STR);
			$stmt->bindParam(':tag', $tag, PDO::PARAM_STR);
			
			$stmt->execute();
		}
	}
	
	/* Redirecting to main page*/
	header('Location: index.php');
} else {
	
	/* Redirecting back to add_post with PART OF inserted values */
	/* Currently PART OF means: author, title, content*/
	
	$_SESSION['fields'] = $fields;
	$_SESSION['errors'] = $errors;
	header('Location: add_post.php');
}

?>