<!-- db-starter.php
     A PHP script to demonstrate database programming.
-->
<html>
<head>
    <title> Likes </title>
    <style type = "text/css">
    td, th, table {border: thin solid black;}
    </style>
	<h1>Likes<h1>
</head>
<body>

<?php
    
	// Get input data
    $id = $_POST["movieID"];
	$title = $_POST["movieTL"];
	$genre = $_POST["movieGN"];
	$releaseDate = $_POST["movieRD"];
	$voteAverage = $_POST["movieVA"];
	$runTime = $_POST["movieRT"];
	$productionCompany = $_POST["moviePC"];
   
    
    // If any of numerical values are blank, set them to zero
    if ($id == "") $id = 0;
	if($title == "") $title = "null";
	if($genre == "") $genre = "null";
	if($releaseDate == "") $releaseDate = "null";
	if($voteAverage == "") $voteAverage = "null";
	if($runTime == "") $runTime = "null";
	if($productionCompany == "") $productionCompany = "null";

	//login to db 
	$db = mysqli_connect("server_url",username,pasword);
	if (!$db) {
		print "Error - Could not connect to MySQL";
		exit;
	}
	//pic a database to use
	$er = mysqli_select_db($db,"name_of_db");
	if (!$er) {
		print "Error - Could not select the database";
		exit;
	}

	$querry = "if thing does not exsists insert movie, also insert to likes no matter what(unless already liked)";
	$result = mysqli_query($db,$query);




?>
</body>
</html>
