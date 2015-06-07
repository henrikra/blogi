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
	
	
	$sql = "SELECT * FROM post WHERE postId = :postId";
	$stmt = $handler->prepare($sql);
	
	$postId = isset($_GET['postId']) ? (int)$_GET['postId'] : 1;
	
	$stmt->bindParam(':postId', $postId, PDO::PARAM_INT);
	$stmt->execute();
	$post = $stmt->fetch(PDO::FETCH_OBJ);
	?>
	
	<body class="preload">
		<?php include_once('header.php'); ?>
		<div class="wrapper clearfix">
			<div class="main-content">
				<div class="single-post panel">
					<div class="panel-container">
						<h2><?php echo $post->title; ?></h2>
						<div class="post-meta">
							<i class="fa fa-calendar"></i>
								<?php echo date('D j.n.Y \- H:i', strtotime($post->postDatetime)) . ' / ';?>
								<i class="fa fa-user"></i> <?php echo $post->author; ?>
								<?php getTags($postId);	?>
						</div>
						<?php if(!empty($post->imageLocation)) : ?>
							<?php $picture = $post->imageLocation;?>
							<a href="<?php echo $picture; ?>">
								<img class="responsive-image" src="<?php echo $picture;?>">
							</a>
						<?php else : ?>
							<hr>
						<?php endif; ?>
						<p><?php echo nl2br($post->content); ?></p>
					</div><!-- panel container -->
				</div><!-- post -->
				
				<div id="comments" class="panel">
					<div class="panel-container">
						<h2>Comments</h2>
						<?php
						$commentLevel = 0;
						
						$sql = "SELECT commentId, commentAuthor, commentDatetime, commentContent, commentReply FROM postcomment WHERE postId = :postId ORDER BY commentDatetime DESC;";
						$stmt = $handler->prepare($sql);
						
						$stmt->bindParam(':postId', $postId, PDO::PARAM_INT);
						$stmt->execute();
						
						$counter = 0;
						while($r = $stmt->fetch(PDO::FETCH_OBJ)) :
							// Käydään läpi vain kommentit, joilla ei ole vanhempia
							if($r->commentReply == null) {
								getComments($r);
								$commentLevel = 0;
							}
							$counter++;
						endwhile;
						echo $counter < 1 ? 'Be first to comment this post!' : ''; ?>
					</div>
				</div><!-- comments -->
				
				<div id="add-comment" class="panel">
					<div class="panel-container">
						<h2>Add Comment</h2>
						<form action="submit_comment.php" method="post">
							<input type='hidden' name="commentReply" value="">
							<input type="hidden" value="<?php echo $postId; ?>" name="postId">
							<div class="form-row">
								<label for="comment-author">Name</label>
								<input type="text" id="comment-author" name="commentAuthor">
							</div>
							<div class="form-row">
								<label for="comment-content">Comment</label>
								<textarea id="comment-content" rows="5" name="commentContent"></textarea>
							</div>
							<input type="submit" value="Post" class="button">
						</form>
					</div>
				</div><!-- Add comment -->
			
			</div><!-- main-content -->
			<?php include_once('sidebar.php'); ?>
		</div><!-- wrapper -->
		<?php include_once('footer.php'); ?>
	</body>

</html>