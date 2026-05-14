<?php
// ajax_student.php - handles add/edit students via AJAX
include "includes/auth.php";
include "includes/db.php";

header('Content-Type: application/json');

// Only admin can access student CRUD actions
if (!isAdmin()) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

$action = $_POST['action'] ?? '';
$response = ['status' => 'error', 'message' => 'Invalid request'];

if ($action == 'add') {
    // Get form data
    $name = trim($_POST['name'] ?? '');
    $section = trim($_POST['section'] ?? '');
    $father_name = trim($_POST['father_name'] ?? '');
    $mother_name = trim($_POST['mother_name'] ?? '');
    $parent_contact = trim($_POST['parent_contact'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $guardian_name = trim($_POST['guardian_name'] ?? '');
    $guardian_relation = trim($_POST['guardian_relation'] ?? '');

    $class_id = (int)($_POST['class_id'] ?? 0);
    if ($class_id <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Please select a valid class.']);
        exit;
    }

    if (empty($name)) {
        echo json_encode(['status' => 'error', 'message' => 'Student name is required.']);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO students 
        (name, class_id, section, father_name, mother_name, parent_contact, address, guardian_name, guardian_relation) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sisssssss", $name, $class_id, $section, $father_name, $mother_name, $parent_contact, $address, $guardian_name, $guardian_relation);

    if ($stmt->execute()) {
        $response = ['status' => 'success', 'message' => 'Student added successfully'];
    } else {
        $response = ['status' => 'error', 'message' => 'Database error: ' . $stmt->error];
    }
    $stmt->close();
} 
elseif ($action == 'edit') {
    $id = (int)($_POST['id'] ?? 0);
    if ($id <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid student ID']);
        exit;
    }


    $name = trim($_POST['name'] ?? '');
    $class_id = (int)($_POST['class_id'] ?? 0);
    $section = trim($_POST['section'] ?? '');
    $father_name = trim($_POST['father_name'] ?? '');
    $mother_name = trim($_POST['mother_name'] ?? '');
    $parent_contact = trim($_POST['parent_contact'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $guardian_name = trim($_POST['guardian_name'] ?? '');
    $guardian_relation = trim($_POST['guardian_relation'] ?? '');

    if (empty($name)) {
        echo json_encode(['status' => 'error', 'message' => 'Student name is required']);
        exit;
    }

    if ($class_id <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Please select a valid class']);
        exit;
    }

    $stmt = $conn->prepare("UPDATE students SET 
        name = ?, class_id = ?, section = ?, father_name = ?, mother_name = ?, 
        parent_contact = ?, address = ?, guardian_name = ?, guardian_relation = ? 
        WHERE id = ?");
    $stmt->bind_param("sisssssssi", $name, $class_id, $section, $father_name, $mother_name, $parent_contact, $address, $guardian_name, $guardian_relation, $id);

    if ($stmt->execute()) {
        $response = ['status' => 'success', 'message' => 'Student updated successfully'];
    } else {
        $response = ['status' => 'error', 'message' => 'Update failed: ' . $stmt->error];
    }
    $stmt->close();
}

echo json_encode($response);
?>