<?php

require_once("../database.php");

$message = "";


/*
====================================================
CREATE TEAM FORMATION
====================================================
*/

if (isset($_POST["create"])) {

    $locationId = $_POST["locationId"];
    $headCoachId = $_POST["headCoachId"];
    $teamName = $_POST["teamName"];

    $sql = "
        INSERT INTO TeamFormations
        (locationId, headCoachId, teamName)
        VALUES
        ('$locationId', '$headCoachId', '$teamName')
    ";

    try {

        $conn->query($sql);

        $message = "Team formation created successfully.";

    }
    catch (mysqli_sql_exception $e) {

        $message = "Database error: " . $e->getMessage();

    }
}


/*
====================================================
DELETE TEAM FORMATION
====================================================
*/

if (isset($_POST["delete"])) {

    $id = $_POST["id"];

    try {

        /*
        Delete players first because of the
        foreign key relationship.
        */

        $conn->query("
            DELETE FROM TeamFormationPlayers
            WHERE formationId = $id
        ");

        $conn->query("
            DELETE FROM TeamFormations
            WHERE id = $id
        ");

        $message = "Team formation deleted successfully.";

    }
    catch (mysqli_sql_exception $e) {

        $message = "Database error: " . $e->getMessage();

    }
}


/*
====================================================
ADD PLAYER TO FORMATION
====================================================
*/

if (isset($_POST["addPlayer"])) {

    $formationId = $_POST["formationId"];
    $memberId = $_POST["memberId"];
    $role = $_POST["role"];

    $sql = "
        INSERT INTO TeamFormationPlayers
        (formationId, memberId, role)
        VALUES
        ('$formationId', '$memberId', '$role')
    ";

    try {

        $conn->query($sql);

        $message = "Player added successfully.";

    }
    catch (mysqli_sql_exception $e) {

        $message = "Database error: " . $e->getMessage();

    }
}


/*
====================================================
REMOVE PLAYER
====================================================
*/

if (isset($_POST["removePlayer"])) {

    $formationId = $_POST["formationId"];
    $memberId = $_POST["memberId"];

    try {

        $conn->query("
            DELETE FROM TeamFormationPlayers
            WHERE formationId = $formationId
            AND memberId = $memberId
        ");

        $message = "Player removed successfully.";

    }
    catch (mysqli_sql_exception $e) {

        $message = "Database error: " . $e->getMessage();

    }
}

?>


<!DOCTYPE html>

<html>

<head>

    <title>Manage Team Formations</title>

</head>


<body>


<a href="../index.php">Home</a>


<h1>Manage Team Formations</h1>


<?php

if (!empty($message)) {

    echo "<p><strong>$message</strong></p>";

}

?>


<!--
====================================================
CREATE FORMATION
====================================================
-->

<h2>Create Team Formation</h2>


<form method="post">


Location:

<select name="locationId" required>

<?php

$result = $conn->query("
    SELECT id, name, city
    FROM Locations
    ORDER BY name
");

while ($row = $result->fetch_assoc()) {

    echo "
        <option value='".$row["id"]."'>
            ".$row["name"]." - ".$row["city"]."
        </option>
    ";

}

?>

</select>


<br><br>


Head Coach:

<select name="headCoachId" required>

<?php

$result = $conn->query("
    SELECT
        p.id,
        p.firstName,
        p.lastName
    FROM Personnel pe
    JOIN Population p
        ON pe.id = p.id
    ORDER BY p.lastName, p.firstName
");

while ($row = $result->fetch_assoc()) {

    echo "
        <option value='".$row["id"]."'>
            ".$row["firstName"]." ".$row["lastName"]."
        </option>
    ";

}

?>

</select>


<br><br>


Team Name:

<input
    type="text"
    name="teamName"
    maxlength="50"
    required
>


<br><br>


<button name="create">

Create Team

</button>


</form>


<hr>


<!--
====================================================
LIST FORMATIONS
====================================================
-->

<h2>Team Formations</h2>


<?php

$result = $conn->query("

    SELECT

        tf.id,

        tf.teamName,

        l.name AS locationName,

        CONCAT(p.firstName, ' ', p.lastName)
            AS coachName,

        COUNT(tfp.memberId) AS playerCount

    FROM TeamFormations tf

    JOIN Locations l
        ON tf.locationId = l.id

    JOIN Personnel pe
        ON tf.headCoachId = pe.id

    JOIN Population p
        ON pe.id = p.id

    LEFT JOIN TeamFormationPlayers tfp
        ON tf.id = tfp.formationId

    GROUP BY
        tf.id,
        tf.teamName,
        l.name,
        p.firstName,
        p.lastName

    ORDER BY tf.teamName

");


echo "<table border='1'>";


echo "

<tr>

    <th>ID</th>

    <th>Team</th>

    <th>Location</th>

    <th>Head Coach</th>

    <th>Players</th>

    <th>Actions</th>

</tr>

";


while ($row = $result->fetch_assoc()) {

    echo "<tr>";

    echo "<td>".$row["id"]."</td>";

    echo "<td>".$row["teamName"]."</td>";

    echo "<td>".$row["locationName"]."</td>";

    echo "<td>".$row["coachName"]."</td>";

    echo "<td>".$row["playerCount"]."</td>";

    echo "<td>";

    echo "
        <a href='?manage=".$row["id"]."'>
            Manage Players
        </a>
    ";

    echo "<br>";

    echo "

        <form method='post'>

            <input
                type='hidden'
                name='id'
                value='".$row["id"]."'
            >

            <button
                name='delete'
                onclick=\"return confirm('Delete this team formation?');\"
            >
                Delete
            </button>

        </form>

    ";

    echo "</td>";

    echo "</tr>";

}


echo "</table>";

?>


<br>


<?php

/*
====================================================
MANAGE PLAYERS
====================================================
*/

if (isset($_GET["manage"])) {

    $formationId = $_GET["manage"];


    /*
    Get formation information
    */

    $formationResult = $conn->query("

        SELECT

            tf.id,

            tf.teamName,

            tf.locationId,

            l.name AS locationName,

            CONCAT(p.firstName, ' ', p.lastName)
                AS coachName

        FROM TeamFormations tf

        JOIN Locations l
            ON tf.locationId = l.id

        JOIN Personnel pe
            ON tf.headCoachId = pe.id

        JOIN Population p
            ON pe.id = p.id

        WHERE tf.id = $formationId

    ");

    $formation = $formationResult->fetch_assoc();


    echo "<hr>";

    echo "<h2>";
    echo "Manage Players: ".$formation["teamName"];
    echo "</h2>";

    echo "<p>";
    echo "Location: ".$formation["locationName"];
    echo "</p>";

    echo "<p>";
    echo "Head Coach: ".$formation["coachName"];
    echo "</p>";


    /*
    ================================================
    ADD PLAYER
    ================================================
    */

    echo "<h3>Add Player</h3>";


    echo "

    <form method='post'>

        <input
            type='hidden'
            name='formationId'
            value='".$formationId."'
        >

        Player:

        <select name='memberId' required>

    ";


    /*
    Only show members registered at
    this formation's location.
    */

    $members = $conn->query("

        SELECT DISTINCT

            cm.id,

            p.firstName,

            p.lastName

        FROM ClubMembers cm

        JOIN Population p
            ON cm.id = p.id

        JOIN ClubMemberRegistrations cmr
            ON cm.id = cmr.memberId

        WHERE cmr.locationId = ".$formation["locationId"]."

        AND (
            cmr.endDate IS NULL
            OR cmr.endDate >= CURDATE()
        )

        ORDER BY
            p.lastName,
            p.firstName

    ");


    while ($member = $members->fetch_assoc()) {

        echo "

            <option value='".$member["id"]."'>

                ".$member["firstName"]."
                ".$member["lastName"]."

            </option>

        ";

    }


    echo "

        </select>

        <br><br>

        Role:

        <select name='role' required>

    ";


    $roles = [

        "Goalkeeper",
        "Right Fullback",
        "Left Fullback",
        "Center Back",
        "Sweeper",
        "Defending Midfielder",
        "Right Midfielder",
        "Central Midfielder",
        "Attacking Midfielder",
        "Left Winger",
        "Striker"

    ];


    foreach ($roles as $role) {

        echo "
            <option value='$role'>
                $role
            </option>
        ";

    }


    echo "

        </select>

        <br><br>

        <button name='addPlayer'>
            Add Player
        </button>

    </form>

    ";


    /*
    ================================================
    CURRENT PLAYERS
    ================================================
    */

    echo "<h3>Current Players</h3>";


    $players = $conn->query("

        SELECT

            tfp.memberId,

            tfp.role,

            p.firstName,

            p.lastName

        FROM TeamFormationPlayers tfp

        JOIN Population p
            ON tfp.memberId = p.id

        WHERE tfp.formationId = $formationId

        ORDER BY
            p.lastName,
            p.firstName

    ");


    echo "<table border='1'>";


    echo "

    <tr>

        <th>Player</th>

        <th>Role</th>

        <th>Action</th>

    </tr>

    ";


    while ($player = $players->fetch_assoc()) {

        echo "<tr>";


        echo "

        <td>
            ".$player["firstName"]."
            ".$player["lastName"]."
        </td>

        ";


        echo "

        <td>
            ".$player["role"]."
        </td>

        ";


        echo "<td>";


        echo "

        <form method='post'>

            <input
                type='hidden'
                name='formationId'
                value='".$formationId."'
            >

            <input
                type='hidden'
                name='memberId'
                value='".$player["memberId"]."'
            >

            <button
                name='removePlayer'
                onclick=\"return confirm('Remove this player?');\"
            >
                Remove
            </button>

        </form>

        ";


        echo "</td>";

        echo "</tr>";

    }


    echo "</table>";

}

?>


</body>

</html>
