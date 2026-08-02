<?php
require_once("../database.php");
?>

<!DOCTYPE html>

<html>

<head>
    <title>Query #1</title>
</head>

<body>

<a href="../index.php">Home</a>

<h2>Query #1</h2>

<?php

$sql = "
SELECT *
FROM Locations
";

$result = $conn->query($sql);

echo "<table border='1'>";

while($row = $result->fetch_assoc()){

    echo "<tr>";

    echo "<td>".$row["name"]."</td>";

    echo "<td>".$row["city"]."</td>";

    echo "</tr>";

}

echo "</table>";

?>

</body>

</html>
