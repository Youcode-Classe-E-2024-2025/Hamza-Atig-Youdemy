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
    $tags = explode(',', $_POST['tags']);
    $teacher_id = $_SESSION['user_id'];

    $thumbnailDir = '../../storage/uploads/course_thumbnails/';
    $videoDir = '../../storage/uploads/course_videos/';

    if (!is_dir($thumbnailDir)) {
        mkdir($thumbnailDir, 0755, true);
    }
    if (!is_dir($videoDir)) {
        mkdir($videoDir, 0755, true);
    }

    $thumbnail = '';
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
        $thumbnailName = uniqid() . '_' . basename($_FILES['thumbnail']['name']);
        $thumbnailPath = $thumbnailDir . $thumbnailName;

        $allowedImageTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $thumbnailType = mime_content_type($_FILES['thumbnail']['tmp_name']);
        if (in_array($thumbnailType, $allowedImageTypes)) {
            move_uploaded_file($_FILES['thumbnail']['tmp_name'], $thumbnailPath);
            $thumbnail = $thumbnailName;
        } else {
            die("Invalid thumbnail file type. Only JPEG, PNG, and GIF are allowed.");
        }
    }

    $video_url = '';
    $videoPath = '';
    if ($type === 'video') {
        if (isset($_FILES['video']) && $_FILES['video']['error'] === UPLOAD_ERR_OK) {
            $videoName = uniqid() . '_' . basename($_FILES['video']['name']);
            $videoPath = $videoDir . $videoName;

            $allowedVideoTypes = ['video/mp4', 'video/mpeg', 'video/quicktime'];
            $videoType = mime_content_type($_FILES['video']['tmp_name']);
            if (in_array($videoType, $allowedVideoTypes)) {
                move_uploaded_file($_FILES['video']['tmp_name'], $videoPath);
                $video_url = $videoPath;
            } else {
                die("Invalid video file type. Only MP4, MPEG, and MOV are allowed.");
            }
        } elseif (!empty($_POST['video_url'])) {
            $video_url = $_POST['video_url'];
        } else {
            die("Please upload a video or provide a video URL.");
        }
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
        if (!empty($tag_id)) {
            $stmt = $pdo->prepare("INSERT INTO course_tags (course_id, tag_id) VALUES (?, ?)");
            $stmt->execute([$course_id, $tag_id]);
        }
    }

    header("Location: ../teacher/dashboard.php");
    exit();
}