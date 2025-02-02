<?php
session_start();

require '../../config/db.php';
require '../Model/student_courses.php';
require '../Model/fillter.php';
require '../Model/check_user_std.php';

require __DIR__ . '/../../vendor/autoload.php';

use League\CommonMark\CommonMarkConverter;
$converter = new CommonMarkConverter();

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$perPage = 1;

$course = new CourseSTD($pdo);

if (isset($_GET['search'])) {
    $courses = $course->search($_GET['search']);
} else {
    $courses = $course->getPaginatedCoursesSTD($page, $perPage);
}

$totalCourses = $course->getTotalCoursesCountSTD();
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

        .markdown-content * {
            all: unset;
            display: revert;
        }

        .markdown-content h1 {
            font-size: 2rem;
            font-weight: bold;
        }

        .markdown-content h2 {
            font-size: 1.75rem;
            font-weight: bold;
        }

        .markdown-content h3 {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .markdown-content p {
            font-size: 1rem;
            margin-bottom: 1rem;
        }

        .markdown-content a {
            color: #2563eb;
            text-decoration: underline;
        }

        .markdown-content ul,
        .markdown-content ol {
            padding-left: 1.5rem;
            margin-bottom: 1rem;
        }

        .markdown-content table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
        }

        .markdown-content table th,
        .markdown-content table td {
            border: 1px solid #ddd;
            padding: 0.5rem;
        }

        .markdown-content pre {
            background: #f3f4f6;
            padding: 1rem;
            border-radius: 0.5rem;
            overflow-x: auto;
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
                    <form action="./inrollnow.php" method="get"
                        class="search-bar flex items-center bg-gray-100 rounded-lg px-3 py-2">
                        <i class="fas fa-search text-gray-500"></i>
                        <input type="text" placeholder="Search courses, tutors..." name="search"
                            class="ml-2 bg-transparent focus:outline-none w-48">
                        <button type="submit" class="hidden"></button>
                    </form>
                    <a href="../logout.php"
                        class="h-8 px-3 py-2 flex items-center justify-center rounded-xl bg-white text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition-all duration-150 hover:bg-gray-50 sm:inline-flex">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        <span class="font-semibold pr-1">Log Out</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main class="p-8 min-h-screen mt-28">
        <div class="max-w-7xl mx-auto flex gap-8">
            <aside class="w-72 bg-white rounded-xl shadow-lg p-6 sticky top-28 max-[650px]:hidden">
                <h2 class="text-lg font-bold text-gray-900 mb-6">Filters</h2>
                <div class="space-y-6">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Category</h3>
                        <select
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                            <option value="" disabled selected>Select a category</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['category_id']; ?>">
                                    <?php echo $category['category_name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Tags</h3>
                        <div id="tagsContainer" class="flex flex-wrap gap-2">
                            <?php foreach ($tags as $tag): ?>
                                <span data-tag-id="<?php echo $tag['tag_id']; ?>"
                                    class="tag-bubble bg-gray-100 text-gray-800 text-sm px-3 py-1 rounded-full cursor-pointer hover:bg-purple-100 transition-colors">
                                    <?php echo $tag['tag_name']; ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                        <input type="hidden" id="selectedTags" name="selectedTags">
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Duration</h3>
                        <ul class="space-y-2">
                            <li>
                                <label
                                    class="flex items-center text-sm text-gray-600 hover:text-purple-600 cursor-pointer">
                                    <input type="checkbox" class="mr-2 rounded text-purple-600 focus:ring-purple-600">
                                    Less than 1 hour
                                </label>
                            </li>
                            <li>
                                <label
                                    class="flex items-center text-sm text-gray-600 hover:text-purple-600 cursor-pointer">
                                    <input type="checkbox" class="mr-2 rounded text-purple-600 focus:ring-purple-600">
                                    1-3 hours
                                </label>
                            </li>
                            <li>
                                <label
                                    class="flex items-center text-sm text-gray-600 hover:text-purple-600 cursor-pointer">
                                    <input type="checkbox" class="mr-2 rounded text-purple-600 focus:ring-purple-600">
                                    3+ hours
                                </label>
                            </li>
                        </ul>
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-sm font-semibold text-gray-700 mb-1">Type</h3>
                        <div class="flex items-center space-x-4">
                            <label class="flex items-center text-sm text-gray-600 hover:text-purple-600 cursor-pointer">
                                <input type="radio" class="mr-2 rounded text-purple-600 focus:ring-purple-600"
                                    name="type" value="all" checked id="filter-all">
                                <span class="ml-1">All</span>
                            </label>
                            <label class="flex items-center text-sm text-gray-600 hover:text-purple-600 cursor-pointer">
                                <input type="radio" class="mr-2 rounded text-purple-600 focus:ring-purple-600"
                                    name="type" value="enrolled" id="filter-enrolled">
                                <span class="ml-1">Enrolled</span>
                            </label>
                            <label class="flex items-center text-sm text-gray-600 hover:text-purple-600 cursor-pointer">
                                <input type="radio" class="mr-2 rounded text-purple-600 focus:ring-purple-600"
                                    name="type" value="not-enrolled" id="filter-not-enrolled">
                                <span class="ml-1">Not Enrolled</span>
                            </label>
                        </div>
                    </div>
                </div>
            </aside>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const filterAll = document.getElementById('filter-all');
                    const filterEnrolled = document.getElementById('filter-enrolled');
                    const filterNotEnrolled = document.getElementById('filter-not-enrolled');
                    const courseContainers = document.querySelectorAll('.course-container');

                    function filterCourses() {
                        const selectedFilter = document.querySelector('input[name="type"]:checked').value;

                        courseContainers.forEach(container => {
                            const isEnrolled = container.querySelector('.complete-button') !== null;

                            if (selectedFilter === 'all') {
                                container.style.display = 'block';
                            } else if (selectedFilter === 'enrolled' && isEnrolled) {
                                container.style.display = 'block';
                            } else if (selectedFilter === 'not-enrolled' && !isEnrolled) {
                                container.style.display = 'block';
                            } else {
                                container.style.display = 'none';
                            }
                        });
                    }

                    filterAll.addEventListener('change', filterCourses);
                    filterEnrolled.addEventListener('change', filterCourses);
                    filterNotEnrolled.addEventListener('change', filterCourses);
                });

                document.addEventListener('DOMContentLoaded', function () {
                    const tagsContainer = document.getElementById('tagsContainer');
                    const selectedTagsInput = document.getElementById('selectedTags');
                    let selectedTags = [];

                    tagsContainer.addEventListener('click', function (event) {
                        const tagBubble = event.target.closest('.tag-bubble');
                        if (tagBubble) {
                            const tagId = tagBubble.getAttribute('data-tag-id');

                            if (selectedTags.includes(tagId)) {
                                selectedTags = selectedTags.filter(id => id !== tagId);
                                tagBubble.classList.remove('bg-purple-600', 'text-white');
                                tagBubble.classList.add('bg-gray-100', 'text-gray-800');
                            } else {
                                selectedTags.push(tagId);
                                tagBubble.classList.remove('bg-gray-100', 'text-gray-800');
                                tagBubble.classList.add('bg-purple-600', 'text-white');
                            }
                            selectedTagsInput.value = selectedTags.join(',');
                        }
                    });
                });
            </script>
            <div class="flex-1">
                <div class="container mx-auto p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Available Courses</h2>
                    <div class="space-y-6">
                        <?php if (empty($courses)): ?>
                            <p class="text-gray-600">No courses available at the moment.</p>
                        <?php else: ?>
                            <?php foreach ($courses as $course): ?>
                                <?php
                                $stmt = $pdo->prepare("SELECT * FROM enrollments WHERE user_id = ? AND course_id = ?");
                                $stmt->execute([$_SESSION['user_id'], $course['course_id']]);
                                $isEnrolled = $stmt->rowCount() > 0;
                                ?>
                                <div
                                    class="course-container bg-white rounded-xl shadow-lg overflow-hidden transition-shadow hover:shadow-xl mb-6">
                                    <div class="flex flex-row max-[1000px]:flex-col">
                                        <img src="../../storage/uploads/course_thumbnails/<?php echo $course['thumbnail']; ?>"
                                            alt="Course Cover" class="w-[40%] max-[1000px]:w-full">
                                        <div class="w-[60%] p-6 max-[1000px]:w-full">
                                            <h3 class="text-xl font-bold text-gray-900 mb-2"><?php echo $course['title']; ?>
                                            </h3>
                                            <p class="text-sm text-gray-600 mb-4"><?php echo $course['description']; ?></p>
                                            <div class="flex items-center mb-4">
                                                <img src="../../assets/images/Guest-user.png" alt="Instructor"
                                                    class="w-10 h-10 rounded-full mr-3">
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">
                                                        <?php echo $course['teacher_name']; ?>
                                                    </p>
                                                    <p class="text-xs text-gray-500">Teacher</p>
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
                                                <span
                                                    class="text-sm font-semibold text-purple-600"><?php echo $isEnrolled ? 'Purchased' : 'free'; ?></span>
                                                <?php if ($isEnrolled): ?>
                                                    <button
                                                        class="complete-button text-center bg-green-600 text-white py-2 px-4 rounded-lg"
                                                        data-course-id="<?php echo $course['course_id']; ?>"
                                                        data-course-title="<?php echo htmlspecialchars($course['title']); ?>">
                                                        Complete
                                                    </button>
                                                <?php else: ?>
                                                    <form action="../Model/enroll.php" method="POST" class="inline">
                                                        <input type="hidden" name="course_id"
                                                            value="<?php echo $course['course_id']; ?>">
                                                        <input type="hidden" name="user_id"
                                                            value="<?php echo $_SESSION['user_id']; ?>">
                                                        <button type="submit"
                                                            class="text-center bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 transition-colors">
                                                            Enroll Now
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div id="courseModal"
                class="fixed inset-0 bg-black bg-opacity-50 h-screen w-screen hidden justify-center items-center z-50">
                <div class="bg-white rounded-lg h-full w-full p-6 flex flex-col">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold text-gray-900" id="modalTitle"></h3>
                        <button id="closeModal" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div id="modalContent" class="flex-grow overflow-y-auto"></div>
                    <div class="flex justify-end mt-4">
                        <button id="finishButton"
                            class="bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition-colors">
                            Finish
                        </button>
                    </div>
                </div>
            </div>


            <script>
                function openModal(courseId, courseTitle) {
                    const modal = document.getElementById('courseModal');
                    const modalTitle = document.getElementById('modalTitle');
                    const modalContent = document.getElementById('modalContent');

                    modalTitle.textContent = courseTitle;

                    fetch(`../Model/get_course_content.php?course_id=${courseId}`)
                        .then(response => response.text())
                        .then(data => {
                            modalContent.innerHTML = data;
                            modal.classList.remove('hidden');
                        })
                        .catch(error => {
                            console.error('Error fetching course content:', error);
                            modalContent.innerHTML = '<p class="text-red-500">Error loading course content.</p>';
                            modal.classList.remove('hidden');
                        });

                    const finishButton = document.getElementById('finishButton');
                    finishButton.onclick = () => {
                        fetch('../Model/generate_certificate.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: `user_id=<?php echo $_SESSION['user_id']; ?>&course_id=${courseId}`,
                        })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                return response.blob();
                            })
                            .then(blob => {
                                const url = window.URL.createObjectURL(blob);
                                const a = document.createElement('a');
                                a.href = url;
                                a.download = 'certificate.pdf';
                                document.body.appendChild(a);
                                a.click();
                                document.body.removeChild(a);
                                window.URL.revokeObjectURL(url);
                            })
                            .catch(error => {
                                console.error('Error generating certificate:', error);
                                alert('Error generating certificate. Please try again.');
                            });

                        closeModal();
                    };

                    const closeModalButton = document.getElementById('closeModal');
                    closeModalButton.onclick = closeModal;
                }

                function closeModal() {
                    const modal = document.getElementById('courseModal');
                    modal.classList.add('hidden');
                }

                document.querySelectorAll('.complete-button').forEach(button => {
                    button.addEventListener('click', () => {
                        const courseId = button.getAttribute('data-course-id');
                        const courseTitle = button.getAttribute('data-course-title');
                        openModal(courseId, courseTitle);
                    });
                });
            </script>

        </div>
    </main>

    <div class="flex justify-center mt-8">
        <nav class="inline-flex rounded-md shadow-sm bg-white border border-gray-300">
            <a href="<?php echo $page > 1 ? '?page=' . ($page - 1) . (isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '') : '#' ?>"
                class="px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition duration-300 <?php echo $page === 1 ? 'cursor-not-allowed opacity-50' : '' ?>">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?php echo $i; ?><?php echo isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : ''; ?>"
                    class="px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition duration-300 <?php echo $i === $page ? 'bg-purple-600 text-white' : ''; ?> <?php echo $i === 1 ? 'rounded-l-md' : '' ?> <?php echo $i === $totalPages ? 'rounded-r-md' : '' ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
            <a href="<?php echo $page < $totalPages ? '?page=' . ($page + 1) . (isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '') : '#' ?>"
                class="px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition duration-300 <?php echo $page === $totalPages ? 'cursor-not-allowed opacity-50' : '' ?>">
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </nav>
    </div>

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