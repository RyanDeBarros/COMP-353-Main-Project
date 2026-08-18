<?php

require_once("../database.php");

$message = "";
$error = "";

/*
    Default form values
*/
$memberId = 5004;
$paymentDate = "2026-08-17";
$amount = "125.00";
$method = "credit";
$dueDate = "2026-12-31";


/*
    Process a new payment
*/
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $memberId = isset($_POST["memberId"])
        ? (int) $_POST["memberId"]
        : 0;

    $paymentDate = $_POST["paymentDate"] ?? "";

    $amount = $_POST["amount"] ?? "";

    $method = $_POST["method"] ?? "";

    $dueDate = $_POST["dueDate"] ?? "";


    $allowedMethods = [
        "cash",
        "debit",
        "credit"
    ];


    if ($memberId <= 0) {

        $error = "Invalid member ID.";

    } elseif ($paymentDate === "") {

        $error = "Payment date is required.";

    } elseif (!is_numeric($amount) || (float) $amount <= 0) {

        $error = "Payment amount must be greater than zero.";

    } elseif (!in_array($method, $allowedMethods, true)) {

        $error = "Invalid payment method.";

    } elseif ($dueDate === "") {

        $error = "Membership cycle due date is required.";

    } else {

        $stmt = $conn->prepare("
            INSERT INTO Payments
            (
                memberId,
                date,
                amount,
                method,
                dueDate
            )
            VALUES
            (
                ?,
                ?,
                ?,
                ?,
                ?
            )
        ");

        if (!$stmt) {

            $error =
                "Unable to prepare payment query: "
                . $conn->error;

        } else {

            $amountValue = (float) $amount;

            $stmt->bind_param(
                "isdss",
                $memberId,
                $paymentDate,
                $amountValue,
                $method,
                $dueDate
            );

            if ($stmt->execute()) {

                $message = "Payment recorded successfully.";

            } else {

                $error = $stmt->error;
            }

            $stmt->close();
        }
    }
}


/*
    Build five representative payment rows.

    We first try to get the most recent:
    - cash payment
    - debit payment
    - credit payment

    Then we add additional recent payments until
    five total records are displayed.
*/

$selectedPayments = [];

$methodsToFind = [
    "cash",
    "debit",
    "credit"
];


/*
    Get one latest payment for each method
*/
foreach ($methodsToFind as $paymentMethod) {

    $stmt = $conn->prepare("
        SELECT
            paymentId,
            memberId,
            date AS paymentDate,
            amount,
            method,
            dueDate
        FROM Payments
        WHERE method = ?
        ORDER BY paymentId DESC
        LIMIT 1
    ");

    if ($stmt) {

        $stmt->bind_param(
            "s",
            $paymentMethod
        );

        $stmt->execute();

        $methodResult = $stmt->get_result();

        if ($methodResult && $methodResult->num_rows > 0) {

            $row = $methodResult->fetch_assoc();

            $selectedPayments[
                $row["paymentId"]
            ] = $row;
        }

        $stmt->close();
    }
}


/*
    Add additional recent payments until
    we have five total records.
*/
$recentResult = $conn->query("
    SELECT
        paymentId,
        memberId,
        date AS paymentDate,
        amount,
        method,
        dueDate
    FROM Payments
    ORDER BY paymentId DESC
    LIMIT 50
");

if (!$recentResult) {

    die(
        "Unable to retrieve payment results: "
        . htmlspecialchars($conn->error)
    );
}


while (
    count($selectedPayments) < 5
    &&
    ($row = $recentResult->fetch_assoc())
) {

    if (
        !isset(
            $selectedPayments[
                $row["paymentId"]
            ]
        )
    ) {

        $selectedPayments[
            $row["paymentId"]
        ] = $row;
    }
}


/*
    Sort selected records by payment ID descending
*/
usort(
    $selectedPayments,
    function ($a, $b) {

        return
            (int) $b["paymentId"]
            <=>
            (int) $a["paymentId"];
    }
);


/*
    Keep only five rows
*/
$selectedPayments =
    array_slice(
        $selectedPayments,
        0,
        5
    );

?>

<!DOCTYPE html>

<html>

<head>

    <meta charset="UTF-8">

    <title>
        Query 7 - Make a Payment For a Club Member
    </title>

</head>


<body>


<a href="../index.php">
    Home
</a>


<h1>
    Query 7
</h1>


<h2>
    Make a Payment For a Club Member
</h2>


<?php if ($message !== ""): ?>

    <p>
        <strong>
            <?= htmlspecialchars($message) ?>
        </strong>
    </p>

<?php endif; ?>


<?php if ($error !== ""): ?>

    <p>
        <strong>
            Error:
            <?= htmlspecialchars($error) ?>
        </strong>
    </p>

<?php endif; ?>


<form method="post">


    <p>

        <label for="memberId">
            Member ID:
        </label>

        <input
            type="number"
            id="memberId"
            name="memberId"
            value="<?= htmlspecialchars($memberId) ?>"
            required
        >

    </p>


    <p>

        <label for="paymentDate">
            Payment Date:
        </label>

        <input
            type="date"
            id="paymentDate"
            name="paymentDate"
            value="<?= htmlspecialchars($paymentDate) ?>"
            required
        >

    </p>


    <p>

        <label for="amount">
            Payment Amount:
        </label>

        <input
            type="number"
            step="0.01"
            min="0.01"
            id="amount"
            name="amount"
            value="<?= htmlspecialchars($amount) ?>"
            required
        >

    </p>


    <p>

        <label for="method">
            Payment Method:
        </label>

        <select
            id="method"
            name="method"
            required
        >

            <option
                value="cash"
                <?= $method === "cash"
                    ? "selected"
                    : "" ?>
            >
                Cash
            </option>

            <option
                value="debit"
                <?= $method === "debit"
                    ? "selected"
                    : "" ?>
            >
                Debit Card
            </option>

            <option
                value="credit"
                <?= $method === "credit"
                    ? "selected"
                    : "" ?>
            >
                Credit Card
            </option>

        </select>

    </p>


    <p>

        <label for="dueDate">
            Membership Cycle Due Date:
        </label>

        <input
            type="date"
            id="dueDate"
            name="dueDate"
            value="<?= htmlspecialchars($dueDate) ?>"
            required
        >

    </p>


    <button type="submit">
        Make Payment
    </button>


</form>


<h2>
    Payment Result
</h2>


<p>
    Five representative payment records stored in the database are
    displayed below. The result includes different payment methods
    whenever Cash, Debit Card, and Credit Card transactions are
    available in the database.
</p>


<table
    border="1"
    cellpadding="5"
    cellspacing="0"
>


<tr>

    <th>
        Payment ID
    </th>

    <th>
        Member ID
    </th>

    <th>
        Payment Date
    </th>

    <th>
        Amount
    </th>

    <th>
        Payment Method
    </th>

    <th>
        Due Date
    </th>

</tr>


<?php if (count($selectedPayments) > 0): ?>


    <?php foreach ($selectedPayments as $payment): ?>


        <tr>


            <td>
                <?= htmlspecialchars(
                    $payment["paymentId"]
                ) ?>
            </td>


            <td>
                <?= htmlspecialchars(
                    $payment["memberId"]
                ) ?>
            </td>


            <td>
                <?= htmlspecialchars(
                    $payment["paymentDate"]
                ) ?>
            </td>


            <td>
                <?= htmlspecialchars(
                    number_format(
                        (float) $payment["amount"],
                        2,
                        ".",
                        ""
                    )
                ) ?>
            </td>


            <td>

                <?php

                if ($payment["method"] === "credit") {

                    echo "Credit Card";

                } elseif ($payment["method"] === "debit") {

                    echo "Debit Card";

                } elseif ($payment["method"] === "cash") {

                    echo "Cash";

                } else {

                    echo htmlspecialchars(
                        $payment["method"]
                    );
                }

                ?>

            </td>


            <td>
                <?= htmlspecialchars(
                    $payment["dueDate"]
                ) ?>
            </td>


        </tr>


    <?php endforeach; ?>


<?php else: ?>


    <tr>

        <td colspan="6">
            No payment records were found.
        </td>

    </tr>


<?php endif; ?>


</table>


</body>

</html>