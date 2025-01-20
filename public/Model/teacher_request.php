<?php

class TeacherRequest {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function getPendingTeachers() {
        $query = "SELECT * FROM users WHERE role = 'teacher' AND status = 'pending'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function updateStatus($user_id, $status) {
        $query = "UPDATE users SET status = :status WHERE user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':user_id', $user_id);
        return $stmt->execute();
    }
}

$teacherRequest = new TeacherRequest();

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $status = $_POST['status'];

    if ($teacherRequest->updateStatus($user_id, $status)) {
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "Failed to update status.";
    }
}

$pendingTeachers = $teacherRequest->getPendingTeachers();

?>