<?php

$userId = $_SESSION['user_id'];

$sql = "SELECT c.category_name 
        FROM enrollments e
        JOIN courses co ON e.course_id = co.course_id
        JOIN categories c ON co.category_id = c.category_id
        WHERE e.user_id = ?
        ORDER BY e.enrolled_at DESC
        LIMIT 5";

$stmt = $pdo->prepare($sql);
$stmt->execute([$userId]);
$enrolledCourses4 = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT c.title, e.enrolled_at 
        FROM enrollments e
        JOIN courses c ON e.course_id = c.course_id
        WHERE e.user_id = ?
        ORDER BY e.enrolled_at DESC
        LIMIT 5";

$stmt = $pdo->prepare($sql);
$stmt->execute([$userId]);
$enrollments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>