<?php
session_start();
$errors = [];
$username = $password = $userError = $passError = '';

if(isset($_POST['sub'])){
  $username = $_POST['username'];
	$password = $_POST['password'];
  if($username === 'admin' && $password === 'irving'){
    $_SESSION['login'] = true;
		header('Location: index.php');
		die();
  }
  if($username !== 'admin' || $password !== 'password') $errors[] = 'Username and password don\'t match';
}
?>
<!DOCTYPE html>
<html>
	<?php 
	$title = 'Korea Blog - Login';
	require_once('head.php');
	?>
	<body class="preload">
		<?php include_once('header.php'); ?>
		<div class="wrapper clearfix">
			<div class="main-content">
				<div class="panel">
					<div class="panel-header">
						<h2>Login</h2>
					</div>
					<div class="panel-equal-container">
						<?php if(!empty($errors)) :?>
						<div class="error">
							<div class="error-title">
								<i class="fa fa-exclamation-triangle"></i> Huomioi nämä
							</div>
							<ul><li> <?php echo implode('</li><li>', $errors);?> </li></ul>
						</div>
						<?php endif; ?>
						<form name="input" action="login.php" method="post">
							<div class="form-row">
								<label for="username">Username</label>
								<input type="text" value="<?php echo $username; ?>" id="username" name="username">
							</div>
							<div class="form-row">
								<label for="password">Password</label>
								<input type="password" value="<?php echo $password; ?>" id="password" name="password">
							</div>
							<input class="button" type="submit" value="Login" name="sub">
						</form>
					</div>
				</div>
			</div><!-- main-content -->
			<?php include_once('sidebar.php'); ?>
		</div><!-- wrapper -->
		<?php include_once('footer.php'); ?>
	</body>
</html>