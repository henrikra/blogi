<div class="pagination">
	<!-- Print pagenumbers with links-->
	<div class="panel-equal-container">
		<?php
		
		// Page count
		$pageCount = ceil($totalPosts / $perPage);

		// Url addition that corresponds to search
		$urlAddition = '';
		
		/* Search all */
		// No urlAddition.
		
		/* Search with tag */
		if(isset($_GET['tagId']))
			$urlAddition = '&amp;tagId=' . $tagId;
		
		/* Search with string */
		if(isset($_GET['search']))
			$urlAddition = '&amp;search=' . $search;
		?>
		
		<?php if ($page > 1) : ?>
		<a href="index.php?page=<?php echo ($page - 1) . $urlAddition;?>">
			<i class="fa fa-chevron-left pagination-arrow"></i>
		</a>
		<?php endif; ?>
		<?php for($i = 1; $i <= $pageCount; $i++) : ?>
		<a href="index.php?page=<?php echo $i . $urlAddition;?>"
		<?php echo $i === $page ? 'class="current-page disabled-link"' : ''; ?>>
			<?php echo $i; ?>
		</a>
		<?php endfor; ?>
		<?php if ($page < $pageCount) : ?>
		<a href="index.php?page=<?php echo ($page + 1) . $urlAddition;?>">
			<i class="fa fa-chevron-right pagination-arrow"></i>
		</a>
		<?php endif; ?>
	</div>
	
</div>