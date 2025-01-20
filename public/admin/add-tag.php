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

        .tag-container {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            padding: 8px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background: white;
        }

        .tag-bubble {
            display: flex;
            align-items: center;
            padding: 4px 8px;
            background: #e5e7eb;
            border-radius: 16px;
            font-size: 14px;
            color: #374151;
        }

        .tag-bubble.existing {
            background: #fee2e2;
            color: #dc2626;
        }

        .tag-bubble i {
            margin-left: 8px;
            cursor: pointer;
        }

        .tag-input {
            flex: 1;
            border: none;
            outline: none;
            padding: 8px;
            font-size: 14px;
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
                        <a href="#"
                            class="flex items-center p-3 text-gray-700 hover:bg-purple-50 rounded-lg transition duration-300">
                            <i class="fas fa-sign-out-alt text-purple-600 mr-3"></i>
                            Logout
                        </a>
                    </li>
                </ul>
            </nav>
        </header>

        <main class="flex-1 ml-64 p-10">
            <h1 class="text-2xl font-bold mb-6">Add New Tags</h1>
            <form action="add-tag.php" method="POST" class="bg-white p-6 rounded-lg shadow-md">
                <input type="hidden" name="form_type" value="comma_separated">
                <div class="mb-4">
                    <label for="tags" class="block text-gray-700 text-sm font-bold mb-2">Enter Tags (comma
                        separated):</label>
                    <input type="text" name="tags" id="tags"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600"
                        placeholder="IT, WebDev, AI">
                </div>
                <button type="submit"
                    class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition duration-300">Add
                    Tags</button>
            </form>

            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                require '../Model/add-tag-model.php';

                $tagHandler = new Tag();
                $results = [];

                if (isset($_POST['form_type']) && $_POST['form_type'] === 'comma_separated') {
                    $tags = explode(',', $_POST['tags']);
                    $results = $tagHandler->addTags($tags);
                } elseif (isset($_POST['form_type']) && $_POST['form_type'] === 'tag_bubbles') {
                    $tags = explode(',', $_POST['tags']);
                    $results = $tagHandler->addTags($tags);
                }

                echo '<div class="mt-6">';
                foreach ($results as $tag => $success) {
                    $status = $success ? 'successfully' : 'failed (duplicate)';
                    echo "<p class='text-sm text-gray-700'>Tag '$tag' was added $status.</p>";
                }
                echo '</div>';
            }
            ?>
        </main>

    </div>
</body>

</html>