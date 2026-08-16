<?php

require_once("../database.php");

$message = "";
$emails = [];

if (isset($_POST["generate"])) {

    $startDate = $_POST["startDate"];
    $endDate = $_POST["endDate"];


    /*
    Clear previous generated emails.
    */

    try {

        $conn->query("DELETE FROM EmailLogs");

    } catch (mysqli_sql_exception $e) {

        $message = "Could not clear email log: " . $e->getMessage();

    }


    /*
    Validate dates.
    */

    if (empty($startDate) || empty($endDate)) {

        $message = "Please select both a start date and an end date.";

    } elseif ($startDate > $endDate) {

        $message = "Start date cannot be after end date.";

    } else {

        /*
        Get all sessions within the date range.

        Each session has two teams.
        We use UNION ALL to turn team1 and team2
        into individual team/session combinations.
        */

        $sql = "

            SELECT
                ts.id AS sessionId,
                ts.sessionType,
                ts.startTime,
                ts.address,

                tf.id AS formationId,
                tf.teamName,

                tf.headCoachId,

                coach.firstName AS coachFirstName,
                coach.lastName AS coachLastName,
                coach.email AS coachEmail

            FROM TeamSessions ts

            JOIN TeamFormations tf
                ON ts.team1 = tf.id

            JOIN Population coach
                ON tf.headCoachId = coach.id

            WHERE DATE(ts.startTime)
                BETWEEN '$startDate' AND '$endDate'


            UNION ALL


            SELECT
                ts.id AS sessionId,
                ts.sessionType,
                ts.startTime,
                ts.address,

                tf.id AS formationId,
                tf.teamName,

                tf.headCoachId,

                coach.firstName AS coachFirstName,
                coach.lastName AS coachLastName,
                coach.email AS coachEmail

            FROM TeamSessions ts

            JOIN TeamFormations tf
                ON ts.team2 = tf.id

            JOIN Population coach
                ON tf.headCoachId = coach.id

            WHERE DATE(ts.startTime)
                BETWEEN '$startDate' AND '$endDate'

            ORDER BY startTime

        ";


        try {

            $result = $conn->query($sql);


            /*
            Each row represents one team
            participating in one session.
            */

            while ($session = $result->fetch_assoc()) {


                /*
                Find all players on this team.
                */

                $players = $conn->query("

                    SELECT

                        tfp.memberId,

                        tfp.role,

                        p.firstName,
                        p.lastName

                    FROM TeamFormationPlayers tfp

                    JOIN Population p
                        ON tfp.memberId = p.id

                    WHERE tfp.formationId =
                        ".$session["formationId"]."

                    ORDER BY
                        p.lastName,
                        p.firstName

                ");


                while ($player = $players->fetch_assoc()) {


                    /*
                    Format date/time for email subject.
                    */

                    $dateTime = new DateTime(
                        $session["startTime"]
                    );

                    $datePart = $dateTime->format(
                        "l d-F-Y"
                    );

                    $timePart = $dateTime->format(
                        "g:i A"
                    );


                    /*
                    Training / game.
                    */

                    $sessionType =
                        strtolower(
                            $session["sessionType"]
                        );


                    /*
                    Subject:
                    Montreal Group 6 Saturday 18-July-2026
                    2:00 PM training session
                    */

                    $subject =
                        $session["teamName"]
                        ." "
                        .$datePart
                        ." "
                        .$timePart
                        ." "
                        .$sessionType
                        ." session";


                    /*
                    Email body.
                    */

                    $body =

                        "Club Member: "
                        .$player["firstName"]
                        ." "
                        .$player["lastName"]
                        ."\n\n"

                        ."Role: "
                        .$player["role"]
                        ."\n\n"

                        ."Head Coach: "
                        .$session["coachFirstName"]
                        ." "
                        .$session["coachLastName"]
                        ."\n\n"

                        ."Head Coach Email: "
                        .$session["coachEmail"]
                        ."\n\n"

                        ."Session Type: "
                        .$session["sessionType"]
                        ."\n\n"

                        ."Address: "
                        .$session["address"];


                    /*
                    EmailLogs only stores a preview.
                    */

                    $bodyPreview = substr(
                        preg_replace(
                            '/\s+/',
                            ' ',
                            trim($body)
                        ),
                        0,
                        100
                    );


                    /*
                    Simulated sender.

                    Since we're not actually sending
                    emails, this is just a value for
                    the EmailLogs table.
                    */

                    $sender = "club@comp353.com";

                    $receiver = $player["firstName"]
                        ." "
                        .$player["lastName"];


                    /*
                    Insert into EmailLogs.
                    */

                    $insert = $conn->prepare("

                        INSERT INTO EmailLogs
                        (
                            sentDate,
                            sender,
                            receiver,
                            subject,
                            bodyPreview
                        )

                        VALUES
                        (
                            NOW(),
                            ?,
                            ?,
                            ?,
                            ?
                        )

                    ");


                    $insert->bind_param(
                        "ssss",
                        $sender,
                        $receiver,
                        $subject,
                        $bodyPreview
                    );


                    $insert->execute();

                    $insert->close();


                    /*
                    Save the complete email so
                    we can display it below.
                    */

                    $emails[] = [

                        "receiver" => $receiver,

                        "subject" => $subject,

                        "body" => $body

                    ];

                }

            }


            $message =
                count($emails)
                ." simulated email(s) generated.";


        } catch (mysqli_sql_exception $e) {

            $message =
                "Database error: "
                .$e->getMessage();

        }

    }

}

?>


<!DOCTYPE html>

<html>

<head>

    <title>Generate Emails</title>

</head>

<body>


<a href="../index.php">Home</a>


<h1>Generate Emails</h1>


<p>
    Generate simulated emails for team sessions
    occurring within a selected date range.
</p>


<form method="post">

    <label for="startDate">
        Start Date:
    </label>

    <input
        type="date"
        id="startDate"
        name="startDate"
        required
    >


    <br><br>


    <label for="endDate">
        End Date:
    </label>

    <input
        type="date"
        id="endDate"
        name="endDate"
        required
    >


    <br><br>


    <button
        type="submit"
        name="generate"
    >
        Generate Emails
    </button>

</form>


<?php if (!empty($message)): ?>

    <hr>

    <p>
        <strong>
            <?= htmlspecialchars($message) ?>
        </strong>
    </p>

<?php endif; ?>


<?php if (!empty($emails)): ?>

    <h2>Generated Emails</h2>


    <?php foreach ($emails as $email): ?>

        <div
            style="
                border: 1px solid black;
                padding: 15px;
                margin: 15px 0;
            "
        >

            <p>
                <strong>To:</strong>

                <?= htmlspecialchars(
                    $email["receiver"]
                ) ?>

            </p>


            <p>
                <strong>Subject:</strong>

                <?= htmlspecialchars(
                    $email["subject"]
                ) ?>

            </p>


            <hr>


            <pre><?= htmlspecialchars(
                $email["body"]
            ) ?></pre>

        </div>

    <?php endforeach; ?>

<?php endif; ?>


<h2>Email Log</h2>


<table border="1">

    <tr>

        <th>ID</th>

        <th>Sent Date</th>

        <th>Sender</th>

        <th>Receiver</th>

        <th>Subject</th>

        <th>Body Preview</th>

    </tr>


    <?php

    $result = $conn->query("

        SELECT

            id,
            sentDate,
            sender,
            receiver,
            subject,
            bodyPreview

        FROM EmailLogs

        ORDER BY sentDate DESC

    ");

    ?>


    <?php while ($row = $result->fetch_assoc()): ?>

        <tr>

            <td>
                <?= htmlspecialchars(
                    $row["id"]
                ) ?>
            </td>

            <td>
                <?= htmlspecialchars(
                    $row["sentDate"]
                ) ?>
            </td>

            <td>
                <?= htmlspecialchars(
                    $row["sender"]
                ) ?>
            </td>

            <td>
                <?= htmlspecialchars(
                    $row["receiver"]
                ) ?>
            </td>

            <td>
                <?= htmlspecialchars(
                    $row["subject"]
                ) ?>
            </td>

            <td>
                <?= htmlspecialchars(
                    $row["bodyPreview"]
                ) ?>
            </td>

        </tr>

    <?php endwhile; ?>

</table>


</body>

</html>
