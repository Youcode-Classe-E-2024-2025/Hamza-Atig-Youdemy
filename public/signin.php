<?php
require '../config/db.php';

class User {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function signup($name, $email, $password, $role) {
        if (empty($name) || empty($email) || empty($password)) {
            return "All fields are required.";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Invalid email format.";
        }

        if (strlen($password) < 6) {
            return "Password must be at least 6 characters long.";
        }

        $stmt = $this->db->prepare("SELECT email FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            return "Email already exists.";
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $status = ($role === 'student') ? 'active' : 'pending';

        $stmt = $this->db->prepare("INSERT INTO users (username, email, password, role, status) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$name, $email, $hashedPassword, $role, $status])) {
            header("Location: login.php");
            exit();
        } else {
            return "Error: " . implode(" ", $stmt->errorInfo());
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];
    $role = htmlspecialchars($_POST['role'], ENT_QUOTES, 'UTF-8');

    if ($password !== $confirmPassword) {
        $message = "Passwords do not match.";
    } else {
        $user = new User();
        $message = $user->signup($name, $email, $password, $role);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - YouDemy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="../assets/images/favicon.png" type="image/x-icon">
    <style>
        body {
            background: linear-gradient(135deg, #6b46c1, #553c9a);
        }

        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 30px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: #ccc;
            transition: 0.4s;
            border-radius: 30px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 22px;
            width: 22px;
            left: 4px;
            bottom: 4px;
            background: white;
            transition: 0.4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background: linear-gradient(135deg, #6b46c1, #553c9a);
        }

        input:checked + .slider:before {
            transform: translateX(30px);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="flex max-w-6xl max-[980px]:w-[80%] bg-white rounded-lg shadow-2xl overflow-hidden">
        <div class="max-[980px]:hidden w-1/2 bg-gradient-to-r from-purple-600 to-blue-500 p-12 flex flex-col justify-center text-white">
            <h1 class="text-4xl font-bold mb-4">Join Us Today!</h1>
            <p class="text-lg mb-6">
                Unlock your potential with YouDemy. Sign up now to access expert-led courses and start your learning journey.
            </p>
            <a href="index.html"
                class="flex items-center text-white hover:text-purple-200 transition duration-300">
                <i class="fas fa-arrow-left mr-2"></i> Back to Home
            </a>
        </div>

        <div class="w-1/2 max-[980px]:w-full p-12">
            <div class="flex justify-center mb-6">
                <img src="../assets/images/logobanner.png" alt="YouDemy Logo" class="h-12 w-auto">
            </div>

            <?php if (isset($message)): ?>
                <div class="mb-4 p-4 text-center <?php echo strpos($message, 'successful') !== false ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?> rounded-lg">
                    <?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-6">
                <input type="hidden" name="role" id="role-hidden" value="student">

                <div class="flex justify-center mb-6">
                    <div class="flex items-center space-x-4">
                        <span class="text-sm font-medium text-gray-700">Student</span>
                        <label class="toggle-switch">
                            <input type="checkbox" id="role-toggle" onchange="updateRole()">
                            <span class="slider"></span>
                        </label>
                        <span class="text-sm font-medium text-gray-700">Teacher</span>
                    </div>
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter your full name"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" required>
                </div>

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
                    <label for="confirm-password" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm your password"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" required>
                </div>

                <div>
                    <button type="submit"
                        class="w-full bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition duration-300">
                        Sign Up
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Already have an account?
                    <a href="login.php" class="text-purple-600 hover:text-purple-700">Log in</a>
                </p>
            </div>
            <a href="index.html" class="min-[980px]:hidden flex items-center mt-6 text-black transition duration-300">
                <i class="fas fa-arrow-left mr-2"></i> Back to Home
            </a>
        </div>
    </div>

    <script>
        function updateRole() {
            const roleToggle = document.getElementById('role-toggle');
            const roleHidden = document.getElementById('role-hidden');
            roleHidden.value = roleToggle.checked ? 'teacher' : 'student';
        }
    </script>
</body>
</html>