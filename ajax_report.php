<?php
include "includes/db.php";
header('Content-Type: application/json');

$student_id = (int)$_GET['student_id'];
$start = $_GET['start'];
$end = $_GET['end'];

$student = $conn->query("SELECT students.name as sname, classes.name as cname FROM students JOIN classes ON students.class_id = classes.id WHERE students.id=$student_id")->fetch_assoc();

$records = [];
$summary = ['total'=>0, 'homework_done'=>0, 'good_behaviors'=>0, 'discipline_bad'=>0];

$result = $conn->query("SELECT * FROM daily_records WHERE student_id=$student_id AND date BETWEEN '$start' AND '$end' ORDER BY date ASC");
while($row = $result->fetch_assoc()) {
    $records[] = $row;
    $summary['total']++;
    if($row['homework_done']) $summary['homework_done']++;
    if($row['behavior'] == 'good') $summary['good_behaviors']++;
    if($row['discipline'] == 'bad') $summary['discipline_bad']++;
}

echo json_encode([
    'student_name' => $student['sname'] ?? 'Unknown',
    'class_name' => $student['cname'] ?? '—',
    'records' => $records,
    'summary' => $summary
]);
?>