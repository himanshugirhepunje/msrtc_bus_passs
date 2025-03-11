<?php
include 'db_connection.php';

// Fetch Members
$sql = "SELECT * FROM registration";
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
                <th>Reject Resion</th>

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
                    <!-- <td class="actions">
                        <a href="approve.php?id=<?= $row['id']; ?>" title="Approve">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"
                        style="color: #3498db;"/> </svg>
                        </a>
                        <a href="reject.php?id=<?= $row['id']; ?>" title="Reject" onclick="return confirm('Are you sure?')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z" style="color: #e74c3c;"/>
                        </svg>
                        </a>
                    </td> -->
                    <td><?= $row['status']; ?></td>
                    <td><?= $row['comment']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p style="text-align: center;">No members found.</p>
    <?php endif; ?>
    <?php $conn->close(); ?>
</body>
</html>
