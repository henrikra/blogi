<!DOCTYPE html>
<html>
	<head>
		<title>Profile site</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="css/styles.css"/>
	</head>
<?php 
include_once('database.php');
include_once('helpers.php');

?>
	<body class="preload">
		<?php include_once('header.php'); ?>
		<div class="wrapper clearfix">
			<div class="main-content">
			
				<?php
				if(isset($_GET['tagId'])) {
					$query = $handler->prepare('SELECT * FROM tag WHERE tagId = :tagId;');
					$tagId = (int)$_GET['tagId'];
					$query->bindParam(':tagId', $tagId, PDO::PARAM_INT);
					$query->execute();
					$r = $query->fetch(PDO::FETCH_OBJ);
				} else if (isset($_GET['search'])){
					$search = e($_GET['search']);
				}
				?>
				
				<?php if (isset($_GET['tagId']) || isset($_GET['search'])) : ?>
				<div class="panel">
					<div class="search-result-container">
						Näytetään postaukset, joissa on <?php echo isset($_GET['tagId']) ? 'tagi' : 'merkkijono';?>
						<span class="search-item"><?php echo isset($_GET['tagId']) ? $r->tagName : $search; ?></span>
						<a href="index.php">Näytä kaikki</a>
					</div>
				</div>
				<?php endif; ?>
				
				<?php
				if(isset($_GET['tagId'])) {
					$query = $handler->prepare('SELECT * FROM post INNER JOIN posttag ON post.postId = posttag.postId WHERE posttag.tagId = :tagId ORDER BY postDatetime DESC;');
					$query->bindParam(':tagId', $tagId, PDO::PARAM_INT);
					$query->execute();
				} else if(isset($_GET['search'])) {
					$query = $handler->prepare('SELECT * FROM post WHERE content LIKE :search ORDER BY postDatetime DESC;');
					$search = '%' . $search . '%';
					$query->bindParam(':search', $search, PDO::PARAM_STR);
					$query->execute();
				} else {
					$query = $handler->query('SELECT * FROM post ORDER BY postDatetime DESC;');
				}

				?>
				<?php while($r = $query->fetch(PDO::FETCH_OBJ)) : ?>
				<div class="post panel">
					<?php if(!empty($r->imageLocation)) :?><!-- If-lauseen short hand syntax -->
					<a href="post.php?postId=<?php echo $r->postId;?>"> 
						<div class="post-image">
							<img class="vertical-center" src="<?php echo $r->imageLocation;?>" alt="Post picture"> 
						</div>
					</a>
					<?php endif; ?>
					<div class="panel-container">
						<div class="post-title">
							<a href="post.php?postId=<?php echo $r->postId;?>">
								<h2><?php echo $r->title; ?></h2>
							</a>
						</div>
						
						<!-- Print post's metainfo -->
						<div class="post-meta">
							<?php printMetaInfo($r); ?>
						</div>
						<hr>
						
						<!-- Printing post content (exerpt version) -->
						<?php echo getExcerpt(createParagraphs($r->content), 0, 400); ?>
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