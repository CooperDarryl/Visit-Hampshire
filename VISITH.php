<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<title>VisitHampshire</title>
</head>
<body>
<header>
<img src="map.png" alt="VH"></br>
</header>
<br />
<div>
<p>Welcome To VisitHampshire</p>
</div>
<div id="search">
	<fieldset>
		<legend>VisitHampshire Search</legend>
		<p>Select the point of interest type</p>
			<form class="log" method="get" action="VISITH.php">
				<label for="type">Type</label>
				<select id="type" name="type">
					<option value="any">All</option>
					<option value="city">City</option>
					<option value="hill">Hill</option>
					<option value="industrial estate">Industrial Estate</option>
					<option value="moor">Moor</option>
					<option value="pub">Pub</option>
					<option value="restaurant">Restaurant</option>
					<option value="touristsite">Tourist site</option>
					<option value="town">Town</option>
					<option value="mountain">Mountain</option>
				</select>
				<input type="submit" value="Search" />
			</form>
	</fieldset>
</div>
<?php
$type = urlencode($_GET["type"]); 

IF (isset($type) && $type !=="")

{
$connection = curl_init();
	curl_setopt($connection, CURLOPT_URL, "http://edward2.solent.ac.uk/~dcooper/POI/POI_LOOKUP.php?region=hampshire&type=$type");
	curl_setopt($connection,CURLOPT_RETURNTRANSFER,1);
$response = curl_exec($connection);
$httpCode = curl_getinfo($connection, CURLINFO_HTTP_CODE);
	curl_close($connection);

IF ($httpCode == 204) 
{
	echo "<h3>Sorry, nothing found</h3>";
}


	ELSE IF ($httpCode == 200)
	{
	echo "<p>Results</p><table><tr><th>Name</th><th>Type</th><th>Country</th><th>Region</th><th>Lon</th><th>Lat</th><th>Description</th><th></th>";
		$data = json_decode($response, true);
	for ($i=0; $i<count($data); $i++)

		{
			echo 
	   
			"</tr>".
				"<td>".$data[$i]["name"]."</td>".
				"<td>".$data[$i]["type"]."</td>".
				"<td>".$data[$i]["country"]."</td>".
				"<td>".$data[$i]["region"]." ".$data[$i]["month"]." ".$data[$i]["year"] ."</td>".
				"<td>".$data[$i]["lon"]."</td>".
				"<td>".$data[$i]["lat"]."</td>".
				"<td>".$data[$i]["description"]."</td>".
			"<td><a href='login.php?id=".$data[$i]['ID']."&name=".$data[$i]['name']."'> Add Review </a></td>".
			"</tr>";
		
		}
	}
}
?>
</table>
<footer>

</footer>
</body>
</html>