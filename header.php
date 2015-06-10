<?php include_once('authentication.php'); ?>

<header>
	<div class="header-background">
		<h1 class="vertical-center">Korea Blog</h1>
	</div>
	<nav>
		<div class="wrapper">
			<ul class="nav-content clearfix">
				<li class="site-logo">
					<a class="vertical-center" href="index.php">
						Korea Blog
					</a>
				</li>
				<li class="menu-item"><a class="vertical-center" href="">About me</a></li>
				<?php if ($isAuthenticated == 1) : ?>
				<li class="menu-item <?php echo basename($_SERVER['SCRIPT_NAME']) == 'add_tag.php' ? 'active' : ''; ?>">
					<a class="vertical-center" href="add_tag.php">Add tag</a>
				</li>
				<li class="menu-item <?php echo basename($_SERVER['SCRIPT_NAME']) == 'add_post.php' ? 'active' : ''; ?>">
					<a class="vertical-center" href="add_post.php">Add post</a>
				</li>
				<?php endif; ?>
				<li class="menu-item <?php echo basename($_SERVER['SCRIPT_NAME']) == 'index.php' ? 'active' : ''; ?>">
					<a class="vertical-center" href="index.php">Home</a>
				</li>
			</ul>
		</div>
	</nav>
</header>