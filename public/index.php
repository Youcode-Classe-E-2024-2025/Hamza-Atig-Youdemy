<?php

session_start();
require '../config/db.php';

require './Model/courses-getter-for-non-log.php';

?>

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouDemy - Home</title>
    <link rel="stylesheet" href="../assets/css/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="shortcut icon" href="../assets/images/favicon.png" type="image/x-icon">
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
                    <a aria-current="page" class="flex items-center" href="">
                        <img class="h-9 w-auto" src="../assets/images/logobanner.png" alt="">
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
                    <form action="./courses/allcourses.php" method="get"
                        class="search-bar flex items-center bg-gray-100 rounded-lg px-3 py-2">
                        <i class="fas fa-search text-gray-500"></i>
                        <input type="text" placeholder="Search courses, tutors..." name="search"
                            class="ml-2 bg-transparent focus:outline-none w-48">
                        <button type="submit" class="hidden"></button>
                    </form>
                    <a class="hidden items-center justify-center rounded-xl bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition-all duration-150 hover:bg-gray-50 sm:inline-flex"
                        href="signin.php">
                        <i class="fas fa-user mr-1"></i>Sign in
                    </a>
                    <a class="inline-flex items-center justify-center rounded-xl bg-purple-600 px-3 py-2 text-sm font-semibold text-white shadow-sm transition-all duration-150 hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600"
                        href="login.php">
                        <i class="fas fa-sign-in-alt mr-1"></i>Login
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main>
        <section class="py-12 md:py-20 mt-16">
            <div class="container mx-auto px-4">
                <div class="text-center">
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                        Unlock Your Potential with YouDemy
                    </h1>
                    <p class="text-lg md:text-xl text-gray-600 mb-8 max-w-2xl mx-auto z-10">
                        Discover a world of knowledge with YouDemy, where expert tutors guide you through interactive
                        lessons, hands-on projects, and personalized feedback to help you master new skills and achieve
                        your career and personal goals at your own pace.
                    </p>
                    <div class="flex justify-center gap-4">
                        <a href="courses/allcourses.php"
                            class="bg-purple-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-purple-700 transition duration-300">
                            Explore Courses
                        </a>
                        <a href="#"
                            class="border border-purple-600 text-purple-600 px-8 py-3 rounded-lg font-semibold hover:bg-purple-50 transition duration-300">
                            Find a Tutor
                        </a>
                    </div>
                </div>

                <div class="mt-12 text-center">
                    <h2 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-6">
                        Why Choose YouDemy?
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl mx-auto">
                        <div class="bg-white p-6 rounded-lg shadow-md hover:bg-gray-100">
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">Expert Tutors</h3>
                            <p class="text-gray-600">
                                Learn from industry professionals with years of experience in their fields.
                            </p>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow-md hover:bg-gray-100">
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">Flexible Learning</h3>
                            <p class="text-gray-600">
                                Study at your own pace with on-demand courses and personalized schedules.
                            </p>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow-md hover:bg-gray-100">
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">Affordable Pricing</h3>
                            <p class="text-gray-600">
                                High-quality education at prices that won’t break the bank.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-4 md:py-5">
            <div class="container mx-auto px-4">
                <div class="text-center">
                    <h2 class="text-2xl md:text-4xl font-semibold text-gray-800 mb-6 animate-fade-in">
                        Discover Our Popular Courses
                    </h2>
                    <p class="text-lg md:text-xl text-gray-600 mb-8 max-w-2xl mx-auto animate-fade-in">
                        Whether you're starting a new career or enhancing your skills, our courses are designed to help
                        you succeed. Join thousands of learners today!
                    </p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl mx-auto">
                    <div
                        class="bg-white p-6 rounded-lg shadow-md transition duration-300 ease-in-out hover:scale-105 hover:shadow-lg animate-fade-in-up">
                        <img src="../assets/images/CoursesCover/C1.png" alt="Web Development"
                            class="w-full h-48 object-cover rounded-lg mb-4">
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Web Development</h3>
                        <p class="text-gray-600 mb-4">
                            Master the art of building modern websites with HTML, CSS, JavaScript, and frameworks like
                            React and Node.js.
                        </p>
                        <div class="flex justify-between items-center">
                            <a href="#"
                                class="text-purple-600 font-semibold hover:text-purple-700 transition duration-300 flex items-center">
                                <i class="fas fa-info-circle mr-2"></i> Learn More
                            </a>
                            <a href="login.php"
                                class="bg-purple-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-purple-700 transition duration-300 flex items-center">
                                <i class="fas fa-user-plus mr-2"></i> Enroll Now
                            </a>
                        </div>
                    </div>
                    <div
                        class="bg-white p-6 rounded-lg shadow-md transition duration-300 ease-in-out hover:scale-105 hover:shadow-lg animate-fade-in-up delay-100">
                        <img src="../assets/images/CoursesCover/C2.jpg" alt="Data Science"
                            class="w-full h-48 object-cover rounded-lg mb-4">
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Data Science</h3>
                        <p class="text-gray-600 mb-4">
                            Dive into data analysis, machine learning, and Python programming to unlock the power of
                            data-driven decision-making.
                        </p>
                        <div class="flex justify-between items-center">
                            <a href="#"
                                class="text-purple-600 font-semibold hover:text-purple-700 transition duration-300 flex items-center">
                                <i class="fas fa-info-circle mr-2"></i> Learn More
                            </a>
                            <a href="login.php"
                                class="bg-purple-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-purple-700 transition duration-300 flex items-center">
                                <i class="fas fa-user-plus mr-2"></i> Enroll Now
                            </a>
                        </div>
                    </div>
                    <div
                        class="bg-white p-6 rounded-lg shadow-md transition duration-300 ease-in-out hover:scale-105 hover:shadow-lg animate-fade-in-up delay-200">
                        <img src="../assets/images/CoursesCover/C3.png" alt="Mobile App Development"
                            class="w-full h-48 object-cover rounded-lg mb-4">
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Mobile App Development</h3>
                        <p class="text-gray-600 mb-4">
                            Build cross-platform mobile apps with Flutter and React Native. Learn to create seamless
                            user experiences for iOS and Android.
                        </p>
                        <div class="flex justify-between items-center">
                            <a href="#"
                                class="text-purple-600 font-semibold hover:text-purple-700 transition duration-300 flex items-center">
                                <i class="fas fa-info-circle mr-2"></i> Learn More
                            </a>
                            <a href="login.php"
                                class="bg-purple-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-purple-700 transition duration-300 flex items-center">
                                <i class="fas fa-user-plus mr-2"></i> Enroll Now
                            </a>
                        </div>
                    </div>
                </div>
                <div class="flex justify-center mt-8">
                    <a href="#"
                        class="flex items-center text-purple-600 font-semibold hover:text-purple-700 transition duration-300">
                        Explore More <i
                            class="fas fa-arrow-right ml-2 transition-transform duration-300 hover:translate-x-1"></i>
                    </a>
                </div>
            </div>
        </section>

        <section class="py-4 md:py-5">
            <div class="container mx-auto px-4">
                <div class="text-center">
                    <h2 class="text-2xl md:text-4xl font-semibold text-gray-800 mb-6 animate-fade-in">
                        Success Stories from Our Learners
                    </h2>
                    <p class="text-lg md:text-xl text-gray-600 mb-8 max-w-2xl mx-auto animate-fade-in">
                        Hear from our students who have transformed their careers and lives with our courses.
                    </p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl mx-auto">
                    <div
                        class="bg-white p-6 rounded-lg shadow-md transition duration-500 ease-in-out hover:scale-105 hover:shadow-lg animate-fade-in-up">
                        <div class="flex items-center mb-4">
                            <img src="../assets/images/Guest-user.png" alt="User 1"
                                class="w-12 h-12 rounded-full object-cover">
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900">John Doe</h4>
                                <p class="text-sm text-gray-600">Web Development Course</p>
                            </div>
                        </div>
                        <p class="text-gray-600 mb-4">
                            "The Web Development course was a game-changer for me. I landed my first job as a front-end
                            developer within 3 months!"
                        </p>
                        <div class="flex items-center">
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <span class="ml-2 text-sm text-gray-600">5.0</span>
                        </div>
                    </div>
                    <div
                        class="bg-white p-6 rounded-lg shadow-md transition duration-500 ease-in-out hover:scale-105 hover:shadow-lg animate-fade-in-up delay-100">
                        <div class="flex items-center mb-4">
                            <img src="../assets/images/Guest-user.png" alt="User 2"
                                class="w-12 h-12 rounded-full object-cover">
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900">Jane Smith</h4>
                                <p class="text-sm text-gray-600">Data Science Course</p>
                            </div>
                        </div>
                        <p class="text-gray-600 mb-4">
                            "The Data Science course helped me transition into a data analyst role. The hands-on
                            projects were incredibly helpful!"
                        </p>
                        <div class="flex items-center">
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <span class="ml-2 text-sm text-gray-600">4.5</span>
                        </div>
                    </div>
                    <div
                        class="bg-white p-6 rounded-lg shadow-md transition duration-500 ease-in-out hover:scale-105 hover:shadow-lg animate-fade-in-up delay-200">
                        <div class="flex items-center mb-4">
                            <img src="../assets/images/Guest-user.png" alt="User 3"
                                class="w-12 h-12 rounded-full object-cover">
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900">Alex Johnson</h4>
                                <p class="text-sm text-gray-600">Mobile App Development Course</p>
                            </div>
                        </div>
                        <p class="text-gray-600 mb-4">
                            "I built my first mobile app using Flutter after completing this course. The instructors
                            were amazing!"
                        </p>
                        <div class="flex items-center">
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <span class="ml-2 text-sm text-gray-600">5.0</span>
                        </div>
                    </div>
                </div>
                <div class="flex justify-center mt-8">
                    <a href="#"
                        class="flex items-center bg-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-purple-700 transition duration-300">
                        Join Our Community <i
                            class="fas fa-arrow-right ml-2 transition-transform duration-300 hover:translate-x-1"></i>
                    </a>
                </div>
            </div>
        </section>

        <section id="roadmap" class="py-4 md:py-5 bg-white">
            <div class="container mx-auto px-4">
                <div class="text-center">
                    <h2 class="text-2xl md:text-4xl font-semibold text-gray-800 mb-6 animate-fade-in">
                        Your Learning Roadmap
                    </h2>
                    <p class="text-lg md:text-xl text-gray-600 mb-8 max-w-2xl mx-auto animate-fade-in">
                        Follow this step-by-step roadmap to go from beginner to advanced in your chosen field. Each
                        milestone includes key skills, topics, and resources to help you succeed.
                    </p>
                </div>
                <div class="relative max-w-4xl mx-auto">
                    <div class="absolute left-1/2 h-full w-1 bg-purple-200 transform -translate-x-1/2"></div>
                    <div class="flex items-center mb-12">
                        <div class="w-1/2 pr-8 text-right">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Beginner</h3>
                            <p class="text-gray-600 mb-4">
                                Start with the basics. Learn the fundamentals of programming, tools, and concepts.
                            </p>
                            <ul class="text-gray-600 mb-4">
                                <li class="mb-2"><i class="fas fa-check-circle text-purple-600 mr-2"></i>Introduction to
                                    Programming</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-purple-600 mr-2"></i>HTML, CSS, and
                                    JavaScript Basics</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-purple-600 mr-2"></i>Version Control
                                    with Git</li>
                            </ul>
                            <a href="#"
                                class="text-purple-600 font-semibold hover:text-purple-700 transition duration-300">
                                Explore Beginner Courses <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                        <div class="w-1/2 pl-8">
                            <div
                                class="w-12 h-12 bg-purple-600 rounded-full flex items-center justify-center text-white text-xl">
                                1
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center mb-12">
                        <div class="w-1/2 pr-8 text-right">
                            <div
                                class="w-12 h-12 absolute right-[54%] bg-purple-600 rounded-full flex items-center justify-center text-white text-xl">
                                2
                            </div>
                        </div>
                        <div class="w-1/2 pl-8">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Intermediate</h3>
                            <p class="text-gray-600 mb-4">
                                Build on your skills with hands-on projects and real-world applications.
                            </p>
                            <ul class="text-gray-600 mb-4">
                                <li class="mb-2"><i class="fas fa-check-circle text-purple-600 mr-2"></i>Advanced
                                    JavaScript and Frameworks (React, Vue)</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-purple-600 mr-2"></i>Backend
                                    Development with Node.js</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-purple-600 mr-2"></i>Database
                                    Management (SQL, MongoDB)</li>
                            </ul>
                            <a href="#"
                                class="text-purple-600 font-semibold hover:text-purple-700 transition duration-300">
                                Explore Intermediate Courses <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center mb-12">
                        <div class="w-1/2 pr-8 text-right">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Advanced</h3>
                            <p class="text-gray-600 mb-4">
                                Master advanced concepts and specialize in your chosen field.
                            </p>
                            <ul class="text-gray-600 mb-4">
                                <li class="mb-2"><i class="fas fa-check-circle text-purple-600 mr-2"></i>Full-Stack
                                    Development</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-purple-600 mr-2"></i>DevOps and
                                    Deployment</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-purple-600 mr-2"></i>Advanced
                                    Algorithms and Data Structures</li>
                            </ul>
                            <a href="#"
                                class="text-purple-600 font-semibold hover:text-purple-700 transition duration-300">
                                Explore Advanced Courses <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                        <div class="w-1/2 pl-8">
                            <div
                                class="w-12 h-12 bg-purple-600 rounded-full flex items-center justify-center text-white text-xl">
                                3
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center mb-12">
                        <div class="w-1/2 pr-8 text-right">
                            <div
                                class="w-12 h-12 absolute right-[54%] bg-purple-600 rounded-full flex items-center justify-center text-white text-xl">
                                4
                            </div>
                        </div>
                        <div class="w-1/2 pl-8">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Specialization</h3>
                            <p class="text-gray-600 mb-4">
                                Focus on a specific area of expertise and build a portfolio of advanced projects.
                            </p>
                            <ul class="text-gray-600 mb-4">
                                <li class="mb-2"><i class="fas fa-check-circle text-purple-600 mr-2"></i>Machine
                                    Learning and AI</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-purple-600 mr-2"></i>Cloud Computing
                                    (AWS, Azure)</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-purple-600 mr-2"></i>Mobile App
                                    Development (Flutter, React Native)</li>
                            </ul>
                            <a href="#"
                                class="text-purple-600 font-semibold hover:text-purple-700 transition duration-300">
                                Explore Specialization Courses <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center mb-12">
                        <div class="w-1/2 pr-8 text-right">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Career Ready</h3>
                            <p class="text-gray-600 mb-4">
                                Prepare for job interviews, build your resume, and land your dream job.
                            </p>
                            <ul class="text-gray-600 mb-4">
                                <li class="mb-2"><i class="fas fa-check-circle text-purple-600 mr-2"></i>Interview
                                    Preparation</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-purple-600 mr-2"></i>Resume and
                                    Portfolio Building</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-purple-600 mr-2"></i>Networking and
                                    Job Search Strategies</li>
                            </ul>
                            <a href="#"
                                class="text-purple-600 font-semibold hover:text-purple-700 transition duration-300">
                                Explore Career Resources <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                        <div class="w-1/2 pl-8">
                            <div
                                class="w-12 h-12 bg-purple-600 rounded-full flex items-center justify-center text-white text-xl">
                                5
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-center mt-8">
                    <a href="#"
                        class="flex items-center bg-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-purple-700 transition duration-300">
                        Start Your Journey <i
                            class="fas fa-arrow-right ml-2 transition-transform duration-300 hover:translate-x-1"></i>
                    </a>
                </div>
            </div>
        </section>

        <section class="py-4 md:py-5 bg-white">
            <div class="container mx-auto px-4">
                <div class="text-center">
                    <h2 class="text-2xl md:text-4xl font-semibold text-gray-800 mb-6 animate-fade-in">
                        Meet Our Expert Tutors
                    </h2>
                    <p class="text-lg md:text-xl text-gray-600 mb-8 max-w-2xl mx-auto animate-fade-in">
                        Learn from industry professionals with years of experience in their fields.
                    </p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl mx-auto">
                    <div
                        class="bg-white p-6 rounded-lg shadow-md transition duration-500 ease-in-out hover:scale-105 hover:shadow-lg animate-fade-in-up">
                        <img src="../assets/images/Guest-user.png" alt="Tutor 1"
                            class="w-24 h-24 rounded-full mx-auto mb-4 object-cover">
                        <h3 class="text-xl font-semibold text-gray-900 text-center mb-2">Sarah Johnson</h3>
                        <p class="text-sm text-gray-600 text-center mb-4">Web Development Expert</p>
                        <p class="text-gray-600 text-center mb-4">
                            Sarah has over 10 years of experience building scalable web applications. She specializes in
                            React and Node.js.
                        </p>
                        <div class="flex justify-center space-x-4">
                            <a href="#" class="text-purple-600 hover:text-purple-700 transition duration-300">
                                <i class="fab fa-linkedin text-xl"></i>
                            </a>
                            <a href="#" class="text-purple-600 hover:text-purple-700 transition duration-300">
                                <i class="fab fa-github text-xl"></i>
                            </a>
                        </div>
                    </div>
                    <div
                        class="bg-white p-6 rounded-lg shadow-md transition duration-500 ease-in-out hover:scale-105 hover:shadow-lg animate-fade-in-up delay-100">
                        <img src="../assets/images/Guest-user.png" alt="Tutor 2"
                            class="w-24 h-24 rounded-full mx-auto mb-4 object-cover">
                        <h3 class="text-xl font-semibold text-gray-900 text-center mb-2">Michael Brown</h3>
                        <p class="text-sm text-gray-600 text-center mb-4">Data Science Specialist</p>
                        <p class="text-gray-600 text-center mb-4">
                            Michael is a data scientist with a passion for machine learning and AI. He has worked on
                            projects for Fortune 500 companies.
                        </p>
                        <div class="flex justify-center space-x-4">
                            <a href="#" class="text-purple-600 hover:text-purple-700 transition duration-300">
                                <i class="fab fa-linkedin text-xl"></i>
                            </a>
                            <a href="#" class="text-purple-600 hover:text-purple-700 transition duration-300">
                                <i class="fab fa-github text-xl"></i>
                            </a>
                        </div>
                    </div>
                    <div
                        class="bg-white p-6 rounded-lg shadow-md transition duration-500 ease-in-out hover:scale-105 hover:shadow-lg animate-fade-in-up delay-200">
                        <img src="../assets/images/Guest-user.png" alt="Tutor 3"
                            class="w-24 h-24 rounded-full mx-auto mb-4 object-cover">
                        <h3 class="text-xl font-semibold text-gray-900 text-center mb-2">Emily Davis</h3>
                        <p class="text-sm text-gray-600 text-center mb-4">Mobile App Developer</p>
                        <p class="text-gray-600 text-center mb-4">
                            Emily is a Flutter and React Native expert with a knack for building beautiful,
                            user-friendly mobile apps.
                        </p>
                        <div class="flex justify-center space-x-4">
                            <a href="#" class="text-purple-600 hover:text-purple-700 transition duration-300">
                                <i class="fab fa-linkedin text-xl"></i>
                            </a>
                            <a href="#" class="text-purple-600 hover:text-purple-700 transition duration-300">
                                <i class="fab fa-github text-xl"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="flex justify-center mt-8">
                    <a href="#"
                        class="flex items-center bg-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-purple-700 transition duration-300">
                        Explore All Tutors <i
                            class="fas fa-arrow-right ml-2 transition-transform duration-300 hover:translate-x-1"></i>
                    </a>
                </div>
            </div>
        </section>

        <section class="py-5 md:py-5 bg-white">
            <div class="container mx-auto px-4">
                <div class="text-center">
                    <h2 class="text-2xl md:text-4xl font-semibold text-gray-800 mb-6 animate-fade-in">
                        Track Your Skill Progress
                    </h2>
                    <p class="text-lg md:text-xl text-gray-600 mb-8 max-w-2xl mx-auto animate-fade-in">
                        Visualize your learning journey and see how far you've come in mastering new skills.
                    </p>
                </div>
                <div class="max-w-4xl mx-auto">
                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-xl font-semibold text-gray-900">Web Development</h3>
                            <span class="text-sm text-gray-600">Intermediate</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-purple-600 h-3 rounded-full" style="width: 65%;"></div>
                        </div>
                        <p class="text-gray-600 mt-2">
                            Master the art of building modern websites with HTML, CSS, JavaScript, and frameworks like
                            React and Node.js.
                        </p>
                        <a href="#" class="text-purple-600 font-semibold hover:text-purple-700 transition duration-300">
                            Explore Web Development Courses <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-xl font-semibold text-gray-900">Data Science</h3>
                            <span class="text-sm text-gray-600">Beginner</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-purple-600 h-3 rounded-full" style="width: 30%;"></div>
                        </div>
                        <p class="text-gray-600 mt-2">
                            Dive into data analysis, machine learning, and Python programming to unlock the power of
                            data-driven decision-making.
                        </p>
                        <a href="#" class="text-purple-600 font-semibold hover:text-purple-700 transition duration-300">
                            Explore Data Science Courses <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-xl font-semibold text-gray-900">Mobile App Development</h3>
                            <span class="text-sm text-gray-600">Advanced</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-purple-600 h-3 rounded-full" style="width: 85%;"></div>
                        </div>
                        <p class="text-gray-600 mt-2">
                            Build cross-platform mobile apps with Flutter and React Native. Learn to create seamless
                            user experiences for iOS and Android.
                        </p>
                        <a href="#" class="text-purple-600 font-semibold hover:text-purple-700 transition duration-300">
                            Explore Mobile App Development Courses <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
                <div class="flex justify-center mt-8">
                    <a href="#"
                        class="flex items-center bg-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-purple-700 transition duration-300">
                        Start Tracking Your Skills <i
                            class="fas fa-arrow-right ml-2 transition-transform duration-300 hover:translate-x-1"></i>
                    </a>
                </div>
            </div>
        </section>

        <section class="py-4 md:py-5 bg-white">
            <div class="container mx-auto px-4">
                <div class="text-center">
                    <h2 class="text-2xl md:text-4xl font-semibold text-gray-800 mb-6 animate-fade-in">
                        Start Your Learning Journey
                    </h2>
                    <p class="text-lg md:text-xl text-gray-600 mb-8 max-w-2xl mx-auto animate-fade-in">
                        Follow our structured learning paths to achieve your career goals step by step.
                    </p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl mx-auto">
                    <div
                        class="bg-white p-6 rounded-lg shadow-md transition duration-500 ease-in-out hover:scale-105 hover:shadow-lg animate-fade-in-up">
                        <div class="flex items-center mb-4">
                            <i class="fas fa-laptop-code text-purple-600 text-2xl mr-4"></i>
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900">Web Development Path</h3>
                                <p class="text-sm text-gray-600">6 Courses | Beginner to Advanced</p>
                            </div>
                        </div>
                        <p class="text-gray-600 mb-4">
                            Master the skills needed to become a full-stack web developer, from HTML and CSS to React
                            and Node.js.
                        </p>
                        <a href="#"
                            class="bg-purple-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-purple-700 transition duration-300 flex items-center justify-center">
                            Start Learning <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                    <div
                        class="bg-white p-6 rounded-lg shadow-md transition duration-500 ease-in-out hover:scale-105 hover:shadow-lg animate-fade-in-up delay-100">
                        <div class="flex items-center mb-4">
                            <i class="fas fa-chart-line text-purple-600 text-2xl mr-4"></i>
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900">Data Science Path</h3>
                                <p class="text-sm text-gray-600">8 Courses | Beginner to Advanced</p>
                            </div>
                        </div>
                        <p class="text-gray-600 mb-4">
                            Learn data analysis, machine learning, and Python programming to unlock the power of
                            data-driven decision-making.
                        </p>
                        <a href="#"
                            class="bg-purple-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-purple-700 transition duration-300 flex items-center justify-center">
                            Start Learning <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                    <div
                        class="bg-white p-6 rounded-lg shadow-md transition duration-500 ease-in-out hover:scale-105 hover:shadow-lg animate-fade-in-up delay-200">
                        <div class="flex items-center mb-4">
                            <i class="fas fa-mobile-alt text-purple-600 text-2xl mr-4"></i>
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900">Mobile App Development Path</h3>
                                <p class="text-sm text-gray-600">5 Courses | Beginner to Advanced</p>
                            </div>
                        </div>
                        <p class="text-gray-600 mb-4">
                            Build cross-platform mobile apps with Flutter and React Native. Learn to create seamless
                            user experiences for iOS and Android.
                        </p>
                        <a href="#"
                            class="bg-purple-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-purple-700 transition duration-300 flex items-center justify-center">
                            Start Learning <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>
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