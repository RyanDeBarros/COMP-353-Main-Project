<?php

require_once("../database.php");

$locationName = $_GET["location"] ?? "Montreal Query Centre";

$stmt = $conn->prepare("
    SELECT DISTINCT
        fam.firstName,
        fam.lastName,
        fam.phoneNumber

    FROM FamilyMemberAssociations fma

    JOIN Population fam
        ON fam.id = fma.familyId

    JOIN ClubMembers childMember
        ON childMember.id = fma.childId

    JOIN Population child
        ON child.id = childMember.id

    JOIN ClubMemberRegistrations childReg
        ON childReg.memberId = childMember.id
       AND childReg.endDate IS NULL

    JOIN Locations l
        ON l.id = childReg.locationId

    JOIN TeamFormations tf
        ON tf.headCoachId = fam.id
       AND tf.locationId = l.id

    WHERE
        fma.endDate IS NULL

        AND l.name = ?

        AND COALESCE((
            SELECT SUM(pay.amount)
            FROM Payments pay
            WHERE pay.memberId = childMember.id
              AND YEAR(pay.dueDate) = YEAR(CURDATE()) - 1
        ), 0) >=

        CASE
            WHEN TIMESTAMPDIFF(
                YEAR,
                child.birthDate,
                STR_TO_DATE(
                    CONCAT(YEAR(CURDATE()) - 1, '-12-31'),
                    '%Y-%m-%d'
                )
            ) >= 18
            THEN 200
            ELSE 100
        END

    ORDER BY
        fam.firstName ASC,
        fam.lastName ASC
");

$stmt->bind_param("s", $locationName);
$stmt->execute();

$result = $stmt->get_result();

$locations = $conn->query("
    SELECT name
    FROM Locations
    ORDER BY name
");

?>

<!DOCTYPE html>

<html>

<head>
    <title>Query 17 - Family Members Who Are Head Coaches</title>
</head>

<body>

<a href="../index.php">Home</a>

<h1>Query 17</h1>

<h2>Family Members Who Are Head Coaches at the Same Location</h2>

<form method="get">

    Location:

    <select name="location">

        <?php while ($location = $locations->fetch_assoc()): ?>

            <option value="<?= htmlspecialchars($location["name"]) ?>"
                <?= $location["name"] === $locationName ? "selected" : "" ?>>

                <?= htmlspecialchars($location["name"]) ?>

            </option>

        <?php endwhile; ?>

    </select>

    <button type="submit">
        Run Query
    </button>

</form>

<br>

<table border="1">

<tr>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Phone Number</th>
</tr>

<?php while ($row = $result->fetch_assoc()): ?>

<tr>

    <td>
        <?= htmlspecialchars($row["firstName"]) ?>
    </td>

    <td>
        <?= htmlspecialchars($row["lastName"]) ?>
    </td>

    <td>
        <?= htmlspecialchars($row["phoneNumber"]) ?>
    </td>

</tr>

<?php endwhile; ?>

</table>

</body>

</html>