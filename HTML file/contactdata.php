<?php
include 'db_connection.php';

// Fetch Members
$sql = "SELECT * FROM contactus";
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
    <h1>Contact Details</h1>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= $row['name']; ?></td>
                    <td><?= $row['email']; ?></td>
                    <td><?= $row['message']; ?></td>
                    <td class="actions">
                        <a href="deletecontact.php?id=<?= $row['id']; ?>" title="Delete" onclick="return confirm('Are you sure?')">
                            <i class="fas fa-trash-alt" style="color: #e74c3c;">    </i>
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p style="text-align: center;">No members found.</p>
    <?php endif; ?>
    <?php $conn->close(); ?>
</body>
</html>