<!doctype html>
<html>
	<head>
		<title>Add a new blog post</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" href= "css/styles.css">
	</head>
	
	<?php include_once('database.php'); ?>

	<body>
		<?php include_once('header.php'); ?>
		<div class="wrapper clearfix">
			<div class="main-content panel">
				<div class="panel-container">
					<h1>Add a new blog post</h1>
				
					<form action="submit.php" method="post" enctype="multipart/form-data">
					
						<div class="form-row">
							<label class="col-2" for="author">Author</label>
							<div class="col-8">
								<input type="text" id="author" name="author">
							</div>
						</div>
										
						<div class="form-row">
							<label class="col-2" for="title">Title</label>
							<div class="col-8">
								<input type="text" id="title" name="title">
							</div>
						</div>
						
						<div class="form-row">
							<label class="col-2" for="content">Content</label>
							<div class="col-8">
								<textarea rows="13" id="content" name="content"></textarea>
							</div>
						</div>
						
						<div class="form-row">
							<label class="col-2" for="file">Picture</label>
							<div class="col-8">
								<input type="file" id="file" name="image">
							</div>
						</div>
						
						<div class="form-row">
							<label class="col-2">Tags</label>
							<div class="col-8">						
								<?php
									$query = $handler->query('SELECT * FROM tag');
									while($r = $query->fetch(PDO::FETCH_OBJ)) : ?>
									<label>
										<input class="cb" type="checkbox" name="tags[]" value="<?php echo $r->tagId; ?>"> <?php echo $r->tagName;?>
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
	</body>
	
</html>


