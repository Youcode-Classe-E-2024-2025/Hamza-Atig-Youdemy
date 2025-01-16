<?php

$database = new Database();
$pdo = $database->connect();

class Course {
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
}

$course = new Course($pdo);
$courses = $course->getAllCourses();
?>