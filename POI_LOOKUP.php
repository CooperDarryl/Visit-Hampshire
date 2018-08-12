<?php
header("Content-type: application/json");
/*Get the parameters from the client and set variables for each*/

$type = $_GET["type"];
$region = $_GET["region"];

/*Connect to database*/

$conn = new PDO ("mysql:host=localhost;dbname=dcooper;","dcooper","ree0OoCh");

IF (strlen($region) >=200)
		{
		header("HTTP/1.1 449 Retry With");
		}

ELSE IF ($type == "any" && $region == "") /* Search DB for all types of POI for all regions*/
		{
					$statement = $conn->prepare("SELECT * FROM pointsofinterest;");
					$statement->execute();
					$row = $statement->fetch();
				IF ($row == false)
					{	
						header("HTTP/1.1 204 No Content");
					}
				ELSE
					{
					header("HTTP/1.1 200 OK");
					$allResults = array();
					while($row != false) 
						{
							$allResults[] = $row;
							$row = $statement->fetch(PDO::FETCH_ASSOC);
						}
							echo json_encode($allResults);
					}
		}
ELSE IF ($type == 'any' && isset($region)) /*Search DB for all types of POI in given region*/
		{
			
			$statement = $conn->prepare("SELECT * FROM pointsofinterest WHERE region = ?;");
			$statement->bindparam(1, $region);
			$statement->execute();
			$row = $statement->fetch();
			
			if ($row == false)
			{	
				header("HTTP/1.1 204 No Content");
			}
			else
			{
				header("HTTP/1.1 200 OK");
				$allResults = array();
				while($row != false) 
				{
					$allResults[] = $row;
					$row = $statement->fetch(PDO::FETCH_ASSOC);
				}
				echo json_encode($allResults);
			}
		}
ELSE IF ( $region=="" && isset($type)) /*Search DB for all POIs with given type in all regions*/
		{
				
			$statement = $conn->prepare("SELECT * FROM pointsofinterest WHERE type = ?;"); 
			$statement->bindparam(1, $type);
			$statement->execute();
			$row = $statement->fetch();
		
			if ($row == false)
			{
				header("HTTP/1.1 204 No Content");
			}
			else
			{
				header("HTTP/1.1 200 OK");
				$allResults = array();
				while($row != false)					
				{
					$allResults[] = $row;
					$row = $statement->fetch(PDO::FETCH_ASSOC);
				}
				echo json_encode($allResults);
			}		
		}
ELSE IF (isset($type, $region)) /*Search POIs matching both given type and region*/
		{
			
			$statement = $conn->prepare("SELECT * FROM pointsofinterest WHERE type = ? AND region = ?;");
			$statement->bindparam(1, $type);
			$statement->bindparam(2, $region);
			$statement->execute();
			$row = $statement->fetch();
			
			if ($row == false)
			{
				header("HTTP/1.1 204 No Content");
			}
			else
			{
				header("HTTP/1.1 200 OK");
				$allResults = array();
				while($row != false) 
				{
					$allResults[] = $row;
					$row = $statement->fetch(PDO::FETCH_ASSOC);
				}
				echo json_encode($allResults);
			}	
		}
?>