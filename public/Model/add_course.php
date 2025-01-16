<?php
session_start();

require '../../config/db.php';

class FileUploader {
    private $uploadDir;
    private $allowedTypes;

    public function __construct($uploadDir, $allowedTypes) {
        $this->uploadDir = $uploadDir;
        $this->allowedTypes = $allowedTypes;
        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0755, true);
        }
    }

    public function upload($file) {
        if ($file['error'] === UPLOAD_ERR_OK) {
            $fileName = uniqid() . '_' . basename($file['name']);
            $filePath = $this->uploadDir . $fileName;
            $fileType = mime_content_type($file['tmp_name']);
            if (in_array($fileType, $this->allowedTypes)) {
                move_uploaded_file($file['tmp_name'], $filePath);
                return $fileName;
            } else {
                throw new Exception("Invalid file type. Allowed types: " . implode(', ', $this->allowedTypes));
            }
        }
        return null;
    }
}

class Course {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create($teacher_id, $title, $description, $type, $category_id, $video_url, $content_text, $thumbnail) {
        $stmt = $this->pdo->prepare("
            INSERT INTO courses (teacher_id, title, description, type, category_id, video_url, content_text, thumbnail, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
        ");
        $stmt->execute([$teacher_id, $title, $description, $type, $category_id, $video_url, $content_text, $thumbnail]);
        return $this->pdo->lastInsertId();
    }

    public function addTags($course_id, $tags) {
        foreach ($tags as $tag_id) {
            if (!empty($tag_id)) {
                $stmt = $this->pdo->prepare("INSERT INTO course_tags (course_id, tag_id) VALUES (?, ?)");
                $stmt->execute([$course_id, $tag_id]);
            }
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Database();
    $pdo = $database->connect();

    $title = $_POST['title'];
    $description = $_POST['description'];
    $type = $_POST['type'];
    $category_id = $_POST['category_id'];
    $tags = explode(',', $_POST['tags']);
    $teacher_id = $_SESSION['user_id'];

    $thumbnailUploader = new FileUploader(
        '../../storage/uploads/course_thumbnails/',
        ['image/jpeg', 'image/png', 'image/gif']
    );

    $videoUploader = new FileUploader(
        '../../storage/uploads/course_videos/',
        ['video/mp4', 'video/mpeg', 'video/quicktime']
    );

    $thumbnail = '';
    if (isset($_FILES['thumbnail'])) {
        try {
            $thumbnail = $thumbnailUploader->upload($_FILES['thumbnail']);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    $video_url = '';
    if ($type === 'video') {
        if (isset($_FILES['video'])) {
            try {
                $video_url = $videoUploader->upload($_FILES['video']);
            } catch (Exception $e) {
                die($e->getMessage());
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

    $course = new Course($pdo);
    $course_id = $course->create($teacher_id, $title, $description, $type, $category_id, $video_url, $content_text, $thumbnail);

    $course->addTags($course_id, $tags);

    header("Location: ../teacher/dashboard.php");
    exit();
}