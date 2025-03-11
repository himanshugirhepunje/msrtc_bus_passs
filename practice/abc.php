<?php
include 'db_connection.php';

$phone = "";
$data_found = false;
$row = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = $_POST['phone'];

    // Fetch user details from registration and passes
    $query = "SELECT p.*, r.* 
              FROM passes p 
              JOIN registration r ON p.phone = r.phone
              WHERE r.phone = '$phone' AND r.status = 'approved'";

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $data_found = true;
        $row = $result->fetch_assoc(); // Fetch user data
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search & Renew Pass</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
            background-image: url("../Image/bus1.jpg");
            background-size: cover;
            background-position: center;
            margin: 0;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            z-index: -1;
        }

        .container {
            width: 50%;
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            background-color: rgba(237, 248, 229, 0.9);
        }

        h2 {
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin: 8px 0 4px 0;
            font-weight: normal;
        }

        input[type="text"],
        input[type="date"],
        input[type="email"],
        input[type="tel"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background: #e9ecef;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 12px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
        }

        button:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
            font-weight: bold;
        }

        @media screen and (max-width: 768px) {
            .container {
                width: 90%;
            }
        }
    </style>
</head>
<body>

<!-- Phone Number Input Form -->
<div class="container">
    <h2>Search Pass by Phone</h2>
    <form method="POST">
        <label for="phone">Enter Mobile No:</label>
        <input type="tel" name="phone" required placeholder="Enter phone number" value="<?= htmlspecialchars($phone); ?>">
        <button type="submit">Search</button>
    </form>
</div>

<?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
    <?php if ($data_found): ?>
    <!-- Display User Details Form -->
    <div class="container">
        <h2>Renew Pass</h2>

        <form id="passDetailsForm" method="POST" action="payment.php">
            <input type="hidden" name="phone" value="<?= $row['phone']; ?>">

            <label>Full Name:</label>
            <input type="text" name="fullname" value="<?= $row['fullname']; ?>" readonly>

            <label>Date of Birth:</label>
            <input type="date" name="dob" value="<?= $row['dob']; ?>" readonly>

            <label>Age:</label>
            <input type="text" name="age" value="<?= $row['age']; ?>" readonly>

            <label>Gender:</label>
            <input type="text" name="gender" value="<?= $row['gender']; ?>" readonly>

            <label>Mobile No:</label>
            <input type="tel" name="phone" value="<?= $row['phone']; ?>" readonly>

            <label>Email:</label>
            <input type="email" name="email" value="<?= $row['email']; ?>" readonly>

            <label>Source:</label>
            <input type="text" name="source" value="<?= $row['source']; ?>" readonly>

            <label>Destination:</label>
            <input type="text" name="destination" value="<?= $row['destination']; ?>" readonly>

            <label for="validUntil">Valid Until:</label>
            <input type="date" id="validUntil" name="validUntil" readonly>

            <label>Cost:</label>
            <input type="text" id="cost" name="cost" value="<?= $row['cost']; ?>" readonly>

            <!-- Button dynamically updates price -->
            <button type="submit" id="payButton">Pay ₹<span id="costDisplay"><?= $row['cost']; ?></span></button>
        </form>
    </div>
    <?php else: ?>
        <p class="error" style="text-align:center;">No records found for this phone number.</p>
    <?php endif; ?>
<?php endif; ?>

<?php $conn->close(); ?>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const validUntilInput = document.getElementById("validUntil");
        const costInput = document.getElementById("cost");
        const costDisplay = document.getElementById("costDisplay");
        const payButton = document.getElementById("payButton");

        // Set "Valid Until" date to next month
        function getNextMonthDate() {
            let today = new Date();
            today.setMonth(today.getMonth() + 1);
            return today.toISOString().split('T')[0];
        }

        validUntilInput.value = getNextMonthDate();

        // Update button cost dynamically
        costDisplay.innerText = costInput.value;

        // Redirect to payment page on button click
        document.getElementById("passDetailsForm").addEventListener("submit", function (event) {
            event.preventDefault();
            window.location.href = "pass_display.php?phone=<?= $row['phone']; ?>&cost=" + encodeURIComponent(costInput.value);
        });
    });
</script>

</body>
</html>
