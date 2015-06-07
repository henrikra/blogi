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