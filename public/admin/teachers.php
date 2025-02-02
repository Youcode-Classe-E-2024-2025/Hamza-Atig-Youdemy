<?php

session_start();

require '../../config/db.php';
require '../Model/check-ad.php';
require '../Model/teacher_request.php';


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
                        <a href="./dashboard.php"
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
                            <a href="#" class="block p-2 text-gray-700 rounded-lg"><i
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
                        <a href="../logout.php"
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
                    <h1 class="text-3xl font-bold text-purple-800">Teacher Requests</h1>
                    <p class="text-gray-600">Review and manage teacher requests.</p>
                </div>

                <div class="mb-8">
                    <div class="flex space-x-4 border-b">
                        <button
                            class="tab-button px-4 py-2 text-purple-800 border-b-2 border-purple-800">Pending</button>
                        <button class="tab-button px-4 py-2 text-gray-500 hover:text-purple-800">Accepted</button>
                        <button class="tab-button px-4 py-2 text-gray-500 hover:text-purple-800">Refused</button>
                    </div>
                </div>

                <div id="pending-requests" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                    <?php foreach ($pendingTeachers as $teacher): ?>
                        <div class="request-card bg-white p-6 rounded-lg shadow-md transition duration-300">
                            <div class="flex items-center space-x-4 mb-4">
                                <img src="../../assets/images/Guest-user.png" alt="User Avatar"
                                    class="w-10 h-10 rounded-full">
                                <div>
                                    <h3 class="text-lg font-semibold text-purple-800">
                                        <?php echo htmlspecialchars($teacher['username'], ENT_QUOTES, 'UTF-8'); ?></h3>
                                    <p class="text-sm text-gray-500">
                                        <?php echo htmlspecialchars($teacher['email'], ENT_QUOTES, 'UTF-8'); ?></p>
                                </div>
                            </div>
                            <div class="mb-4">
                                <p class="text-sm text-gray-600">Requested to become a teacher.</p>
                            </div>
                            <div class="flex items-center justify-between">
                                <form action="" method="POST" class="inline">
                                    <input type="hidden" name="user_id" value="<?php echo $teacher['user_id']; ?>">
                                    <input type="hidden" name="status" value="active">
                                    <button type="submit"
                                        class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition duration-300">
                                        <i class="fas fa-check mr-2"></i>Accept
                                    </button>
                                </form>
                                <form action="" method="POST" class="inline">
                                    <input type="hidden" name="user_id" value="<?php echo $teacher['user_id']; ?>">
                                    <input type="hidden" name="status" value="suspended">
                                    <button type="submit"
                                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition duration-300">
                                        <i class="fas fa-times mr-2"></i>Refuse
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div id="accepted-requests" class="hidden grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php
                    $stmt = $database->connect()->prepare("SELECT * FROM users WHERE role = 'teacher' AND status = 'active'");
                    $stmt->execute();
                    $acceptedTeachers = $stmt->fetchAll();
                    foreach ($acceptedTeachers as $teacher):
                    ?>
                        <div class="request-card bg-white p-6 rounded-lg shadow-md transition duration-300">
                            <div class="flex items-center space-x-4 mb-4">
                                <img src="../../assets/images/Guest-user.png" alt="User Avatar"
                                    class="w-10 h-10 rounded-full">
                                <div>
                                    <h3 class="text-lg font-semibold text-purple-800">
                                        <?php echo htmlspecialchars($teacher['username'], ENT_QUOTES, 'UTF-8'); ?></h3>
                                    <p class="text-sm text-gray-500">
                                        <?php echo htmlspecialchars($teacher['email'], ENT_QUOTES, 'UTF-8'); ?></p>
                                </div>
                            </div>
                            <div class="mb-4">
                                <p class="text-sm text-gray-600">Accepted to become a teacher.</p>
                            </div>
                            <div class="flex items-center justify-center">
                                <span class="text-sm text-green-500"><i class="fas fa-check-circle mr-2"></i>Accepted</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div id="refused-requests" class="hidden grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php
                    $stmt = $database->connect()->prepare("SELECT * FROM users WHERE role = 'teacher' AND status = 'suspended'");
                    $stmt->execute();
                    $refusedTeachers = $stmt->fetchAll();
                    foreach ($refusedTeachers as $teacher):
                    ?>
                        <div class="request-card bg-white p-6 rounded-lg shadow-md transition duration-300">
                            <div class="flex items-center space-x-4 mb-4">
                                <img src="../../assets/images/Guest-user.png" alt="User Avatar"
                                    class="w-10 h-10 rounded-full">
                                <div>
                                    <h3 class="text-lg font-semibold text-purple-800">
                                        <?php echo htmlspecialchars($teacher['username'], ENT_QUOTES, 'UTF-8'); ?></h3>
                                    <p class="text-sm text-gray-500">
                                        <?php echo htmlspecialchars($teacher['email'], ENT_QUOTES, 'UTF-8'); ?></p>
                                </div>
                            </div>
                            <div class="mb-4">
                                <p class="text-sm text-gray-600">Specializes in UI/UX Design.</p>
                            </div>
                            <div class="flex items-center justify-center">
                                <span class="text-sm text-red-500"><i class="fas fa-times-circle mr-2"></i>Refused</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </main>

        <script>
            const tabs = document.querySelectorAll('.tab-button');
            const pendingSection = document.getElementById('pending-requests');
            const acceptedSection = document.getElementById('accepted-requests');
            const refusedSection = document.getElementById('refused-requests');

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    tabs.forEach(t => t.classList.remove('border-purple-800', 'text-purple-800'));
                    tabs.forEach(t => t.classList.add('text-gray-500'));

                    tab.classList.add('border-purple-800', 'text-purple-800');
                    tab.classList.remove('text-gray-500');

                    if (tab.textContent === 'Pending') {
                        pendingSection.classList.remove('hidden');
                        acceptedSection.classList.add('hidden');
                        refusedSection.classList.add('hidden');
                    } else if (tab.textContent === 'Accepted') {
                        pendingSection.classList.add('hidden');
                        acceptedSection.classList.remove('hidden');
                        refusedSection.classList.add('hidden');
                    } else if (tab.textContent === 'Refused') {
                        pendingSection.classList.add('hidden');
                        acceptedSection.classList.add('hidden');
                        refusedSection.classList.remove('hidden');
                    }
                });
            });
        </script>
    </div>
</body>

</html>