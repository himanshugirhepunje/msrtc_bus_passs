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
        .header {
            background: #a40000;
            color: white;
            padding: 10px;
            text-align: center;
        }
        .container {
            width: 60%;
            margin: auto;
            padding: 20px;
            background: white;
            border: 2px solid black;
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.2);
        }
        .logo {
            width: 80px;
            height: auto;
            float: left;
        }
        .title {
            font-size: 22px;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: left;
        }
        .photo {
            width: 100px;
            height: 120px;
            border: 1px solid black;
        }
        .seal {
            width: 100px;
            height: auto;
        }
        .btn {
            padding: 10px;
            margin: 5px;
            border: none;
            cursor: pointer;
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
    </style>
</head>
<body>

    <div class="header">
        <img src="../Image/logo.jpg" class="logo" alt="MSRTC Logo">
        <span class="title">Maharashtra State Road Transport Corporation (MSRTC) - Bus Pass</span>
    </div>

    <h2>Check Your Bus Pass</h2>

    <form method="POST">
        <input type="text" name="phone" placeholder="Enter Phone Number" required>
        <button type="submit" class="btn btn-print">Search</button>
    </form>

    <?php if ($passData): ?>
        <div class="container" id="pass">
            <table>
            <div class="header">
        <img src="../Image/logo.jpg" class="logo" alt="MSRTC Logo">
        <span class="title">Maharashtra State Road Transport Corporation (MSRTC) - Bus Pass</span>
    </div>
                <tr>
                    <td colspan="2"><strong>Pass No:</strong> <?php echo $passData['id']; ?></td>
                    <td rowspan="9">
                        <img src="data:image/jpeg;base64,<?= base64_encode($passData['passport']); ?>" class="photo" alt="User Photo">   
                    </td>


                    
                </tr>
                <tr><td><strong>Name:</strong></td><td><?php echo $passData['fullname']; ?></td></tr>
                <tr><td><strong>Phone:</strong></td><td><?php echo $passData['phone']; ?></td></tr>
                <tr><td><strong>School/College:</strong></td><td><?php echo $passData['college']; ?></td></tr>
                <tr><td><strong>Source:</strong></td><td><?php echo $passData['source']; ?></td></tr>
                <tr><td><strong>Destination:</strong></td><td><?php echo $passData['destination']; ?></td></tr>
                <tr><td><strong>Pass Created On:</strong></td><td><?php echo date("d-m-Y", strtotime($passData['created_at'])); ?></td></tr>
                <tr><td><strong>Valid Until:</strong></td><td><?php echo date("d-m-Y", strtotime($passData['validUntil'])); ?></td></tr>
                <tr><td><strong>Cost:</strong></td><td>₹<?php echo $passData['cost']; ?></td></tr>
                <tr>
                    <td colspan="3" style="text-align: center;">
                        <img src="../Image/logo.jpg" class="seal" alt="Official Seal">
                    </td>
                </tr>
            </table>
            <button class="btn btn-print" onclick="printPass()">Print Pass</button>
            <button class="btn btn-back" onclick="goBack()">Back</button>
        </div>
    <?php elseif ($error): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>

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