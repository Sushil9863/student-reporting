<?php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "student_tracker";

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Optional: set charset
$conn->set_charset("utf8");

// Ensure subject and teacher-subject schema exists
$schemaQueries = [
    "CREATE TABLE IF NOT EXISTS `subjects` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `name` varchar(100) NOT NULL,
      PRIMARY KEY (`id`),
      UNIQUE KEY `name` (`name`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci",
    "CREATE TABLE IF NOT EXISTS `class_subjects` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `class_id` int(11) NOT NULL,
      `subject_id` int(11) NOT NULL,
      PRIMARY KEY (`id`),
      UNIQUE KEY `class_subject_unique` (`class_id`,`subject_id`),
      KEY `idx_class_id` (`class_id`),
      KEY `idx_subject_id` (`subject_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci",
    "CREATE TABLE IF NOT EXISTS `teacher_subjects` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `teacher_id` int(11) NOT NULL,
      `class_id` int(11) NOT NULL,
      `subject_id` int(11) NOT NULL,
      PRIMARY KEY (`id`),
      UNIQUE KEY `teacher_subject_unique` (`teacher_id`,`class_id`,`subject_id`),
      KEY `idx_teacher_id` (`teacher_id`),
      KEY `idx_class_id` (`class_id`),
      KEY `idx_subject_id` (`subject_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci",
    "ALTER TABLE `daily_records` ADD COLUMN IF NOT EXISTS `subject_id` int(11) NOT NULL DEFAULT 0"
];
foreach ($schemaQueries as $sql) {
    $conn->query($sql);
}

$indexResult = $conn->query("SHOW INDEX FROM daily_records WHERE Key_name = 'student_date_subject'");
if ($indexResult && $indexResult->num_rows === 0) {
    $oldIndexResult = $conn->query("SHOW INDEX FROM daily_records WHERE Key_name = 'unique_student_date'");
    if ($oldIndexResult && $oldIndexResult->num_rows > 0) {
        $conn->query("ALTER TABLE daily_records DROP INDEX unique_student_date");
    }
    $conn->query("ALTER TABLE daily_records ADD UNIQUE INDEX student_date_subject (student_id, date, subject_id)");
}


?>