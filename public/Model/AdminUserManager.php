<?php 

class AdminUserManager {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function getActiveUsers() {
        $query = "SELECT * FROM users";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function updateUserStatus($user_id, $status) {
        $query = "UPDATE users SET status = :status WHERE user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':user_id', $user_id);
        return $stmt->execute();
    }
}

$adminUserManager = new AdminUserManager();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $status = $_POST['status'];

    if ($adminUserManager->updateUserStatus($user_id, $status)) {
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "Failed to update status.";
    }
}

$activeUsers = $adminUserManager->getActiveUsers();

?>