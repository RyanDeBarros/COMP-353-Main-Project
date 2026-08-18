<?php

require_once("../database.php");

$sql = "
SELECT
    l.id AS locationId,
    l.name AS locationName,
    l.address,
    l.city,
    l.province,
    l.postalCode,

    GROUP_CONCAT(
        DISTINCT lpn.phoneNumber
        ORDER BY lpn.phoneNumber
        SEPARATOR ', '
    ) AS phoneNumber,

    l.webAddress,
    l.type,
    l.maxCapacity AS capacity,

    CONCAT(gmPop.firstName, ' ', gmPop.lastName) AS generalManagerName,

    COUNT(DISTINCT CASE
        WHEN TIMESTAMPDIFF(YEAR, p.birthDate, CURDATE()) < 18
        THEN cm.id
    END) AS totalMinorMembers,

    COUNT(DISTINCT CASE
        WHEN TIMESTAMPDIFF(YEAR, p.birthDate, CURDATE()) >= 18
        THEN cm.id
    END) AS totalMajorMembers,

    COUNT(DISTINCT fg.memberId) AS totalFifaParticipants

FROM Locations l

LEFT JOIN LocationPhoneNumbers lpn
    ON lpn.locationId = l.id

LEFT JOIN ClubMemberRegistrations cmr
    ON cmr.locationId = l.id
   AND cmr.endDate IS NULL

LEFT JOIN ClubMembers cm
    ON cm.id = cmr.memberId

LEFT JOIN Population p
    ON p.id = cm.id

LEFT JOIN FIFA_Games fg
    ON fg.memberId = cm.id

LEFT JOIN PersonnelOperations gmOp
    ON gmOp.locationId = l.id
   AND gmOp.endDate IS NULL
   AND gmOp.role = 'Administrator'
   AND gmOp.title = 'General Manager'

LEFT JOIN Personnel gm
    ON gm.id = gmOp.personnelId

LEFT JOIN Population gmPop
    ON gmPop.id = gm.id

GROUP BY
    l.id,
    l.name,
    l.address,
    l.city,
    l.province,
    l.postalCode,
    l.webAddress,
    l.type,
    l.maxCapacity,
    gmPop.firstName,
    gmPop.lastName

HAVING COUNT(DISTINCT fg.memberId) >= 2

ORDER BY totalFifaParticipants DESC;
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
    <title>Query 8 - Location FIFA Report</title>
</head>

<body>

<a href="../index.php">Home</a>

<h1>Query 8</h1>

<h2>Locations with at Least Two FIFA Game Participants</h2>

<table border="1" cellpadding="5" cellspacing="0">

<tr>
    <th>Location</th>
    <th>Address</th>
    <th>City</th>
    <th>Province</th>
    <th>Postal Code</th>
    <th>Phone Number</th>
    <th>Web Address</th>
    <th>Type</th>
    <th>Capacity</th>
    <th>General Manager</th>
    <th>Minor Members</th>
    <th>Major Members</th>
    <th>FIFA Participants</th>
</tr>

<?php while ($row = $result->fetch_assoc()): ?>

<tr>

    <td><?= htmlspecialchars($row["locationName"] ?? "") ?></td>

    <td><?= htmlspecialchars($row["address"] ?? "") ?></td>

    <td><?= htmlspecialchars($row["city"] ?? "") ?></td>

    <td><?= htmlspecialchars($row["province"] ?? "") ?></td>

    <td><?= htmlspecialchars($row["postalCode"] ?? "") ?></td>

    <td><?= htmlspecialchars($row["phoneNumber"] ?? "") ?></td>

    <td><?= htmlspecialchars($row["webAddress"] ?? "") ?></td>

    <td><?= htmlspecialchars($row["type"] ?? "") ?></td>

    <td><?= htmlspecialchars($row["capacity"] ?? "") ?></td>

    <td><?= htmlspecialchars($row["generalManagerName"] ?? "") ?></td>

    <td><?= htmlspecialchars($row["totalMinorMembers"] ?? "") ?></td>

    <td><?= htmlspecialchars($row["totalMajorMembers"] ?? "") ?></td>

    <td><?= htmlspecialchars($row["totalFifaParticipants"] ?? "") ?></td>

</tr>

<?php endwhile; ?>

</table>

</body>
</html>
