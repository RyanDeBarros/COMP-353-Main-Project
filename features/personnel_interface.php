<?php

require_once("../database.php");

$message = "";

/* =========================================================
   CREATE PERSONNEL
   ========================================================= */

if (isset($_POST["create"])) {

    try {

        $conn->begin_transaction();

        // Create Population record
        $stmt = $conn->prepare("
            INSERT INTO Population
            (firstName, lastName, birthDate, SSN, medicareNo,
             phoneNumber, address, city, province, postalCode,
             email, gender)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "ssssssssssss",
            $_POST["firstName"],
            $_POST["lastName"],
            $_POST["birthDate"],
            $_POST["SSN"],
            $_POST["medicareNo"],
            $_POST["phoneNumber"],
            $_POST["address"],
            $_POST["city"],
            $_POST["province"],
            $_POST["postalCode"],
            $_POST["email"],
            $_POST["gender"]
        );

        $stmt->execute();

        $personId = $conn->insert_id;

        // Create Personnel record
        $stmt = $conn->prepare("
            INSERT INTO Personnel (id)
            VALUES (?)
        ");

        $stmt->bind_param("i", $personId);
        $stmt->execute();

        $conn->commit();

        $message = "Personnel created successfully.";

    } catch (Exception $e) {

        $conn->rollback();
        $message = "Database error: " . $e->getMessage();
    }
}


/* =========================================================
   UPDATE PERSONNEL
   ========================================================= */

if (isset($_POST["update"])) {

    try {

        $stmt = $conn->prepare("
            UPDATE Population SET
                firstName = ?,
                lastName = ?,
                birthDate = ?,
                SSN = ?,
                medicareNo = ?,
                phoneNumber = ?,
                address = ?,
                city = ?,
                province = ?,
                postalCode = ?,
                email = ?,
                gender = ?
            WHERE id = ?
        ");

        $stmt->bind_param(
            "ssssssssssssi",
            $_POST["firstName"],
            $_POST["lastName"],
            $_POST["birthDate"],
            $_POST["SSN"],
            $_POST["medicareNo"],
            $_POST["phoneNumber"],
            $_POST["address"],
            $_POST["city"],
            $_POST["province"],
            $_POST["postalCode"],
            $_POST["email"],
            $_POST["gender"],
            $_POST["id"]
        );

        $stmt->execute();

        $message = "Personnel updated successfully.";

    } catch (Exception $e) {

        $message = "Database error: " . $e->getMessage();
    }
}


/* =========================================================
   DELETE PERSONNEL
   ========================================================= */

if (isset($_POST["delete"])) {

    try {

        $stmt = $conn->prepare("
            DELETE FROM Personnel
            WHERE id = ?
        ");

        $stmt->bind_param("i", $_POST["id"]);
        $stmt->execute();

        // Population record can now be deleted if no other
        // table references it.
        $stmt = $conn->prepare("
            DELETE FROM Population
            WHERE id = ?
        ");

        $stmt->bind_param("i", $_POST["id"]);
        $stmt->execute();

        $message = "Personnel deleted successfully.";

    } catch (Exception $e) {

        $message = "Database error: " . $e->getMessage();
    }
}


/* =========================================================
   CREATE PERSONNEL OPERATION
   ========================================================= */

if (isset($_POST["createOperation"])) {

    try {

        $stmt = $conn->prepare("
            INSERT INTO PersonnelOperations
            (personnelId, locationId, startDate, endDate,
             role, title, mandate)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "iisssss",
            $_POST["personnelId"],
            $_POST["locationId"],
            $_POST["startDate"],
            $_POST["endDate"],
            $_POST["role"],
            $_POST["title"],
            $_POST["mandate"]
        );

        $stmt->execute();

        $message = "Personnel operation created successfully.";

    } catch (Exception $e) {

        $message = "Database error: " . $e->getMessage();
    }
}

/* =========================================================
   UPDATE PERSONNEL OPERATION
   ========================================================= */

if (isset($_POST["updateOperation"])) {

    try {

        $stmt = $conn->prepare("
            UPDATE PersonnelOperations SET
                personnelId = ?,
                locationId = ?,
                startDate = ?,
                endDate = ?,
                role = ?,
                title = ?,
                mandate = ?
            WHERE personnelId = ?
            AND startDate = ?
        ");

        $stmt->bind_param(
            "iisssssis",
            $_POST["personnelId"],
            $_POST["locationId"],
            $_POST["startDate"],
            $_POST["endDate"],
            $_POST["role"],
            $_POST["title"],
            $_POST["mandate"],
            $_POST["originalPersonnelId"],
            $_POST["originalStartDate"]
        );

        $stmt->execute();

        $message = "Personnel operation updated successfully.";

    } catch (Exception $e) {

        $message = "Database error: " . $e->getMessage();
    }
}

/* =========================================================
   DELETE PERSONNEL OPERATION
   ========================================================= */

if (isset($_POST["deleteOperation"])) {

    try {

        $stmt = $conn->prepare("
            DELETE FROM PersonnelOperations
            WHERE personnelId = ?
            AND startDate = ?
        ");

        $stmt->bind_param(
            "is",
            $_POST["personnelId"],
            $_POST["operationStartDate"]
        );

        $stmt->execute();

        $message = "Personnel operation deleted successfully.";

    } catch (Exception $e) {

        $message = "Database error: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>

<html>

<head>

    <title>Manage Personnel</title>

</head>

<body>

<a href="../index.php">Home</a>

<h1>Manage Personnel</h1>

<?php if (!empty($message)): ?>

    <p><strong><?= htmlspecialchars($message) ?></strong></p>

<?php endif; ?>


<h2>Create Personnel</h2>

<form method="post">

    First Name:
    <input type="text" name="firstName" required>

    <br>

    Last Name:
    <input type="text" name="lastName" required>

    <br>

    Birth Date:
    <input type="date" name="birthDate">

    <br>

    SSN:
    <input type="text" name="SSN" maxlength="9" required>

    <br>

    Medicare Number:
    <input type="text" name="medicareNo" required>

    <br>

    Phone:
    <input type="text" name="phoneNumber">

    <br>

    Address:
    <input type="text" name="address">

    <br>

    City:
    <input type="text" name="city">

    <br>

    Province:

    <select name="province">

        <?php
        $provinces = [
            "AB","BC","MB","NB","NL","NS","NT",
            "NU","ON","PE","QC","SK","YT"
        ];

        foreach ($provinces as $province) {
            echo "<option value='$province'>$province</option>";
        }
        ?>

    </select>

    <br>

    Postal Code:
    <input type="text" name="postalCode">

    <br>

    Email:
    <input type="email" name="email">

    <br>

    Gender:

    <select name="gender">

        <option value="M">M</option>
        <option value="F">F</option>

    </select>

    <br><br>

    <button name="create">
        Create Personnel
    </button>

</form>


<h2>Personnel</h2>

<?php

$result = $conn->query("
    SELECT
        p.id,
        p.firstName,
        p.lastName,
        p.birthDate,
        p.SSN,
        p.medicareNo,
        p.phoneNumber,
        p.address,
        p.city,
        p.province,
        p.postalCode,
        p.email,
        p.gender
    FROM Personnel pe
    JOIN Population p
        ON p.id = pe.id
    ORDER BY p.lastName, p.firstName
");

?>

<table border="1">

<tr>

    <th>ID</th>
    <th>Name</th>
    <th>Birth Date</th>
    <th>SSN</th>
    <th>Medicare</th>
    <th>Phone</th>
    <th>Address</th>
    <th>City</th>
    <th>Province</th>
    <th>Postal Code</th>
    <th>Email</th>
    <th>Gender</th>
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
        <input name="firstName"
               value="<?= htmlspecialchars($row["firstName"]) ?>">
        <br>
        <input name="lastName"
               value="<?= htmlspecialchars($row["lastName"]) ?>">
    </td>

    <td>
        <input type="date"
               name="birthDate"
               value="<?= htmlspecialchars($row["birthDate"]) ?>">
    </td>

    <td>
        <input name="SSN"
               value="<?= htmlspecialchars($row["SSN"]) ?>">
    </td>

    <td>
        <input name="medicareNo"
               value="<?= htmlspecialchars($row["medicareNo"]) ?>">
    </td>

    <td>
        <input name="phoneNumber"
               value="<?= htmlspecialchars($row["phoneNumber"]) ?>">
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
        <input name="email"
               value="<?= htmlspecialchars($row["email"]) ?>">
    </td>

    <td>
        <select name="gender">

            <option value="M"
                <?= $row["gender"] == "M" ? "selected" : "" ?>>
                M
            </option>

            <option value="F"
                <?= $row["gender"] == "F" ? "selected" : "" ?>>
                F
            </option>

        </select>
    </td>

    <td>

        <button name="update">
            Save
        </button>

        <button name="delete"
                onclick="return confirm('Delete this personnel member?');">
            Delete
        </button>

    </td>

</form>

</tr>

<?php endwhile; ?>

</table>


<h2>Add Personnel Operation</h2>

<form method="post">

    Personnel:

    <select name="personnelId">

        <?php

        $people = $conn->query("
            SELECT pe.id, p.firstName, p.lastName
            FROM Personnel pe
            JOIN Population p ON p.id = pe.id
            ORDER BY p.lastName, p.firstName
        ");

        while ($person = $people->fetch_assoc()) {

            echo "<option value='{$person["id"]}'>"
                . htmlspecialchars(
                    $person["firstName"] . " " .
                    $person["lastName"]
                )
                . "</option>";
        }

        ?>

    </select>

    <br>

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

    Start Date:
    <input type="date" name="startDate" required>

    <br>

    End Date:
    <input type="date" name="endDate">

    <br>

    Role:

    <select name="role">

        <option>Administrator</option>
        <option>Captain</option>
        <option>Coach</option>
        <option>Assistant Coach</option>
        <option>Other</option>

    </select>

    <br>

    Title:

    <select name="title">

        <option>General Manager</option>
        <option>Deputy Manager</option>
        <option>Treasurer</option>
        <option>Secretary</option>
        <option>None</option>

    </select>

    <br>

    Mandate:

    <select name="mandate">

        <option value="volunteer">Volunteer</option>
        <option value="salaried">Salaried</option>

    </select>

    <br><br>

    <button name="createOperation">
        Add Operation
    </button>

</form>

<h2>Personnel Operations</h2>

<table border="1">

<tr>

    <th>Personnel</th>
    <th>Location</th>
    <th>Start</th>
    <th>End</th>
    <th>Role</th>
    <th>Title</th>
    <th>Mandate</th>
    <th>Action</th>

</tr>

<?php

$operations = $conn->query("
    SELECT
        po.*,
        CONCAT(p.firstName, ' ', p.lastName) AS personnelName,
        l.name AS locationName
    FROM PersonnelOperations po
    JOIN Population p
        ON p.id = po.personnelId
    JOIN Locations l
        ON l.id = po.locationId
    ORDER BY po.startDate DESC
");

while ($operation = $operations->fetch_assoc()):

?>

<tr>

<form method="post">

    <!-- Keep the original key values so the row can still
         be found even if Personnel or Start Date is changed. -->

    <input type="hidden"
           name="originalPersonnelId"
           value="<?= htmlspecialchars($operation["personnelId"]) ?>">

    <input type="hidden"
           name="originalStartDate"
           value="<?= htmlspecialchars($operation["startDate"]) ?>">


    <td>

        <select name="personnelId">

            <?php

            $people = $conn->query("
                SELECT pe.id, p.firstName, p.lastName
                FROM Personnel pe
                JOIN Population p
                    ON p.id = pe.id
                ORDER BY p.lastName, p.firstName
            ");

            while ($person = $people->fetch_assoc()):

            ?>

                <option
                    value="<?= htmlspecialchars($person["id"]) ?>"
                    <?= $person["id"] == $operation["personnelId"]
                        ? "selected"
                        : "" ?>>

                    <?= htmlspecialchars(
                        $person["firstName"] . " " .
                        $person["lastName"]
                    ) ?>

                </option>

            <?php endwhile; ?>

        </select>

    </td>


    <td>

        <select name="locationId">

            <?php

            $locations = $conn->query("
                SELECT id, name
                FROM Locations
                ORDER BY name
            ");

            while ($location = $locations->fetch_assoc()):

            ?>

                <option
                    value="<?= htmlspecialchars($location["id"]) ?>"
                    <?= $location["id"] == $operation["locationId"]
                        ? "selected"
                        : "" ?>>

                    <?= htmlspecialchars($location["name"]) ?>

                </option>

            <?php endwhile; ?>

        </select>

    </td>


    <td>

        <input type="date"
               name="startDate"
               value="<?= htmlspecialchars($operation["startDate"]) ?>"
               required>

    </td>


    <td>

        <input type="date"
               name="endDate"
               value="<?= htmlspecialchars($operation["endDate"]) ?>">

    </td>


    <td>

        <select name="role">

            <option value="Administrator"
                <?= $operation["role"] == "Administrator"
                    ? "selected" : "" ?>>
                Administrator
            </option>

            <option value="Captain"
                <?= $operation["role"] == "Captain"
                    ? "selected" : "" ?>>
                Captain
            </option>

            <option value="Coach"
                <?= $operation["role"] == "Coach"
                    ? "selected" : "" ?>>
                Coach
            </option>

            <option value="Assistant Coach"
                <?= $operation["role"] == "Assistant Coach"
                    ? "selected" : "" ?>>
                Assistant Coach
            </option>

            <option value="Other"
                <?= $operation["role"] == "Other"
                    ? "selected" : "" ?>>
                Other
            </option>

        </select>

    </td>


    <td>

        <select name="title">

            <option value="General Manager"
                <?= $operation["title"] == "General Manager"
                    ? "selected" : "" ?>>
                General Manager
            </option>

            <option value="Deputy Manager"
                <?= $operation["title"] == "Deputy Manager"
                    ? "selected" : "" ?>>
                Deputy Manager
            </option>

            <option value="Treasurer"
                <?= $operation["title"] == "Treasurer"
                    ? "selected" : "" ?>>
                Treasurer
            </option>

            <option value="Secretary"
                <?= $operation["title"] == "Secretary"
                    ? "selected" : "" ?>>
                Secretary
            </option>

            <option value="None"
                <?= $operation["title"] == "None"
                    ? "selected" : "" ?>>
                None
            </option>

        </select>

    </td>


    <td>

        <select name="mandate">

            <option value="volunteer"
                <?= $operation["mandate"] == "volunteer"
                    ? "selected" : "" ?>>
                Volunteer
            </option>

            <option value="salaried"
                <?= $operation["mandate"] == "salaried"
                    ? "selected" : "" ?>>
                Salaried
            </option>

        </select>

    </td>


    <td>

        <button name="updateOperation">
            Save
        </button>

        <button name="deleteOperation"
                onclick="return confirm('Delete this operation?');">
            Delete
        </button>

    </td>

</form>

</tr>

<?php endwhile; ?>

</table>

</body>
</html>
