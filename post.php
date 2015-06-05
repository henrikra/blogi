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
	
	
	$sql = "SELECT * FROM post WHERE postId = :postId";
	$stmt = $handler->prepare($sql);
	
	$postId = isset($_GET['postId']) ? (int)$_GET['postId'] : 1;
	
	$stmt->bindParam(':postId', $postId, PDO::PARAM_INT);
	$stmt->execute();
	$post = $stmt->fetch(PDO::FETCH_OBJ);
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
				<div class="single-post panel">
					<div class="panel-container">
						<h2><?php echo $post->title; ?></h2>
						<div class="post-meta">
							<i class="fa fa-calendar"></i>
								<?php echo date('D j.n.Y \- H:i', strtotime($post->postDatetime)) . ' / ';?>
								<i class="fa fa-user"></i> <?php echo $post->author; ?>
								<?php 
								$sql = "SELECT tag.tagName FROM tag INNER JOIN posttag ON tag.tagId = posttag.tagId WHERE posttag.postID = :postId;";
								$stmt = $handler->prepare($sql);
								
								$stmt->bindParam(':postId', $postId, PDO::PARAM_INT);
								$stmt->execute();
								
								$tags = ' / <i class="fa fa-tags"></i> ';
								$counter = 0;
								while($post2 = $stmt->fetch(PDO::FETCH_OBJ)) :
									$tags .= $post2->tagName . ', ';
									$counter++;
								endwhile;
								if ($counter > 0) {
									echo substr($tags, 0, -2);
								}
								?>
						</div>
						<?php $picture = !empty($post->imageLocation) ? $post->imageLocation : 'uploads/korea-field.jpg';?>
						<a href="<?php echo $picture; ?>">
							<img class="responsive-image" src="<?php echo $picture;?>">
						</a>
						<p><?php echo nl2br($post->content); ?></p>
					</div>
				</div><!-- post -->
			</div><!-- main-content -->
			<?php include_once('sidebar.php'); ?>
		</div><!-- wrapper -->
	</body>

</html>