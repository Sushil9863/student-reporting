<?php
include "includes/db.php";
header('Content-Type: application/json');

$class_id = isset($_GET['class_id']) ? (int)$_GET['class_id'] : 0;
if (!$class_id) { echo json_encode([]); exit; }

$result = $conn->query("SELECT id, name, section, father_name, mother_name, parent_contact, address, guardian_name, guardian_relation 
                        FROM students 
                        WHERE class_id = $class_id 
                        ORDER BY name");
$students = [];
while($row = $result->fetch_assoc()) {
    $students[] = $row;
}
echo json_encode($students);
?>