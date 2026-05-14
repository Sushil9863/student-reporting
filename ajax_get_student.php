<?php
include "includes/auth.php";
include "includes/db.php";
header('Content-Type: application/json');

if (!isAdmin()) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) {
    echo json_encode(['status' => 'error', 'message' => 'No ID']);
    exit;
}

$extra = '';
if (isTeacher()) {
    $classIds = getTeacherClassIds();
    if (empty($classIds)) {
        echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
        exit;
    }
    $extra = ' AND class_id IN (' . implode(',', $classIds) . ')';
}

$result = $conn->query("SELECT * FROM students WHERE id = $id $extra");
if ($result && $row = $result->fetch_assoc()) {
    echo json_encode(['status' => 'success', 'student' => $row]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Student not found']);
}
?>