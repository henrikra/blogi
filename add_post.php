<!doctype html>
<html>
	<head>
		<title>Add a new blog post</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
		<link rel="stylesheet" href= "css/styles.css">
	</head>
	
	<?php
		session_start();
		include_once('helpers.php');
		include_once('database.php');
		
		if (!isAuthenticated())
			header('Location: login.php');
				
		$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
		$fields = isset($_SESSION['fields']) ? $_SESSION['fields'] : [];
	?>

	<body class="preload">
		<?php include_once('header.php'); ?>
		<div class="wrapper clearfix">
			<div class="main-content panel">
				<div class="panel-container">
					<h1>Add a new blog post</h1>
					<?php if(!empty($errors)) :?>
						<div class="error">
							<div class="error-title">
								<i class="fa fa-exclamation-triangle"></i> Huomioi nämä
							</div>
							<ul><li> <?php echo implode('</li><li>', $errors);?> </li></ul>
						</div>
					<?php endif; ?>
					<form action="submit.php" method="post" enctype="multipart/form-data">
					
						<div class="form-row">
							<label class="col-2" for="author">Author</label>
							<div class="col-8">
								<input type="text" id="author" name="author"
								<?php echo !empty($fields['author']) ? 'value="' . $fields['author'] . '"' : '';?>>
							</div>
						</div>
										
						<div class="form-row">
							<label class="col-2" for="title">Title</label>
							<div class="col-8">
								<input type="text" id="title" name="title"
								<?php echo !empty($fields['title']) ? 'value="' . $fields['title'] . '"' : '';?>>
							</div>
						</div>
						
						<div class="form-row">
							<label class="col-2" for="content">Content</label>
							<div class="col-8">
								<textarea rows="13" id="content" name="content"><?php echo !empty($fields['content']) ? $fields['content'] : '';?></textarea>
							</div>
						</div>
						
						<div class="form-row">
							<label class="col-2" for="file"><?php echo !empty($fields['imageName']) ? 'Change picture' : 'Picture'; ?></label>
							<div class="col-8">
								<input type="file" id="file" name="image">
								<input type="hidden" name="imageNameHidden" value="<?php echo !empty($fields['imageName']) ? $fields['imageName'] : ''; ?>">
								
							</div>
						</div>
						<?php if (!empty($fields['imageName'])) : ?>
						<div class="form-row">
							<label class="col-2">Current picture</label>
							<div class="col-8">
									<img class="thumbnail" src="uploads/<?php echo $fields['imageName']; ?>" alt="image-thumbnail">
							</div>
						</div>
						<?php endif; ?>
						
						<div class="form-row">
							<label class="col-2">Tags</label>
							<div class="col-8">						
								<?php
									$query = $handler->query('SELECT * FROM tag');
									while($r = $query->fetch(PDO::FETCH_OBJ)) : ?>
									<label>
										<input class="cb" type="checkbox" name="tags[]" value="<?php echo $r->tagId; ?>"
										<?php
										if (!empty($fields['tags'])) {
											foreach($fields['tags'] as $value){
												if($r->tagId == $value){
													echo 'checked';
													break;
												}
											}
										}
										?>> <?php echo $r->tagName;?>
										
									</label> 
									<?php endwhile; ?>
							</div>
						</div>
						
						<div class="form-row">
							<label class="col-2"></label>
							<div class="col-8">
								<input class="button" type="submit" value="Submit">
							</div>
						</div>	
					</form>
				</div><!-- panel-container -->
			</div> <!-- main content -->
			<?php include_once('sidebar.php'); ?>
		</div>
		<?php include_once('footer.php'); ?>
	</body>
	
</html>

<?php
unset($_SESSION['fields']);
unset($_SESSION['errors']);
?>


