<?php

session_start();

require '../../config/db.php';
require '../Model/check-ad.php';
require '../Model/courses-getter-for-non-log.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="shortcut icon" href="../../assets/images/favicon.png" type="image/x-icon">
    <style>
        .dropdown-content {
            display: none;
            margin-top: 4px;
            margin-left: 16px;
            border-left: 2px solid #e5e7eb;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown-content a {
            transition: all 0.3s ease;
        }

        .dropdown-content a:hover {
            background: #f3f4f6;
            padding-left: 12px;
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="flex">
        <header class="sidebar fixed h-screen w-64 bg-white shadow-lg overflow-y-auto">
            <div class="p-6 border-b">
                <img src="../../assets/images/logobanner.png" alt="youdemy logo" class="h-20">
            </div>

            <nav class="p-4">
                <ul class="space-y-2">
                    <li>
                        <a href="#"
                            class="flex items-center p-3 text-gray-700 hover:bg-purple-50 rounded-lg transition duration-300">
                            <i class="fas fa-tachometer-alt text-purple-600 mr-3"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="#"
                            class="flex items-center p-3 text-gray-700 hover:bg-purple-50 rounded-lg transition duration-300">
                            <i class="fas fa-users text-purple-600 mr-3"></i>
                            Users
                            <i class="fas fa-chevron-down ml-auto text-purple-400"></i>
                        </a>
                        <div class="dropdown-content pl-4">
                            <a href="./allusers.php" class="block p-2 text-gray-700 rounded-lg"><i
                                    class="fas fa-users mr-2"></i>All Users</a>
                            <a href="./teachers.php" class="block p-2 text-gray-700 rounded-lg"><i
                                    class="fas fa-chalkboard-teacher mr-2"></i>Teacher Programe</a>
                        </div>
                    </li>
                    <li class="dropdown">
                        <a href="#"
                            class="flex items-center p-3 text-gray-700 hover:bg-purple-50 rounded-lg transition duration-300">
                            <i class="fas fa-book-open text-purple-600 mr-3"></i>
                            Courses
                            <i class="fas fa-chevron-down ml-auto text-purple-400"></i>
                        </a>
                        <div class="dropdown-content pl-4">
                            <a href="add-tag.php" class="block p-2 text-gray-700 rounded-lg">
                                <i class="fas fa-tag mr-2"></i> Add New Tag
                            </a>
                            <a href="#" class="block p-2 text-gray-700 rounded-lg">
                                <i class="fas fa-list-alt mr-2"></i> Categories
                            </a>
                        </div>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center p-3 text-gray-700 hover:bg-purple-50 rounded-lg transition duration-300">
                            <i class="fas fa-chart-line text-purple-600 mr-3"></i>
                            Analytics
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center p-3 text-gray-700 hover:bg-purple-50 rounded-lg transition duration-300">
                            <i class="fas fa-cog text-purple-600 mr-3"></i>
                            Settings
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center p-3 text-gray-700 hover:bg-purple-50 rounded-lg transition duration-300">
                            <i class="fas fa-sign-out-alt text-purple-600 mr-3"></i>
                            Logout
                        </a>
                    </li>
                </ul>
            </nav>
        </header>

        <main class="flex-1 ml-64">
            <div class="p-8">
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-purple-800">Dashboard</h1>
                    <p class="text-gray-600">Welcome to your Youdemy statistics dashboard.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500">Total Users</p>
                                <?php
                                $stmt = $database->connect()->prepare("SELECT COUNT(*) FROM users");
                                $stmt->execute();
                                $total_users = $stmt->fetchColumn();
                                ?>
                                <p class="text-3xl font-bold text-purple-800"><?php echo $total_users; ?></p>
                            </div>
                            <i class="fas fa-users text-4xl text-purple-500"></i>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">+5.2% from last month</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500">Total Courses</p>
                                <?php
                                $stmt = $database->connect()->prepare("SELECT COUNT(*) FROM courses");
                                $stmt->execute();
                                $total_courses = $stmt->fetchColumn();
                                ?>
                                <p class="text-3xl font-bold text-purple-800"><?php echo $total_courses; ?></p>
                            </div>
                            <i class="fas fa-book-open text-4xl text-purple-500"></i>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">+12 new courses this month</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500">Total Revenue</p>
                                <p class="text-3xl font-bold text-purple-800">$0</p>
                            </div>
                            <i class="fas fa-dollar-sign text-4xl text-purple-500"></i>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">+8.7% from last month</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500">Active Subscriptions</p>
                                <p class="text-3xl font-bold text-purple-800">0</p>
                            </div>
                            <i class="fas fa-chart-line text-4xl text-purple-500"></i>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">+3.4% from last month</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h2 class="text-xl font-semibold text-purple-800 mb-4">User Growth</h2>
                        <canvas id="userGrowthChart"></canvas>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h2 class="text-xl font-semibold text-purple-800 mb-4">Course Enrollment</h2>
                        <canvas id="courseEnrollmentChart"></canvas>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md mb-8">
                    <h2 class="text-xl font-semibold text-purple-800 mb-4">Recent Activity</h2>
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b">
                                <th class="py-2">User</th>
                                <th class="py-2">Activity</th>
                                <th class="py-2">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b">
                                <td class="py-3">John Doe</td>
                                <td class="py-3">Enrolled in "Advanced JavaScript"</td>
                                <td class="py-3">2023-10-01</td>
                            </tr>
                            <tr class="border-b">
                                <td class="py-3">Jane Smith</td>
                                <td class="py-3">Completed "Python for Beginners"</td>
                                <td class="py-3">2023-10-02</td>
                            </tr>
                            <tr class="border-b">
                                <td class="py-3">Alice Johnson</td>
                                <td class="py-3">Purchased "Data Science Bootcamp"</td>
                                <td class="py-3">2023-10-03</td>
                            </tr>
                            <tr class="border-b">
                                <td class="py-3">Bob Brown</td>
                                <td class="py-3">Started "React Masterclass"</td>
                                <td class="py-3">2023-10-04</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold text-purple-800 mb-4">All Courses</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        <?php foreach ($courses as $course): ?>
                            <div class="course-card bg-white p-6 rounded-lg shadow-md transition duration-300">
                                <img src="../../storage/uploads/course_thumbnails/<?php echo htmlspecialchars($course['thumbnail'], ENT_QUOTES, 'UTF-8'); ?>" alt="Course Image"
                                    class="w-full h-40 object-cover rounded-lg mb-4">
                                <h3 class="text-xl font-semibold text-purple-800 mb-2"><?php echo htmlspecialchars($course['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
                                <p class="text-gray-600 mb-4"><?php echo htmlspecialchars($course['description'], ENT_QUOTES, 'UTF-8'); ?></p>
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-sm text-gray-500"><i class="fas fa-users mr-2"></i>***
                                        Enrollments</span>
                                    <span class="text-sm text-gray-500"><i
                                            class="fas fa-star text-yellow-500 mr-2"></i>4.7</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-500">Status: <span
                                            class="text-green-500">Published</span></span>
                                    <a href="#" class="text-purple-600 hover:text-purple-700">Copyright <i class="far fa-copyright"></i> 2023</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        const userGrowthCtx = document.getElementById('userGrowthChart').getContext('2d');
        new Chart(userGrowthCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                datasets: [{
                    label: 'Users',
                    data: [1000, 1200, 1500, 1800, 2000, 2400, 3000],
                    borderColor: '#4f46e5',
                    backgroundColor: 'rgba(79, 70, 229, 0.1)',
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const courseEnrollmentCtx = document.getElementById('courseEnrollmentChart').getContext('2d');
        new Chart(courseEnrollmentCtx, {
            type: 'bar',
            data: {
                labels: ['Web Dev', 'Data Science', 'Mobile Dev', 'UI/UX', 'Database'],
                datasets: [{
                    label: 'Enrollments',
                    data: [500, 300, 200, 150, 100],
                    backgroundColor: '#4f46e5',
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

</html>