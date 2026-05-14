<?php
// ajax_teacher.php - handles edit teachers via AJAX
include "includes/auth.php";
include "includes/db.php";

header('Content-Type: application/json');

// Only admin can access teacher CRUD actions
if (!isAdmin()) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

$action = $_POST['action'] ?? '';
$response = ['status' => 'error', 'message' => 'Invalid request'];

if ($action == 'get_teacher') {
    $teacher_id = (int)($_POST['teacher_id'] ?? 0);
    if ($teacher_id <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid teacher ID']);
        exit;
    }

    $stmt = $conn->prepare("SELECT id, full_name, username FROM users WHERE id = ? AND role = 'teacher'");
    $stmt->bind_param("i", $teacher_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $teacher = $result->fetch_assoc();

    if (!$teacher) {
        echo json_encode(['status' => 'error', 'message' => 'Teacher not found']);
        exit;
    }

    // Get assigned class and subject pairs
    $assign_stmt = $conn->prepare("SELECT teacher_subjects.class_id, teacher_subjects.subject_id, subjects.name AS subject_name FROM teacher_subjects JOIN subjects ON teacher_subjects.subject_id = subjects.id WHERE teacher_subjects.teacher_id = ? ORDER BY teacher_subjects.class_id, subjects.name");
    $assign_stmt->bind_param("i", $teacher_id);
    $assign_stmt->execute();
    $assign_result = $assign_stmt->get_result();
    $assigned_subjects = [];
    while ($row = $assign_result->fetch_assoc()) {
        $assigned_subjects[(int)$row['class_id']][] = [
            'id' => (int)$row['subject_id'],
            'name' => $row['subject_name']
        ];
    }

    $response = [
        'status' => 'success',
        'teacher' => $teacher,
        'assigned_subjects' => $assigned_subjects
    ];
} elseif ($action == 'update') {
    $teacher_id = (int)($_POST['teacher_id'] ?? 0);
    $full_name = trim($_POST['full_name'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $assignments = [];
    if (isset($_POST['assignments']) && is_array($_POST['assignments'])) {
        foreach ($_POST['assignments'] as $class_id => $subject_ids) {
            $class_id = (int)$class_id;
            if ($class_id <= 0 || !is_array($subject_ids)) {
                continue;
            }
            $subject_ids = array_values(array_unique(array_filter(array_map('intval', $subject_ids))));
            if ($subject_ids) {
                $assignments[$class_id] = $subject_ids;
            }
        }
    }

    if ($teacher_id <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid teacher ID']);
        exit;
    }

    if (empty($full_name) || empty($username)) {
        echo json_encode(['status' => 'error', 'message' => 'Full name and username are required']);
        exit;
    }

    // Check if username already exists for another teacher
    $check_stmt = $conn->prepare("SELECT id FROM users WHERE username = ? AND id != ?");
    $check_stmt->bind_param("si", $username, $teacher_id);
    $check_stmt->execute();
    if ($check_stmt->get_result()->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Username already exists']);
        exit;
    }

    // Update user information
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET full_name = ?, username = ?, password = ? WHERE id = ?");
        $stmt->bind_param("sssi", $full_name, $username, $hashed_password, $teacher_id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET full_name = ?, username = ? WHERE id = ?");
        $stmt->bind_param("ssi", $full_name, $username, $teacher_id);
    }

    if ($stmt->execute()) {
        // Update teacher class and subject assignments
        $conn->query("DELETE FROM teacher_subjects WHERE teacher_id = $teacher_id");
        $conn->query("DELETE FROM teacher_classes WHERE teacher_id = $teacher_id");

        if (!empty($assignments)) {
            $class_stmt = $conn->prepare("INSERT IGNORE INTO teacher_classes (teacher_id, class_id) VALUES (?, ?)");
            $subject_stmt = $conn->prepare("INSERT IGNORE INTO teacher_subjects (teacher_id, class_id, subject_id) VALUES (?, ?, ?)");
            foreach ($assignments as $class_id => $subject_ids) {
                $class_stmt->bind_param("ii", $teacher_id, $class_id);
                $class_stmt->execute();

                foreach ($subject_ids as $subject_id) {
                    $subject_stmt->bind_param("iii", $teacher_id, $class_id, $subject_id);
                    $subject_stmt->execute();
                }
            }
            $class_stmt->close();
            $subject_stmt->close();
        }

        $response = ['status' => 'success', 'message' => 'Teacher updated successfully'];
    } else {
        $response = ['status' => 'error', 'message' => 'Database error: ' . $stmt->error];
    }
    $stmt->close();
}

echo json_encode($response);
?>
