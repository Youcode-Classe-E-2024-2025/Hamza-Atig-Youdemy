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
        return isset($_SESSION['id']);
    }

    public function isStudent()
    {
        return isset($_SESSION['admin_role']) && $_SESSION['admin_role'] === 'admin';
    }

    public function getUserName($user_id)
    {
        $stmt = $this->pdo->prepare("SELECT log FROM admin WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch();
        return $user['log'];
    }
}

$user = new User($pdo);

if (!$user->isLoggedIn() || !$user->isStudent()) {
    header("Location: ../login-ad.php");
    exit();
}

$user_name = $user->getUserName($_SESSION['id']);
?>