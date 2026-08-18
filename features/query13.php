<?php

require_once("../database.php");

$sql = "
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

    COUNT(fg.gameId) AS fifaParticipationCount,

    l.name AS locationName

FROM ClubMembers cm

JOIN Population p
    ON p.id = cm.id

JOIN ClubMemberRegistrations cmr
    ON cmr.memberId = cm.id
   AND cmr.endDate IS NULL

JOIN Locations l
    ON l.id = cmr.locationId

JOIN FIFA_Games fg
    ON fg.memberId = cm.id

WHERE
    NOT EXISTS (
        SELECT 1
        FROM SessionPlayers sp
        WHERE sp.memberId = cm.id
    )

    AND COALESCE((
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
                CONCAT(
                    YEAR(CURDATE()) - 1,
                    '-12-31'
                ),
                '%Y-%m-%d'
            )
        ) >= 18
        THEN 200
        ELSE 100
    END

GROUP BY
    cm.id,
    p.firstName,
    p.lastName,
    p.birthDate,
    p.phoneNumber,
    p.email,
    l.name

ORDER BY
    l.name ASC,
    fifaParticipationCount ASC,
    p.lastName ASC,
    p.firstName ASC;
";

$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . htmlspecialchars($conn->error));
}

?>

<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <title>Query 13 - Unassigned Active FIFA Members</title>
</head>

<body>

<a href="../index.php">Home</a>

<h1>Query 13</h1>

<h2>Unassigned Active Members Participating in FIFA Games</h2>

<p>
This report displays active club members who participated in at least one
FIFA game but have never been assigned to any team formation session.
</p>

<table border="1" cellpadding="5" cellspacing="0">

<tr>
    <th>Membership Number</th>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Age</th>
    <th>Phone Number</th>
    <th>Email</th>
    <th>FIFA Participations</th>
    <th>Current Location</th>
</tr>

<?php if ($result->num_rows > 0): ?>

    <?php while ($row = $result->fetch_assoc()): ?>

        <tr>

            <td>
                <?= htmlspecialchars($row["membershipNumber"] ?? "") ?>
            </td>

            <td>
                <?= htmlspecialchars($row["firstName"] ?? "") ?>
            </td>

            <td>
                <?= htmlspecialchars($row["lastName"] ?? "") ?>
            </td>

            <td>
                <?= htmlspecialchars($row["age"] ?? "") ?>
            </td>

            <td>
                <?= htmlspecialchars($row["phoneNumber"] ?? "") ?>
            </td>

            <td>
                <?= htmlspecialchars($row["email"] ?? "") ?>
            </td>

            <td>
                <?= htmlspecialchars($row["fifaParticipationCount"] ?? "") ?>
            </td>

            <td>
                <?= htmlspecialchars($row["locationName"] ?? "") ?>
            </td>

        </tr>

    <?php endwhile; ?>

<?php else: ?>

    <tr>
        <td colspan="8">
            No club members satisfy the Query 13 requirements.
        </td>
    </tr>

<?php endif; ?>

</table>

</body>

</html>
