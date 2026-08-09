<?php

require_once("../database.php");

$message = "";


/* =========================================================
   ADD LOCATION
   ========================================================= */

if (isset($_POST["create"])) {

    try {

        $stmt = $conn->prepare("
            INSERT INTO Locations
            (type, name, address, city, province, postalCode,
             webAddress, maxCapacity)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "sssssssi",
            $_POST["type"],
            $_POST["name"],
            $_POST["address"],
            $_POST["city"],
            $_POST["province"],
            $_POST["postalCode"],
            $_POST["webAddress"],
            $_POST["maxCapacity"]
        );

        $stmt->execute();

        $message = "Location created successfully.";

    } catch (Exception $e) {

        $message = "Database error: " . $e->getMessage();
    }
}


/* =========================================================
   UPDATE LOCATION
   ========================================================= */

if (isset($_POST["update"])) {

    try {

        $stmt = $conn->prepare("
            UPDATE Locations SET
                type = ?,
                name = ?,
                address = ?,
                city = ?,
                province = ?,
                postalCode = ?,
                webAddress = ?,
                maxCapacity = ?
            WHERE id = ?
        ");

        $stmt->bind_param(
            "sssssssii",
            $_POST["type"],
            $_POST["name"],
            $_POST["address"],
            $_POST["city"],
            $_POST["province"],
            $_POST["postalCode"],
            $_POST["webAddress"],
            $_POST["maxCapacity"],
            $_POST["id"]
        );

        $stmt->execute();

        $message = "Location updated successfully.";

    } catch (Exception $e) {

        $message = "Database error: " . $e->getMessage();
    }
}


/* =========================================================
   DELETE LOCATION
   ========================================================= */

if (isset($_POST["delete"])) {

    try {

        $stmt = $conn->prepare("
            DELETE FROM Locations
            WHERE id = ?
        ");

        $stmt->bind_param(
            "i",
            $_POST["id"]
        );

        $stmt->execute();

        $message = "Location deleted successfully.";

    } catch (Exception $e) {

        $message = "Database error: " . $e->getMessage();
    }
}


/* =========================================================
   ADD LOCATION PHONE NUMBER
   ========================================================= */

if (isset($_POST["addPhone"])) {

    try {

        $stmt = $conn->prepare("
            INSERT INTO LocationPhoneNumbers
            (locationId, phoneNumber)
            VALUES (?, ?)
        ");

        $stmt->bind_param(
            "is",
            $_POST["locationId"],
            $_POST["phoneNumber"]
        );

        $stmt->execute();

        $message = "Phone number added successfully.";

    } catch (Exception $e) {

        $message = "Database error: " . $e->getMessage();
    }
}


/* =========================================================
   DELETE LOCATION PHONE NUMBER
   ========================================================= */

if (isset($_POST["deletePhone"])) {

    try {

        $stmt = $conn->prepare("
            DELETE FROM LocationPhoneNumbers
            WHERE locationId = ?
            AND phoneNumber = ?
        ");

        $stmt->bind_param(
            "is",
            $_POST["locationId"],
            $_POST["phoneNumber"]
        );

        $stmt->execute();

        $message = "Phone number deleted successfully.";

    } catch (Exception $e) {

        $message = "Database error: " . $e->getMessage();
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

<h1>Manage Locations</h1>

<?php if (!empty($message)): ?>

    <p>
        <strong><?= htmlspecialchars($message) ?></strong>
    </p>

<?php endif; ?>


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

$result = $conn->query("
    SELECT *
    FROM Locations
    ORDER BY name
");

?>

<table border="1">

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

<?php while ($row = $result->fetch_assoc()): ?>

<tr>

<form method="post">

    <td>

        <?= htmlspecialchars($row["id"]) ?>

        <input type="hidden"
               name="id"
               value="<?= htmlspecialchars($row["id"]) ?>">

    </td>


    <td>

        <select name="type">

            <option value="Head"
                <?= $row["type"] == "Head" ? "selected" : "" ?>>
                Head
            </option>

            <option value="Branch"
                <?= $row["type"] == "Branch" ? "selected" : "" ?>>
                Branch
            </option>

        </select>

    </td>


    <td>

        <input name="name"
               value="<?= htmlspecialchars($row["name"]) ?>">

    </td>


    <td>

        <input name="address"
               value="<?= htmlspecialchars($row["address"]) ?>">

    </td>


    <td>

        <input name="city"
               value="<?= htmlspecialchars($row["city"]) ?>">

    </td>


    <td>

        <input name="province"
               value="<?= htmlspecialchars($row["province"]) ?>">

    </td>


    <td>

        <input name="postalCode"
               value="<?= htmlspecialchars($row["postalCode"]) ?>">

    </td>


    <td>

        <input name="webAddress"
               value="<?= htmlspecialchars($row["webAddress"]) ?>">

    </td>


    <td>

        <input type="number"
               name="maxCapacity"
               value="<?= htmlspecialchars($row["maxCapacity"]) ?>">

    </td>


    <td>

        <button name="update">
            Save
        </button>

        <button name="delete"
                onclick="return confirm('Delete this location?');">
            Delete
        </button>

    </td>

</form>

</tr>

<?php endwhile; ?>

</table>


<h2>Add Location Phone Number</h2>

<form method="post">

    Location:

    <select name="locationId">

        <?php

        $locations = $conn->query("
            SELECT id, name
            FROM Locations
            ORDER BY name
        ");

        while ($location = $locations->fetch_assoc()) {

            echo "<option value='{$location["id"]}'>"
                . htmlspecialchars($location["name"])
                . "</option>";
        }

        ?>

    </select>

    <br>

    Phone Number:

    <input type="text"
           name="phoneNumber"
           required>

    <br><br>

    <button name="addPhone">
        Add Phone Number
    </button>

</form>


<h2>Location Phone Numbers</h2>

<table border="1">

<tr>

    <th>Location</th>
    <th>Phone Number</th>
    <th>Action</th>

</tr>

<?php

$phones = $conn->query("
    SELECT
        lpn.locationId,
        lpn.phoneNumber,
        l.name AS locationName

    FROM LocationPhoneNumbers lpn

    JOIN Locations l
        ON l.id = lpn.locationId

    ORDER BY l.name, lpn.phoneNumber
");

while ($phone = $phones->fetch_assoc()):

?>

<tr>

    <td>
        <?= htmlspecialchars($phone["locationName"]) ?>
    </td>

    <td>
        <?= htmlspecialchars($phone["phoneNumber"]) ?>
    </td>

    <td>

        <form method="post">

            <input type="hidden"
                   name="locationId"
                   value="<?= $phone["locationId"] ?>">

            <input type="hidden"
                   name="phoneNumber"
                   value="<?= htmlspecialchars($phone["phoneNumber"]) ?>">

            <button name="deletePhone"
                    onclick="return confirm('Delete this phone number?');">

                Delete

            </button>

        </form>

    </td>

</tr>

<?php endwhile; ?>

</table>


</body>

</html>
