<!DOCTYPE html>
<html>
	<head>
		<title>Profile site</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/styles.css"/>
	</head>
<?php 
try {
	$handler = new PDO('mysql:host=127.0.0.1;dbname=blogi', 'root', '');
	$handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
	echo $e->getMessage();
	die();
}

$query = $handler->query('SELECT * FROM post ORDER BY postDatetime DESC;');

?>
	<body>
		<div class="wrapper">
			<header>
				<h1>Erik's Blogi</h1>
				<a href="add_post.php">Add post</a>
				<div id="flag"></div>
			</header>
			
			<?php while($r = $query->fetch(PDO::FETCH_OBJ)) : ?>
			<div class="post">
				<div class="post-image">
					<img src="img/korea-field.jpg" alt="Default picture">
				</div>
				<div class="post-container">
					<h2><?php echo $r->title; ?></h2>
					<div class="post-info"><?php echo $r->postDatetime . " / " . $r->author; ?></div>
					<p><?php echo nl2br($r->content); ?></p>
				</div>
			</div><!-- post -->
			<?php endwhile; ?>
		</div>
	</body>

</html>