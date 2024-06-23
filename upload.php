<?php
session_start();
require_once ('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['is_admin']) {
    $category_id = $_POST['category_id'];
    $uploaded_by = $_SESSION['user_id'];

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        $filename = basename($_FILES["file"]["name"]);

        $stmt = $pdo->prepare('INSERT INTO files (filename, category_id, uploaded_by) VALUES (?, ?, ?)');
        $stmt->execute([$filename, $category_id, $uploaded_by]);

        echo "File uploaded successfully.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>