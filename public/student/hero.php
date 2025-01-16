<?php
session_start();

require '../../config/db.php';
require '../Model/fillter.php';

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
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouDemy - Student</title>
    <link rel="stylesheet" href="../../assets/css/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="shortcut icon" href="../../assets/images/favicon.png" type="image/x-icon">
    <style>
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 240px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.1);
            z-index: 1;
            border-radius: 8px;
            padding: 12px;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: flex;
            align-items: center;
            font-size: 14px;
            transition: background-color 0.2s;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown-content .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .dropdown-content .dropdown-item i {
            font-size: 16px;
            color: #6b7280;
        }

        .dropdown-content .dropdown-item .item-details {
            display: flex;
            flex-direction: column;
        }

        .dropdown-content .dropdown-item .item-title {
            font-weight: 600;
            color: #111827;
        }

        .dropdown-content .dropdown-item .item-description {
            font-size: 12px;
            color: #6b7280;
        }

        .search-bar {
            display: flex;
            align-items: center;
            background-color: #f3f4f6;
            border-radius: 12px;
            padding: 8px 12px;
            margin-left: 16px;
        }

        .search-bar input {
            border: none;
            outline: none;
            background: transparent;
            margin-left: 8px;
            width: 200px;
        }

        .search-bar i {
            color: #6b7280;
        }

        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 1s ease-out;
        }

        .animate-fade-in-up {
            animation: fade-in-up 1s ease-out;
        }

        .delay-100 {
            animation-delay: 0.1s;
        }

        .delay-200 {
            animation-delay: 0.2s;
        }
    </style>
</head>

<body>
    <header
        class="fixed inset-x-0 top-0 z-30 mx-auto w-full max-w-screen-md border border-gray-100 bg-white/80 py-3 shadow backdrop-blur-lg md:top-6 md:rounded-3xl lg:max-w-screen-lg">
        <div class="px-4">
            <div class="flex items-center justify-between">
                <div class="flex shrink-0">
                    <a aria-current="page" class="flex items-center" href="./hero.html">
                        <img class="h-9 w-auto" src="../../assets/images/logobanner.png" alt="">
                    </a>
                </div>
                <div class="hidden md:flex md:items-center md:justify-center md:gap-5">
                    <div class="dropdown">
                        <a aria-current="page"
                            class="inline-block rounded-lg px-2 py-1 text-sm font-medium text-gray-900 transition-all duration-200 hover:bg-gray-100 hover:text-gray-900"
                            href="#">
                            <i class="fas fa-book mr-1"></i>Courses
                        </a>
                        <div class="dropdown-content w-[600px] p-6 grid grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Categories</h3>
                                <ul class="space-y-3">
                                    <?php $count = 0;
                                    foreach ($categories as $category): ?>
                                        <?php if (++$count > 3)
                                            break; ?>
                                        <li>
                                            <a href="#"
                                                class="flex items-center text-gray-700 hover:text-purple-600 transition duration-300">
                                                <i class="fas fa-laptop-code text-purple-600 mr-2"></i>
                                                <?php echo $category['category_name']; ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Popular Courses</h3>
                                <ul class="space-y-3">
                                    <?php $count = 0;
                                    foreach ($enrolledCourses as $course): ?>
                                        <?php if (++$count > 2)
                                            break; ?>
                                        <li>
                                            <a href="#"
                                                class="flex items-center text-gray-700 hover:text-purple-600 transition duration-300">
                                                <i class="fas fa-star text-yellow-400 mr-2"></i>
                                                <div>
                                                    <span class="font-medium"><?php echo $course['title']; ?></span>
                                                    <p class="text-sm text-gray-500"><?php echo $course['description']; ?>
                                                    </p>
                                                </div>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="dropdown">
                        <a class="inline-block rounded-lg px-2 py-1 text-sm font-medium text-gray-900 transition-all duration-200 hover:bg-gray-100 hover:text-gray-900"
                            href="#">
                            <i class="fas fa-chalkboard-teacher mr-1"></i>Tutors
                        </a>
                        <div class="dropdown-content">
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-search"></i>
                                <div class="item-details">
                                    <span class="item-title">Find a Tutor</span>
                                    <span class="item-description">Connect with expert tutors in various fields.</span>
                                </div>
                            </a>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-user-plus"></i>
                                <div class="item-details">
                                    <span class="item-title">Become a Tutor</span>
                                    <span class="item-description">Share your knowledge and earn money.</span>
                                </div>
                            </a>
                        </div>
                    </div>
                    <a class="inline-block rounded-lg px-2 py-1 text-sm font-medium text-gray-900 transition-all duration-200 hover:bg-gray-100 hover:text-gray-900"
                        href="#">
                        <i class="fas fa-graduation-cap mr-1"></i>Community
                    </a>
                </div>
                <div class="flex items-center justify-end gap-3">
                    <div class="search-bar flex items-center bg-gray-100 rounded-lg px-3 py-2">
                        <i class="fas fa-search text-gray-500"></i>
                        <input type="text" placeholder="Search courses, tutors..."
                            class="ml-2 bg-transparent focus:outline-none w-48">
                    </div>
                    <a href="../logout.php"
                        class="h-8 px-3 py-2 flex items-center justify-center rounded-xl bg-white text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition-all duration-150 hover:bg-gray-50 sm:inline-flex">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        <span class="font-semibold pr-1">Log Out</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main class="p-8 min-h-screen mt-24">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white rounded-xl shadow-lg p-8 mb-8 border border-purple-100">
                <h1 class="text-4xl font-bold text-purple-900 mb-2">Welcome Back,
                    <?php echo htmlspecialchars($user_name, ENT_QUOTES, 'UTF-8'); ?>! 👋</h1>
                <p class="text-sm text-purple-600">Track your skills and progress with our interactive radar chart. Keep
                    growing and improving!</p>
                <div class="mt-6 flex space-x-4">
                    <a href="./inrollnow.php"
                        class="bg-white text-purple-600 px-6 py-2 rounded-lg border border-purple-600 hover:bg-purple-50 transition-colors">
                        Enroll in New Course
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-8 border border-purple-100">
                <h2 class="text-3xl font-bold text-purple-900 mb-6">Skills Overview</h2>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="bg-gradient-to-r from-purple-600 to-purple-400 rounded-xl p-6 shadow-lg">
                        <div class="bg-white rounded-lg p-4">
                            <canvas id="skillsChart"></canvas>
                        </div>
                    </div>
                    <div class="space-y-6">
                        <div class="bg-purple-50 rounded-xl p-6 border border-purple-100">
                            <h3 class="text-xl font-semibold text-purple-900 mb-4">Skill Levels</h3>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm text-purple-600">React</p>
                                    <div class="w-1/2 bg-purple-200 rounded-full h-2">
                                        <div class="bg-purple-600 h-2 rounded-full" style="width: 85%;"></div>
                                    </div>
                                    <span class="text-sm font-bold text-purple-600">85%</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <p class="text-sm text-purple-600">Python</p>
                                    <div class="w-1/2 bg-purple-200 rounded-full h-2">
                                        <div class="bg-purple-600 h-2 rounded-full" style="width: 90%;"></div>
                                    </div>
                                    <span class="text-sm font-bold text-purple-600">90%</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <p class="text-sm text-purple-600">Flutter</p>
                                    <div class="w-1/2 bg-purple-200 rounded-full h-2">
                                        <div class="bg-purple-600 h-2 rounded-full" style="width: 75%;"></div>
                                    </div>
                                    <span class="text-sm font-bold text-purple-600">75%</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <p class="text-sm text-purple-600">UI/UX</p>
                                    <div class="w-1/2 bg-purple-200 rounded-full h-2">
                                        <div class="bg-purple-600 h-2 rounded-full" style="width: 80%;"></div>
                                    </div>
                                    <span class="text-sm font-bold text-purple-600">80%</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <p class="text-sm text-purple-600">Database</p>
                                    <div class="w-1/2 bg-purple-200 rounded-full h-2">
                                        <div class="bg-purple-600 h-2 rounded-full" style="width: 70%;"></div>
                                    </div>
                                    <span class="text-sm font-bold text-purple-600">70%</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-purple-50 rounded-xl p-6 border border-purple-100">
                            <h3 class="text-xl font-semibold text-purple-900 mb-4">Quick Actions</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <a href="#"
                                    class="bg-white rounded-xl p-4 text-center hover:bg-purple-100 transition-colors shadow-md">
                                    <i class="fas fa-book text-2xl text-purple-600 mb-2"></i>
                                    <p class="text-sm font-medium text-purple-900">View Courses</p>
                                </a>
                                <a href="#"
                                    class="bg-white rounded-xl p-4 text-center hover:bg-purple-100 transition-colors shadow-md">
                                    <i class="fas fa-chart-line text-2xl text-purple-600 mb-2"></i>
                                    <p class="text-sm font-medium text-purple-900">Track Progress</p>
                                </a>
                                <a href="#"
                                    class="bg-white rounded-xl p-4 text-center hover:bg-purple-100 transition-colors shadow-md">
                                    <i class="fas fa-trophy text-2xl text-purple-600 mb-2"></i>
                                    <p class="text-sm font-medium text-purple-900">Achievements</p>
                                </a>
                                <a href="#"
                                    class="bg-white rounded-xl p-4 text-center hover:bg-purple-100 transition-colors shadow-md">
                                    <i class="fas fa-users text-2xl text-purple-600 mb-2"></i>
                                    <p class="text-sm font-medium text-purple-900">Community</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">
                <div class="bg-white rounded-xl shadow-lg p-8 border border-purple-100">
                    <h2 class="text-2xl font-bold text-purple-900 mb-6">Recent Activity</h2>
                    <div class="space-y-4">
                        <div class="flex items-center space-x-4">
                            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-check text-purple-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-purple-900">Completed React Course</p>
                                <p class="text-xs text-purple-400">2 hours ago</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-trophy text-purple-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-purple-900">Achievement Unlocked: Python Pro</p>
                                <p class="text-xs text-purple-400">1 day ago</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-8 border border-purple-100">
                    <h2 class="text-2xl font-bold text-purple-900 mb-6">Upcoming Goals</h2>
                    <div class="space-y-4">
                        <div class="flex items-center space-x-4">
                            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-bullseye text-purple-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-purple-900">Complete Flutter Project</p>
                                <p class="text-xs text-purple-400">Due in 3 days</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-book text-purple-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-purple-900">Start UI/UX Design Course</p>
                                <p class="text-xs text-purple-400">Due in 5 days</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const skillsCtx = document.getElementById('skillsChart').getContext('2d');
        const skillsChart = new Chart(skillsCtx, {
            type: 'radar',
            data: {
                labels: ['React', 'Python', 'Flutter', 'UI/UX', 'Database'],
                datasets: [{
                    label: 'Your Skills',
                    data: [85, 90, 75, 80, 70],
                    backgroundColor: 'rgba(124, 58, 237, 0.2)',
                    borderColor: '#7C3AED',
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    r: {
                        angleLines: {
                            color: '#E5E7EB',
                        },
                        grid: {
                            color: '#E5E7EB',
                        },
                        pointLabels: {
                            color: '#6B7280',
                        },
                        ticks: {
                            display: false,
                            beginAtZero: true,
                            max: 100,
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false,
                    },
                },
            }
        });
    </script>

    <footer class="bg-gray-50 text-gray-800 py-12 border-t-2">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-600 hover:text-purple-600 transition duration-300">About
                                    Us</a></li>
                            <li><a href="#"
                                    class="text-gray-600 hover:text-purple-600 transition duration-300">Courses</a></li>
                            <li><a href="#"
                                    class="text-gray-600 hover:text-purple-600 transition duration-300">Tutors</a></li>
                            <li><a href="#"
                                    class="text-gray-600 hover:text-purple-600 transition duration-300">Contact</a></li>
                            <li><a href="#" class="text-gray-600 hover:text-purple-600 transition duration-300">Privacy
                                    Policy</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Contact Us</h3>
                        <ul class="space-y-2">
                            <li class="text-gray-600">
                                <i class="fas fa-envelope mr-2 text-purple-600"></i>info@youdemy.com
                            </li>
                            <li class="text-gray-600">
                                <i class="fas fa-phone mr-2 text-purple-600"></i>+1 (123) 456-7890
                            </li>
                            <li class="text-gray-600">
                                <i class="fas fa-map-marker-alt mr-2 text-purple-600"></i>123 Learning St, Knowledge
                                City
                            </li>
                        </ul>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Subscribe to Our Newsletter</h3>
                    <form class="flex flex-col space-y-4">
                        <input type="email" placeholder="Your email address"
                            class="px-4 py-2 rounded-lg bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-600">
                        <button type="submit"
                            class="bg-gradient-to-r from-purple-600 to-blue-500 text-white px-4 py-2 rounded-lg hover:from-purple-700 hover:to-blue-600 transition duration-300">
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>
            <div class="border-t border-gray-200 mt-8 pt-8 text-center">
                <p class="text-gray-600">
                    &copy; 2023 YouDemy. All rights reserved.
                </p>
            </div>
        </div>
    </footer>
</body>

</html>