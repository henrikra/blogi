<!doctype html>
<html>
	<head>
		<title>Add a new blog post</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" href= "css/styles.css">
	</head>

	<body>
		<div class="wrapper">
		
			<h1>Add a new blog post</h1>
		
			<form action="submit.php" method="post">
			
				<div class="form-row">
					<label class="form-label" for="author">Author</label><!--
					--><input class="form-input" type="text" id="author">
				</div>
								
				<div class="form-row">
					<label class="form-label" for="title">Title</label><!--
					--><input class="form-input" type="text" id="title">
				</div>
				
				<div class="form-row">
					<label class="form-label" for="content">Content</label><!--
					--><textarea class="form-input" rows="13" cols="70" id="content"></textarea>
				</div>
				
				<div class="form-row">
					<label class="form-label" for="tags">Tags</label><!--
					--><select class="form-input" id="tags">
						<option value="ruoka">Ruoka</option>
						<option value="kulttuuri">Kulttuuri</option>
						<option value="ohjelmointi">Ohjelmointi</option>
					</select>
				</div>
				
				<div class="form-row">
					<label class="form-label"></label><!--
					--><input type="submit" value="Submit">
				</div>
				
			</form>
			
		</div>
	</body>
	
</html>


