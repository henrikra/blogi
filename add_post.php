<!doctype html>
<html>
	<head>
		<title>Add a new blog post</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
		<link href='http://fonts.googleapis.com/css?family=Dosis|Open+Sans' rel='stylesheet' type='text/css'>
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
								<i class="fa fa-exclamation-triangle"></i> Please note
							</div>
							<?php printErrorList($errors);?>
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
								<div class="button-group">
									<input id="tag-input" class="datalist-input" list="tags" name="tag" autocomplete="off"
									placeholder="Search for tags...">
									<input id="selected-tag-id" type="hidden">
									<input id="selected-tag-name" type="hidden">
									<button id="add-tag-button" class="button" type="button">Add</button>
								</div>
								<datalist id="tags">
								<?php
									$query = $handler->query('SELECT * FROM tag');
									while($r = $query->fetch(PDO::FETCH_OBJ)) : ?>
									<option id="<?php echo $r->tagId; ?>" value="<?php echo $r->tagName; ?>">
										<?php echo $r->tagName; ?>
									</option>
									<?php endwhile; ?>
								</datalist>
							</div>
						</div>
						
						<div class="form-row">
							<label class="col-2"></label>
							<div class="col-8">
								<div id="selected-tags">
								<?php
								$query = $handler->query('SELECT * FROM tag');
								while($r = $query->fetch(PDO::FETCH_OBJ)) : ?>
								<?php
								if (!empty($fields['tags'])) {
									foreach($fields['tags'] as $value){
										if($r->tagId == $value){
											echo '<div class="selected-tag">' . $r->tagName . ' <i class="fa fa-times unselect-tag"></i></div>';
											echo '<input class="selected-tag-hidden" type="hidden" name="tagIds[]" value="' . $value . '">';
											echo '<input class="selected-tag-hidden-name" type="hidden" name="tagNames[]" value="' . $r->tagName . '">';
											break;
										}
									}
								}
								?>
								<?php endwhile; ?>
								
								<?php
								if (!empty($fields['tagNames'])) {
									foreach($fields['tagNames'] as $value){
										echo '<div class="selected-tag">' . $value . ' <i class="fa fa-times unselect-tag"></i></div>';
										echo '<input class="selected-tag-hidden" type="hidden" name="tagIds[]" value="">';
										echo '<input class="selected-tag-hidden-name" type="hidden" name="tagNames[]" value="' . $value . '">';
									}
								}
								?>
								</div>
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


