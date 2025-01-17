<?php

session_start();

require '../../config/db.php';
require '../Model/check-ad.php';

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
                        <a href="./dashboard.html" class="flex items-center p-3 text-gray-700 hover:bg-purple-50 rounded-lg transition duration-300">
                            <i class="fas fa-tachometer-alt text-purple-600 mr-3"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="flex items-center p-3 text-gray-700 hover:bg-purple-50 rounded-lg transition duration-300">
                            <i class="fas fa-users text-purple-600 mr-3"></i>
                            Users
                            <i class="fas fa-chevron-down ml-auto text-purple-400"></i>
                        </a>
                        <div class="dropdown-content pl-4">
                            <a href="./allusers.html" class="block p-2 text-gray-700 rounded-lg"><i class="fas fa-users mr-2"></i>All Users</a>
                            <a href="./teachers.html" class="block p-2 text-gray-700 rounded-lg"><i class="fas fa-chalkboard-teacher mr-2"></i>Teacher Programe</a>
                        </div>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="flex items-center p-3 text-gray-700 hover:bg-purple-50 rounded-lg transition duration-300">
                            <i class="fas fa-book-open text-purple-600 mr-3"></i>
                            Courses
                            <i class="fas fa-chevron-down ml-auto text-purple-400"></i>
                        </a>
                        <div class="dropdown-content pl-4">
                            <a href="#" class="block p-2 text-gray-700 rounded-lg">
                                <i class="fas fa-book mr-2"></i> All Courses
                            </a>
                            <a href="#" class="block p-2 text-gray-700 rounded-lg">
                                <i class="fas fa-tag mr-2"></i> Add New Tag
                            </a>
                            <a href="#" class="block p-2 text-gray-700 rounded-lg">
                                <i class="fas fa-list-alt mr-2"></i> Categories
                            </a>
                        </div>
                    </li>
                    <li>
                        <a href="#" class="flex items-center p-3 text-gray-700 hover:bg-purple-50 rounded-lg transition duration-300">
                            <i class="fas fa-chart-line text-purple-600 mr-3"></i>
                            Analytics
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center p-3 text-gray-700 hover:bg-purple-50 rounded-lg transition duration-300">
                            <i class="fas fa-cog text-purple-600 mr-3"></i>
                            Settings
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center p-3 text-gray-700 hover:bg-purple-50 rounded-lg transition duration-300">
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
                    <h1 class="text-3xl font-bold text-purple-800">User Management</h1>
                    <p class="text-gray-600">Manage all users, ban/unban accounts, and handle copyright issues.</p>
                </div>

                <div class="mb-8 flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <input type="text" placeholder="Search users..." class="p-2 border rounded-lg w-64">
                        <select class="p-2 border rounded-lg">
                            <option>All Users</option>
                            <option>Active Users</option>
                            <option>Banned Users</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <div class="user-card bg-white p-6 rounded-lg shadow-md transition duration-300">
                        <div class="flex items-center space-x-4 mb-4">
                            <img src="../../assets/images/Guest-user.png" alt="User Avatar" class="w-10 h-10 rounded-full">
                            <div>
                                <h3 class="text-lg font-semibold text-purple-800">John Doe</h3>
                                <p class="text-sm text-gray-500">john.doe@example.com</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm text-gray-500">Status: <span
                                    class="text-green-500">Active</span></span>
                            <span class="text-sm text-gray-500">Role: <span
                                    class="text-purple-600">Student</span></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <button class="text-red-500 hover:text-red-700">
                                <i class="fas fa-ban"></i> Ban
                            </button>
                            <button class="text-gray-600 hover:text-gray-800">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                        </div>
                    </div>

                    <div class="user-card bg-white p-6 rounded-lg shadow-md transition duration-300">
                        <div class="flex items-center space-x-4 mb-4">
                            <img src="../../assets/images/Guest-user.png" alt="User Avatar" class="w-10 h-10 rounded-full">
                            <div>
                                <h3 class="text-lg font-semibold text-purple-800">Jane Smith</h3>
                                <p class="text-sm text-gray-500">jane.smith@example.com</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm text-gray-500">Status: <span class="text-red-500">Banned</span></span>
                            <span class="text-sm text-gray-500">Role: <span
                                    class="text-purple-600">Student</span></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <button class="text-green-500 hover:text-green-700">
                                <i class="fas fa-check"></i> Unban
                            </button>
                            <button class="text-gray-600 hover:text-gray-800">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                        </div>
                    </div>

                    <div class="user-card bg-white p-6 rounded-lg shadow-md transition duration-300">
                        <div class="flex items-center space-x-4 mb-4">
                            <img src="../../assets/images/Guest-user.png" alt="User Avatar" class="w-10 h-10 rounded-full">
                            <div>
                                <h3 class="text-lg font-semibold text-purple-800">Alice Johnson</h3>
                                <p class="text-sm text-gray-500">alice.johnson@example.com</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm text-gray-500">Status: <span
                                    class="text-green-500">Active</span></span>
                            <span class="text-sm text-gray-500">Role: <span class="text-purple-600">Enseignant</span></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <button class="text-red-500 hover:text-red-700">
                                <i class="fas fa-ban"></i> Ban
                            </button>
                            <button class="text-purple-600 hover:text-purple-700">
                                <i class="fas fa-copyright"></i> Copyright
                            </button>
                            <button class="text-gray-600 hover:text-gray-800">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                        </div>
                    </div>

                    <div class="user-card bg-white p-6 rounded-lg shadow-md transition duration-300">
                        <div class="flex items-center space-x-4 mb-4">
                            <img src="../../assets/images/Guest-user.png" alt="User Avatar" class="w-10 h-10 rounded-full">
                            <div>
                                <h3 class="text-lg font-semibold text-purple-800">Bob Brown</h3>
                                <p class="text-sm text-gray-500">bob.brown@example.com</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm text-gray-500">Status: <span
                                    class="text-green-500">Active</span></span>
                            <span class="text-sm text-gray-500">Role: <span
                                    class="text-purple-600">Enseignant</span></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <button class="text-red-500 hover:text-red-700">
                                <i class="fas fa-ban"></i> Ban
                            </button>
                            <button class="text-purple-600 hover:text-purple-700">
                                <i class="fas fa-copyright"></i> Copyright
                            </button>
                            <button class="text-gray-600 hover:text-gray-800">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>