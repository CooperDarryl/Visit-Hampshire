<?php
header("Content-type: application/json");

/*Get map boundries*/

$north = $_GET["north"];
$south = $_GET["south"];
$east =	$_GET["east"];
$west = $_GET["west"];

/*Connect to database*/

$conn = new PDO ("mysql:host=localhost;dbname=dcooper;","dcooper","ree0OoCh");

$fnorth = floatval($north);
$fsouth = floatval($south);
$feast = floatval($east);
$fwest = floatval($west);







IF ($north !== "" && $south !== "" && $east !== "" && $west !== "" )
		{
					$statement = $conn->prepare("SELECT * FROM pointsofinterest WHERE lat >= ? AND lat <= ? AND lon >= ? AND lon <= ?;");
					$statement->bindparam(1, $fsouth);
					$statement->bindparam(2, $fnorth);
					$statement->bindparam(3, $fwest);
					$statement->bindparam(4, $feast);
					


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
					while($row !== false) 
						{
							$allResults[] = $row;
							$row = $statement->fetch(PDO::FETCH_ASSOC);
						}
							echo json_encode($allResults);
					}
		}

?>

