<?php

require_once("../database.php");

$locations = $conn->query("
    SELECT id, name
    FROM Locations
    ORDER BY name
");

$selectedLocation = isset($_GET["locationId"])
    ? (int) $_GET["locationId"]
    : 1;

$startDate = isset($_GET["startDate"])
    ? $_GET["startDate"]
    : "2026-01-01";

$endDate = isset($_GET["endDate"])
    ? $_GET["endDate"]
    : "2026-05-31";

$stmt = $conn->prepare("
    SELECT
        ts.id AS sessionId,

        CONCAT(
            coachPop.firstName,
            ' ',
            coachPop.lastName
        ) AS headCoachName,

        ts.startTime AS sessionStartTime,

        ts.address AS sessionAddress,

        ts.sessionType AS sessionNature,

        tf.teamName,

        CASE
            WHEN ts.startTime > NOW()
            THEN NULL
            ELSE CONCAT(
                COALESCE(ts.team1Score, ''),
                ' - ',
                COALESCE(ts.team2Score, '')
            )
        END AS score,

        (
            SELECT COUNT(*)
            FROM SessionPlayers spCount
            WHERE spCount.sessionId = ts.id
              AND spCount.formationId = tf.id
        ) AS totalPlayerCount,

        playerPop.firstName AS playerFirstName,

        playerPop.lastName AS playerLastName,

        sp.role AS playerRole

    FROM TeamSessions ts

    JOIN TeamFormations tf
        ON (
            tf.id = ts.team1
            OR tf.id = ts.team2
        )

    JOIN Personnel coach
        ON coach.id = tf.headCoachId

    JOIN Population coachPop
        ON coachPop.id = coach.id

    LEFT JOIN SessionPlayers sp
        ON sp.sessionId = ts.id
       AND sp.formationId = tf.id

    LEFT JOIN ClubMembers cm
        ON cm.id = sp.memberId

    LEFT JOIN Population playerPop
        ON playerPop.id = cm.id

    WHERE tf.locationId = ?

      AND DATE(ts.startTime)
          BETWEEN ? AND ?

    ORDER BY
        ts.startTime ASC,
        tf.teamName ASC,
        playerPop.lastName ASC,
        playerPop.firstName ASC
");

$stmt->bind_param(
    "iss",
    $selectedLocation,
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
    <title>Query 10 - Team Formation Details</title>
</head>

<body>

<a href="../index.php">Home</a>

<h1>Query 10</h1>

<h2>Team Formation Details for a Location and Time Period</h2>


<form method="get">

    <label>Location:</label>

    <select name="locationId">

        <?php while ($location = $locations->fetch_assoc()): ?>

            <option
                value="<?= htmlspecialchars($location["id"]) ?>"
                <?= $selectedLocation == $location["id"]
                    ? "selected"
                    : "" ?>
            >
                <?= htmlspecialchars($location["name"]) ?>
            </option>

        <?php endwhile; ?>

    </select>


    <label>Start Date:</label>

    <input
        type="date"
        name="startDate"
        value="<?= htmlspecialchars($startDate) ?>"
    >


    <label>End Date:</label>

    <input
        type="date"
        name="endDate"
        value="<?= htmlspecialchars($endDate) ?>"
    >


    <button type="submit">
        Run Query
    </button>

</form>


<br>


<table border="1" cellpadding="5" cellspacing="0">

<tr>

    <th>Head Coach</th>
    <th>Session Start Time</th>
    <th>Address</th>
    <th>Session Nature</th>
    <th>Team Name</th>
    <th>Score</th>
    <th>Total Players</th>
    <th>Player First Name</th>
    <th>Player Last Name</th>
    <th>Player Role</th>

</tr>


<?php if ($result->num_rows > 0): ?>

    <?php while ($row = $result->fetch_assoc()): ?>

        <tr>

            <td>
                <?= htmlspecialchars($row["headCoachName"] ?? "") ?>
            </td>

            <td>
                <?= htmlspecialchars($row["sessionStartTime"] ?? "") ?>
            </td>

            <td>
                <?= htmlspecialchars($row["sessionAddress"] ?? "") ?>
            </td>

            <td>
                <?= htmlspecialchars($row["sessionNature"] ?? "") ?>
            </td>

            <td>
                <?= htmlspecialchars($row["teamName"] ?? "") ?>
            </td>

            <td>
                <?= htmlspecialchars($row["score"] ?? "NULL") ?>
            </td>

            <td>
                <?= htmlspecialchars($row["totalPlayerCount"] ?? "") ?>
            </td>

            <td>
                <?= htmlspecialchars($row["playerFirstName"] ?? "") ?>
            </td>

            <td>
                <?= htmlspecialchars($row["playerLastName"] ?? "") ?>
            </td>

            <td>
                <?= htmlspecialchars($row["playerRole"] ?? "") ?>
            </td>

        </tr>

    <?php endwhile; ?>

<?php else: ?>

    <tr>
        <td colspan="10">
            No team formations were found for this location and date range.
        </td>
    </tr>

<?php endif; ?>


</table>


</body>

</html>
