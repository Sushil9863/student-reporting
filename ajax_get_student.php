<?php
include "includes/db.php";
header('Content-Type: application/json');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) {
    echo json_encode(['status' => 'error', 'message' => 'No ID']);
    exit;
}

$result = $conn->query("SELECT * FROM students WHERE id = $id");
if ($result && $row = $result->fetch_assoc()) {
    echo json_encode(['status' => 'success', 'student' => $row]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Student not found']);
}
?>