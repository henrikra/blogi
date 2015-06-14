<?php include_once('helpers.php'); ?>
<header>
	<div class="header-background">
		<a href="index.php">
			<h1 class="vertical-center">Korea Blog</h1>
		</a>
	</div>
	<nav>
		<div class="wrapper">
			<input type="checkbox" id="show-menu" role="button">
			<label for="show-menu" class="show-menu">
				<span class="show-menu-content"><i class="fa fa-bars"></i> Menu</span>
			</label>
			<ul class="nav-content clearfix">
				<li class="site-logo">
					<a class="vertical-center" href="index.php">
						Korea Blog
					</a>
				</li>
				<div class="menu-actions clearfix">
					<li class="menu-item <?php echo basename($_SERVER['SCRIPT_NAME']) == 'index.php' ? 'active' : ''; ?>">
						<a class="vertical-center" href="index.php">Home</a>
					</li>
					<?php if (isAuthenticated()) : ?>
					<li class="menu-item <?php echo basename($_SERVER['SCRIPT_NAME']) == 'add_post.php' ? 'active' : ''; ?>">
						<a class="vertical-center" href="add_post.php">Add post</a>
					</li>
					<?php endif; ?>
					<li class="menu-item"><a class="vertical-center" href="">About me</a></li>
					<?php if (!isAuthenticated()) : ?>
					<li class="menu-item <?php echo basename($_SERVER['SCRIPT_NAME']) == 'login.php' ? 'active' : ''; ?>">
						<a class="vertical-center" href="login.php">Login</a>
					</li>
					<?php else : ?>
					<li class="menu-item">
						<a class="vertical-center" href="logout.php">Logout</a>
					</li>
					<?php endif; ?>
				</div>
			</ul>
		</div>
	</nav>
</header>