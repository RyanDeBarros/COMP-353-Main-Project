<?php

require_once("../database.php");

$result = $conn->query("
    SELECT
        p.firstName,
        p.lastName,

        COUNT(DISTINCT CASE
            WHEN TIMESTAMPDIFF(
                YEAR,
                child.birthDate,
                CURDATE()
            ) BETWEEN 4 AND 17
            THEN fma.childId
        END) AS associatedMinorCount,

        COUNT(DISTINCT CASE
            WHEN EXISTS (
                SELECT 1
                FROM FIFA_Games fg
                WHERE fg.memberId = fma.childId
            )
            THEN fma.childId
        END) AS fifaMemberCount,

        p.phoneNumber,
        p.email,
        l.name AS currentLocation,
        po.role AS currentRole

    FROM Personnel pe

    JOIN Population p
        ON p.id = pe.id

    JOIN PersonnelOperations po
        ON po.personnelId = pe.id
       AND po.endDate IS NULL
       AND po.mandate = 'volunteer'

    JOIN Locations l
        ON l.id = po.locationId

    JOIN FamilyMemberAssociations fma
        ON fma.familyId = pe.id
       AND fma.endDate IS NULL

    JOIN ClubMembers cm
        ON cm.id = fma.childId

    JOIN Population child
        ON child.id = cm.id

    GROUP BY
        pe.id,
        p.firstName,
        p.lastName,
        p.phoneNumber,
        p.email,
        l.name,
        po.role

    HAVING
        associatedMinorCount >= 1
        AND fifaMemberCount >= 1

    ORDER BY
        l.name ASC,
        po.role ASC,
        p.firstName ASC,
        p.lastName ASC
");

?>

<!DOCTYPE html>
<html>

<head>
    <title>Query 19 - Volunteer Personnel Family Members</title>
</head>

<body>

<a href="../index.php">Home</a>

<h1>Query 19</h1>

<h2>Volunteer Personnel Who Are Family Members of Club Members</h2>

<table border="1">

<tr>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Associated Minor Members</th>
    <th>Members in FIFA Games</th>
    <th>Phone Number</th>
    <th>Email</th>
    <th>Current Location</th>
    <th>Current Role</th>
</tr>

<?php while ($row = $result->fetch_assoc()): ?>

<tr>
    <td><?= htmlspecialchars($row["firstName"]) ?></td>
    <td><?= htmlspecialchars($row["lastName"]) ?></td>
    <td><?= htmlspecialchars($row["associatedMinorCount"]) ?></td>
    <td><?= htmlspecialchars($row["fifaMemberCount"]) ?></td>
    <td><?= htmlspecialchars($row["phoneNumber"]) ?></td>
    <td><?= htmlspecialchars($row["email"]) ?></td>
    <td><?= htmlspecialchars($row["currentLocation"]) ?></td>
    <td><?= htmlspecialchars($row["currentRole"]) ?></td>
</tr>

<?php endwhile; ?>

</table>

</body>
</html>