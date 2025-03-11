<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $fullname = $_POST['fullname'];
    $dob = $_POST['dob'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $mobileno = $_POST['mobileno'];
    $email = $_POST['email'];
    $passport = addslashes(file_get_contents($_FILES['passport']['tmp_name']));
    $idcard = addslashes(file_get_contents($_FILES['idcard']['tmp_name']));
    $bonafide = addslashes(file_get_contents($_FILES['bonafide']['tmp_name']));

    $sql = "INSERT INTO registration (id, fullname, dob, age, gender,mobileno,email,passport,idcard,bonafide) 
            VALUES ('$id', '$fullname', '$dob', '$age', '$gender','$mobileno','$email','$passport','$idcard','$bonafide')";
    if ($conn->query($sql) === TRUE) {
        // header("Location: members_list.php?msg=add_success");
        $message="Registration  Successful";
      echo " <script>alert('$message');</script>";
        // exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>

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
        <h2>REGISTRATION FORM</h2>
        <!-- <form id="registrationForm" action="registration.php" method="post" onsubmit="return validateForm()"> -->
        <form id="registrationForm" action="registration.php" method="POST" enctype="multipart/form-data">

            <label for="fullname">Full Name:</label>
            <input type="text" id="fullname" name="fullname" required>

            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob" onchange="calculateAge()" required>

            <label for="age">Age:</label>
            <input type="text" id="age" name="age" required>

            <label>Gender:</label>
            <label><input type="radio" name="gender" value="Male" required> Male</label>
            <label><input type="radio" name="gender" value="Female"> Female</label>
            <label><input type="radio" name="gender" value="Other"> Other</label>

            <label for="mobileno">Mobile No:</label>
            <input type="tel" id="mobileno" name="mobileno" pattern="[0-9]{10}" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="passport">Upload Passport Photo:</label>
            <input type="file" id="passport" name="passport"  required>

            <label for="idcard">Upload ID Card:</label>
            <input type="file" id="idcard" name="idcard" required>

            <label for="bonafide">Upload Bonafide Document:</label>
            <input type="file" id="bonafide" name="bonafide"  required>

            <button type="submit" id="registerBtn">Register</button>
        </form>
    </div>

    <script src="../Javascript file/register.js"></script>
</body>

</html>