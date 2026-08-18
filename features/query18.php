<?php

require_once("../database.php");

$result = $conn->query("
    SELECT
        cm.id AS membershipNumber,
        p.firstName,
        p.lastName,

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

    JOIN ClubMemberRegistrations currentReg
        ON currentReg.memberId = cm.id
       AND currentReg.endDate IS NULL

    JOIN Locations l
        ON l.id = currentReg.locationId

    WHERE
        COALESCE((
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

        AND EXISTS (
            SELECT 1
            FROM SessionPlayers sp
            JOIN TeamSessions ts
                ON ts.id = sp.sessionId
            WHERE sp.memberId = cm.id
              AND ts.sessionType = 'Game'
        )

        AND NOT EXISTS (
            SELECT 1
            FROM SessionPlayers sp
            JOIN TeamSessions ts
                ON ts.id = sp.sessionId
            WHERE sp.memberId = cm.id
              AND ts.sessionType = 'Game'
              AND (
                  (
                      sp.formationId = ts.team1
                      AND ts.team1Score > ts.team2Score
                  )
                  OR
                  (
                      sp.formationId = ts.team2
                      AND ts.team2Score > ts.team1Score
                  )
              )
        )

    ORDER BY
        l.name ASC,
        cm.id ASC
");

?>

<!DOCTYPE html>
<html>

<head>
    <title>Query 18 - Members Who Never Won a Game</title>
</head>

<body>

<a href="../index.php">Home</a>

<h1>Query 18</h1>

<h2>Active Club Members Who Have Never Won a Game</h2>

<table border="1">

<tr>
    <th>Membership Number</th>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Age</th>
    <th>Phone Number</th>
    <th>Email</th>
    <th>Current Location</th>
</tr>

<?php while ($row = $result->fetch_assoc()): ?>

<tr>
    <td><?= htmlspecialchars($row["membershipNumber"]) ?></td>
    <td><?= htmlspecialchars($row["firstName"]) ?></td>
    <td><?= htmlspecialchars($row["lastName"]) ?></td>
    <td><?= htmlspecialchars($row["age"]) ?></td>
    <td><?= htmlspecialchars($row["phoneNumber"]) ?></td>
    <td><?= htmlspecialchars($row["email"]) ?></td>
    <td><?= htmlspecialchars($row["currentLocation"]) ?></td>
</tr>

<?php endwhile; ?>

</table>

</body>
</html>