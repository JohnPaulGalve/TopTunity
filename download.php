<?php
/**
 * download.php - Serves uploaded files and profile photos.
 *   download.php?file=ID   an uploaded file (only people allowed to see it)
 *   download.php?photo=ID  a profile photo (user ID)
 */
require_once __DIR__ . '/includes/data.php';

function tt_send_file($stored, $name)
{
    $path = __DIR__ . '/storage/uploads/' . basename($stored);
    if (!is_file($path)) { http_response_code(404); echo 'File not found.'; exit; }
    $ext  = strtolower(pathinfo($stored, PATHINFO_EXTENSION));
    $mime = ['pdf' => 'application/pdf', 'png' => 'image/png', 'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg',
             'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'][$ext] ?? 'application/octet-stream';
    $inline = in_array($ext, ['pdf', 'png', 'jpg', 'jpeg'], true);
    header('Content-Type: ' . $mime);
    header('Content-Length: ' . filesize($path));
    header('Content-Disposition: ' . ($inline ? 'inline' : 'attachment') . '; filename="' . str_replace('"', '', basename($name)) . '"');
    readfile($path);
    exit;
}

if (isset($_GET['photo'])) {
    $stmt = db()->prepare('SELECT role FROM users WHERE id = ?');
    $stmt->execute([(int) $_GET['photo']]);
    $role = $stmt->fetchColumn();
    $photo = $role ? tt_user_photo((int) $_GET['photo'], $role) : null;
    if (!$photo) { http_response_code(404); echo 'No photo.'; exit; }
    tt_send_file($photo, $photo);
}

if (isset($_GET['file'])) {
    $f = tt_can_download((int) $_GET['file']);
    if (!$f) {
        http_response_code(404);
        echo 'This file is not available to your account.';
        exit;
    }
    tt_send_file($f['stored_name'], $f['original_name']);
}

http_response_code(400);
echo 'Nothing to download.';