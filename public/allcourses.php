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
                    <a aria-current="page" class="flex items-center" href="./hero.php">
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
                    <div class="search-bar flex items-center bg-gray-100 rounded-lg px-3 py-2">
                        <i class="fas fa-search text-gray-500"></i>
                        <input type="text" placeholder="Search courses, tutors..."
                            class="ml-2 bg-transparent focus:outline-none w-48">
                    </div>
                    <a href="../../logout.php"
                        class="h-8 px-3 py-2 flex items-center justify-center rounded-xl bg-white text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition-all duration-150 hover:bg-gray-50 sm:inline-flex">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        <span class="font-semibold pr-1">Log Out</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main class="p-8 bg-gray-50 min-h-screen mt-28">
        <div class="max-w-7xl mx-auto flex gap-8">
            <aside class="w-72 bg-white rounded-xl shadow-lg p-6 sticky top-28 max-[650px]:hidden">
                <h2 class="text-lg font-bold text-gray-900 mb-6">Filters</h2>
                <div class="space-y-6">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Category</h3>
                        <ul class="space-y-2">
                            <li>
                                <label class="flex items-center text-sm text-gray-600 hover:text-purple-600 cursor-pointer">
                                    <input type="checkbox" class="mr-2 rounded text-purple-600 focus:ring-purple-600">
                                    Web Development
                                </label>
                            </li>
                            <li>
                                <label class="flex items-center text-sm text-gray-600 hover:text-purple-600 cursor-pointer">
                                    <input type="checkbox" class="mr-2 rounded text-purple-600 focus:ring-purple-600">
                                    Data Science
                                </label>
                            </li>
                            <li>
                                <label class="flex items-center text-sm text-gray-600 hover:text-purple-600 cursor-pointer">
                                    <input type="checkbox" class="mr-2 rounded text-purple-600 focus:ring-purple-600">
                                    Mobile Development
                                </label>
                            </li>
                            <li>
                                <label class="flex items-center text-sm text-gray-600 hover:text-purple-600 cursor-pointer">
                                    <input type="checkbox" class="mr-2 rounded text-purple-600 focus:ring-purple-600">
                                    UI/UX Design
                                </label>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Rating</h3>
                        <ul class="space-y-2">
                            <li>
                                <label class="flex items-center text-sm text-gray-600 hover:text-purple-600 cursor-pointer">
                                    <input type="checkbox" class="mr-2 rounded text-purple-600 focus:ring-purple-600">
                                    4 Stars & Above
                                </label>
                            </li>
                            <li>
                                <label class="flex items-center text-sm text-gray-600 hover:text-purple-600 cursor-pointer">
                                    <input type="checkbox" class="mr-2 rounded text-purple-600 focus:ring-purple-600">
                                    3 Stars & Above
                                </label>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Price</h3>
                        <ul class="space-y-2">
                            <li>
                                <label class="flex items-center text-sm text-gray-600 hover:text-purple-600 cursor-pointer">
                                    <input type="checkbox" class="mr-2 rounded text-purple-600 focus:ring-purple-600">
                                    Free
                                </label>
                            </li>
                            <li>
                                <label class="flex items-center text-sm text-gray-600 hover:text-purple-600 cursor-pointer">
                                    <input type="checkbox" class="mr-2 rounded text-purple-600 focus:ring-purple-600">
                                    Paid
                                </label>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Duration</h3>
                        <ul class="space-y-2">
                            <li>
                                <label class="flex items-center text-sm text-gray-600 hover:text-purple-600 cursor-pointer">
                                    <input type="checkbox" class="mr-2 rounded text-purple-600 focus:ring-purple-600">
                                    Less than 1 hour
                                </label>
                            </li>
                            <li>
                                <label class="flex items-center text-sm text-gray-600 hover:text-purple-600 cursor-pointer">
                                    <input type="checkbox" class="mr-2 rounded text-purple-600 focus:ring-purple-600">
                                    1-3 hours
                                </label>
                            </li>
                            <li>
                                <label class="flex items-center text-sm text-gray-600 hover:text-purple-600 cursor-pointer">
                                    <input type="checkbox" class="mr-2 rounded text-purple-600 focus:ring-purple-600">
                                    3+ hours
                                </label>
                            </li>
                        </ul>
                    </div>
                    <button class="w-full text-center bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 transition-colors">
                        Reset Filters
                    </button>
                </div>
            </aside>
            <div class="flex-1">
                <!-- Course Card 1 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden transition-shadow hover:shadow-xl mb-6">
                    <div class="flex flex-row max-[1000px]:flex-col">
                        <img src="../../assets/images/CoursesCover/C3.png" alt="" class="w-[40%] max-[1000px]:w-full">
                        <div class="w-[60%] p-6 max-[1000px]:w-full">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">React Masterclass</h3>
                            <p class="text-sm text-gray-600 mb-4">
                                Build modern web apps with React. Learn hooks, state management, and more.
                            </p>
                            <div class="flex items-center mb-4">
                                <img src="../../assets/images/Guest-user.png" alt="Instructor" class="w-10 h-10 rounded-full mr-3">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">John Doe</p>
                                    <p class="text-xs text-gray-500">Senior Frontend Developer</p>
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
                                <span class="text-sm font-semibold text-gray-500">Purchased</span>
                                <a href="#" class="text-center bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 transition-colors">
                                    Complete Now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
    
                <!-- Course Card 2 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden transition-shadow hover:shadow-xl mb-6">
                    <div class="flex flex-row max-[1000px]:flex-col">
                        <img src="../../assets/images/CoursesCover/C2.jpg" alt="" class="w-[40%] max-[1000px]:w-full">
                        <div class="w-[60%] p-6 max-[1000px]:w-full">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Data Science Essentials</h3>
                            <p class="text-sm text-gray-600 mb-4">
                                Master Python, Pandas, and Machine Learning for data analysis.
                            </p>
                            <div class="flex items-center mb-4">
                                <img src="../../assets/images/Guest-user.png" alt="Instructor" class="w-10 h-10 rounded-full mr-3">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Jane Smith</p>
                                    <p class="text-xs text-gray-500">Data Scientist</p>
                                </div>
                            </div>
                            <div class="flex items-center mb-4">
                                <div class="flex text-yellow-400">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="text-sm text-gray-600 ml-2">5.0 (2.3k reviews)</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-semibold text-purple-600">$49.99</span>
                                <a href="#" class="text-center bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 transition-colors">
                                    Enroll Now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
    
                <!-- Course Card 3 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden transition-shadow hover:shadow-xl mb-6">
                    <div class="flex flex-row max-[1000px]:flex-col">
                        <img src="../../assets/images/CoursesCover/C1.png" alt="" class="w-[40%] max-[1000px]:w-full">
                        <div class="w-[60%] p-6 max-[1000px]:w-full">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Flutter Development</h3>
                            <p class="text-sm text-gray-600 mb-4">
                                Build cross-platform mobile apps with Flutter and Dart.
                            </p>
                            <div class="flex items-center mb-4">
                                <img src="../../assets/images/Guest-user.png" alt="Instructor" class="w-10 h-10 rounded-full mr-3">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Alex Johnson</p>
                                    <p class="text-xs text-gray-500">Mobile Developer</p>
                                </div>
                            </div>
                            <div class="flex items-center mb-4">
                                <div class="flex text-yellow-400">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="text-sm text-gray-600 ml-2">4.8 (1.8k reviews)</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-semibold text-gray-500">Purchased</span>
                                <a href="#" class="text-center bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 transition-colors">
                                    Complete Now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Course Card 4 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden transition-shadow hover:shadow-xl mb-6">
                    <div class="flex flex-row max-[1000px]:flex-col">
                        <img src="../../assets/images/CoursesCover/C3.png" alt="" class="w-[40%] max-[1000px]:w-full">
                        <div class="w-[60%] p-6 max-[1000px]:w-full">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">React Masterclass</h3>
                            <p class="text-sm text-gray-600 mb-4">
                                Build modern web apps with React. Learn hooks, state management, and more.
                            </p>
                            <div class="flex items-center mb-4">
                                <img src="../../assets/images/Guest-user.png" alt="Instructor" class="w-10 h-10 rounded-full mr-3">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">John Doe</p>
                                    <p class="text-xs text-gray-500">Senior Frontend Developer</p>
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
                                <span class="text-sm font-semibold text-purple-600">$49.99</span>
                                <a href="#" class="text-center bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 transition-colors">
                                    Enroll Now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
    
                <!-- Course Card 5 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden transition-shadow hover:shadow-xl mb-6">
                    <div class="flex flex-row max-[1000px]:flex-col">
                        <img src="../../assets/images/CoursesCover/C2.jpg" alt="" class="w-[40%] max-[1000px]:w-full">
                        <div class="w-[60%] p-6 max-[1000px]:w-full">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Data Science Essentials</h3>
                            <p class="text-sm text-gray-600 mb-4">
                                Master Python, Pandas, and Machine Learning for data analysis.
                            </p>
                            <div class="flex items-center mb-4">
                                <img src="../../assets/images/Guest-user.png" alt="Instructor" class="w-10 h-10 rounded-full mr-3">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Jane Smith</p>
                                    <p class="text-xs text-gray-500">Data Scientist</p>
                                </div>
                            </div>
                            <div class="flex items-center mb-4">
                                <div class="flex text-yellow-400">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="text-sm text-gray-600 ml-2">5.0 (2.3k reviews)</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-semibold text-gray-500">Purchased</span>
                                <a href="#" class="text-center bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 transition-colors">
                                    Complete Now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
    
                <!-- Course Card 6 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden transition-shadow hover:shadow-xl mb-6">
                    <div class="flex flex-row max-[1000px]:flex-col">
                        <img src="../../assets/images/CoursesCover/C1.png" alt="" class="w-[40%] max-[1000px]:w-full">
                        <div class="w-[60%] p-6 max-[1000px]:w-full">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Flutter Development</h3>
                            <p class="text-sm text-gray-600 mb-4">
                                Build cross-platform mobile apps with Flutter and Dart.
                            </p>
                            <div class="flex items-center mb-4">
                                <img src="../../assets/images/Guest-user.png" alt="Instructor" class="w-10 h-10 rounded-full mr-3">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Alex Johnson</p>
                                    <p class="text-xs text-gray-500">Mobile Developer</p>
                                </div>
                            </div>
                            <div class="flex items-center mb-4">
                                <div class="flex text-yellow-400">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="text-sm text-gray-600 ml-2">4.8 (1.8k reviews)</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-semibold text-purple-600">$49.99</span>
                                <a href="#" class="text-center bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 transition-colors">
                                    Enroll Now
                                </a>
                            </div>
                        </div>
                    </div>
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