
<html lang="en"><head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Movie Info</title>
<!-- Bootstrap core CSS -->
<link href="https://invicdn.worldcdn.net/836428152/http/95.215.224.43/smarthostug.com/movieInfo/css/A.bootstrap.min.css.pagespeed.cf.Ys2PnL9McW.css" rel="stylesheet">
<style>#movies img,#movie img{width:100%}@media (min-width:960px){#movies .col-md-3 .well{height:390px}#movies .col-md-3 img{height:240px}}</style>
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

	$querry = "check username and login things";
	$result = mysqli_query($db,$query);

	//check if the username is correct if not go back to index.html 



?>
<nav class="navbar navbar-default">
<div class="container">
<div class="navbar-header">
<a class="navbar-brand" href="index.html">MovieInfo</a>
</div>
</div>
</nav>
<div class="container">
<div class="jumbotron">
<h3 class="text-center">Search For Any Movie</h3>
<form id="searchForm">
<input type="text" class="form-control" id="searchText" placeholder="Search Movie....">
</form>
</div>
</div>
<div class="container">
<div id="movies" class="row"></div>
</div>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="https://invicdn.worldcdn.net/836428152/http/95.215.224.43/smarthostug.com/movieInfo/js/jquery-3.2.1.min.js.pagespeed.jm.Y8jX7FH_5H.js"></script>
<script src="https://invicdn.worldcdn.net/836428152/http/95.215.224.43/smarthostug.com/movieInfo/js/bootstrap.min.js.pagespeed.jm.ACjAVc6v8f.js"></script>
<script src="https://invicdn.worldcdn.net/836428152/http/95.215.224.43/smarthostug.com/movieInfo/js/axios.min.js.pagespeed.jm.i3mwM7qHVR.js"></script>
<script type="text/javascript" src="https://invicdn.worldcdn.net/836428152/http/95.215.224.43/smarthostug.com/movieInfo/js/main.js.pagespeed.ce.Rbr_xellDA.js"></script>


</body></html>
</body>
</html>
