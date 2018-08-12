<?php
header("Content-type: application/json");

/*Get the user and pass parameters from the client and set variables for each*/

if(isset($_POST["user"]) && isset($_POST["pass"]))
{
	$user = $_POST["user"];
	$pass = $_POST["pass"];
}
else
{
	$user = $_SERVER["PHP_AUTH_USER"];
	$pass = $_SERVER["PHP_AUTH_PW"];
}

$name = $_POST["name"];
$type = $_POST["type"];
$country = $_POST["country"];
$region = $_POST["region"];
$lon = $_POST["lon"];
$lat = $_POST["lat"];
$desc = $_POST["desc"];

/*Connect to database*/
$conn = new PDO ("mysql:host=localhost;dbname=dcooper;","dcooper","ree0OoCh");

/*Check user exists*/
	$statement = $conn->prepare("SELECT * FROM poi_users WHERE username = ? AND password = ?;");
	$statement->bindparam(1, $user);
	$statement->bindparam(2, $pass);
	$statement->execute();
	$row = $statement->fetch();
/*Send Header if user does not exist*/	
IF ($row == FALSE)
{
	header("HTTP/1.1 401 Unauthorized");
}
/*Check all variables are set and not blank, if any are send header*/
ELSE IF  (!isset($lon, $lat, $name, $type, $country, $region, $desc) || $lon =="" || $lat =="" || $name =="" || $type =="" || $country =="" || $region =="" || $desc =="")
{
	header("HTTP/1.1 449 Retry With");
}
/*Check the long and lat are valid and if not send header*/
ELSE IF ($lon > 180 || $lon < -180 || $lat > +90 || $lat < -90)
{
	header("HTTP/1.1 406 Not Acceptable");
}
/*Check a record doesnt already exist in the database for the POI*/
ELSE
{
		$statement = $conn->prepare("SELECT * FROM pointsofinterest WHERE type = ? AND region = ? AND lat = ? AND lon = ?;");
		$statement->bindparam(1, $type);
		$statement->bindparam(2, $region);
		$statement->bindparam(3, $lat);
		$statement->bindparam(4, $lon);
		$statement->execute();
		$row = $statement->fetch();
		/*If record exists send header*/
		IF ($row !== FALSE)
		{
			header("HTTP/1.1 409 Conflict");
		}
		/*If no record exists already insert the data in to the database and send header*/
		ELSE IF ($row == FALSE)
		{
		$statement = $conn->prepare("INSERT INTO pointsofinterest (name, type, country, region, lon, lat, description) VALUES (?,?,?,?,?,?,?);");
		$statement->bindparam(1, $name);
		$statement->bindparam(2, $type);
		$statement->bindparam(3, $country);
		$statement->bindparam(4, $region);
		$statement->bindparam(5, $lon);
		$statement->bindparam(6, $lat);
		$statement->bindparam(7, $desc);
		$statement->execute();
			
		header("HTTP/1.1  201 Created");
		}
}

	
?>