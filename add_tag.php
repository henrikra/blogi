<!doctype html>
<html>

	<head>
		<meta charset="UTF-8">
		<title>Add a new tag</title>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="css/styles.css">
	</head>
	
	<?php
	
		include_once('database.php');
		include_once('authentication.php');
		include_once('helpers.php');
		
		/* Authentication */
		if($isAuthenticated != 1)
			die('You must be Erik Rantanen to do that!');	
	?>
	
	<body class="preload">
		<?php include_once('header.php'); ?>
		<div class="wrapper clearfix">
			<div class="main-content panel">
				<div class="panel-container">
					<h1>Add a new tag</h1>
					
					<!-- form that sends tag-info -->
					<form action="submit-tag.php" method="post">
						
						<div class="form-row">
							<label class="col-2" for="tag">Tag name</label>
							<div class="col-8">
								<input type="text" id="tag" name="tag">
							</div>
						</div>
						
						<div class="form-row">
							<label class="col-2"></label>
							<div class="col-8">
								<button class="button" type="submit" value="Submit">Submit</button>
							</div>
						</div>
						
					</form>
					
				</div><!-- panel-container -->
			</div><!-- main-content -->
			<?php include_once('sidebar.php'); ?>
		</div><!-- Wrapper -->
		<?php include_once('footer.php'); ?>
	</body>
	
</html>