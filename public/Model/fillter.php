<?php

$database = new Database();
$pdo = $database->connect();

$stmtCategories = $pdo->query("SELECT * FROM categories");
$categories = $stmtCategories->fetchAll();

$stmtTags = $pdo->query("SELECT * FROM tags");
$tags = $stmtTags->fetchAll();

$stmtEnrolledCourses = $pdo->prepare("
    SELECT courses.* 
    FROM courses
    JOIN enrollments ON courses.course_id = enrollments.course_id
    WHERE enrollments.user_id = ?
");
$stmtEnrolledCourses->execute([$_SESSION['user_id']]);
$enrolledCourses = $stmtEnrolledCourses->fetchAll();

$stmtNonEnrolledCourses = $pdo->prepare("
    SELECT courses.* 
    FROM courses
    WHERE courses.course_id NOT IN (
        SELECT course_id FROM enrollments WHERE user_id = ?
    )
");
$stmtNonEnrolledCourses->execute([$_SESSION['user_id']]);
$nonEnrolledCourses = $stmtNonEnrolledCourses->fetchAll();

?>