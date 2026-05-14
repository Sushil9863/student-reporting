<?php
include "includes/auth.php";
include "includes/db.php";
header('Content-Type: application/json');

$class_id = isset($_GET['class_id']) ? (int)$_GET['class_id'] : 0;
if (!$class_id) {
    echo json_encode([]);
    exit;
}

$subjects = [];
if (isTeacher()) {
    $stmt = $conn->prepare("SELECT DISTINCT subjects.id, subjects.name FROM teacher_subjects JOIN subjects ON teacher_subjects.subject_id = subjects.id WHERE teacher_subjects.teacher_id = ? AND teacher_subjects.class_id = ? ORDER BY subjects.name");
    $stmt->bind_param("ii", $_SESSION['user_id'], $class_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $subjects[] = $row;
    }
    $stmt->close();
} else {
    $stmt = $conn->prepare("SELECT DISTINCT subjects.id, subjects.name FROM class_subjects JOIN subjects ON class_subjects.subject_id = subjects.id WHERE class_subjects.class_id = ? ORDER BY subjects.name");
    $stmt->bind_param("i", $class_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $subjects[] = $row;
    }
    $stmt->close();
    if (empty($subjects)) {
        $result = $conn->query("SELECT id, name FROM subjects ORDER BY name");
        while ($row = $result->fetch_assoc()) {
            $subjects[] = $row;
        }
    }
}

echo json_encode($subjects);
