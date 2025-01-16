<?php
$database = new Database();
$pdo = $database->connect();

class User
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    public function isStudent()
    {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'student';
    }

    public function getUserName($user_id)
    {
        $stmt = $this->pdo->prepare("SELECT username FROM users WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch();
        return $user['username'];
    }
}

$user = new User($pdo);

if (!$user->isLoggedIn() || !$user->isStudent()) {
    header("Location: ../login.php");
    exit();
}

$user_name = $user->getUserName($_SESSION['user_id']);
?>