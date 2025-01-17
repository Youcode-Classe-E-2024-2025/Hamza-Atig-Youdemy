<?php

$database = new Database();
$pdo = $database->connect();

try {
    $stmt = $pdo->prepare("
        SELECT courses.*, users.username AS teacher_name
        FROM courses
        JOIN users ON courses.teacher_id = users.user_id
        ORDER BY courses.created_at DESC
    ");
    $stmt->execute();
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching courses: " . $e->getMessage());
}
?>