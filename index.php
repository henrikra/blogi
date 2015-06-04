<!DOCTYPE html>
<html>
	<head>
		<title>Profile site</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/styles.css"/>
	</head>
<?php 
include_once('database.php');

$query = $handler->query('SELECT * FROM post ORDER BY postDatetime DESC;');

?>
	<body>
		<div class="wrapper">
			<header>
				<h1>Erik's Blogi</h1>
				<a href="add_post.php">Add post</a>
				<div id="flag"></div>
			</header>
			
			<div class="main-content">
				<?php while($r = $query->fetch(PDO::FETCH_OBJ)) : ?>
				<div class="post panel">
					<div class="post-image">
						<img src="img/korea-field.jpg" alt="Default picture">
					</div>
					<div class="panel-container">
						<h2><?php echo $r->title; ?></h2>
						<div class="post-info"><?php echo date('D j.n.Y \- H:i', strtotime($r->postDatetime)) . " / " . $r->author; ?></div>
						<p><?php echo nl2br($r->content); ?></p>
					</div>
				</div><!-- post -->
				<?php endwhile; ?>
			</div><!-- main-content -->
			<aside>
				<div class="bio panel">
					<div class="bio-background">
						<img src="img/bio-background.jpg" alt="Bio background">
					</div>
					<div class="bio-face-image">
						<img src="http://s14.postimg.org/jtmz3pd1d/index.jpg" alt="Erik Rantanen">
					</div>
					<div class="panel-container">
						<h2>Erik Rantanen</h2>
						<div class="bio-description">
							Programmer, son, chili head, revolvist...
						</div>
					</div><!-- panel-container -->
				</div>
			</aside>
			<div class="clearfix"></div>
		</div><!-- wrapper -->
	</body>

</html>