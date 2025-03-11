<?php
include 'db_connection.php';

$status = $comment = ""; // Default values

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"] ?? "");  
    $phone = trim($_POST["phone"] ?? "");  

    if (!empty($email) && !empty($phone)) {
        $stmt = $conn->prepare("SELECT status, comment FROM registration WHERE email=? AND phone=?");
        $stmt->bind_param("ss", $email, $phone);
        $stmt->execute();
        $stmt->bind_result($status, $comment);
        $stmt->fetch();
        $stmt->close();

        // ✅ Debug: Print status
        echo "<script>console.log('Fetched status: " . addslashes($status) . "');</script>";

        // ✅ Check for redirection
        if (trim($status) === "Approved") {
            echo "<script>alert('Status: Approved');window.location.href='status.php';</script>";
            exit();
        } else {
            echo "<script>alert('Status is not approved. Current status: $status');window.location.href='status.php';</script>";
        }

    } else {
        echo "<script>alert('Please enter both Email and Mobile Number');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Registration Status</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
          background-image: url(../Image/bus1.jpg);  /*  Add the path to your image */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #333;
            position: relative;
        }

        /* Dark Overlay for the background image */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4); /* 40% opacity overlay */
            z-index: -1; /* Keep overlay behind the content */
        }

        .container {
            background-color: #ffffff;
            max-width: 450px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
            position: relative;
        }

        h1 {
            font-size: 28px;
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .message {
            font-size: 16px;
            color: #7f8c8d;
            margin-bottom: 25px;
        }

        button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 14px;
            font-size: 18px;
            cursor: pointer;
            border-radius: 8px;
            transition: all 0.3s ease;
            width: 100%;
        }

        button:hover {
            background-color: #218838;
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 768px) {
            .container {
                padding: 25px;
            }

            h1 {
                font-size: 24px;
            }

            .message {
                font-size: 14px;
            }

            button {
                padding: 12px;
                font-size: 16px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Check Your Registration Status</h2>
        <div class="message">
            <p>Enter your details to check your application status Your Form is appovred then Redirect to the next page</p>
        </div>

        <form action="status.php" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Mobile Number</label>
                <input type="tel" class="form-control" id="phone" name="phone" required>
            </div>

            <button type="submit">Check Status</button>
        </form>

        <div class="mt-3 text-center">
            <a href="../index.html" class="text-decoration-none">Back to Home</a><br><br>

            <?php if (!empty($status)) { ?>
                <h3>Status: <?= strtoupper($status) ?></h3>
                <?php if ($status == "rejected") { ?>
                    <p>Reason: <?= $comment ?></p>
                <?php } ?>
            <?php } ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
