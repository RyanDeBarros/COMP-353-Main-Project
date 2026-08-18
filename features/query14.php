<?php

require_once("../database.php");

$result = $conn->query("
    SELECT
        cm.id AS membershipNumber,
        p.firstName,
        p.lastName,

        CASE
            WHEN COALESCE((
                SELECT SUM(pay.amount)
                FROM Payments pay
                WHERE pay.memberId = cm.id
                  AND YEAR(pay.dueDate) = YEAR(CURDATE()) - 1
            ), 0) >=
            CASE
                WHEN TIMESTAMPDIFF(
                    YEAR,
                    p.birthDate,
                    STR_TO_DATE(
                        CONCAT(YEAR(CURDATE()) - 1, '-12-31'),
                        '%Y-%m-%d'
                    )
                ) >= 18
                THEN 200
                ELSE 100
            END
            THEN 'Active'
            ELSE 'Inactive'
        END AS status,

        firstReg.joinDate,

        TIMESTAMPDIFF(
            YEAR,
            p.birthDate,
            CURDATE()
        ) AS age,

        p.phoneNumber,
        p.email,
        l.name AS currentLocation

    FROM ClubMembers cm

    JOIN Population p
        ON p.id = cm.id

    JOIN (
        SELECT
            memberId,
            MIN(startDate) AS joinDate
        FROM ClubMemberRegistrations
        GROUP BY memberId
    ) firstReg
        ON firstReg.memberId = cm.id

    JOIN ClubMemberRegistrations currentReg
        ON currentReg.memberId = cm.id
       AND currentReg.endDate IS NULL

    JOIN Locations l
        ON l.id = currentReg.locationId

    WHERE
        TIMESTAMPDIFF(
            YEAR,
            p.birthDate,
            CURDATE()
        ) >= 18

        AND TIMESTAMPDIFF(
            YEAR,
            p.birthDate,
            firstReg.joinDate
        ) < 18

    ORDER BY
        l.name ASC,
        age ASC
");

?>

<!DOCTYPE html>

<html>

<head>

    <title>Query 14 - Major Members Since Minor</title>

</head>

<body>

<a href="../index.php">Home</a>

<h1>Query 14</h1>

<h2>Major Club Members Who Have Been Members Since They Were Minors</h2>

<table border="1">

<tr>

    <th>Membership Number</th>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Status</th>
    <th>Date Joined</th>
    <th>Age</th>
    <th>Phone Number</th>
    <th>Email</th>
    <th>Current Location</th>

</tr>

<?php while ($row = $result->fetch_assoc()): ?>

<tr>

    <td>
        <?= htmlspecialchars($row["membershipNumber"]) ?>
    </td>

    <td>
        <?= htmlspecialchars($row["firstName"]) ?>
    </td>

    <td>
        <?= htmlspecialchars($row["lastName"]) ?>
    </td>

    <td>
        <?= htmlspecialchars($row["status"]) ?>
    </td>

    <td>
        <?= htmlspecialchars($row["joinDate"]) ?>
    </td>

    <td>
        <?= htmlspecialchars($row["age"]) ?>
    </td>

    <td>
        <?= htmlspecialchars($row["phoneNumber"]) ?>
    </td>

    <td>
        <?= htmlspecialchars($row["email"]) ?>
    </td>

    <td>
        <?= htmlspecialchars($row["currentLocation"]) ?>
    </td>

</tr>

<?php endwhile; ?>

</table>

</body>

</html>
