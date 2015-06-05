<!DOCTYPE html>
<html>
	<head>
		<title>Profile site</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/styles.css"/>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	</head>
<?php 
include_once('database.php');

$query = $handler->query('SELECT * FROM post ORDER BY postDatetime DESC;');

?>
	<body>
		<div class="wrapper clearfix">
			<header>
				<h1>Erik's Blogi</h1>
				<a href="add_post.php">Add post</a>
				<div id="flag"></div>
			</header>
			
			<div id="nav">
				<li><a href="#">Etusivu</a></li>
				<li><a href="#">Ruoka</a></li>
				<li><a href="#">Kulttuuri</a></li>
				<li><a href="#">Ohjelmointi</a></li>
				<li><a href="#">Luo artikkeli</a></li>
			</div>
			<div class="main-content">
				<?php while($r = $query->fetch(PDO::FETCH_OBJ)) : ?>
				<div class="post panel">
					<div class="post-image">
						<img class="vertical-center"
						src="<?php echo (!empty($r->imageLocation) ? $r->imageLocation : 'uploads/korea-field.jpg');?>"> <!-- If-lauseen short hand syntax -->
					</div>
					<div class="panel-container">
						<h2><?php echo $r->title; ?></h2>
						<div class="post-meta">
							<i class="fa fa-calendar"></i>
								<?php echo date('D j.n.Y \- H:i', strtotime($r->postDatetime)) . ' / ';?>
								<i class="fa fa-user"></i> <?php echo $r->author; ?>
								<?php
								$sql = "SELECT tag.tagName FROM tag INNER JOIN posttag ON tag.tagId = posttag.tagId WHERE posttag.postID = :postId;";
								$stmt = $handler->prepare($sql);
								
								$postId = $r->postId;
								$stmt->bindParam(':postId', $postId, PDO::PARAM_INT);
								$stmt->execute();
								
								$tags = ' / <i class="fa fa-tags"></i> ';
								$counter = 0;
								while($r2 = $stmt->fetch(PDO::FETCH_OBJ)) :
									$tags .= $r2->tagName . ', ';
									$counter++;
								endwhile;
								if ($counter > 0) {
									echo substr($tags, 0, -2);
								}
								?>
						</div>
						<hr>
						<p><?php echo nl2br($r->content); ?></p>
					</div>
				</div><!-- post -->
				<?php endwhile; ?>
			</div><!-- main-content -->
			<aside>
				<div class="bio panel">
					<div class="bio-background">
						<img class="vertical-center" src="img/bio-background.jpg" alt="Bio background">
					</div>
					<div class="bio-face-image">
						<img class="vertical-center" src="img/Erik.jpg" alt="Erik Rantanen">
					</div>
					<div class="panel-container">
						<h2>Erik Rantanen</h2>
						<div class="bio-description">
							Programmer, son, chili head, revolvist...
						</div>
					</div><!-- panel-container -->
				</div>
			</aside>
		</div><!-- wrapper -->
	</body>

</html>