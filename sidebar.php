<?php
include_once('helpers.php');
include_once('database.php');
?>

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
	
	<!-- Search -->
	<!--        -->
	<!-- Myös: tulostaa etsimiseen liittyvät virheet -->
	<div class="panel">
		<!-- Tulostetaan virheet -->
		<?php if(!empty($searchErrors)) :?>
		<div class="error">
			<div class="error-title">
				<i class="fa fa-exclamation-triangle"></i>Huomioi nämä
			</div>
			<ul><li> <?php echo implode('</li><li>', $searchErrors); ?> </li></ul>
		</div>
		<?php endif; ?>
		<!-- Etsintäkenttä -->
		<div class="panel-equal-container">
			<form class="clearfix" action="index.php" method="get">
				<input class="search-input" type="text" name="search" placeholder="Search">
				<button class="button search-button" type="submit"><i class="fa fa-search"></i></button>
			</form>
		</div>
	</div>
	
	<!-- Most commented -->
	<?php $query = $handler->query("SELECT post.postId, title, postDatetime, imageLocation, COUNT(*) AS postCommentCount FROM postcomment INNER JOIN post ON post.postId = postcomment.postid GROUP BY postId ORDER BY postCommentCount DESC, postDatetime DESC LIMIT 5;") ?>
	<div class="panel">
		<div class="panel-header">
			<h2>Most commented</h2>
		</div>
		<?php while($r = $query->fetch(PDO::FETCH_OBJ)) :?>
			<div class="post-top clearfix">
				<a href="post.php?postId=<?php echo $r->postId; ?>">
					<img src="<?php echo $r->imageLocation; ?>" alt="top-post">
				</a>
				<div class="post-top-info">
				<a class="post-title" href="post.php?postId=<?php echo $r->postId; ?>"><?php echo $r->title; ?></a>
					<div class="post-meta">
						<i class="fa fa-calendar"></i>
						<?php echo formatDateShort($r->postDatetime) . ' / ';?>
						<i class="fa fa-comments"></i>
						<?php echo $r->postCommentCount; ?>
					</div>
				</div>
			</div>
		<?php endwhile; ?>
	</div>
	
	<?php	$query = $handler->query('SELECT * FROM tag;'); ?>
	<div class="panel">
		<div class="panel-header">
			<h2>Tags</h2>
		</div>
		<?php while($r = $query->fetch(PDO::FETCH_OBJ)) : ?>
		<a href="index.php?tagId=<?php echo $r->tagId; ?>" class="tag"><?php echo $r->tagName; ?></a>
		<?php endwhile; ?>
	</div>
</aside>