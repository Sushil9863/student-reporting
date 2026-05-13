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

?>