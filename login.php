<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
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
    <?php
$id = $_GET[id];
$name = $_GET["name"];
echo "<p> Enter Your Review Below for"." ".$name." "."</p>";
echo "<fieldset>";
echo "<form  method='post' action='VHREVIEW.php'>";
echo "<textarea  rows='4' cols='50' type='text' name='rev' value='rev'></textarea><br>"; 
echo "<input type='submit' name='submit' value='Submit Review'/>";
echo "<input type='hidden' name='name' value='$name' />";
echo "<input type='hidden' name='id' value='$id'/>";
echo "</form>";
echo "</fieldset>";
?>
        </table>
        <footer>
        </footer>
</body>

</html>