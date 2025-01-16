<?php
require __DIR__ . '/../../vendor/autoload.php';

use League\CommonMark\CommonMarkConverter;

$converter = new CommonMarkConverter();

$courseId = $_GET['course_id'] ?? null;

if (!$courseId) {
    die('Course ID is required.');
}

$pdo = new PDO('mysql:host=localhost;dbname=youdemy_db', 'root', '');
$stmt = $pdo->prepare("SELECT type, video_url, content_text FROM courses WHERE course_id = ?");
$stmt->execute([$courseId]);
$course = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$course) {
    die('Course not found.');
}

if ($course['type'] === 'video') {
    echo '<video class="w-full" controls>
            <source src="../../storage/uploads/course_videos/' . htmlspecialchars($course['video_url']) . '" type="video/mp4">
            Your browser does not support the video tag.
          </video>';
} else {
    echo '<div class="prose">' . $converter->convert($course['content_text']) . '</div>';
}
?>
