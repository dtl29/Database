
<html lang="en"><head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Movie Info</title>
<!-- Bootstrap core CSS -->
<link rel="stylesheet" type="text/css" href="Ys2PnL9McW.css">
<style>#movies img,#movie img{width:100%}@media (min-width:960px){#movies .col-md-3 .well{height:390px}#movies .col-md-3 img{height:240px}}</style>
</head>
<body>

<?php
	$submitType = $_POST["submit"];
	$username = $_POST["username"];
	$password = $_POST["password"];
	$usernameLogin = $_POST["usernameLogin"];
	$passwordLogin = $_POST["passwordLogin"];
	$usernameDelete = $_POST["usernameDelete"];
	$passwordDelete = $_POST["passwordDelete"];
	$usernameLogin2 = $_COOKIE['usernameLogin'];
	$loginBool = $_COOKIE['loginBool'];
	$loginBoolName = "loginBool";
	$true = "true";
	$false = "false";
	$usernameLoginName = "usernameLogin";

	if($loginBool == "true")
	{
		echo 'Hello ' . $usernameLogin2;
	}
	else if($loginBool == "" || $loginBool == "false")
	{
		setcookie($loginBoolName, $false, time() + (86400 * 30), "/");
	}
	if($submitType == "Sign Up")
	{
		//login to db 
		$db = new mysqli("db1.cs.uakron.edu:3306", "dtl29", "Pah8quei", "ISP_dtl29");		
		if ($db->connect_error) {
			print "Error - Could not connect to MySQL";
			exit;
		}

		$query = "SELECT MAX(Id) FROM Users";
		$result = $db->query($query);
		$row = $result->fetch_row();
		$id = (int)$row[0] +1;
		if($username == "")
		{
			header("Location:./index.html");

		}
		//print $value;
		$stmt = $db->prepare("INSERT INTO Users(Id,Username,Password) VALUES(?,?,?)");
		$stmt->bind_param("iss",$id,$username,$password);
		if($stmt->execute())
		{
			$stmt->close();
			echo "New records created successfully";
		}
		else
		{
			$stmt->close();
			echo "New records Failed to Create";
			header("Location:./index.html");
		}

		$_usernameSql = mysqli_real_escape_string($db, $username);
		$query2 = 'CREATE TABLE Liked'.$_usernameSql.' (titles VARCHAR(500) PRIMARY KEY )';
		$db->query($query2);
		echo $db->error;
		$db->close();
	}
	if($submitType == "Login")
	{
		$db = new mysqli("db1.cs.uakron.edu:3306", "dtl29", "Pah8quei", "ISP_dtl29");		
		if ($db->connect_error) {
			print "Error - Could not connect to MySQL";
			exit;
		}
		$stmt = $db->prepare("SELECT Password FROM Users WHERE Username = ?");
		$stmt->bind_param("s",$usernameLogin);
		setcookie($usernameLoginName, $usernameLogin, time()+ (86400 * 30), "/");
		if($stmt->execute() && $usernameLogin != "" && $loginBool == "false")
		{
			//$stmt->bind_result(colm_name, colm_name2,...for hole table);
			$stmt->bind_result($pas);
			$stmt->fetch();
			if($passwordLogin == $pas)
			{
				setcookie($loginBoolName, $true, time()+ (86400 * 30), "/");
				echo "log in successfully";
			}
			else
			{
				$stmt->close();
				$db->close();
				echo "Failed to log in";
				setcookie($loginBoolName, $false, time()+ (86400 * 30), "/");
				header("Location:./index.html");
			}
			$stmt->close();
			$db->close();
		}
		else
		{
			$stmt->close();
			$db->close();
			echo "Failed to log in";
			setcookie($loginBoolName, $false, time()+ (86400 * 30), "/");
			header("Location:./index.html");
		}
		$db->close();
	}
	if($submitType == "Delete User")
	{
		$db = new mysqli("db1.cs.uakron.edu:3306", "dtl29", "Pah8quei", "ISP_dtl29");		
		if ($db->connect_error) {
			print "Error - Could not connect to MySQL";
			exit;
		}
		echo'stage 1<br>';
		$stmt = $db->prepare("SELECT Password FROM Users WHERE Username = ?");
		$stmt->bind_param("s",$usernameDelete);
		if($stmt->execute() && $usernameDelete!= "")
		{
			//$stmt->bind_result(colm_name, colm_name2,...for hole table);
			$stmt->bind_result($pas);
			$stmt->fetch();
			if($passwordDelete == $pas)
			{
				$stmt->close();
				$stmt = $db->prepare("DELETE FROM Users WHERE Username = ? ");
				$stmt->bind_param("s",$usernameDelete);
				if($stmt->execute() && $usernameDelete != "")
				{
					$stmt->close();
					$db->close();
					header("Location:./index.html");
				}
				else
				{
					$stmt->close();
					$db->close();
					echo "did not delete";
					header("Location:./index.html");
				}
			}
			else
			{
				$stmt->close();
				$db->close();
				echo "did not delete 2";
				header("Location:./index.html");
			}
		}
		else
		{
			$stmt->close();
			$db->close();
			echo "did not delete3";
			header("Location:./index.html");
		}
		$db->close();
	}
    if ($submitType == "Add Info") 
	{
		$movie = $_POST["FavoriteMovie"];
		$actor = $_POST["FavoriteActor"];
		$director = $_POST["FavoriteDirector"];
		$composer = $_POST["FavoriteComposer"];
		$genre = $_POST["FavoriteGenre"];
                $title = "title";
		
		$db = new mysqli("db1.cs.uakron.edu:3306", "dtl29", "Pah8quei", "ISP_dtl29");		
		if ($db->connect_error) 
		{
			print "Error - Could not connect to MySQL";
			exit;
		}

		$stmt = $db->prepare("SELECT Title FROM Movies WHERE Title = ?");
		$stmt->bind_param("s", $movie);
		if($stmt->execute() && $movie != "")
		{
			$stmt->bind_result($ti);
			$stmt->fetch();
                        if ($ti != "")
			{
				echo "<br />Already have movie in database. Added as your favorite movie";
			}
			$stmt->close();	
		}
		else
		{
			$stmt->close();
		}

		if ($ti == "") 
		{
			$stmt = $db->prepare("INSERT INTO Movies(Title)VALUES(?)");
			$stmt->bind_param("s", $movie);
			if($stmt->execute() && $movie != "")
			{
				echo "<br />New movie added! Added as your favorite movie";
				$stmt->close();	
			}
			else
			{
				$stmt->close();
			}
		}

		$stmt = $db->prepare("SELECT Name FROM Actors WHERE Name = ?");
		$stmt->bind_param("s", $actor);
		if($stmt->execute() && $actor != "")
		{
			$stmt->bind_result($na);
			$stmt->fetch();
                        if ($na != "")
			{
				echo "<br />Already have actor in database. Added as your favorite actor";
			}
			$stmt->close();	
		}
		else
		{
			$stmt->close();
		}

		if ($na == "") 
		{
			$stmt = $db->prepare("INSERT INTO Actors(Name, Title)VALUES(?,?)");
			$stmt->bind_param("ss", $actor, $title);
			if($stmt->execute() && $actor != "")
			{
				echo "<br />New actor added! Added as your favorite actor";
				$stmt->close();	
			}
			else
			{
				$stmt->close();
			}
		}

		$stmt = $db->prepare("SELECT Name FROM Directors WHERE Name = ?");
		$stmt->bind_param("s", $director);
		if($stmt->execute() && $director!= "")
		{
			$stmt->bind_result($np);
			$stmt->fetch();
                        if ($np != "")
			{
				echo "<br />Already have director in database. Added as your favorite director";
			}
			$stmt->close();	
		}
		else
		{
			$stmt->close();
		}

		if ($np == "") 
		{
			$stmt = $db->prepare("INSERT INTO Directors(Name, Title)VALUES(?,?)");
			$stmt->bind_param("ss", $director, $title);
			if($stmt->execute() && $director!= "")
			{
				echo "<br />New director added! Added as your favorite director";
				$stmt->close();	
			}
			else
			{
				$stmt->close();
			}
		}

		$stmt = $db->prepare("SELECT Name FROM Composers WHERE Name = ?");
		$stmt->bind_param("s", $composer);
		if($stmt->execute() && $composer!= "")
		{
			$stmt->bind_result($nc);
			$stmt->fetch();
                        if ($nc != "")
			{
				echo "<br />Already have composer in database. Added as your favorite composer";
			}
			$stmt->close();	
		}
		else
		{
			$stmt->close();
		}

		if ($nc == "") 
		{
			$stmt = $db->prepare("INSERT INTO Composers(Name, Title)VALUES(?,?)");
			$stmt->bind_param("ss", $composer, $title);
			if($stmt->execute() && $composer!= "")
			{
				echo "<br />New composer added! Added as your favorite composer";
				$stmt->close();	
			}
			else
			{
				$stmt->close();
			}
		}

		$stmt = $db->prepare("SELECT Genre FROM Genres WHERE Genre = ?");
		$stmt->bind_param("s", $genre);
		if($stmt->execute() && $genre!= "")
		{
			$stmt->bind_result($gr);
			$stmt->fetch();
                        if ($gr != "")
			{
				echo "<br />Already have genre in database. Added as your favorite genre";
			}
			$stmt->close();	
		}
		else
		{
			$stmt->close();
		}

		if ($gr == "") 
		{
			$stmt = $db->prepare("INSERT INTO Genres(Title, Genre)VALUES(?,?)");
			$stmt->bind_param("ss", $genre, $genre);
			if($stmt->execute() && $genre!= "")
			{
				echo "<br />New genre added! Added as your favorite genre";
				$stmt->close();	
			}
			else
			{
				$stmt->close();
			}
		}

		$theusername = mysqli_real_escape_string($db, $usernameLogin2);
		//echo $theusername;

		$sql = 'CREATE TABLE Favorites'.$theusername.'(
			Movie VARCHAR(500) PRIMARY KEY,
            Actor VARCHAR(50),
			Director VARCHAR(50),
			Composer VARCHAR(50),
			Genre VARCHAR(20)
		)';
		$db->query($sql);

		$stmt = $db->prepare('INSERT INTO Favorites'.$theusername.'(Movie, Actor, Director, Composer, Genre) VALUES(?, ?, ?, ?, ?)');
		$stmt->bind_param("sssss",$movie, $actor, $director, $composer, $genre);
		if($stmt->execute() && $movie != "")
		{
			echo 'Added to Favorites';
			$stmt->close();
		}
		else
		{
			echo'Did Not Add to Favorites';
			$stmt->close();
		}

		$db->close();
	}

	
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
<div id="sugestions">
	Some Suggestions For You Are: 
	<?php 
		$searchtitle = $_POST["movieTL"];
		$searchgenre = $_POST["movieGN"];
		$searchdirector = $_POST["director"];
		$searchactorArray = $_POST["actors"];

		//need to have a query for suggestions 
		$db = new mysqli("db1.cs.uakron.edu:3306", "dtl29", "Pah8quei", "ISP_dtl29");		
		if ($db->connect_error) 
		{
			print "Error - Could not connect to MySQL";
			exit;
		}
		$_username = mysqli_real_escape_string($db, $usernameLogin2);
		$stmt = $db->prepare('SELECT DISTINCT titles FROM (SELECT * FROM Liked'.$_username.' JOIN (SELECT *  FROM Movies JOIN (SELECT Genre FROM Genres)AS G)AS J ON Liked'.$_username.'.titles = J.Title )AS K JOIN (SELECT *  FROM Movies JOIN (SELECT Genre FROM Genres)AS G) AS O ON K.Title != O.Title GROUP BY K.NumberOfLikes ORDER BY COUNT(*) ASC;');
		$stmt->bind_param();
		if($stmt->execute())
		{
			$stmt->bind_result($);
			$stmt->fetch();
                        if ($return != "")
			{
				echo $return;
			}
			$stmt->close();	
		}
		else
		{
			echo "did not find any sugestions";
			$stmt->close();
		}
		?><br/>
</div>
<form action="index.php" method="post">
    <div style="float : left; margin-left : 20%;">
        <p>Favorite Movie</p>
        <input type="text" name="FavoriteMovie" /><br /><br />
    </div>
    <div style="float : left; margin-left : 20%;">
        <p>Favorite Actor</p>
        <input type="text" name="FavoriteActor" /><br /><br />
    </div>
    <div style="float : left; margin-left : 20%;">
        <p>Favorite Director</p>
        <input type="text" name="FavoriteDirector" /><br /><br />
    </div>
    <div style="float : left; margin-left : 30%;">
        <p>Favorite Composer</p>
        <input type="text" name="FavoriteComposer" /><br /><br />
    </div>
    <div style="float : left; margin-left : 20%;">
        <p>Favorite Genre</p>
        <input type="text" name="FavoriteGenre" /><br /><br />
        <input type="submit" name="submit" value="Add Info" />
    </div>
</form>



<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script type="text/javascript" src="js/Y8jX7FH_5H.js"></script>
<script type="text/javascript" src="js/ACjAVc6v8f.js"></script>
<script type="text/javascript" src="js/i3mwM7qHVR.js"></script>
<script type="text/javascript" src="js/Rbr_xellDA.js"></script>



</body></html>
</body>
</html>
