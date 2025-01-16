<?php
session_start();

require '../../config/db.php';

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
        return isset($_SESSION['role']) && $_SESSION['role'] === 'teacher';
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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher - YouDemy</title>
    <link rel="stylesheet" href="../../assets/css/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="shortcut icon" href="../../assets/images/favicon.png" type="image/x-icon">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
            margin: 0;
            padding: 0;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #ffffff;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            padding: 20px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            padding: 12px;
            margin: 8px 0;
            color: #4b5563;
            text-decoration: none;
            border-radius: 8px;
            transition: background-color 0.3s, color 0.3s;
        }

        .sidebar a:hover {
            background-color: #f3f4f6;
            color: #111827;
        }

        .sidebar a i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
        }

        .sidebar .active {
            background-color: #4f46e5;
            color: white;
        }

        .sidebar .active:hover {
            background-color: #4338ca;
        }

        .main-content {
            margin-left: 250px;
            padding: 24px;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background-color: white;
            padding: 24px;
            border-radius: 12px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .modal-content h2 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 16px;
        }

        .modal-content input,
        .modal-content textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 16px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
        }

        .modal-content button {
            background-color: #4f46e5;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .modal-content button:hover {
            background-color: #4338ca;
        }

        .modal-close {
            position: absolute;
            top: 6px;
            right: 6px;
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #6b7280;
        }

        .modal-close:hover {
            color: #111827;
        }

        .card {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                padding: 10px;
            }

            .main-content {
                margin-left: 0;
                padding: 16px;
            }
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <a href="#" class="active">
            <i class="fas fa-tachometer-alt"></i>
            Dashboard
        </a>
        <a href="#">
            <i class="fas fa-users"></i>
            View Enroll Requests
        </a>
        <a href="#">
            <i class="fas fa-book"></i>
            My Courses
        </a>
        <a href="#">
            <i class="fas fa-chart-line"></i>
            Analytics
        </a>
        <a href="#">
            <i class="fas fa-cog"></i>
            Settings
        </a>
    </div>

    <div class="main-content">
        <section class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Welcome Back, Teacher!</h1>
            <p class="text-gray-600 mt-2">Here's an overview of your courses and activities.</p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Analytics Overview</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="card p-6">
                    <h3 class="text-lg font-semibold text-gray-900">Total Students</h3>
                    <p class="text-3xl font-bold text-purple-600 mt-2">55</p>
                    <p class="text-sm text-gray-500">Enrolled in your courses</p>
                </div>
                <div class="card p-6">
                    <h3 class="text-lg font-semibold text-gray-900">Course Completion Rate</h3>
                    <p class="text-3xl font-bold text-blue-600 mt-2">78%</p>
                    <p class="text-sm text-gray-500">Average across all courses</p>
                </div>
                <div class="card p-6">
                    <h3 class="text-lg font-semibold text-gray-900">Student Satisfaction</h3>
                    <p class="text-3xl font-bold text-green-600 mt-2">4.5/5</p>
                    <p class="text-sm text-gray-500">Based on feedback</p>
                </div>
            </div>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Quick Actions</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="card p-6 text-center hover:bg-gray-50 cursor-pointer" onclick="openModal()">
                    <i class="fas fa-plus-circle text-2xl text-purple-600 mb-4"></i>
                    <h3 class="text-lg font-semibold text-gray-900">Create New Course</h3>
                    <p class="text-sm text-gray-500 mt-2">Start building a new course from scratch.</p>
                </div>
                <div class="card p-6 text-center hover:bg-gray-50 cursor-pointer">
                    <i class="fas fa-edit text-2xl text-blue-600 mb-4"></i>
                    <h3 class="text-lg font-semibold text-gray-900">Edit Existing Course</h3>
                    <p class="text-sm text-gray-500 mt-2">Update and improve your existing courses.</p>
                </div>
                <div class="card p-6 text-center hover:bg-gray-50 cursor-pointer">
                    <i class="fas fa-chart-line text-2xl text-green-600 mb-4"></i>
                    <h3 class="text-lg font-semibold text-gray-900">View Analytics</h3>
                    <p class="text-sm text-gray-500 mt-2">Track student progress and performance.</p>
                </div>
                <div class="card p-6 text-center hover:bg-gray-50 cursor-pointer">
                    <i class="fas fa-comments text-2xl text-orange-600 mb-4"></i>
                    <h3 class="text-lg font-semibold text-gray-900">Student Feedback</h3>
                    <p class="text-sm text-gray-500 mt-2">Read feedback from your students.</p>
                </div>
            </div>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Your Courses</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="card">
                    <div class="flex flex-col">
                        <img src="../../assets/images/CoursesCover/C3.png" alt="Course Cover"
                            class="w-full h-40 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">React Masterclass</h3>
                            <p class="text-sm text-gray-600 mb-4">Build modern web apps with React. Learn hooks, state
                                management, and more.</p>
                            <div class="flex items-center mb-4">
                                <img src="../../assets/images/Guest-user.png" alt="Instructor"
                                    class="w-10 h-10 rounded-full mr-3">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">John Doe</p>
                                    <p class="text-xs text-gray-500">Senior Frontend Developer</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="flex text-yellow-400">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <span class="text-sm text-gray-600 ml-2">4.5 (1.2k reviews)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Recent Activities</h2>
            <div class="card p-6">
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center gap-4">
                            <i class="fas fa-user-plus text-purple-600"></i>
                            <div>
                                <h3 class="text-sm font-semibold text-gray-900">New Student Enrolled</h3>
                                <p class="text-xs text-gray-500">John Doe joined your React Masterclass course.</p>
                            </div>
                        </div>
                        <span class="text-xs text-gray-500">2 hours ago</span>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div id="addCourseModal" class="modal">
        <div class="modal-content">
            <button class="modal-close" onclick="closeModal()">&times;</button>
            <h2>Create New Course</h2>
            <input type="text" placeholder="Course Title" required>
            <textarea placeholder="Course Description" rows="4" required></textarea>
            <button onclick="closeModal()">Create Course</button>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('addCourseModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('addCourseModal').style.display = 'none';
        }
    </script>
</body>

</html>