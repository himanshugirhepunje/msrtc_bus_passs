<?php
include 'db_connection.php';

// Fetch Members
$sql = "SELECT * FROM registration WHERE status ='approved'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Members List</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <h1>Student Pass Form</h1>
   
    <h2>Student List</h2>
    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Date of Birth</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Mobile Number</th>
                <th>Email</th>
                <th>Pass Photo</th>
                <th>Id Card</th>
                <th>Bonafide</th>
                <th>Status</th>
                

            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= $row['fullname']; ?></td>
                    <td><?= $row['dob']; ?></td>
                    <td><?= $row['age']; ?></td>
                    <td><?= $row['gender']; ?></td>
                    <td><?= $row['phone']; ?></td>
                    <td><?= $row['email']; ?></td>
                    <td><img  src="data:image/jpeg;base64,<?= base64_encode($row['passport']); ?>" alt="Pass Photo"></td>
                    <td><img  src="data:image/jpeg;base64,<?= base64_encode($row['idcard']); ?>" alt="IdCard"></td>
                    <td><img  src="data:image/jpeg;base64,<?= base64_encode($row['bonafide']); ?>" alt="Bonafide"></td>
                    <td><?= $row['status']; ?></td>
                    
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p style="text-align: center;">No members found.</p>
    <?php endif; ?>
    <?php $conn->close(); ?>
</body>
</html>