<?php
session_start();
require_once ('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['is_admin']) {
    $file_id = $_POST['file_id'];

    $stmt = $pdo->prepare('SELECT filename FROM files WHERE id = ?');
    $stmt->execute([$file_id]);
    $file = $stmt->fetch();

    if ($file) {
        $file_path = "uploads/" . $file['filename'];
        if (unlink($file_path)) {
            $stmt = $pdo->prepare('DELETE FROM files WHERE id = ?');
            $stmt->execute([$file_id]);
            echo "File deleted successfully.";
        } else {
            echo "Error deleting file.";
        }
    } else {
        echo "File not found.";
    }
}
?>