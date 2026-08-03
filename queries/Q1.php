<?php
require_once("../database.php");


/* CREATE */
if (isset($_POST["create"])) {

    $type = $_POST["type"];
    $name = $_POST["name"];
    $address = $_POST["address"];
    $city = $_POST["city"];
    $province = $_POST["province"];
    $postalCode = $_POST["postalCode"];
    $webAddress = $_POST["webAddress"];
    $maxCapacity = $_POST["maxCapacity"];


    $sql = "
    INSERT INTO Locations
    (type, name, address, city, province, postalCode, webAddress, maxCapacity)
    VALUES
    ('$type','$name','$address','$city','$province','$postalCode','$webAddress','$maxCapacity')
    ";

    try {
        $conn->query($sql);
        $message = "Location created successfully.";
    }
    catch (mysqli_sql_exception $e) {
        $message = "Database error: " . $e->getMessage();
    }
    catch (Exception $e) {
        $message = "Error: " . $e->getMessage();
    }
}


/* DELETE */
if (isset($_POST["delete"])) {

    $id = $_POST["id"];

    $sql = "
    DELETE FROM Locations
    WHERE id=$id
    ";

    try {
        $conn->query($sql);
        $message = "Location deleted successfully.";
    }
    catch (mysqli_sql_exception $e) {
        $message = "Database error: " . $e->getMessage();
    }
    catch (Exception $e) {
        $message = "Error: " . $e->getMessage();
    }
}


/* UPDATE */
if (isset($_POST["update"])) {

    $id = $_POST["id"];

    $type = $_POST["type"];
    $name = $_POST["name"];
    $address = $_POST["address"];
    $city = $_POST["city"];
    $province = $_POST["province"];
    $postalCode = $_POST["postalCode"];
    $webAddress = $_POST["webAddress"];
    $maxCapacity = $_POST["maxCapacity"];


    $sql = "
    UPDATE Locations SET
        type='$type',
        name='$name',
        address='$address',
        city='$city',
        province='$province',
        postalCode='$postalCode',
        webAddress='$webAddress',
        maxCapacity='$maxCapacity'
    WHERE id=$id
    ";

    try {
        $conn->query($sql);
        $message = "Location updated successfully.";
    }
    catch (mysqli_sql_exception $e) {
        $message = "Database error: " . $e->getMessage();
    }
    catch (Exception $e) {
        $message = "Error: " . $e->getMessage();
    }
}

?>


<!DOCTYPE html>
<html>

<head>
    <title>Manage Locations</title>
</head>


<body>

<a href="../index.php">Home</a>

<h2>Create Location</h2>


<form method="post">

Type:
<select name="type">
    <option value="Head">Head</option>
    <option value="Branch">Branch</option>
</select>

<br>

Name:
<input type="text" name="name">

<br>

Address:
<input type="text" name="address">

<br>

City:
<input type="text" name="city">

<br>

Province:
<select name="province">
    <option>AB</option>
    <option>BC</option>
    <option>MB</option>
    <option>NB</option>
    <option>NL</option>
    <option>NS</option>
    <option>NT</option>
    <option>NU</option>
    <option>ON</option>
    <option>PE</option>
    <option>QC</option>
    <option>SK</option>
    <option>YT</option>
</select>

<br>

Postal Code:
<input type="text" name="postalCode">

<br>

Website:
<input type="text" name="webAddress">

<br>

Maximum Capacity:
<input type="number" name="maxCapacity">

<br><br>

<button name="create">
Create Location
</button>

</form>


<h2>Locations</h2>


<?php

$result = $conn->query("SELECT * FROM Locations");


echo "<table border='1'>";

echo "
<tr>
<th>ID</th>
<th>Type</th>
<th>Name</th>
<th>Address</th>
<th>City</th>
<th>Province</th>
<th>Postal Code</th>
<th>Website</th>
<th>Capacity</th>
<th>Actions</th>
</tr>
";


while($row = $result->fetch_assoc()) {


echo "<tr>";

echo "
<form method='post'>
";


echo "<td>".$row["id"]."</td>";


echo "
<td>
<select name='type'>
<option ".($row["type"]=="Head"?"selected":"").">Head</option>
<option ".($row["type"]=="Branch"?"selected":"").">Branch</option>
</select>
</td>
";


echo "
<td>
<input name='name' value='".$row["name"]."'>
</td>
";


echo "
<td>
<input name='address' value='".$row["address"]."'>
</td>
";


echo "
<td>
<input name='city' value='".$row["city"]."'>
</td>
";


echo "
<td>
<input name='province' value='".$row["province"]."'>
</td>
";


echo "
<td>
<input name='postalCode' value='".$row["postalCode"]."'>
</td>
";


echo "
<td>
<input name='webAddress' value='".$row["webAddress"]."'>
</td>
";


echo "
<td>
<input name='maxCapacity' value='".$row["maxCapacity"]."'>
</td>
";


echo "
<td>

<input type='hidden' name='id' value='".$row["id"]."'>

<button name='update'>
Save
</button>

<button name='delete'
onclick=\"return confirm('Delete this location?');\">
Delete
</button>

</td>
";


echo "</form>";

echo "</tr>";

}


echo "</table>";

?>


</body>
</html>

<?php
if (!empty($message)) {
    echo "<p><strong>$message</strong></p>";
}
?>
