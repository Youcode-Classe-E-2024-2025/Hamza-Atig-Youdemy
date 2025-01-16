<?php
require __DIR__ . '/../../vendor/autoload.php';

use Dompdf\Dompdf;

$userId = $_POST['user_id'] ?? null;
$courseId = $_POST['course_id'] ?? null;

if (!$userId || !$courseId) {
    die('User ID and Course ID are required.');
}

try {
    $pdo = new PDO('mysql:host=localhost;dbname=youdemy_db', 'root', '');
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}

$stmt = $pdo->prepare("SELECT username FROM users WHERE user_id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die('User not found.');
}

$stmt = $pdo->prepare("SELECT c.title, u.username as teacher_name FROM courses c JOIN users u ON c.teacher_id = u.user_id WHERE c.course_id = ?");
$stmt->execute([$courseId]);
$course = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$course) {
    die('Course not found.');
}

$backgroundImagePath = __DIR__ . '/../../assets/images/certificate-bg/certif.png';
$backgroundImageBase64 = base64_encode(file_get_contents($backgroundImagePath));
$backgroundImageCss = "data:image/png;base64,{$backgroundImageBase64}";

$html = '
<!DOCTYPE html>
<html>
<head>
    <style>
        /* Remove default margin and padding */
        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: url("' . $backgroundImageCss . '");
            background-size: cover;
            background-position: center;
        }
        .certificate {
            position: relative;
            width: 100%;
            height: 100%;
        }
        #user, #title, #instructor, #date {
            position: absolute;
        }
        #user {
            top: 28%;
            left: 33%;
            right: 10%;
            font-size: 80px;
            font-family: "Mea Culpa", serif;
            font-style: oblique;
        }
        #title {
            top: 53%;
            left: 45%;
            right: 0%;
            font-family: "Handlee", serif;
        }
        #instructor {
            top: 70%;
            left: 66%;
            right: 10%;
            font-size: 20px;
        }
        #date {
            top: 76%;
            left: 68%;
            right: 10%;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <p id="user">' . htmlspecialchars($user['username']) . '</p>
        <h2 id="title">' . htmlspecialchars($course['title']) . '</h2>
        <p id="instructor">' . htmlspecialchars($course['teacher_name']) . '</p>
        <div class="signature">
            <p id="date">' . date('F j, Y') . '</p>
        </div>
    </div>
</body>
</html>
';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');

$dompdf->set_option('defaultMediaType', 'all');
$dompdf->set_option('isPhpEnabled', true);
$dompdf->set_option('isHtml5ParserEnabled', true);
$dompdf->set_option('isRemoteEnabled', true);

$dompdf->render();

$dompdf->stream('certificate.pdf', ['Attachment' => 1]);
?>