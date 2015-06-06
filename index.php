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
include_once('helpers.php');

$query = $handler->query('SELECT * FROM post ORDER BY postDatetime DESC;');

?>
	<body class="preload">
		<?php include_once('header.php'); ?>
		<div class="wrapper clearfix">
			<div class="main-content">
				<?php while($r = $query->fetch(PDO::FETCH_OBJ)) : ?>
				<div class="post panel">
					<?php if(!empty($r->imageLocation)) :?><!-- If-lauseen short hand syntax -->
					<a href="post.php?postId=<?php echo $r->postId;?>"> 
						<div class="post-image">
							<img class="vertical-center" src="<?php echo $r->imageLocation;?>"> 
						</div>
					</a>
					<?php endif; ?>
					<div class="panel-container">
						<div class="post-title">
							<a href="post.php?postId=<?php echo $r->postId;?>">
								<h2><?php echo $r->title; ?></h2>
							</a>
						</div>
						<div class="post-meta">
							<i class="fa fa-calendar"></i>
								<?php echo formatDate($r->postDatetime) . ' / ';?>
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
						<p><?php echo getExcerpt(nl2br($r->content), 0, 400); ?></p>
						<a class="post-more" href="post.php?postId=<?php echo $r->postId;?>">
							Read more
						</a>
					</div>
				</div><!-- post -->
				<?php endwhile; ?>
			</div><!-- main-content -->
			<?php include_once('sidebar.php'); ?>
		</div><!-- wrapper -->
		<?php include_once('footer.php'); ?>
	</body>

</html>