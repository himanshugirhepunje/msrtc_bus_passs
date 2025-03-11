<?php
include 'db_connection.php';

// Handle form submission for approval
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["approve"]) && isset($_POST["id"])) {
        $id = intval($_POST["id"]); // Convert to integer for security

        $sql = "UPDATE registration SET status='approved' WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('User approved successfully!');</script>";
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
    }

    // Handle rejection with comment
    if (isset($_POST["reject"]) && isset($_POST["id"]) && isset($_POST["comment"])) {
        $id = intval($_POST["id"]);
        $comment = $conn->real_escape_string($_POST["comment"]); // Prevent SQL Injection

        $sql = "UPDATE registration SET status='rejected', comment='$comment' WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('User rejected successfully!');</script>";
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
    }
}

// Fetch all pending users
$result = $conn->query("SELECT * FROM registration WHERE status='pending'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .btn {
            padding: 5px 10px;
            margin: 2px;
            border: none;
            cursor: pointer;
        }
        .approve-btn {
            background-color: green;
            color: white;
        }
        .reject-btn {
            background-color: red;
            color: white;
        }
        .comment-box {
            width: 150px;
        }
        img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 10%;
            border: 2px solid #ddd;
        }
    </style>
</head>
<body>

    <h2>Admin Panel - Approve or Reject Users</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Date Of Birth</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Mobile</th>
            <th>Email</th>
            <th>PassPhoto</th>
            <th>Id card</th>
            <th>Bonafied</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row["id"] ?></td>
                <td><?= htmlspecialchars($row["fullname"]) ?></td>
                <td><?= htmlspecialchars($row["dob"]) ?></td>
                <td><?= htmlspecialchars($row["age"]) ?></td>
                <td><?= htmlspecialchars($row["gender"]) ?></td>
                <td><?= htmlspecialchars($row["phone"]) ?></td>
                <td><?= htmlspecialchars($row["email"]) ?></td>
                <td><img  src="data:image/jpeg;base64,<?= base64_encode($row['passport']); ?>" alt="Pass Photo"></td>
                <td><img  src="data:image/jpeg;base64,<?= base64_encode($row['idcard']); ?>" alt="IdCard"></td>
                <td><img  src="data:image/jpeg;base64,<?= base64_encode($row['bonafide']); ?>" alt="Bonafide"></td>
                   
                
                <td>
                    <!-- Approve Form -->
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <button type="submit" name="approve" class="btn approve-btn">Approve</button>
                    </form><br>

                    <!-- Reject Form -->
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <input type="text" name="comment" placeholder="Rejection reason" class="comment-box" required>
                        <button type="submit" name="reject" class="btn reject-btn">Reject</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>

</body>
</html>
