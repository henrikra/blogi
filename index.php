<!DOCTYPE html>
<html>
	<head>
		<title>Profile site</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="css/styles.css"/>
	</head>
<?php 
session_start();
include_once('database.php');
include_once('helpers.php');
?>

<?php
// Pagination
include_once('set_pagination_parameters.php');
?>

	<body class="preload">
		<?php include_once('header.php'); ?>
		<div class="wrapper clearfix">
			<div class="main-content">
			
				<?php
				// luodaan tyhjä array mahdollisille hakuvirheille. 
				// huom. ei voida käyttää errors[]-taulukkoa, koska se on jo käytössä muualla
				$searchErrors = []; 
				$searchLength = -1; // Alustettu arvo
				// Onko hyvä paikka näille?
				if(isset($_GET['tagId'])) {
					$query = $handler->prepare('SELECT SQL_CALC_FOUND_ROWS * FROM tag WHERE tagId = :tagId;');
					$tagId = (int)$_GET['tagId'];
					$query->bindParam(':tagId', $tagId, PDO::PARAM_INT);
					$query->execute();
					$r = $query->fetch(PDO::FETCH_OBJ);
				} else if (isset($_GET['search'])){
					$search = e($_GET['search']);
					$searchLength = strlen($search);
				}
				?>
				
				<?php
				/*** Suoritetaan haluttu haku ***/
				/* vaihtoehto 1: haetaan tagilla*/
				if(isset($_GET['tagId'])) {
					$searchType = "tag";
					$query = $handler->prepare('SELECT SQL_CALC_FOUND_ROWS * FROM post INNER JOIN posttag ON post.postId = posttag.postId WHERE posttag.tagId = :tagId ORDER BY postDatetime DESC LIMIT :startingPost, 5;');
					$query->bindParam(':tagId', $tagId, PDO::PARAM_INT);
					$query->bindParam(':startingPost', $startingPost, PDO::PARAM_INT);
					$query->execute();
					
				/* vaihtoehto 2: haetaan hakusanalla */
				} else if(isset($_GET['search']) && $searchLength >= 3) {
					$searchType = "string";
					$query = $handler->prepare('SELECT SQL_CALC_FOUND_ROWS * FROM post WHERE content LIKE :search ORDER BY postDatetime DESC LIMIT :startingPost, 5;');
					$searchPattern = '%' . $search . '%';
					$query->bindParam(':search', $searchPattern, PDO::PARAM_STR);
					$query->bindParam(':startingPost', $startingPost, PDO::PARAM_INT);
					$query->execute();
				} else {
					
				/* vaihtoehto 3: haetaan kaikki */
					$searchType = "all";
					$query = $handler->query("SELECT SQL_CALC_FOUND_ROWS * FROM post ORDER BY postDatetime DESC LIMIT {$startingPost}, 5;");
					$query->execute();
					

					
					/* Tarkistetaan oliko pituuden vuoksi hylättyä hakusanaa */
					if ($searchLength >= 0 && $searchLength <= 2) {
						$searchErrors[] = 'Minimum length for search term is 3 characters.';
					}
				}
				// Total posts
				$totalPosts = $handler->query("SELECT FOUND_ROWS() AS total")->fetch()['total'];
				?>
				
				<!-- Näytetään mahdolliset hakuehdot -->
				<?php if (isset($_GET['tagId']) || (isset($_GET['search'])) && $searchLength >= 3) : ?>
				<div class="panel">
					<div class="search-result-container">
						<?php
						/* Calculating if there is any rows returned from DB */
						$rowCount = $query->rowCount();
						
						if(isset($_GET['tagId'])) {
							printTagSearchInfo($_GET['tagId']);
						} else {
							printStringSearchInfo($_GET['search'], $rowCount);
						}
						?>
						<a href="index.php">Show all</a>
					</div>
				</div>
				<?php endif; ?>
				
				<!-- Print posts -->
				<?php while($r = $query->fetch(PDO::FETCH_OBJ)) : ?>
				<div class="post panel">
					<?php if(!empty($r->imageLocation)) :?><!-- If-lauseen short hand syntax -->
					<a href="post.php?postId=<?php echo $r->postId;?>"> 
						<div class="post-image">
							<img class="vertical-center" src="<?php echo $r->imageLocation;?>" alt="Post picture"> 
						</div>
					</a>
					<?php endif; ?>
					<div class="panel-container">
						<div class="post-title">
							<a href="post.php?postId=<?php echo $r->postId;?>">
								<h2><?php echo $r->title; ?></h2>
							</a>
						</div>
						
						<!-- Print post's metainfo -->
						<div class="post-meta">
							<?php printMetaInfo($r); ?>
						</div>
						<hr>
						
						<!-- Printing post content (exerpt version) -->
						<?php echo getExcerpt(createParagraphs($r->content), 0, 400); ?>
						<a class="post-more" href="post.php?postId=<?php echo $r->postId;?>">
							Read more
						</a>
					</div>
				</div><!-- post -->
				<?php endwhile; ?>
				<?php include_once('page_panel.php') ?>
			</div><!-- main-content -->
			<?php include_once('sidebar.php'); ?>
		</div><!-- wrapper -->
		<?php include_once('footer.php'); ?>
	</body>

</html>