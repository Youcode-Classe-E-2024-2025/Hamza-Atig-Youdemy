<?php
session_start();

require '../../config/db.php';

$database = new Database();
$pdo = $database->connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $type = $_POST['type'];
    $category_id = $_POST['category_id'];
    $tags = $_POST['tags'];
    $teacher_id = $_SESSION['user_id'];

    $thumbnail = '';
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../../assets/images/course_thumbnails/';
        $thumbnailName = uniqid() . '_' . basename($_FILES['thumbnail']['name']);
        $thumbnailPath = $uploadDir . $thumbnailName;
        move_uploaded_file($_FILES['thumbnail']['tmp_name'], $thumbnailPath);
        $thumbnail = $thumbnailName;
    }

    if ($type === 'video') {
        $video_url = $_POST['video_url'];
        $content_text = null;
    } else {
        $content_text = $_POST['content_text'];
        $video_url = null;
    }

    $stmt = $pdo->prepare("
        INSERT INTO courses (teacher_id, title, description, type, category_id, video_url, content_text, thumbnail, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
    ");
    $stmt->execute([$teacher_id, $title, $description, $type, $category_id, $video_url, $content_text, $thumbnail]);

    $course_id = $pdo->lastInsertId();

    foreach ($tags as $tag_id) {
        $stmt = $pdo->prepare("INSERT INTO course_tags (course_id, tag_id) VALUES (?, ?)");
        $stmt->execute([$course_id, $tag_id]);
    }

    header("Location: teacher.php");
    exit();
}