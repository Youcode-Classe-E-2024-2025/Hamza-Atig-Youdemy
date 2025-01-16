<?php
session_start();

require '../../config/db.php';

class Enrollment {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function isEnrolled($user_id, $course_id) {
        $stmt = $this->pdo->prepare("
            SELECT * FROM enrollments
            WHERE user_id = ? AND course_id = ?
        ");
        $stmt->execute([$user_id, $course_id]);
        return $stmt->rowCount() > 0;
    }

    public function enroll($user_id, $course_id) {
        if ($this->isEnrolled($user_id, $course_id)) {
            return false;
        }

        $stmt = $this->pdo->prepare("
            INSERT INTO enrollments (user_id, course_id)
            VALUES (?, ?)
        ");
        $stmt->execute([$user_id, $course_id]);
        return true;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Database();
    $pdo = $database->connect();

    $user_id = $_POST['user_id'];
    $course_id = $_POST['course_id'];

    $enrollment = new Enrollment($pdo);

    if ($enrollment->enroll($user_id, $course_id)) {
        header("Location: ../student/inrollnow.php?success=enrolled");
    } else {
        header("Location: ../student/inrollnow.php?error=already_enrolled");
    }
    exit();
}
?>