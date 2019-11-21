
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
	session_start();
	if($_SESSION['bool'] == true)
	{
		$username = $_SESSION['username'];
		echo 'Hello ' . $username;
	}
	if($_SESSION['bool'] == null || $_SESSION['bool'] == false)
	{
		$_SESSION['bool'] = false;
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

		//print $value;
		$stmt = $db->prepare("INSERT INTO Users(Id,Username,Password) VALUES(?,?,?)");
		$stmt->bind_param("iss",$id,$username,$password);
		if($stmt->execute())
		{
			$stmt->close();
			$db->close();
			echo "New records created successfully";
		}
		else
		{
			$stmt->close();
			$db->close();
			echo "New records Failed to Create";
			header("Location:./index.html");
		}		
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
		$_SESSION['username'] = $usernameLogin;
		if($stmt->execute() && $usernameLogin != "" && $_SESSION['bool'] == false)
		{
			//$stmt->bind_result(colm_name, colm_name2,...for hole table);
			$stmt->bind_result($pas);
			$stmt->fetch();
			if($passwordLogin == $pas)
			{
				$_SESSION['bool'] = true;
				echo "log in successfully";
			}
			else
			{
				$stmt->close();
				$db->close();
				echo "Failed to log in";
				$_SESSION['bool'] = false;
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
			$_SESSION['bool'] = false;
			header("Location:./index.html");
		}
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
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script type="text/javascript" src="js/Y8jX7FH_5H.js"></script>
<script type="text/javascript" src="js/ACjAVc6v8f.js"></script>
<script type="text/javascript" src="js/i3mwM7qHVR.js"></script>
<script type="text/javascript" src="js/Rbr_xellDA.js"></script>



</body></html>
</body>
</html>
