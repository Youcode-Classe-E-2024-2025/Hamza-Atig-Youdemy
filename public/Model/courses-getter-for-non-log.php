<?php

$database = new Database();
$pdo = $database->connect();

class Guest {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getAllCoursesWithTeacher() {
        try {
            $stmt = $this->pdo->prepare("
                SELECT courses.*, users.username AS teacher_name
                FROM courses
                JOIN users ON courses.teacher_id = users.user_id
                ORDER BY courses.created_at DESC
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching courses: " . $e->getMessage());
            return [];
        }
    }
}

$guest = new Guest($pdo);
$courses = $guest->getAllCoursesWithTeacher();