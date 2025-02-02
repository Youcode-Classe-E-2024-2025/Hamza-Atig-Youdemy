<?php
session_start();
require '../../config/db.php';
require '../Model/courses-getter-for-non-log.php';

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$perPage = 1;

$guest = new Guest($pdo);

if (isset($_GET['search'])) {
    $courses = $guest->search($_GET['search']);
} else {
    $courses = $guest->getPaginatedCoursesWithTeacher($page, $perPage);
}

$totalCourses = $guest->getTotalCoursesCount();
$totalPages = ceil($totalCourses / $perPage);
?>

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouDemy - Home</title>
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
                    <a aria-current="page" class="flex items-center" href="../index.php">
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
                                    <li>
                                        <a href="#"
                                            class="flex items-center text-gray-700 hover:text-purple-600 transition duration-300">
                                            <i class="fas fa-laptop-code text-purple-600 mr-2"></i>
                                            Web Development
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="flex items-center text-gray-700 hover:text-purple-600 transition duration-300">
                                            <i class="fas fa-chart-line text-purple-600 mr-2"></i>
                                            Data Science
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="flex items-center text-gray-700 hover:text-purple-600 transition duration-300">
                                            <i class="fas fa-mobile-alt text-purple-600 mr-2"></i>
                                            Mobile App Development
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="flex items-center text-gray-700 hover:text-purple-600 transition duration-300">
                                            <i class="fas fa-paint-brush text-purple-600 mr-2"></i>
                                            UI/UX Design
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="flex items-center text-gray-700 hover:text-purple-600 transition duration-300">
                                            <i class="fas fa-database text-purple-600 mr-2"></i>
                                            Database Management
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Popular Courses</h3>
                                <ul class="space-y-3">
                                    <li>
                                        <a href="#"
                                            class="flex items-center text-gray-700 hover:text-purple-600 transition duration-300">
                                            <i class="fas fa-star text-yellow-400 mr-2"></i>
                                            <div>
                                                <span class="font-medium">React Masterclass</span>
                                                <p class="text-sm text-gray-500">Build modern web apps with React.</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="flex items-center text-gray-700 hover:text-purple-600 transition duration-300">
                                            <i class="fas fa-star text-yellow-400 mr-2"></i>
                                            <div>
                                                <span class="font-medium">Python for Data Science</span>
                                                <p class="text-sm text-gray-500">Master Python for data analysis and
                                                    machine learning.</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="flex items-center text-gray-700 hover:text-purple-600 transition duration-300">
                                            <i class="fas fa-star text-yellow-400 mr-2"></i>
                                            <div>
                                                <span class="font-medium">Flutter Essentials</span>
                                                <p class="text-sm text-gray-500">Build cross-platform mobile apps with
                                                    Flutter.</p>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="col-span-2 mt-4">
                                <div class="flex justify-between">
                                    <a href="#" class="text-purple-600 hover:text-purple-700 transition duration-300">
                                        <i class="fas fa-book-open mr-2"></i>All Courses
                                    </a>
                                    <a href="#" class="text-purple-600 hover:text-purple-700 transition duration-300">
                                        <i class="fas fa-certificate mr-2"></i>Certifications
                                    </a>
                                    <a href="#roadmap"
                                        class="text-purple-600 hover:text-purple-700 transition duration-300">
                                        <i class="fas fa-road mr-2"></i>Learning Paths
                                    </a>
                                </div>
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
                    <form action="./allcourses.php" method="get"
                        class="search-bar flex items-center bg-gray-100 rounded-lg px-3 py-2">
                        <i class="fas fa-search text-gray-500"></i>
                        <input type="text" placeholder="Search courses, tutors..." name="search"
                            class="ml-2 bg-transparent focus:outline-none w-48">
                        <button type="submit" class="hidden"></button>
                    </form>
                    <a class="hidden items-center justify-center rounded-xl bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition-all duration-150 hover:bg-gray-50 sm:inline-flex"
                        href="../signin.php">
                        <i class="fas fa-user mr-1"></i>Sign in
                    </a>
                    <a class="inline-flex items-center justify-center rounded-xl bg-purple-600 px-3 py-2 text-sm font-semibold text-white shadow-sm transition-all duration-150 hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600"
                        href="../login.php">
                        <i class="fas fa-sign-in-alt mr-1"></i>Login
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main class="p-8 bg-gray-50 min-h-screen mt-28">
        <div class="flex-1">
            <div class="grid grid-cols-1 gap-6">
                <?php foreach ($courses as $course): ?>
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden transition-shadow hover:shadow-xl mb-6">
                        <div class="flex flex-row max-[1000px]:flex-col">
                            <img src="../../storage/uploads/course_thumbnails/<?php echo htmlspecialchars($course['thumbnail'], ENT_QUOTES, 'UTF-8'); ?>"
                                alt="Course Thumbnail" class="w-[40%] max-[1000px]:w-full">
                            <div class="w-[60%] p-6 max-[1000px]:w-full">
                                <h3 class="text-xl font-bold text-gray-900 mb-2">
                                    <?php echo htmlspecialchars($course['title'], ENT_QUOTES, 'UTF-8'); ?>
                                </h3>
                                <p class="text-sm text-gray-600 mb-4">
                                    <?php echo htmlspecialchars($course['description'], ENT_QUOTES, 'UTF-8'); ?>
                                </p>
                                <div class="flex items-center mb-4">
                                    <img src="../../assets/images/Guest-user.png" alt="Instructor"
                                        class="w-10 h-10 rounded-full mr-3">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">
                                            <?php echo htmlspecialchars($course['teacher_name'], ENT_QUOTES, 'UTF-8'); ?>
                                        </p>
                                        <p class="text-xs text-gray-500">Instructor</p>
                                    </div>
                                </div>
                                <div class="flex items-center mb-4">
                                    <div class="flex text-yellow-400">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                    <span class="text-sm text-gray-600 ml-2">4.5 (1.2k reviews)</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-semibold text-purple-600">Free</span>
                                    <a href="../login.php"
                                        class="text-center bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 transition-colors">
                                        Enroll Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="flex justify-center mt-8">
                    <nav class="inline-flex rounded-md shadow-sm overflow-hidden">
                        <?php if ($page > 1): ?>
                            <a href="?page=<?php echo $page - 1; ?>"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border-t border-b border-l border-gray-300 hover:bg-gray-50 transition duration-300">
                                <i class="fas fa-chevron-left mr-1"></i> Previous
                            </a>
                        <?php endif; ?>
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <a href="?page=<?php echo $i; ?>"
                                class="px-4 py-2 text-sm font-medium <?php echo $i === $page ? 'bg-purple-600 text-white' : 'text-gray-700 bg-white'; ?> border-t border-b border-gray-300 hover:bg-gray-50 transition duration-300">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>
                        <?php if ($page < $totalPages): ?>
                            <a href="?page=<?php echo $page + 1; ?>"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border-t border-b border-r border-gray-300 hover:bg-gray-50 transition duration-300">
                                Next <i class="fas fa-chevron-right ml-1"></i>
                            </a>
                        <?php endif; ?>
                    </nav>
                </div>
            </div>
        </div>
    </main>

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