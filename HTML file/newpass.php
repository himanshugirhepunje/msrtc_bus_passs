<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $phone = $_POST['phone'];
    $source = $_POST['source'];
    $destination = $_POST['destination'];
    $validUntil = $_POST['validUntil'];
    $cost = $_POST['cost'];

    // Check if the phone number exists and the status is "approved"
    $stmt = $conn->prepare("SELECT status FROM registration WHERE phone = ?");
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $status = $row['status'];

        if ($status === "Approved") {
            // Student is approved, proceed with pass registration
            $sql = "INSERT INTO passes (phone, source, destination, validUntil, cost) 
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssd", $phone, $source, $destination, $validUntil, $cost);

            if ($stmt->execute()) {
                echo "<script>alert('New Pass Added Successfully');window.location.href='pass_display.php';</script>";
            } else {
                echo "Error: " . $conn->error;
            }
        } else {
            // Status is pending or rejected
            echo "<script>alert('Error: Your application is \"$status\". Only Approved students can create a pass.');</script>";
        }
    } else {
        // Phone number not found
        echo "<script>alert('Error: Enter a valid registered mobile number');</script>";
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
    <title>Bus Pass Application</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-image: url(../Image/bus1.jpg);
            object-fit: fill;
            background-size: cover;
        }
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
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        h1 {
            text-align: center;
            color: #3498db;
        }

        label {
            font-weight: bold;
        }

        select,
        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[readonly] {
            background: #e9ecef;
            
        }

        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 5px;
            margin-bottom: 10px;
            display: block;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #2ecc71;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 15px;
        }

        button:hover {
            background: #27ae60;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Bus Pass Application</h1>
        <form id="passDetailsForm" action="newpass.php" method="POST" >
        <!-- <form id="passDetailsForm" action="newpass.php" onsubmit="paybt()" method="post"> -->
            <label for="Mobile">Nobile no:</label>
            <input type="text" id="phone" name="phone" placeholder="Enter Phone no" required />   
            
            <label for="source">Source:</label>
            <select id="source" name="source" required>
                <option value="">Select Source</option>
            </select>
            <span id="sourceError" class="error-message"></span>

            <label for="destination">Destination:</label>
            <select id="destination" name="destination" required>
                <option value="">Select Destination</option>
            </select>
            <span id="destinationError" class="error-message"></span>

            <label for="date">Valid Until:</label>
            <input type="date" id="date" name="validUntil" readonly required>

            <label for="cost">Cost (₹):</label>
            <input type="text" id="cost" name="cost" readonly required>
            <span id="costError" class="error-message"></span>

            <button type="submit" id="saveButton">Pay ₹<span id="costDisplay">0</span></button>
        </form>
    </div>

    <script>
// function validateForm(event) {
//  if (source === "" || destination === "" || validUntil === "" || cost === "") {
//                 alert("⚠️ Error: All fields are required!");
//                 event.preventDefault(); 
//                 // Stop form submission
//                 return false;
//             }
//         }
//      document.addEventListener("DOMContentLoaded", function () {
//     const sourceSelect = document.getElementById("source");
//     const destinationSelect = document.getElementById("destination");
//     const dateInput = document.getElementById("date");
//     const costInput = document.getElementById("cost");
//     const costDisplay = document.getElementById("costDisplay");
//     const saveButton = document.getElementById("saveButton");

//     const sourceError = document.getElementById("sourceError");
//     const destinationError = document.getElementById("destinationError");
//     const costError = document.getElementById("costError");

//     const fareRate = 40; // ₹ per km

//     // All locations
//     const locations = [
//         "Sakoli", "Dharmapuri", "Kumbhli", "Sawarband", "Sivanibandh", "Sangadi",
//         "Dongargaon/Sangadi", "Salebardi", "Dighori/Mothi", "Sakhra/Tawsi", "Chichal","Barwaha",
//         "Borgoan", "Antargoan", "Lakahndur", "Ghusobatola", "Silezari", "Bondgoan/Devi",
//         "Nimgoan", "Arrttondi", "Arjuni/Mor", "Sendurwafa", "Ukara/Fata", "Saudad",
//         "Bamhani/Saudad", "Kohmara", "Arjuni/Sadak", "Wadegoan", "Khajari", "Mundipar",
//         "Pipalgoan", "Manegoan/Road", "Lakhani", "Murmadi", "Gadegoan"
//     ];

//     // Distance chart (in km)
//     const distanceChart = {
//         "sakoli-dharmapuri": 5, "sakoli-kumbhli": 5, "sakoli-sawarband": 5, "sakoli-sivanibandh": 10, "sakoli-sangadi": 12.5,
//         "sakoli-dongargaon/sangadi": 15, "sakoli-salebardi": 20, "sakoli-dighori/mothi": 25, "sakoli-sakhra/tawsi": 30,
//         "sakoli-chichal/barwaha": 35,"sakoli-barwaha": 35, "sakoli-borgoan": 40, "sakoli-antargoan": 45, "sakoli-lakahndur": 50,
//         "sakoli-ghusobatola": 20, "sakoli-silezari": 20, "sakoli-bondgoan/devi": 25, "sakoli-nimgoan": 30,
//         "sakoli-arrttondi": 35, "sakoli-arjuni/mor": 35, "sakoli-sendurwafa": 5, "sakoli-ukara/fata": 5,
//         "sakoli-saudad": 10, "sakoli-bamhani/saudad": 10, "sakoli-kohmara": 15, "sakoli-arjuni/sadak": 20,
//         "sakoli-wadegoan": 25, "sakoli-khajari": 25, "sakoli-mundipar": 10, "sakoli-pipalgoan": 15,
//         "sakoli-manegoan/road": 20, "sakoli-lakhani": 20, "sakoli-murmadi": 20, "sakoli-gadegoan": 25
//     };

//     // Populate dropdowns
//     locations.forEach(location => {
//         let option1 = new Option(location, location.toLowerCase());
//         let option2 = new Option(location, location.toLowerCase());
//         sourceSelect.add(option1);
//         destinationSelect.add(option2);
//     });

//     // Set next month date
//     function getNextMonthDate() {
//         let today = new Date();
//         today.setMonth(today.getMonth() + 1);
//         return today.toISOString().split('T')[0];
//     }

//     function updateCostAndDate() {
//         // Clear previous errors
//         sourceError.textContent = "";
//         destinationError.textContent = "";
//         costError.textContent = "";

//         let source = sourceSelect.value.toLowerCase();
//         let destination = destinationSelect.value.toLowerCase();

//         // Validation: Check if source and destination are the same
//         if (!source || !destination) {
//             return;
//              // Don't show an error if nothing is selected
//         }

//         if (source === destination) {
//             sourceError.textContent = "Source and destination cannot be the same.";
//             destinationError.textContent = "Source and destination cannot be the same.";
//             costInput.value = "";
//             costDisplay.textContent = "0";
//             event.preventDefault();
//             return false;
//             return;
            
//         }

//         let routeKey = `${source}-${destination}`;
//         let reverseKey = `${destination}-${source}`;
//         let distance = distanceChart[routeKey] || distanceChart[reverseKey];

//         if (distance) {
//             let calculatedCost = distance * fareRate;
//             costInput.value = calculatedCost;
//             costDisplay.textContent = calculatedCost;
//             dateInput.value = getNextMonthDate();
//         } else {
//             costInput.value = "";
//             costDisplay.textContent = "0";
//             costError.textContent = "Fare information not available for this route.";
//             event.preventDefault();
//             return false;
//         }
//     }

//     sourceSelect.addEventListener("change", updateCostAndDate);
//     destinationSelect.addEventListener("change", updateCostAndDate);
//     dateInput.value = getNextMonthDate();
// });



document.addEventListener("DOMContentLoaded", function () {
    const sourceSelect = document.getElementById("source");
    const destinationSelect = document.getElementById("destination");
    const dateInput = document.getElementById("date");
    const costInput = document.getElementById("cost");
    const costDisplay = document.getElementById("costDisplay");
    const saveButton = document.getElementById("saveButton");

    const sourceError = document.getElementById("sourceError");
    const destinationError = document.getElementById("destinationError");
    const costError = document.getElementById("costError");

    // List of locations
    const locations = [
        "Sakoli", "Dharmapuri", "Kumbhli", "Sawarband", "Sivanibandh", "Sangadi",
        "Dongargaon/Sangadi", "Salebardi", "Dighori/Mothi", "Sakhra/Tawsi", "Chichal/Barwaha",
        "Borgoan", "Antargoan", "Lakahndur", "Ghusobatola", "Silezari", "Bondgoan/Devi",
        "Nimgoan", "Arrttondi", "Arjuni/Mor", "Sendurwafa", "Ukara/Fata", "Saudad",
        "Bamhani/Saudad", "Kohmara", "Arjuni/Sadak", "Wadegoan", "Khajari", "Mundipar",
        "Pipalgoan", "Manegoan/Road", "Lakhani", "Murmadi", "Gadegoan"
    ];

    //  Fixed Costs for Each Route 
    const fixedCosts = {
        "sakoli-dharmapuri": 200, "sakoli-kumbhli": 200, "sakoli-sawarband": 200, 
        "sakoli-sivanibandh": 400, "sakoli-sangadi": 500, "sakoli-dongargaon/sangadi": 500, 
        "sakoli-salebardi": 600, "sakoli-dighori/mothi": 700, "sakoli-sakhra/tawsi": 800, 
        "sakoli-chichal/barwaha": 800, "sakoli-borgoan": 900, "sakoli-antargoan":900, 
        "sakoli-lakahndur": 1000, "sakoli-ghusobatola": 500, "sakoli-silezari": 600, 
        "sakoli-bondgoan/devi": 700, "sakoli-nimgoan": 700, "sakoli-arrttondi": 800, 
        "sakoli-arjuni/mor": 900, "sakoli-sendurwafa": 200, "sakoli-ukara/fata": 300, 
        "sakoli-saudad": 300, "sakoli-bamhani/saudad": 300, "sakoli-kohmara": 500, 
        "sakoli-arjuni/sadak": 600, "sakoli-wadegoan": 300, "sakoli-khajari": 320, 
        "sakoli-mundipar": 200, "sakoli-pipalgoan": 250, "sakoli-manegoan/road": 280, 
        "sakoli-lakhani": 300, "sakoli-murmadi": 320, "sakoli-gadegoan": 350
    };

    // Populate dropdowns
    locations.forEach(location => {
        let option1 = new Option(location, location.toLowerCase());
        let option2 = new Option(location, location.toLowerCase());
        sourceSelect.add(option1);
        destinationSelect.add(option2);
    });

    // Set next month's date
    function getNextMonthDate() {
        let today = new Date();
        today.setMonth(today.getMonth() + 1);
        return today.toISOString().split('T')[0];
    }

    function updateCostAndDate() {
        // Clear previous errors
        sourceError.textContent = "";
        destinationError.textContent = "";
        costError.textContent = "";

        let source = sourceSelect.value.toLowerCase();
        let destination = destinationSelect.value.toLowerCase();

        if (!source || !destination) {
            return; // If nothing is selected, don't proceed
        }

        if (source === destination) {
            sourceError.textContent = "Source and destination cannot be the same.";
            destinationError.textContent = "Source and destination cannot be the same.";
            costInput.value = "";
            costDisplay.textContent = "0";
            return;
        }

        // 🔥 Check fixed cost for selected route 🔥
        let routeKey = `${source}-${destination}`;
        let reverseKey = `${destination}-${source}`;

        if (fixedCosts[routeKey] !== undefined) {
            costInput.value = fixedCosts[routeKey];
            costDisplay.textContent = fixedCosts[routeKey];
        } else if (fixedCosts[reverseKey] !== undefined) {
            costInput.value = fixedCosts[reverseKey];
            costDisplay.textContent = fixedCosts[reverseKey];
        } else {
            costInput.value = "";
            costDisplay.textContent = "0";
            costError.textContent = "⚠️ Error: Fare information not available for this route.";
            return;
        }

        dateInput.value = getNextMonthDate();
    }

    sourceSelect.addEventListener("change", updateCostAndDate);
    destinationSelect.addEventListener("change", updateCostAndDate);
    dateInput.value = getNextMonthDate(); // Set default date

    // Form validation before submission
    function validateForm(event) {
        let source = sourceSelect.value;
        let destination = destinationSelect.value;
        let validUntil = dateInput.value;
        let cost = costInput.value;
        let isValid = true;

        if (source === "" || destination === "") {
            alert("⚠️ Error: Source and Destination are required!");
            isValid = false;
        }

        if (source === destination) {
            alert("⚠️ Error: Source and Destination cannot be the same!");
            isValid = false;
        }

        if (validUntil === "") {
            alert("⚠️ Error: Please select a valid date!");
            isValid = false;
        }

        if (cost === "" || cost === "0") {
            alert("⚠️ Error: Cost is required and cannot be ₹0!");
            isValid = false;
        }

        if (!isValid) {
            event.preventDefault(); // Prevent form submission if validation fails
        }

        return isValid;
    }

    document.getElementById("passDetailsForm").addEventListener("submit", validateForm);
});


    </script>
</body>

</html>

