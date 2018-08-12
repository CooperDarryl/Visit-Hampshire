<?php
header("Content-type: application/json");
/*Get the parameters from the client and set variables for each*/

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

$id = $_POST["id"];
$rev = $_POST["rev"];

/*Connect to database*/
$conn = new PDO ("mysql:host=localhost;dbname=dcooper;","dcooper","ree0OoCh");

	$statement = $conn->prepare("SELECT * FROM poi_users WHERE username = ? AND password = ?;");
	$statement->bindparam(1, $user);
	$statement->bindparam(2, $pass);
	$statement->execute();
	$row = $statement->fetch();
	
IF ($row == FALSE)
{
	header("HTTP/1.1 401 Unauthorised");
}
ELSE IF (!isset($id) || $id =="")
		{
			header("HTTP/1.1 400 Bad Request");
		}
ELSE
{
	IF (isset($id) && $id !=="")
	{
			$statement = $conn->prepare("SELECT * FROM pointsofinterest WHERE ID = ?;");
			$statement->bindparam(1, $id);
			$statement->execute();
			$row = $statement->fetch();
			
			IF ($row == FALSE)
			{
				header("HTTP/1.1 404 Not Found");
			}	
				ElSE IF (!isset($rev) || $rev =="")
				{
					header("HTTP/1.1 449 Retry With");
				}
					ELSE  
					{
						$statement = $conn->prepare("INSERT INTO poi_reviews (poi_id, review) VALUES (?, ?);");
						$statement->bindparam(1, $id);
						$statement->bindparam(2, $rev);
						$statement->execute();
						header("HTTP/1.1 200 OK");
					}
					
	}
}
?>