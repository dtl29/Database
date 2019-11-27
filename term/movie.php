 <!-- db-starter.php
     A PHP script to demonstrate database programming.
-->
<html>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<head>
    <title> Likes </title>
    <style type = "text/css">
    td, th, table {border: thin solid black;}
    </style>
	<h1>Likes<h1>
</head>
<body>

<?php
    
	if($_COOKIE['loginBool'] == true)
	{
		$username = $_COOKIE['usernameLogin'];
		echo 'Hello ' . $username;
	}
	else
	{
		echo'You are not logged in';
	}
	// Get input data
    $id = $_POST["movieID"];
	$title = $_POST["movieTL"];
	$genre = $_POST["movieGN"];
	$releaseDate = $_POST["movieRD"];
	$voteAverage = $_POST["movieVA"];
	$runTime = $_POST["movieRT"];
	$productionCompany = $_POST["moviePC"];
	$director = $_POST["director"];
	$actorArray = $_POST["actors"];
    
    // If any of numerical values are blank, set them to zero
    if ($id == "") $id = 0;
	if($title == "") $title = "null";
	if($genre == "") $genre = "null";
  	if($releaseDate == "") $releaseDate = "null";
	if($voteAverage == "") $voteAverage = "null";
	if($runTime == "") $runTime = "null";
	if($productionCompany == "") $productionCompany = "null";

	$db = new mysqli("db1.cs.uakron.edu:3306", "dtl29", "Pah8quei", "ISP_dtl29");		
		if ($db->connect_error) 
		{
			print "Error - Could not connect to MySQL";
			exit;
		}
		$stmt = $db->prepare("SELECT Title, NumberOfLikes FROM Movies WHERE Title = ?");
		$stmt->bind_param("s", $title);
		if($stmt->execute() && $title != "")
		{
			$stmt->bind_result($ti,$nu);
			$stmt->fetch();
			$stmt->close();
		}
		echo " the title is: " .  $ti . " and the number of likes are: " . $nu . "!";
		if($ti == "")
		{
			echo " ti was null ";
			$nu = 1;
			$releaseDate = substr($releaseDate,0,-6);
			$ye = (int)$releaseDate;
			$stmt = $db->prepare("INSERT INTO Genres(Title, Genre) VALUES(?,?)");
			$stmt->bind_param("ss",$title,$genre);
			if($stmt->execute() && $title != "")
			{
				$stmt->close();
			}
			else
			{
				$stmt->close();
				
			}
			//add another statement here to add more to tables 
			$stmt = $db->prepare("INSERT INTO Movies(Title, Year, Director, NumberOfLikes)VALUES(?,?,?,?)");
			$stmt->bind_param("sisi", $title, $ye, $director, $nu);
			if($stmt->execute() && $title != "")
			{
				$stmt->close();	
			}
			else
			{
				$stmt->close();
			}
			$stmt = $db->prepare("INSERT INTO Directors(Name,Title)VALUES(?,?)");
			$stmt->bind_param("ss",$director,$title);
			if($stmt->execute() && $title != "")
			{
				$stmt->close();
			}
			else
			{
				$stmt->close();
			}
			for($i=0; $i < sizeof($actorArray); $i++)
			{
				$stmt = $db->prepare("INSERT INTO Actors(Name, Title) VALUES(?,?)");
				$stmt->bind_param("ss",$actorArray[$i], $title);
				if($stmt->execute() && $title != "")
				{
					echo'The actor was placed <br/>';
					$stmt->close();
				
				}
				else
				{
					echo'failed to place actor <br/>';
					$stmt->close();
				}
			}

			$_username = mysqli_real_escape_string($db, $username);
			echo $_username;
			$stmt = $db->prepare('INSERT INTO Liked'.$_username.'(titles) VALUES(?)');
			$stmt->bind_param("s",$title);
			if($stmt->execute() && $title != "")
			{
				echo 'Added to likes just fine';
				$stmt->close();
			}
			else
			{
				echo'Did not add to likes';
				$stmt->close();
			}
		}
		else
		{
			$_username = mysqli_real_escape_string($db, $username);
			echo $_username;
			$stmt = $db->prepare('INSERT INTO Liked'.$_username.'(titles) VALUES(?)');
			$stmt->bind_param("s",$title);
			if($stmt->execute() && $title != "")
			{
				echo '<br />Added to likes just fine';
				$stmt->close();
			}
			else
			{
				echo'<br />Did not add to likes';
				$stmt->close();
			}

			$nu = 1 + (int)$nu;
			echo "ti was NOT null".$nu."!";
			$stmt = $db->prepare("UPDATE Movies SET NumberOfLikes = ? WHERE Title = ?");
			$stmt->bind_param("is",$nu,$ti);
			if($ti != "" && $stmt->execute())
			{
				$stmt->close();
				$db->close();			
			}
			else
			{
				$stmt->close();
				$db->close();
			}
		}
		$db->close();
		header("Location:./index.php");
?>
</body>
</html>
