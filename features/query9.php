<?php

require_once("../database.php");

$sql = "
SELECT
    pfm.firstName AS primaryFirstName,
    pfm.lastName AS primaryLastName,
    cm.id AS membershipNumber,
    childP.firstName AS memberFirstName,
    childP.lastName AS memberLastName,
    childP.birthDate AS memberDOB,
    fma.relationship AS memberRelationship

FROM FamilyMemberAssociations fma

JOIN Population pfm
    ON pfm.id = fma.familyId

JOIN ClubMembers cm
    ON cm.id = fma.childId

JOIN Population childP
    ON childP.id = cm.id

WHERE
    fma.familyType = 'Primary'

    AND fma.endDate IS NULL

    AND EXISTS (
        SELECT 1
        FROM FIFA_Games fg
        WHERE fg.memberId = cm.id
    )

    AND fma.familyId IN (

        SELECT fma_sub.familyId

        FROM FamilyMemberAssociations fma_sub

        WHERE
            fma_sub.familyType = 'Primary'
            AND fma_sub.endDate IS NULL

            AND EXISTS (
                SELECT 1
                FROM FIFA_Games fg_sub
                WHERE fg_sub.memberId = fma_sub.childId
            )

        GROUP BY fma_sub.familyId

        HAVING COUNT(DISTINCT fma_sub.childId) >= 2
    )

ORDER BY
    pfm.firstName ASC,
    pfm.lastName ASC,
    childP.lastName ASC,
    childP.firstName ASC;
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
    <title>Query 9 - Primary Family Members with FIFA Participants</title>
</head>

<body>

<a href="../index.php">Home</a>

<h1>Query 9</h1>

<h2>Primary Family Members with FIFA Game Participants</h2>

<p>
This report displays primary family members who have at least two associated
club members who participated in at least one FIFA game.
</p>

<table border="1" cellpadding="5" cellspacing="0">

<tr>
    <th>Primary First Name</th>
    <th>Primary Last Name</th>
    <th>Membership Number</th>
    <th>Member First Name</th>
    <th>Member Last Name</th>
    <th>Date of Birth</th>
    <th>Relationship</th>
</tr>

<?php if ($result->num_rows > 0): ?>

    <?php while ($row = $result->fetch_assoc()): ?>

    <tr>

        <td>
            <?= htmlspecialchars($row["primaryFirstName"] ?? "") ?>
        </td>

        <td>
            <?= htmlspecialchars($row["primaryLastName"] ?? "") ?>
        </td>

        <td>
            <?= htmlspecialchars($row["membershipNumber"] ?? "") ?>
        </td>

        <td>
            <?= htmlspecialchars($row["memberFirstName"] ?? "") ?>
        </td>

        <td>
            <?= htmlspecialchars($row["memberLastName"] ?? "") ?>
        </td>

        <td>
            <?= htmlspecialchars($row["memberDOB"] ?? "") ?>
        </td>

        <td>
            <?= htmlspecialchars($row["memberRelationship"] ?? "") ?>
        </td>

    </tr>

    <?php endwhile; ?>

<?php else: ?>

    <tr>
        <td colspan="7">
            No primary family members satisfy the Query 9 requirements.
        </td>
    </tr>

<?php endif; ?>

</table>

</body>

</html>
