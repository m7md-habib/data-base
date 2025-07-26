<?php
$conn = new mysqli("localhost", "root", "", "mydb");
if ($conn->connect_error) {
    die("Connection failed");
}

$id = $_POST['id'];
$res = $conn->query("SELECT status FROM users WHERE id = $id");
$row = $res->fetch_assoc();
$new_status = $row['status'] == 1 ? 0 : 1;

$conn->query("UPDATE users SET status = $new_status WHERE id = $id");

echo json_encode(['success' => true, 'new_status' => $new_status]);
?>
