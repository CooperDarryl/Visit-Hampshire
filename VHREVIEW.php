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
      <?php
         $id = $_POST["id"];
         $rev = $_POST["rev"];
         $name = $_POST["name"];
         $user = "visithampshire";
         $pass = "vh123";
         
         $connection = curl_init();
         curl_setopt($connection, CURLOPT_URL, "http://edward2.solent.ac.uk/~dcooper/POI/ADDREVIEW.php");
         $dataToPost = array
         ("id" => "$id", "rev" => "$rev");
         curl_setopt($connection,CURLOPT_USERPWD,"$user:$pass");
         curl_setopt($connection,CURLOPT_RETURNTRANSFER,1);
         curl_setopt($connection, CURLOPT_POSTFIELDS, $dataToPost);
         $response = curl_exec($connection);
         $httpCode = curl_getinfo($connection, CURLINFO_HTTP_CODE);
         
         IF ($httpCode == 200)
         {
            echo "<h2>Thank you, your review for"." ".$name." "."has been added to the database. </h2>";
            echo "<a href='VISITH.php'>Home</a>"; 
         }
         ELSE IF ($httpCode == 449)
         {
            echo "<h3>Either the POI doesn't exist or you haven't entered a review. Try again.</h3>";
            echo "<a href='VISITH.php'>Home</a>"; 
         }
         ELSE IF ($httpCode == 400)
         {
            echo "<h3>Bad request, the ID of the POI hasn't been set!</h3>";
            echo "<a href='VISITH.php'>Home</a>";
         }
         ?>
      </table>
      <footer>
      </footer>
   </body>
</html>