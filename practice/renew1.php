<?php
include 'db_connection.php';
$userData = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = $_POST['phone'];

    // Prepare SQL Query (Checking both phone & status)
    $stmt = $conn->prepare("SELECT * FROM passes WHERE phone = ? ");
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch Data
    if ($result->num_rows > 0) {
        $userData = $result->fetch_assoc();
    } else {
        $error = "You Can not create a Pass fist time plese create a new pass";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renew Pass</title>

    
    <style>
        /* Basic styling */
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
            width: 100%;
            height: 80%;
            margin: 0%;
            background-image: url("../Image/bus1.jpg");
            background-size: cover;
            object-fit: fill;

        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            background-size: cover;
            object-fit: fill;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            /* 40% opacity overlay */
            z-index: -1;
            /* Keep overlay behind the content */
        }


        .container {
            width: 45%;
            margin: 0 auto;
            padding: 30px;
            border-radius: 8px;
            background-color: rgb(237, 248, 229);
            opacity: 90%;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin: 8px 0;
        }

        input[type="text"],
        input[type="date"],
        input[type="tel"],
        input[type="email"],
        input[type="file"],
        button {
            padding: 8px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            padding: 12px 20px;
        }

        button:hover {
            background-color: #45a049;
        }

        /* For radio buttons */
        label input[type="radio"] {
            margin-right: 10px;
        }

        input[type="file"] {
            padding: 5px;
        }

        /* Adjust mobile view */
        @media screen and (max-width: 768px) {
            .container {
                width: 90%;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Check Details </h2>

    <form method="POST">
        <label for="phone">Enter Mobile No:</label>
        <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" required>
        <button type="submit">Check</button>
    </form>
   
    <?php if (isset($userData)): ?>



    <?php elseif (isset($error)): ?>
        <p style="color: red;"><?= $error; ?></p>
    <?php endif; ?>
 </div>


    <?php if (isset($userData)): ?>
    <div class="container">
        <h2>Renew Pass</h2>

        <form id="registrationForm">
            <label for="fullname">Source</label>
            <input type="text" value="<?= $userData['source']; ?>" readonly>

            <label for="destination">Destination</label>
            <input type="text" value="<?= $userData['destination']; ?>"readonly>

            <label for="validUntil">Valid Util</label>
            <input type="date" value="<?= $userData['validUntil']; ?>"readonly>

            <label>Coste</label>
            <input type="text" value="<?= $userData['cost']; ?>"readonly>
            

            <label for="phone">Mobile No.:</label>
            <input type="text" value="<?= $userData['phone']; ?>"readonly>

           


            <button type="submit" id="saveButton">Pay ₹<span id="costDisplay"></span></button>

             <?php elseif (isset($error)): ?>
        <!-- <p style="color: red;"><?= $error; ?></p> -->
    <?php endif; ?>
        </form>
    </div>

</body>
</html>
