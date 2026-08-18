<?php

require_once("../database.php");

$startDate = isset($_GET["startDate"])
    ? $_GET["startDate"]
    : "2025-01-01";

$endDate = isset($_GET["endDate"])
    ? $_GET["endDate"]
    : "2025-05-31";

$stmt = $conn->prepare("
    SELECT
        l.name AS locationName,

        COUNT(
            DISTINCT CASE
                WHEN ts.sessionType = 'Training'
                THEN ts.id
            END
        ) AS totalTrainingSessions,

        COUNT(
            DISTINCT CASE
                WHEN ts.sessionType = 'Training'
                THEN CONCAT(
                    sp.sessionId,
                    '-',
                    sp.memberId
                )
            END
        ) AS totalTrainingPlayers,

        COUNT(
            DISTINCT CASE
                WHEN ts.sessionType = 'Game'
                THEN ts.id
            END
        ) AS totalGameSessions,

        COUNT(
            DISTINCT CASE
                WHEN ts.sessionType = 'Game'
                THEN CONCAT(
                    sp.sessionId,
                    '-',
                    sp.memberId
                )
            END
        ) AS totalGamePlayers

    FROM Locations l

    JOIN TeamFormations tf
        ON tf.locationId = l.id

    JOIN TeamSessions ts
        ON (
            ts.team1 = tf.id
            OR ts.team2 = tf.id
        )

    LEFT JOIN SessionPlayers sp
        ON sp.sessionId = ts.id
       AND sp.formationId = tf.id

    WHERE DATE(ts.startTime)
          BETWEEN ? AND ?

    GROUP BY
        l.id,
        l.name

    HAVING COUNT(
        DISTINCT CASE
            WHEN ts.sessionType = 'Game'
            THEN ts.id
        END
    ) >= 4

    ORDER BY
        totalGameSessions DESC,
        l.name ASC
");

$stmt->bind_param(
    "ss",
    $startDate,
    $endDate
);

$stmt->execute();

$result = $stmt->get_result();

?>

<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <title>Query 12 - Location Session and Player Statistics</title>
</head>

<body>

<a href="../index.php">Home</a>

<h1>Query 12</h1>

<h2>Location Session and Player Statistics</h2>

<form method="get">

    <label>Start Date:</label>

    <input
        type="date"
        name="startDate"
        value="<?= htmlspecialchars($startDate) ?>"
        required
    >

    <label>End Date:</label>

    <input
        type="date"
        name="endDate"
        value="<?= htmlspecialchars($endDate) ?>"
        required
    >

    <button type="submit">
        Run Query
    </button>

</form>

<br>

<table border="1" cellpadding="5" cellspacing="0">

<tr>
    <th>Location</th>
    <th>Total Training Sessions</th>
    <th>Total Training Players</th>
    <th>Total Game Sessions</th>
    <th>Total Game Players</th>
</tr>

<?php if ($result->num_rows > 0): ?>

    <?php while ($row = $result->fetch_assoc()): ?>

        <tr>

            <td>
                <?= htmlspecialchars($row["locationName"] ?? "") ?>
            </td>

            <td>
                <?= htmlspecialchars($row["totalTrainingSessions"] ?? "") ?>
            </td>

            <td>
                <?= htmlspecialchars($row["totalTrainingPlayers"] ?? "") ?>
            </td>

            <td>
                <?= htmlspecialchars($row["totalGameSessions"] ?? "") ?>
            </td>

            <td>
                <?= htmlspecialchars($row["totalGamePlayers"] ?? "") ?>
            </td>

        </tr>

    <?php endwhile; ?>

<?php else: ?>

    <tr>
        <td colspan="5">
            No locations satisfy the Query 12 requirements for this period.
        </td>
    </tr>

<?php endif; ?>

</table>

</body>

</html>
