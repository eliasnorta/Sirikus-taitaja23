<!-- yhdistää tietonakntaan -->
<?php
$servername   = "localhost";
$database = "sirkus";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
}
// echo "<div style='color:grey;'>Connected successfully</div>";
