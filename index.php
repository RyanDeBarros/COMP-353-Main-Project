<?php

$host = "wlc353.encs.concordia.ca";
$username = "wlc353_1";
$password = "12345678";
$database = "wlc353_1";
$port = 3306;

$conn = new mysqli($host, $username, $password, $database, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<h1>Welcome to COMP 353 Main Project</h1>
<?php echo "Hello World!" ?>
