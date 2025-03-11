<?php
include 'db_connection.php';

// Initialize pass data
$passData = null;
$error = "";

// Check if phone number is provided
if (isset($_POST['phone'])) {
    $phone = $conn->real_escape_string($_POST['phone']);

    // SQL JOIN query to fetch pass details along with user's name
    $query = "SELECT p.*, r.fullname, r.college, r.passport 
              FROM passes p 
              JOIN registration r ON p.phone = r.phone 
              WHERE p.phone = '$phone'";

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $passData = $result->fetch_assoc();
    } else {
        $error = "No pass found for this phone number!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MSRTC Bus Pass</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
        }
        .container {
            width: 350px;
            background: white;
            padding: 10px;
            margin: auto;
            border: 2px solid black;
            box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.2);
            text-align: left;
            position: relative;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #a40000;
            color: white;
            padding: 5px;
            font-size: 16px;
            font-weight: bold;
            gap: 15px; 
        }
        .logo {
            width: 50px;
        }
        .details {
            font-size: 12px;
            margin-top: 5px;
        }
        .photo {
            width: 80px;
            height: 100px;
            border: 1px solid black;
            float: right;
            margin-left: 10px;
        }
        .seal {
            width: 70px;
            height: 40px;
            float: right;
            margin-right: 120px;
            
        }
        .btn {
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            font-size: 12px;
        }
        .btn-print {
            background: blue;
            color: white;
        }
        .btn-print:hover {
            background: darkblue;
        }
        .btn-back {
            background: gray;
            color: white;
        }
        .btn-back:hover {
            background: darkgray;
        }
        @media print {
    body {
        background-color: white !important; /* White background ensure karein */
        color: black !important; /* Text black rahe */
    }
    .container {
        border: 2px solid black !important; /* Border print me dikhana */
        box-shadow: none !important; /* Shadows remove karna */
    }
    .btn {
        display: none; /* Buttons hide karein taaki print me na aaye */
    }
}


    </style>
</head>
<body>

    <h2>Check Your Bus Pass</h2>

    <form method="POST">
        <input type="text" name="phone" placeholder="Enter Phone Number" required>
        <button type="submit" class="btn btn-print">Search</button>
    </form>
<br><br>
    <?php if ($passData): ?>
        <div class="container" id="pass">
            <div class="header">
                <img src="../Image/logo.jpg" class="logo" alt="MSRTC Logo">
                <span> Maharashtra State Road Transport Corporation (MSRTC) - Bus Pass</span>
            </div>
            <div class="details">
                <img src="data:image/jpeg;base64,<?= base64_encode($passData['passport']); ?>" class="photo" alt="User Photo">
                <strong>Pass No:</strong> <?php echo $passData['id']; ?><br>
                <strong>Name:</strong> <?php echo $passData['fullname']; ?><br>
                <strong>Phone:</strong> <?php echo $passData['phone']; ?><br>
                <strong>College:</strong> <?php echo $passData['college']; ?><br>
                <strong>Source:</strong> <?php echo $passData['source']; ?><br>
                <strong>Destination:</strong> <?php echo $passData['destination']; ?><br>
                <strong>Valid Until:</strong> <?php echo date("d-m-Y", strtotime($passData['validUntil'])); ?><br>
                <strong>Cost:</strong> ₹<?php echo $passData['cost']; ?><br>
                <center><img src="../Image/verified.jpg" class="seal" alt="Official Seal"></center>
            </div><br>
            <button class="btn btn-print" onclick="printPass()">Print</button>
            <button class="btn btn-back" onclick="goBack()">Back</button>
        </div>
    <?php elseif ($error): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>
<br>
    <script>
        function printPass() {
            var passContent = document.getElementById("pass").innerHTML;
            var originalContent = document.body.innerHTML;
            document.body.innerHTML = passContent;
            window.print();
            document.body.innerHTML = originalContent;
        }

        function goBack() {
            window.history.back();
        }



    </script>

</body>
</html>
