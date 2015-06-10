<?php
session_start();
$username = $password = $userError = $passError = '';

if(isset($_POST['sub'])){
  $username = $_POST['username'];
	$password = $_POST['password'];
  if($username === 'admin' && $password === 'irving'){
    $_SESSION['login'] = true;
		header('Location: index.php');
		die();
  }
  if($username !== 'admin') $userError = 'Invalid Username';
  if($password !== 'password') $passError = 'Invalid Password';
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Login</title>
	</head>
	<body>
		<h1>Please login</h1>
		<form name="input" action="login.php" method="post">
			<label for="username"></label>
			<input type="text" value="<?php echo $username; ?>" id="username" name="username">
			<div class="error">
				<?php echo $userError; ?>
			</div>
			<label for="password"></label>
			<input type="password" value="<?php echo $password; ?>" id="password" name="password">
			<div class="error">
				<?php echo $passError; ?>
			</div>
			<input type="submit" value="Home" name="sub">
		</form>
	</body>
</html>