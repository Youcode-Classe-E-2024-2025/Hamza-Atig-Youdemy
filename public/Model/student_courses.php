<?php

$database = new Database();
$pdo = $database->connect();

class CourseSTD {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllCourses() {
        $stmt = $this->pdo->prepare("
            SELECT courses.*, users.username AS teacher_name
            FROM courses
            JOIN users ON courses.teacher_id = users.user_id
            ORDER BY courses.created_at DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function search($query) {
        $stmt = $this->pdo->prepare("
            SELECT courses.*, users.username AS teacher_name
            FROM courses
            JOIN users ON courses.teacher_id = users.user_id
            WHERE courses.title LIKE :query
            OR courses.description LIKE :query
            OR users.username LIKE :query
            ORDER BY courses.created_at DESC
        ");
        $stmt->execute(['query' => "%$query%"]);
        return $stmt->fetchAll();
    }
}

$course = new CourseSTD($pdo);
if (isset($_GET['search'])) {
    $courses = $course->search($_GET['search']);
} else {
    $courses = $course->getAllCourses();
}
?>