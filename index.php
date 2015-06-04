<!DOCTYPE html>
<html>
	<head>
		<title>Profile site</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/styles.css"/>
	</head>
<?php 
try {
	$handler = new PDO('mysql:host=127.0.0.1;dbname=blogi', 'root', '');
	$handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
	echo $e->getMessage();
	die();
}

$query = $handler->query('SELECT * FROM post;');

?>
	<body>
		<div class="wrapper">
			<h1>Erik's Blogi (T. Pekka)</h1>
			<a href="add_post.php">Add post</a>
			<div id="flag"></div>
			
			<div class="post">
				<div class="post-image">
					<img src="img/korea-field.jpg" alt="Default picture">
				</div>
				<div class="post-container">
					<h2>Welcome to Addiction!</h2>
					<div class="post-info">
						Thursday, July 03, 2014 / Pekka Pekkonen
					</div>
					<p>
						Nunc tincidunt, elit non cursus euismod, lacus augue ornare metus, egestas imperdiet nulla nisl quis mauris. Suspendisse a pharetra urna. Morbi dui lectus, pharetra nec elementum eget, vulputate ut nisi. Aliquam accumsan, nulla sed feugiat vehicula, lacus justo semper libero, quis porttitor turpis odio sit amet ligula. Duis dapibus fermentum orci, nec malesuada libero vehicula ut. Integer sodales, urna...
					</p>
					<p>
						Olipa kerran suo, kuokka ja Jussi. Jussi kynsi suota kuokalla.
					</p>
				</div>
			</div><!-- post -->
			
			<div class="template">
				<div class="theme">
					News
				</div>
				<div class ="date">
					< 3.6.2015 > Food Culture
				</div>
				<hr>
				<div class="heading">
				My first day in North-Korea
				</div>
				<div class="content">
					<p>
						"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
					</p>
					<p>
						"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque erik rantanen laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?"
					</p>
					<p>
						"At vero eos et accusamus et iusto odio. Pekka Pekkonen ja Klaus tekivät tämän. Henrik antoi hyviä vinkkejä! dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat."
					</p>
				</div>
				<hr>
			</div>
		</div>
	</body>

</html>