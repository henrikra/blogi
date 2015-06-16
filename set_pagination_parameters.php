<?php

//
$perPage = 5;

// User input
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Start showing pages position
$startingPost = $page * $perPage - $perPage;



?>