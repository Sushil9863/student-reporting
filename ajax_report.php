<?php
include "includes/db.php";
header('Content-Type: application/json');

$student_id = (int)$_GET['student_id'];
$start = $_GET['start'];
$end = $_GET['end'];

$subject_id = isset($_GET['subject_id']) ? (int)$_GET['subject_id'] : 0;

$student = $conn->query("SELECT students.name as sname, classes.name as cname FROM students JOIN classes ON students.class_id = classes.id WHERE students.id=$student_id")->fetch_assoc();
$subject_name = 'All subjects';
if ($subject_id > 0) {
    $subject = $conn->query("SELECT name FROM subjects WHERE id=$subject_id")->fetch_assoc();
    $subject_name = $subject['name'] ?? 'Unknown';
}

$records = [];
$summary = ['total'=>0, 'homework_done'=>0, 'good_behaviors'=>0, 'discipline_bad'=>0];

$sql = "SELECT daily_records.*, subjects.name as subject_name FROM daily_records LEFT JOIN subjects ON daily_records.subject_id = subjects.id WHERE student_id=$student_id AND date BETWEEN '$start' AND '$end'";
if ($subject_id > 0) {
    $sql .= " AND daily_records.subject_id=$subject_id";
}
$sql .= " ORDER BY date ASC";
$result = $conn->query($sql);
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
    'subject_name' => $subject_name,
    'start' => $start,
    'end' => $end,
    'records' => $records,
    'summary' => $summary
]);
?>