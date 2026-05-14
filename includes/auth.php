<?php
// includes/auth.php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Helper functions
function isAdmin() {
    return $_SESSION['role'] == 'admin';
}

function isTeacher() {
    return $_SESSION['role'] == 'teacher';
}

function getTeacherClassIds() {
    if (!isTeacher()) {
        return [];
    }

    if (isset($_SESSION['class_ids']) && is_array($_SESSION['class_ids']) && count($_SESSION['class_ids'])) {
        return array_map('intval', $_SESSION['class_ids']);
    }

    if (!empty($_SESSION['class_id'])) {
        return [(int)$_SESSION['class_id']];
    }

    return [];
}

function getTeacherClassId() {
    $ids = getTeacherClassIds();
    return $ids[0] ?? null;
}

function teacherHasClass($class_id) {
    return in_array((int)$class_id, getTeacherClassIds(), true);
}
?>