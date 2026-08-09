<?php

require_once("../database.php");

$message = "";


/* =========================================================
   CREATE FAMILY RELATIONSHIP
   ========================================================= */

if (isset($_POST["create"])) {

    try {

        $stmt = $conn->prepare("
            INSERT INTO FamilyMembers
            (childId, familyId, relationship)
            VALUES (?, ?, ?)
        ");

        $stmt->bind_param(
            "iis",
            $_POST["childId"],
            $_POST["familyId"],
            $_POST["relationship"]
        );

        $stmt->execute();

        $message = "Family relationship created successfully.";

    } catch (Exception $e) {

        $message = "Database error: " . $e->getMessage();
    }
}


/* =========================================================
   UPDATE RELATIONSHIP
   ========================================================= */

if (isset($_POST["update"])) {

    try {

        $stmt = $conn->prepare("
            UPDATE FamilyMembers
            SET relationship = ?
            WHERE childId = ?
              AND familyId = ?
        ");

        $stmt->bind_param(
            "sii",
            $_POST["relationship"],
            $_POST["childId"],
            $_POST["familyId"]
        );

        $stmt->execute();

        $message = "Family relationship updated successfully.";

    } catch (Exception $e) {

        $message = "Database error: " . $e->getMessage();
    }
}


/* =========================================================
   DELETE RELATIONSHIP
   ========================================================= */

if (isset($_POST["delete"])) {

    try {

        $stmt = $conn->prepare("
            DELETE FROM FamilyMembers
            WHERE childId = ?
              AND familyId = ?
        ");

        $stmt->bind_param(
            "ii",
            $_POST["childId"],
            $_POST["familyId"]
        );

        $stmt->execute();

        $message = "Family relationship deleted successfully.";

    } catch (Exception $e) {

        $message = "Database error: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>

<html>

<head>

<title>Manage Family Members</title>

</head>

<body>

<a href="../index.php">Home</a>

<h1>Manage Family Members</h1>

<?php if (!empty($message)): ?>

<p>
<strong><?= htmlspecialchars($message) ?></strong>
</p>

<?php endif; ?>


<h2>Add Family Relationship</h2>

<form method="post">

Child / Club Member:

<select name="childId">

<?php

$children = $conn->query("
    SELECT
        cm.id,
        p.firstName,
        p.lastName
    FROM ClubMembers cm
    JOIN Population p
        ON p.id = cm.id
    ORDER BY p.lastName, p.firstName
");

while ($child = $children->fetch_assoc()) {

    echo "<option value='{$child["id"]}'>"
        . htmlspecialchars(
            $child["firstName"] . " " .
            $child["lastName"]
        )
        . "</option>";

}

?>

</select>

<br>

Family Member:

<select name="familyId">

<?php

$people = $conn->query("
    SELECT id, firstName, lastName
    FROM Population
    ORDER BY lastName, firstName
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

Relationship:

<select name="relationship">

<option>Father</option>
<option>Mother</option>
<option>Grandfather</option>
<option>Grandmother</option>
<option>Tutor</option>
<option>Partner</option>
<option>Friend</option>
<option>Other</option>

</select>

<br><br>

<button name="create">
Add Relationship
</button>

</form>


<h2>Family Relationships</h2>

<table border="1">

<tr>

<th>Child</th>
<th>Family Member</th>
<th>Relationship</th>
<th>Action</th>

</tr>

<?php

$result = $conn->query("
    SELECT
        fm.childId,
        fm.familyId,
        fm.relationship,

        CONCAT(
            child.firstName,
            ' ',
            child.lastName
        ) AS childName,

        CONCAT(
            family.firstName,
            ' ',
            family.lastName
        ) AS familyName

    FROM FamilyMembers fm

    JOIN Population child
        ON child.id = fm.childId

    JOIN Population family
        ON family.id = fm.familyId

    ORDER BY child.lastName, child.firstName
");

while ($row = $result->fetch_assoc()):

?>

<tr>

<form method="post">

<td>

<?= htmlspecialchars($row["childName"]) ?>

<input type="hidden"
       name="childId"
       value="<?= $row["childId"] ?>">

</td>

<td>

<?= htmlspecialchars($row["familyName"]) ?>

<input type="hidden"
       name="familyId"
       value="<?= $row["familyId"] ?>">

</td>

<td>

<select name="relationship">

<?php

$relationships = [
    "Father",
    "Mother",
    "Grandfather",
    "Grandmother",
    "Tutor",
    "Partner",
    "Friend",
    "Other"
];

foreach ($relationships as $relationship) {

    $selected =
        $row["relationship"] == $relationship
        ? "selected"
        : "";

    echo "<option $selected>"
        . htmlspecialchars($relationship)
        . "</option>";
}

?>

</select>

</td>

<td>

<button name="update">
Save
</button>

<button name="delete"
        onclick="return confirm('Delete this relationship?');">
Delete
</button>

</td>

</form>

</tr>

<?php endwhile; ?>

</table>

</body>

</html>
