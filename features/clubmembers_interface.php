<?php

require_once("../database.php");

$message = "";


/* =========================================================
   CREATE CLUB MEMBER
   ========================================================= */

if (isset($_POST["create"])) {

    try {

        $conn->begin_transaction();

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

        $memberId = $conn->insert_id;

        $stmt = $conn->prepare("
            INSERT INTO ClubMembers
            (id, height, weight)
            VALUES (?, ?, ?)
        ");

        $stmt->bind_param(
            "iii",
            $memberId,
            $_POST["height"],
            $_POST["weight"]
        );

        $stmt->execute();

        $conn->commit();

        $message = "Club member created successfully.";

    } catch (Exception $e) {

        $conn->rollback();
        $message = "Database error: " . $e->getMessage();
    }
}


/* =========================================================
   UPDATE CLUB MEMBER
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

        $stmt = $conn->prepare("
            UPDATE ClubMembers
            SET height = ?, weight = ?
            WHERE id = ?
        ");

        $stmt->bind_param(
            "iii",
            $_POST["height"],
            $_POST["weight"],
            $_POST["id"]
        );

        $stmt->execute();

        $message = "Club member updated successfully.";

    } catch (Exception $e) {

        $message = "Database error: " . $e->getMessage();
    }
}


/* =========================================================
   DELETE CLUB MEMBER
   ========================================================= */

if (isset($_POST["delete"])) {

    try {

        $stmt = $conn->prepare("
            DELETE FROM ClubMembers
            WHERE id = ?
        ");

        $stmt->bind_param("i", $_POST["id"]);
        $stmt->execute();

        $stmt = $conn->prepare("
            DELETE FROM Population
            WHERE id = ?
        ");

        $stmt->bind_param("i", $_POST["id"]);
        $stmt->execute();

        $message = "Club member deleted successfully.";

    } catch (Exception $e) {

        $message = "Database error: " . $e->getMessage();
    }
}


/* =========================================================
   CREATE REGISTRATION
   ========================================================= */

if (isset($_POST["createRegistration"])) {

    try {

        $stmt = $conn->prepare("
            INSERT INTO ClubMemberRegistrations
            (memberId, locationId, startDate, endDate)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "iiss",
            $_POST["memberId"],
            $_POST["locationId"],
            $_POST["startDate"],
            $_POST["endDate"]
        );

        $stmt->execute();

        $message = "Registration created successfully.";

    } catch (Exception $e) {

        $message = "Database error: " . $e->getMessage();
    }
}

/* =========================================================
   UPDATE REGISTRATION
   ========================================================= */

if (isset($_POST["updateRegistration"])) {

    try {

        $stmt = $conn->prepare("
            UPDATE ClubMemberRegistrations SET
                memberId = ?,
                locationId = ?,
                startDate = ?,
                endDate = ?
            WHERE memberId = ?
            AND startDate = ?
        ");

        $stmt->bind_param(
            "iissis",
            $_POST["memberId"],
            $_POST["locationId"],
            $_POST["startDate"],
            $_POST["endDate"],
            $_POST["originalMemberId"],
            $_POST["originalStartDate"]
        );

        $stmt->execute();

        $message = "Registration updated successfully.";

    } catch (Exception $e) {

        $message = "Database error: " . $e->getMessage();
    }
}

/* =========================================================
   DELETE REGISTRATION
   ========================================================= */

if (isset($_POST["deleteRegistration"])) {

    try {

        $stmt = $conn->prepare("
            DELETE FROM ClubMemberRegistrations
            WHERE memberId = ?
            AND startDate = ?
        ");

        $stmt->bind_param(
            "is",
            $_POST["memberId"],
            $_POST["registrationStartDate"]
        );

        $stmt->execute();

        $message = "Registration deleted successfully.";

    } catch (Exception $e) {

        $message = "Database error: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>

<html>

<head>

    <title>Manage Club Members</title>

</head>

<body>

<a href="../index.php">Home</a>

<h1>Manage Club Members</h1>

<?php if (!empty($message)): ?>

<p>
    <strong><?= htmlspecialchars($message) ?></strong>
</p>

<?php endif; ?>


<h2>Create Club Member</h2>

<form method="post">

First Name:
<input name="firstName" required>

<br>

Last Name:
<input name="lastName" required>

<br>

Birth Date:
<input type="date" name="birthDate">

<br>

SSN:
<input name="SSN" maxlength="9" required>

<br>

Medicare Number:
<input name="medicareNo" required>

<br>

Phone:
<input name="phoneNumber">

<br>

Address:
<input name="address">

<br>

City:
<input name="city">

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
<input name="postalCode">

<br>

Email:
<input type="email" name="email">

<br>

Gender:

<select name="gender">

<option value="M">M</option>
<option value="F">F</option>

</select>

<br>

Height:
<input type="number" name="height">

<br>

Weight:
<input type="number" name="weight">

<br><br>

<button name="create">
Create Club Member
</button>

</form>


<h2>Club Members</h2>

<table border="1">

<tr>

<th>ID</th>
<th>Name</th>
<th>Birth Date</th>
<th>Gender</th>
<th>Phone</th>
<th>Email</th>
<th>Height</th>
<th>Weight</th>
<th>Actions</th>

</tr>

<?php

$result = $conn->query("
    SELECT
        p.*,
        cm.height,
        cm.weight
    FROM ClubMembers cm
    JOIN Population p
        ON p.id = cm.id
    ORDER BY p.lastName, p.firstName
");

while ($row = $result->fetch_assoc()):

?>

<tr>

<form method="post">

<td>

<?= $row["id"] ?>

<input type="hidden"
       name="id"
       value="<?= $row["id"] ?>">

</td>

<td>

<input name="firstName"
       value="<?= htmlspecialchars($row["firstName"]) ?>">

<input name="lastName"
       value="<?= htmlspecialchars($row["lastName"]) ?>">

</td>

<td>

<input type="date"
       name="birthDate"
       value="<?= htmlspecialchars($row["birthDate"]) ?>">

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

<input name="phoneNumber"
       value="<?= htmlspecialchars($row["phoneNumber"]) ?>">

</td>

<td>

<input name="email"
       value="<?= htmlspecialchars($row["email"]) ?>">

</td>

<td>

<input type="number"
       name="height"
       value="<?= htmlspecialchars($row["height"]) ?>">

</td>

<td>

<input type="number"
       name="weight"
       value="<?= htmlspecialchars($row["weight"]) ?>">

</td>

<td>

<button name="update">
Save
</button>

<button name="delete"
        onclick="return confirm('Delete this member?');">
Delete
</button>

</td>

</form>

</tr>

<?php endwhile; ?>

</table>


<h2>Create Registration</h2>

<form method="post">

Member:

<select name="memberId">

<?php

$members = $conn->query("
    SELECT
        cm.id,
        p.firstName,
        p.lastName
    FROM ClubMembers cm
    JOIN Population p
        ON p.id = cm.id
    ORDER BY p.lastName, p.firstName
");

while ($member = $members->fetch_assoc()) {

    echo "<option value='{$member["id"]}'>"
        . htmlspecialchars(
            $member["firstName"] . " " .
            $member["lastName"]
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

<br><br>

<button name="createRegistration">
Create Registration
</button>

</form>


<h2>Registrations</h2>

<table border="1">

<tr>

    <th>Member</th>
    <th>Location</th>
    <th>Start</th>
    <th>End</th>
    <th>Action</th>

</tr>

<?php

$registrations = $conn->query("
    SELECT
        cmr.*,
        CONCAT(p.firstName, ' ', p.lastName) AS memberName,
        l.name AS locationName
    FROM ClubMemberRegistrations cmr
    JOIN ClubMembers cm
        ON cm.id = cmr.memberId
    JOIN Population p
        ON p.id = cm.id
    JOIN Locations l
        ON l.id = cmr.locationId
    ORDER BY cmr.startDate DESC
");

while ($registration = $registrations->fetch_assoc()):

?>

<tr>

<form method="post">

    <!-- Original values identify the database row -->
    <!-- even if Member or Start Date is changed. -->

    <input type="hidden"
           name="originalMemberId"
           value="<?= htmlspecialchars($registration["memberId"]) ?>">

    <input type="hidden"
           name="originalStartDate"
           value="<?= htmlspecialchars($registration["startDate"]) ?>">


    <td>

        <select name="memberId">

            <?php

            $members = $conn->query("
                SELECT
                    cm.id,
                    p.firstName,
                    p.lastName
                FROM ClubMembers cm
                JOIN Population p
                    ON p.id = cm.id
                ORDER BY p.lastName, p.firstName
            ");

            while ($member = $members->fetch_assoc()):

            ?>

                <option
                    value="<?= htmlspecialchars($member["id"]) ?>"
                    <?= $member["id"] == $registration["memberId"]
                        ? "selected"
                        : "" ?>>

                    <?= htmlspecialchars(
                        $member["firstName"] . " " .
                        $member["lastName"]
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
                    <?= $location["id"] == $registration["locationId"]
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
               value="<?= htmlspecialchars($registration["startDate"]) ?>"
               required>

    </td>


    <td>

        <input type="date"
               name="endDate"
               value="<?= htmlspecialchars($registration["endDate"]) ?>">

    </td>


    <td>

        <button name="updateRegistration">
            Save
        </button>

        <button name="deleteRegistration"
                onclick="return confirm('Delete this registration?');">
            Delete
        </button>

    </td>

</form>

</tr>

<?php endwhile; ?>

</table>

</body>

</html>
