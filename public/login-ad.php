<?php
session_start();
require '../config/db.php';

$database = new Database();
$pdo = $database->connect();

class User
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function login($username, $password)
    {
        if (empty($username) || empty($password)) {
            return "All fields are required.";
        }

        $stmt = $this->pdo->prepare("SELECT * FROM admin WHERE log = ?");
        $stmt->execute([$username]);

        if ($stmt->rowCount() === 0) {
            return "Invalid username or password.";
        }

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!password_verify($password, $user['pass'])) {
            return "Invalid username or password.";
        }

        $_SESSION['id'] = $user['id'];
        $_SESSION['admin_role'] = $user['admin_role'];

        if ($user['admin_role'] === 'superadmin' || $user['admin_role'] === 'admin') {
            header("Location: admin/dashboard.php");
            exit();
        } else {
            return "Invalid admin account.";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
    $password = $_POST['password'];

    $user = new User($pdo);
    $message = $user->login($username, $password);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - YouDemy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="../assets/images/favicon.png" type="image/x-icon">
    <style>
        body {
            background: linear-gradient(135deg, #6b46c1, #553c9a);
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="flex max-w-6xl max-[980px]:w-[80%] bg-white rounded-lg shadow-2xl overflow-hidden">
        <div
            class="max-[980px]:hidden w-1/2 bg-gradient-to-r from-purple-600 to-blue-500 p-12 flex flex-col justify-center text-white">
            <h1 class="text-4xl font-bold mb-4">Admin Login</h1>
            <p class="text-lg mb-6">
                Please enter your admin credentials to access your admin dashboard.
            </p>
            <a href="index.php" class="flex items-center text-white hover:text-purple-200 transition duration-300">
                <i class="fas fa-arrow-left mr-2"></i> Back to Home
            </a>
        </div>

        <div class="w-1/2 max-[980px]:w-full p-12">
            <div class="flex justify-center mb-6">
                <img src="../assets/images/logobanner.png" alt="YouDemy Logo" class="h-12 w-auto">
            </div>

            <?php if (isset($message)): ?>
                <div
                    class="mb-4 p-4 text-center <?php echo strpos($message, 'pending') !== false ? 'bg-yellow-100 text-yellow-700' : (strpos($message, 'suspended') !== false ? 'bg-red-100 text-red-700' : 'bg-red-100 text-red-700'); ?> rounded-lg">
                    <?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-6">
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" id="username" name="username" placeholder="Enter your username"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                        required>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                        required>
                </div>

                <div>
                    <button type="submit"
                        class="w-full bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition duration-300">
                        Log In
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Not an admin? <a href="login.php" class="text-purple-600 hover:text-purple-700">Go to student
                        login</a>
                </p>
            </div>
            <a href="index.php" class="min-[980px]:hidden flex items-center mt-6 text-black transition duration-300">
                <i class="fas fa-arrow-left mr-2"></i> Back to Home
            </a>
        </div>
    </div>
</body>

</html>