<header>
	<nav>
		<div class="wrapper">
			<ul class="nav-content clearfix">
				<li class="site-logo">
					<a class="vertical-center" href="index.php">Main logo</a>
				</li>
				<li class="menu-item"><a class="vertical-center" href="">About me</a></li>
				<li class="menu-item <?php echo basename($_SERVER['SCRIPT_NAME']) == 'add_post.php' ? 'active' : ''; ?>">
					<a class="vertical-center" href="add_post.php">Add post</a>
				</li>
				<li class="menu-item <?php echo basename($_SERVER['SCRIPT_NAME']) == 'index.php' ? 'active' : ''; ?>">
					<a class="vertical-center" href="index.php">Home</a>
				</li>
			</ul>
		</div>
	</nav>
	<div class="header-background">
		<h1 class="vertical-center">Korea Blog</h1>
	</div>
</header>