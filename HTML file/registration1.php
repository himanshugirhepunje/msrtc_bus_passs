<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieving form data safely
    $fullname = $_POST['fullname'];
    $dob = $_POST['dob'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $college = $_POST['college'];

    // Function to handle file uploads and store file path
    function uploadFile($file, $uploadDir) {
        if ($file['error'] === UPLOAD_ERR_OK) {
            $targetFile = $uploadDir . basename($file["name"]);
            move_uploaded_file($file["tmp_name"], $targetFile);
            return $targetFile;
        }
        return null; // Return null if upload fails
    }

    $uploadDir = "uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $passport = uploadFile($_FILES['passport'], $uploadDir);
    $idcard = uploadFile($_FILES['idcard'], $uploadDir);
    $bonafide = uploadFile($_FILES['bonafide'], $uploadDir);

    if (!$passport || !$idcard || !$bonafide) {
        echo "<script>alert('File upload failed. Please try again.');window.location.href='registration.php';</script>";
        exit;
    }

    // Check if phone number exists in 'users' table
    $stmt = $conn->prepare("SELECT * FROM users WHERE phone = ?");
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Check for duplicate entry in 'registration' table
        $stmt = $conn->prepare("SELECT * FROM registration WHERE phone = ? OR email = ?");
        $stmt->bind_param("ss", $phone, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('This phone number or email is already registered.');window.location.href='registration.php';</script>";
        } else {
            // Insert registration data
            $sql = "INSERT INTO registration (fullname, dob, age, gender, phone, email, college, passport, idcard, bonafide) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssisssssss", $fullname, $dob, $age, $gender, $phone, $email, $college, $passport, $idcard, $bonafide);

            if ($stmt->execute()) {
                echo "<script>alert('Registration Successful! Wait for approval.');window.location.href='status.php';</script>";
            } else {
                echo "Error: " . $conn->error;
            }
        }
    } else {
        echo "<script>alert('Error: Phone number is not registered in the system. Please enter a valid signup phone number & email.');window.location.href='signup.php';</script>";
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

            <label for="phone">Mobile No:</label>
            <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="School/College Name">School/College Name:</label>
            <input type="text" id="college" name="college" required>

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