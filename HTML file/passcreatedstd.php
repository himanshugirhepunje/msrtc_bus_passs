<?php
include 'db_connection.php';

// Fetch Members
$sql = "SELECT * FROM passes";
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
    <h1>Pass Created Student List</h1>
   
    
    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>ID</th>
                <!-- <th>Name</th> -->
                <th>source</th>
                <th>Destination</th>
                <th>validUntil</th>
                <th>Cost</th>
                

            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= $row['source']; ?></td>
                    <td><?= $row['destination']; ?></td>
                    <td><?= $row['validUntil']; ?></td>
                    <td><?= $row['cost']; ?></td>
        
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p style="text-align: center;">No members found.</p>
    <?php endif; ?>
    <?php $conn->close(); ?>
</body>
</html>
