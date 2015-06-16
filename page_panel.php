<div class="panel">
	<?php
	
	// Page count
	$pageCount = ceil($totalPosts / $perPage);
	?>
	
	<!-- Print pagenumbers with links-->
	<div class="pagination-panel">
		<?php
		// Url addition that corresponds to search
		$urlAddition = '';
		
		/* Search all */
		// No urlAddition.
		
		/* Search with tag */
		if(isset($_GET['tagId']))
			$urlAddition = '&tagId=' . $tagId;
		
		/* Search with string */
		if(isset($_GET['search']))
			$urlAddition = '&search=' . $search;
		?>
		
		<?php for($i = 1; $i <= $pageCount; $i++) : ?>
		<a href="index.php?page=<?php echo $i . $urlAddition;?>" <?php echo $i === $page ? 'class="current-page"' : ''; ?>>
			<?php echo $i . ' '; ?>
		</a>
		<?php endfor; ?>
	</div>
	
</div>