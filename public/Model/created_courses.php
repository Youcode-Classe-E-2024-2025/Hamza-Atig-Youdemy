<?php
$database = new Database();
$pdo = $database->connect();

class Course {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getCoursesByTeacher($teacher_id) {
        $stmt = $this->pdo->prepare("
            SELECT courses.*, users.username AS teacher_name
            FROM courses
            JOIN users ON courses.teacher_id = users.user_id
            WHERE courses.teacher_id = ?
        ");
        $stmt->execute([$teacher_id]);
        return $stmt->fetchAll();
    }
}

$teacher_id = $_SESSION['user_id'];
$course = new Course($pdo);
$courses = $course->getCoursesByTeacher($teacher_id);
?>