<?php
session_start();
require '../config/db.php';

$database = new Database();
$pdo = $database->connect();

class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function login($email, $password) {
        if (empty($email) || empty($password)) {
            return "All fields are required.";
        }
    
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
    
        if ($stmt->rowCount() === 0) {
            return "Invalid email or password.";
        }
    
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!password_verify($password, $user['password'])) {
            return "Invalid email or password.";
        }
    
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['status'] = $user['status'];
    
        if ($user['status'] === 'active') {
            if ($user['role'] === 'student') {
                header("Location: student/hero.php");
                exit();
            } elseif ($user['role'] === 'teacher') {
                header("Location: teacher/dashboard.php");
                exit();
            } else {
                return "Invalid role.";
            }
        } elseif ($user['status'] === 'pending') {
            return "Your account is pending approval. Please wait for admin confirmation.";
        } elseif ($user['status'] === 'suspended') {
            return "Your account has been suspended or banned by the admin.";
        } else {
            return "Invalid account status.";
        }
    }
    
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
    $password = $_POST['password'];

    $user = new User($pdo);
    $message = $user->login($email, $password);
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
        <div class="max-[980px]:hidden w-1/2 bg-gradient-to-r from-purple-600 to-blue-500 p-12 flex flex-col justify-center text-white">
            <h1 class="text-4xl font-bold mb-4">Welcome Back!</h1>
            <p class="text-lg mb-6">
                Sign in to continue your learning journey with YouDemy.
            </p>
            <a href="index.php"
                class="flex items-center text-white hover:text-purple-200 transition duration-300">
                <i class="fas fa-arrow-left mr-2"></i> Back to Home
            </a>
        </div>

        <div class="w-1/2 max-[980px]:w-full p-12">
            <div class="flex justify-center mb-6">
                <img src="../assets/images/logobanner.png" alt="YouDemy Logo" class="h-12 w-auto">
            </div>

            <?php if (isset($message)): ?>
                <div class="mb-4 p-4 text-center <?php echo strpos($message, 'pending') !== false ? 'bg-yellow-100 text-yellow-700' : (strpos($message, 'suspended') !== false ? 'bg-red-100 text-red-700' : 'bg-red-100 text-red-700'); ?> rounded-lg">
                    <?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-6">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" required>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" required>
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
                    Don't have an account?
                    <a href="signin.php" class="text-purple-600 hover:text-purple-700">Sign up</a>
                </p>
                <p class="text-sm text-gray-600">
                    You are a admin?
                    <a href="login-ad.php" class="text-purple-600 hover:text-purple-700">Go To Admin</a>
                </p>
            </div>
            <a href="index.php" class="min-[980px]:hidden flex items-center mt-6 text-black transition duration-300">
                <i class="fas fa-arrow-left mr-2"></i> Back to Home
            </a>
        </div>
    </div>
</body>
</html>