<?php

require_once("../database.php");

$sql = "
SELECT
    cm.id AS membershipNumber,
    p.firstName,
    p.lastName,

    COUNT(fg.gameId) AS totalFifaGames,

    MIN(YEAR(fg.date)) AS earliestFifaYear,

    MAX(YEAR(fg.date)) AS latestFifaYear

FROM ClubMembers cm

JOIN Population p
    ON p.id = cm.id

JOIN FIFA_Games fg
    ON fg.memberId = cm.id

GROUP BY
    cm.id,
    p.firstName,
    p.lastName

HAVING COUNT(fg.gameId) >= 5

ORDER BY
    totalFifaGames DESC,
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
    <title>Query 11 - Members with at Least Five FIFA Games</title>
</head>

<body>

<a href="../index.php">Home</a>

<h1>Query 11</h1>

<h2>Members with at Least Five FIFA Game Participations</h2>

<p>
This report displays club members who participated in at least five FIFA
games, together with their total number of participations and the earliest
and latest years in which they participated.
</p>

<table border="1" cellpadding="5" cellspacing="0">

<tr>

    <th>Membership Number</th>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Total FIFA Games</th>
    <th>Earliest FIFA Year</th>
    <th>Latest FIFA Year</th>

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
                <?= htmlspecialchars($row["totalFifaGames"] ?? "") ?>
            </td>

            <td>
                <?= htmlspecialchars($row["earliestFifaYear"] ?? "") ?>
            </td>

            <td>
                <?= htmlspecialchars($row["latestFifaYear"] ?? "") ?>
            </td>

        </tr>

    <?php endwhile; ?>

<?php else: ?>

    <tr>
        <td colspan="6">
            No club members satisfy the Query 11 requirements.
        </td>
    </tr>

<?php endif; ?>

</table>

</body>

</html>
