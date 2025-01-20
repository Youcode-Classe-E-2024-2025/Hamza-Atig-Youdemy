<?php

$database = new Database();
$pdo = $database->connect();

class Guest
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllCoursesWithTeacher()
    {
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

    public function getPaginatedCoursesWithTeacher($page = 1, $perPage = 10)
    {
        try {
            $offset = ($page - 1) * $perPage;

            $stmt = $this->pdo->prepare("
                SELECT courses.*, users.username AS teacher_name
                FROM courses
                JOIN users ON courses.teacher_id = users.user_id
                ORDER BY courses.created_at DESC
                LIMIT :limit OFFSET :offset
            ");
            $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching courses: " . $e->getMessage());
            return [];
        }
    }

    public function getTotalCoursesCount()
    {
        try {
            $stmt = $this->pdo->prepare("
                SELECT COUNT(*) AS total
                FROM courses
            ");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            error_log("Error fetching total courses count: " . $e->getMessage());
            return 0;
        }
    }

    public function search($query)
    {
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

$guest = new Guest($pdo);
if (isset($_GET['search'])) {
    $courses = $guest->search($_GET['search']);
} else {
    $courses = $guest->getAllCoursesWithTeacher();
}