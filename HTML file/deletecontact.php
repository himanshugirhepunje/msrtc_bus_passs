<?php
include 'db_connection.php';

$id = $_GET['id'];
$sql = "DELETE FROM contactus WHERE id=$id";
if ($conn->query($sql) === TRUE) {
    $message="Message deleted Successfully";
    echo " <script>alert('$message');
    window.location.href='contactdata.php';</script>";
    // header("Location: members_list.php?msg=delete_success");
} else {
    echo "Error: " . $conn->error;
}
?>