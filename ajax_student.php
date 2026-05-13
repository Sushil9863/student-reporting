<?php
include "includes/db.php";
header('Content-Type: application/json');

$action = $_POST['action'] ?? '';
$response = ['status' => 'error', 'message' => 'Invalid request'];

if ($action == 'add') {
    $name = $_POST['name'];
    $class_id = $_POST['class_id'];
    $section = $_POST['section'];
    $father_name = $_POST['father_name'];
    $mother_name = $_POST['mother_name'];
    $parent_contact = $_POST['parent_contact'];
    $address = $_POST['address'];
    $guardian_name = $_POST['guardian_name'];
    $guardian_relation = $_POST['guardian_relation'];

    $stmt = $conn->prepare("INSERT INTO students (name, class_id, section, father_name, mother_name, parent_contact, address, guardian_name, guardian_relation) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sisssssss", $name, $class_id, $section, $father_name, $mother_name, $parent_contact, $address, $guardian_name, $guardian_relation);
    if ($stmt->execute()) {
        $response = ['status' => 'success', 'message' => 'Student added'];
    } else {
        $response = ['status' => 'error', 'message' => 'Database error'];
    }
} 
elseif ($action == 'edit') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $class_id = $_POST['class_id'];
    $section = $_POST['section'];
    $father_name = $_POST['father_name'];
    $mother_name = $_POST['mother_name'];
    $parent_contact = $_POST['parent_contact'];
    $address = $_POST['address'];
    $guardian_name = $_POST['guardian_name'];
    $guardian_relation = $_POST['guardian_relation'];

    $stmt = $conn->prepare("UPDATE students SET name=?, class_id=?, section=?, father_name=?, mother_name=?, parent_contact=?, address=?, guardian_name=?, guardian_relation=? WHERE id=?");
    $stmt->bind_param("sisssssssi", $name, $class_id, $section, $father_name, $mother_name, $parent_contact, $address, $guardian_name, $guardian_relation, $id);
    if ($stmt->execute()) {
        $response = ['status' => 'success', 'message' => 'Student updated'];
    } else {
        $response = ['status' => 'error', 'message' => 'Update failed'];
    }
}

echo json_encode($response);
?>