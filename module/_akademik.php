<?php
function can_manage_course($koneksi, $courseId) {
    if (($_SESSION['role'] ?? '') === 'admin') {
        return true;
    }

    if (($_SESSION['role'] ?? '') !== 'dosen') {
        return false;
    }

    $userId = (int) ($_SESSION['user_id'] ?? 0);
    $courseId = (int) $courseId;
    $stmt = db_prepare($koneksi, "SELECT id FROM courses WHERE id = ? AND teacher_id = ?");
    db_stmt_bind_param($stmt, "ii", $courseId, $userId);
    db_stmt_execute($stmt);
    return (bool) db_fetch_assoc(db_stmt_get_result($stmt));
}

function can_view_course($koneksi, $courseId) {
    if (in_array($_SESSION['role'] ?? '', ['admin', 'dosen'], true)) {
        return can_manage_course($koneksi, $courseId);
    }

    $userId = (int) ($_SESSION['user_id'] ?? 0);
    $courseId = (int) $courseId;
    $stmt = db_prepare($koneksi, "SELECT id FROM enrollments WHERE user_id = ? AND course_id = ?");
    db_stmt_bind_param($stmt, "ii", $userId, $courseId);
    db_stmt_execute($stmt);
    return (bool) db_fetch_assoc(db_stmt_get_result($stmt));
}

function course_query_for_role($koneksi) {
    if (($_SESSION['role'] ?? '') === 'admin') {
        return db_query($koneksi, "SELECT id, judul FROM courses ORDER BY judul");
    }

    if (($_SESSION['role'] ?? '') === 'dosen') {
        $userId = (int) $_SESSION['user_id'];
        $stmt = db_prepare($koneksi, "SELECT id, judul FROM courses WHERE teacher_id = ? ORDER BY judul");
        db_stmt_bind_param($stmt, "i", $userId);
        db_stmt_execute($stmt);
        return db_stmt_get_result($stmt);
    }

    $userId = (int) $_SESSION['user_id'];
    $stmt = db_prepare($koneksi, "SELECT c.id, c.judul FROM courses c JOIN enrollments e ON e.course_id = c.id WHERE e.user_id = ? ORDER BY c.judul");
    db_stmt_bind_param($stmt, "i", $userId);
    db_stmt_execute($stmt);
    return db_stmt_get_result($stmt);
}

function save_upload($field, $folder) {
    if (!isset($_FILES[$field]) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    $baseDir = dirname(__DIR__) . '/uploads/' . $folder;
    if (!is_dir($baseDir)) {
        mkdir($baseDir, 0777, true);
    }

    $original = basename($_FILES[$field]['name']);
    $safeName = preg_replace('/[^A-Za-z0-9._-]/', '_', $original);
    $fileName = date('YmdHis') . '_' . bin2hex(random_bytes(4)) . '_' . $safeName;
    $target = $baseDir . '/' . $fileName;

    if (!move_uploaded_file($_FILES[$field]['tmp_name'], $target)) {
        return null;
    }

    return 'uploads/' . $folder . '/' . $fileName;
}
