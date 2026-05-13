<?php
include "includes/db.php";
$data = json_decode(file_get_contents("php://input"), true);
if (!$data) { echo json_encode(["status"=>"error","message"=>"No data"]); exit; }

foreach ($data as $row) {
    $stmt = $conn->prepare("INSERT INTO daily_records (student_id, date, homework_done, classwork_done, behavior, discipline, uniform, handwriting, remarks) VALUES (?,?,?,?,?,?,?,?,?) ON DUPLICATE KEY UPDATE homework_done=VALUES(homework_done), classwork_done=VALUES(classwork_done), behavior=VALUES(behavior), discipline=VALUES(discipline), uniform=VALUES(uniform), handwriting=VALUES(handwriting), remarks=VALUES(remarks)");
    $stmt->bind_param("isiisssss", $row['student_id'], $row['date'], $row['homework'], $row['classwork'], $row['behavior'], $row['discipline'], $row['uniform'], $row['handwriting'], $row['remarks']);
    $stmt->execute();
}
echo json_encode(["status"=>"success"]);
?>