<?php

require_once("../database.php");


/* =========================================================
   BONUS FEATURE
   CSCS MANAGEMENT ANALYTICS DASHBOARD
   ========================================================= */


/* =========================================================
   GENERAL STATISTICS
   ========================================================= */

$totalMembers = $conn->query("
    SELECT COUNT(*) AS total
    FROM ClubMembers
")->fetch_assoc()["total"];


$totalLocations = $conn->query("
    SELECT COUNT(*) AS total
    FROM Locations
")->fetch_assoc()["total"];


$totalPersonnel = $conn->query("
    SELECT COUNT(*) AS total
    FROM Personnel
")->fetch_assoc()["total"];


/* =========================================================
   MAJOR / MINOR MEMBERS
   ========================================================= */

$ageStats = $conn->query("
    SELECT

        SUM(
            CASE
                WHEN TIMESTAMPDIFF(
                    YEAR,
                    p.birthDate,
                    CURDATE()
                ) >= 18
                THEN 1
                ELSE 0
            END
        ) AS majors,

        SUM(
            CASE
                WHEN TIMESTAMPDIFF(
                    YEAR,
                    p.birthDate,
                    CURDATE()
                ) BETWEEN 4 AND 17
                THEN 1
                ELSE 0
            END
        ) AS minors

    FROM ClubMembers cm

    JOIN Population p
        ON p.id = cm.id
")->fetch_assoc();

$majorMembers = $ageStats["majors"] ?? 0;
$minorMembers = $ageStats["minors"] ?? 0;


/* =========================================================
   ACTIVE / INACTIVE MEMBERS
   ========================================================= */

$statusStats = $conn->query("
    SELECT

        SUM(
            CASE
                WHEN COALESCE((
                    SELECT SUM(pay.amount)
                    FROM Payments pay
                    WHERE pay.memberId = cm.id
                      AND YEAR(pay.dueDate) =
                          YEAR(CURDATE()) - 1
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

                THEN 1
                ELSE 0
            END
        ) AS activeMembers,

        SUM(
            CASE
                WHEN COALESCE((
                    SELECT SUM(pay.amount)
                    FROM Payments pay
                    WHERE pay.memberId = cm.id
                      AND YEAR(pay.dueDate) =
                          YEAR(CURDATE()) - 1
                ), 0) <

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

                THEN 1
                ELSE 0
            END
        ) AS inactiveMembers

    FROM ClubMembers cm

    JOIN Population p
        ON p.id = cm.id
")->fetch_assoc();

$activeMembers = $statusStats["activeMembers"] ?? 0;
$inactiveMembers = $statusStats["inactiveMembers"] ?? 0;


/* =========================================================
   PERSONNEL STATISTICS
   ========================================================= */

$personnelStats = $conn->query("
    SELECT

        COUNT(DISTINCT CASE
            WHEN mandate = 'volunteer'
            THEN personnelId
        END) AS volunteers,

        COUNT(DISTINCT CASE
            WHEN mandate = 'salaried'
            THEN personnelId
        END) AS salaried

    FROM PersonnelOperations

    WHERE endDate IS NULL
")->fetch_assoc();

$volunteers = $personnelStats["volunteers"] ?? 0;
$salaried = $personnelStats["salaried"] ?? 0;


/* =========================================================
   FIFA PARTICIPANTS
   ========================================================= */

$fifaParticipants = $conn->query("
    SELECT COUNT(DISTINCT memberId) AS total
    FROM FIFA_Games
")->fetch_assoc()["total"];


/* =========================================================
   UPCOMING SESSIONS
   ========================================================= */

$upcomingSessions = $conn->query("
    SELECT COUNT(*) AS total
    FROM TeamSessions
    WHERE startTime >= NOW()
")->fetch_assoc()["total"];


/* =========================================================
   PAYMENT STATISTICS
   ========================================================= */

$paymentStats = $conn->query("
    SELECT
        COALESCE(SUM(amount), 0) AS totalPayments
    FROM Payments
")->fetch_assoc();

$totalPayments = $paymentStats["totalPayments"] ?? 0;


/* =========================================================
   DONATIONS
   ========================================================= */

$donationResult = $conn->query("
    SELECT
        COALESCE(SUM(
            CASE
                WHEN yearlyPayments > requiredFee
                THEN yearlyPayments - requiredFee
                ELSE 0
            END
        ), 0) AS donations

    FROM (

        SELECT
            pay.memberId,
            YEAR(pay.dueDate) AS membershipYear,
            SUM(pay.amount) AS yearlyPayments,

            CASE
                WHEN TIMESTAMPDIFF(
                    YEAR,
                    p.birthDate,
                    STR_TO_DATE(
                        CONCAT(
                            YEAR(pay.dueDate),
                            '-12-31'
                        ),
                        '%Y-%m-%d'
                    )
                ) >= 18
                THEN 200
                ELSE 100
            END AS requiredFee

        FROM Payments pay

        JOIN Population p
            ON p.id = pay.memberId

        GROUP BY
            pay.memberId,
            YEAR(pay.dueDate),
            p.birthDate

    ) paymentYears
")->fetch_assoc();

$totalDonations = $donationResult["donations"] ?? 0;


/* =========================================================
   LOCATION UTILIZATION
   ========================================================= */

$locationStats = $conn->query("
    SELECT
        l.id,
        l.name,
        l.type,
        l.city,
        l.maxCapacity,

        COUNT(
            DISTINCT CASE
                WHEN cmr.endDate IS NULL
                THEN cmr.memberId
            END
        ) AS currentMembers

    FROM Locations l

    LEFT JOIN ClubMemberRegistrations cmr
        ON cmr.locationId = l.id

    GROUP BY
        l.id,
        l.name,
        l.type,
        l.city,
        l.maxCapacity

    ORDER BY
        l.name ASC
");


/* =========================================================
   UPCOMING SESSION LIST
   ========================================================= */

$nextSessions = $conn->query("
    SELECT
        ts.id,
        ts.startTime,
        ts.sessionType,
        ts.address,
        tf1.teamName AS team1Name,
        tf2.teamName AS team2Name

    FROM TeamSessions ts

    JOIN TeamFormations tf1
        ON tf1.id = ts.team1

    JOIN TeamFormations tf2
        ON tf2.id = ts.team2

    WHERE ts.startTime >= NOW()

    ORDER BY ts.startTime ASC

    LIMIT 5
");


/* =========================================================
   RECENT EMAIL LOGS
   ========================================================= */

$recentEmails = $conn->query("
    SELECT
        sentDate,
        sender,
        receiver,
        subject

    FROM EmailLogs

    ORDER BY sentDate DESC

    LIMIT 5
");

?>

<!DOCTYPE html>

<html>

<head>

    <title>CSCS Management Dashboard</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background-color: #f5f5f5;
        }

        h1 {
            margin-bottom: 5px;
        }

        .subtitle {
            margin-bottom: 30px;
        }

        .cards {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 35px;
        }

        .card {
            background: white;
            border: 1px solid #cccccc;
            border-radius: 8px;
            padding: 20px;
            width: 180px;
            text-align: center;
        }

        .number {
            font-size: 30px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .label {
            font-size: 14px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            background: white;
            margin-bottom: 35px;
        }

        th,
        td {
            border: 1px solid #cccccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background: #eeeeee;
        }

        .progress-container {
            width: 150px;
            height: 18px;
            border: 1px solid #999999;
            background: #eeeeee;
        }

        .progress {
            height: 18px;
            background: #555555;
        }

        .section {
            margin-top: 35px;
        }

        .home {
            display: inline-block;
            margin-bottom: 20px;
        }

    </style>

</head>

<body>

<a class="home" href="../index.php">
    Back to Home
</a>

<h1>CSCS Management Analytics Dashboard</h1>

<p class="subtitle">
    Bonus Feature - Real-time overview of Country Soccer Club operations
</p>


<!-- =====================================================
     SUMMARY CARDS
     ===================================================== -->

<div class="cards">

    <div class="card">
        <div class="number">
            <?= htmlspecialchars($totalMembers) ?>
        </div>

        <div class="label">
            Total Members
        </div>
    </div>


    <div class="card">
        <div class="number">
            <?= htmlspecialchars($activeMembers) ?>
        </div>

        <div class="label">
            Active Members
        </div>
    </div>


    <div class="card">
        <div class="number">
            <?= htmlspecialchars($inactiveMembers) ?>
        </div>

        <div class="label">
            Inactive Members
        </div>
    </div>


    <div class="card">
        <div class="number">
            <?= htmlspecialchars($majorMembers) ?>
        </div>

        <div class="label">
            Major Members
        </div>
    </div>


    <div class="card">
        <div class="number">
            <?= htmlspecialchars($minorMembers) ?>
        </div>

        <div class="label">
            Minor Members
        </div>
    </div>


    <div class="card">
        <div class="number">
            <?= htmlspecialchars($totalPersonnel) ?>
        </div>

        <div class="label">
            Personnel
        </div>
    </div>


    <div class="card">
        <div class="number">
            <?= htmlspecialchars($volunteers) ?>
        </div>

        <div class="label">
            Active Volunteers
        </div>
    </div>


    <div class="card">
        <div class="number">
            <?= htmlspecialchars($salaried) ?>
        </div>

        <div class="label">
            Active Salaried Personnel
        </div>
    </div>


    <div class="card">
        <div class="number">
            <?= htmlspecialchars($totalLocations) ?>
        </div>

        <div class="label">
            Locations
        </div>
    </div>


    <div class="card">
        <div class="number">
            <?= htmlspecialchars($fifaParticipants) ?>
        </div>

        <div class="label">
            FIFA Participants
        </div>
    </div>


    <div class="card">
        <div class="number">
            <?= htmlspecialchars($upcomingSessions) ?>
        </div>

        <div class="label">
            Upcoming Sessions
        </div>
    </div>


    <div class="card">
        <div class="number">
            $<?= number_format($totalPayments, 2) ?>
        </div>

        <div class="label">
            Total Payments
        </div>
    </div>


    <div class="card">
        <div class="number">
            $<?= number_format($totalDonations, 2) ?>
        </div>

        <div class="label">
            Total Donations
        </div>
    </div>

</div>


<!-- =====================================================
     LOCATION UTILIZATION
     ===================================================== -->

<div class="section">

<h2>Location Capacity and Utilization</h2>

<table>

<tr>
    <th>Location</th>
    <th>Type</th>
    <th>City</th>
    <th>Current Members</th>
    <th>Maximum Capacity</th>
    <th>Utilization</th>
</tr>

<?php while ($location = $locationStats->fetch_assoc()): ?>

<?php

$capacity = (int) $location["maxCapacity"];
$current = (int) $location["currentMembers"];

if ($capacity > 0) {
    $percentage = round(($current / $capacity) * 100, 1);
} else {
    $percentage = 0;
}

$barPercentage = min($percentage, 100);

?>

<tr>

    <td>
        <?= htmlspecialchars($location["name"]) ?>
    </td>

    <td>
        <?= htmlspecialchars($location["type"]) ?>
    </td>

    <td>
        <?= htmlspecialchars($location["city"]) ?>
    </td>

    <td>
        <?= htmlspecialchars($current) ?>
    </td>

    <td>
        <?= htmlspecialchars($capacity) ?>
    </td>

    <td>

        <?= htmlspecialchars($percentage) ?>%

        <div class="progress-container">

            <div
                class="progress"
                style="width: <?= $barPercentage ?>%;">
            </div>

        </div>

    </td>

</tr>

<?php endwhile; ?>

</table>

</div>


<!-- =====================================================
     UPCOMING SESSIONS
     ===================================================== -->

<div class="section">

<h2>Next Scheduled Sessions</h2>

<table>

<tr>
    <th>Date / Time</th>
    <th>Type</th>
    <th>Team 1</th>
    <th>Team 2</th>
    <th>Address</th>
</tr>

<?php while ($session = $nextSessions->fetch_assoc()): ?>

<tr>

    <td>
        <?= htmlspecialchars($session["startTime"]) ?>
    </td>

    <td>
        <?= htmlspecialchars($session["sessionType"]) ?>
    </td>

    <td>
        <?= htmlspecialchars($session["team1Name"]) ?>
    </td>

    <td>
        <?= htmlspecialchars($session["team2Name"]) ?>
    </td>

    <td>
        <?= htmlspecialchars($session["address"]) ?>
    </td>

</tr>

<?php endwhile; ?>

</table>

</div>


<!-- =====================================================
     EMAIL ACTIVITY
     ===================================================== -->

<div class="section">

<h2>Recent Email Activity</h2>

<table>

<tr>
    <th>Date</th>
    <th>Sender</th>
    <th>Receiver</th>
    <th>Subject</th>
</tr>

<?php while ($email = $recentEmails->fetch_assoc()): ?>

<tr>

    <td>
        <?= htmlspecialchars($email["sentDate"]) ?>
    </td>

    <td>
        <?= htmlspecialchars($email["sender"]) ?>
    </td>

    <td>
        <?= htmlspecialchars($email["receiver"]) ?>
    </td>

    <td>
        <?= htmlspecialchars($email["subject"]) ?>
    </td>

</tr>

<?php endwhile; ?>

</table>

</div>


</body>

</html>