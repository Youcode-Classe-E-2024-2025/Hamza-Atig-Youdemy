<?php
session_start();

require '../../config/db.php';
require '../Model/created_courses.php';

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
            <i class="fas fa-chart-line"></i>
            Analytics
        </a>
        <a href="#">
            <i class="fas fa-cog"></i>
            Settings
        </a>
        <a href="../logout.php" class="text-gray-900 flex items-center">
            <i class="fas fa-sign-out-alt mr-2"></i>
            Log Out
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
                    <?php
                    $stmt = $pdo->prepare("SELECT COUNT(*) AS num_students FROM enrollments WHERE course_id IN (SELECT course_id FROM courses WHERE teacher_id = :teacher_id)");
                    $stmt->execute(['teacher_id' => $_SESSION['user_id']]);
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <p class="text-3xl font-bold text-purple-600 mt-2"><?php echo $row['num_students']; ?></p>
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
                <?php if (empty($courses)): ?>
                    <p class="text-gray-600">You haven't created any courses yet.</p>
                <?php else: ?>
                    <?php foreach ($courses as $course): ?>
                        <div class="card">
                            <div class="flex flex-col">
                                <img src="../../storage/uploads/course_thumbnails/<?php echo $course['thumbnail']; ?>"
                                    alt="Course Cover" class="w-full h-40 object-cover">
                                <div class="p-6">
                                    <h3 class="text-xl font-bold text-gray-900 mb-2"><?php echo $course['title']; ?></h3>
                                    <p class="text-sm text-gray-600 mb-4"><?php echo $course['description']; ?></p>
                                    <div class="flex items-center mb-4">
                                        <img src="../../assets/images/Guest-user.png" alt="Instructor"
                                            class="w-10 h-10 rounded-full mr-3">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900"><?php echo $course['teacher_name']; ?>
                                            </p>
                                            <p class="text-xs text-gray-500">Teacher</p>
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
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Recent Activities</h2>
            <div class="space-y-4">
                <?php
                $teacher_id = $_SESSION['user_id'];

                $stmtEnrollments = $pdo->prepare("
        SELECT enrollment_id, e.enrolled_at, title AS course_title, username, email
        FROM enrollments e
        LEFT JOIN courses c ON e.course_id = c.course_id
        LEFT JOIN users u ON e.user_id = u.user_id
        WHERE c.teacher_id = ?
        ORDER BY e.enrolled_at DESC
        LIMIT 10
    ");
                $stmtEnrollments->execute([$teacher_id]);

                $stmtCourses = $pdo->prepare("
        SELECT course_id, title, created_at
        FROM courses
        WHERE teacher_id = ?
        ORDER BY created_at DESC
        LIMIT 10
    ");
                $stmtCourses->execute([$teacher_id]);

                while ($row = $stmtEnrollments->fetch(PDO::FETCH_ASSOC)): ?>
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center gap-4">
                            <i class="fas fa-user-plus text-purple-600"></i>
                            <div>
                                <h3 class="text-sm font-semibold text-gray-900">
                                    <?php echo $row['username']; ?> enrolled in course
                                </h3>
                                <p class="text-xs text-gray-500">
                                    <?php echo $row['course_title']; ?> - <?php echo $row['email']; ?>
                                </p>
                            </div>
                        </div>
                        <span class="text-xs text-gray-500">
                            <?php echo (new DateTime($row['enrolled_at']))->format('F j, Y, g:i a'); ?>
                        </span>
                    </div>
                <?php endwhile;

                while ($row = $stmtCourses->fetch(PDO::FETCH_ASSOC)): ?>
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center gap-4">
                            <i class="fas fa-book text-blue-600"></i>
                            <div>
                                <h3 class="text-sm font-semibold text-gray-900">
                                    You created a new course
                                </h3>
                                <p class="text-xs text-gray-500">
                                    <?php echo $row['title']; ?>
                                </p>
                            </div>
                        </div>
                        <span class="text-xs text-gray-500">
                            <?php echo (new DateTime($row['created_at']))->format('F j, Y, g:i a'); ?>
                        </span>
                    </div>
                <?php endwhile; ?>
            </div>
        </section>
    </div>

    <div id="addCourseModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 lg:w-1/3 p-6 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-plus-circle text-purple-600"></i>
                    Create New Course
                </h2>
                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form id="courseForm" action="../Model/add_course.php" method="POST" enctype="multipart/form-data">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Course Title</label>
                    <div class="relative">
                        <i class="fas fa-heading absolute left-3 top-3 text-gray-400"></i>
                        <input type="text" name="title" placeholder="Enter course title" required
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Course Description</label>
                    <div class="relative">
                        <i class="fas fa-align-left absolute left-3 top-3 text-gray-400"></i>
                        <textarea name="description" placeholder="Enter course description" rows="4" required
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"></textarea>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Course Type</label>
                    <div class="relative">
                        <i class="fas fa-file-alt absolute left-3 top-3 text-gray-400"></i>
                        <select name="type" id="courseType" required onchange="toggleCourseFields()"
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent appearance-none">
                            <option value="" disabled selected>Select Course Type</option>
                            <option value="video">Video</option>
                            <option value="doc">Document</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-3 top-3 text-gray-400 pointer-events-none"></i>
                    </div>
                </div>

                <div id="videoFields" class="hidden mb-4">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Upload Video</label>
                        <div class="relative">
                            <i class="fas fa-video absolute left-3 top-3 text-gray-400"></i>
                            <input type="file" name="video" accept="video/*"
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>
                    </div>
                </div>

                <div id="docFields" class="hidden mb-4">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Markdown Content</label>
                        <div class="relative">
                            <i class="fas fa-file-code absolute left-3 top-3 text-gray-400"></i>
                            <textarea name="content_text" placeholder="Paste your markdown content here" rows="6"
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"></textarea>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Thumbnail</label>
                    <div class="relative">
                        <i class="fas fa-image absolute left-3 top-3 text-gray-400"></i>
                        <input type="file" name="thumbnail" accept="image/*" required
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <div class="relative">
                        <i class="fas fa-folder absolute left-3 top-3 text-gray-400"></i>
                        <select name="category_id" required
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent appearance-none">
                            <option value="" disabled selected>Select Category</option>
                            <?php
                            $stmt = $pdo->query("SELECT category_id, category_name FROM categories");
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='{$row['category_id']}'>{$row['category_name']}</option>";
                            }
                            ?>
                        </select>
                        <i class="fas fa-chevron-down absolute right-3 top-3 text-gray-400 pointer-events-none"></i>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tags (Max 3)</label>
                    <div class="flex flex-wrap gap-2 mb-2" id="selectedTags"></div>
                    <div class="flex flex-wrap gap-2" id="tagOptions">
                        <?php
                        $stmt = $pdo->query("SELECT tag_id, tag_name FROM tags");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "
                            <div class='tag-option bg-gray-100 text-gray-800 text-sm px-3 py-1 rounded-full cursor-pointer hover:bg-gray-200'
                                 data-tag-id='{$row['tag_id']}' data-tag-name='{$row['tag_name']}'>
                                {$row['tag_name']}
                            </div>
                        ";
                        }
                        ?>
                    </div>
                    <input type="hidden" name="tags" id="tagsInput">
                </div>

                <button type="submit"
                    class="w-full bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 transition duration-300 flex items-center justify-center gap-2">
                    <i class="fas fa-save"></i>
                    Create Course
                </button>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('addCourseModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('addCourseModal').classList.add('hidden');
        }

        function toggleCourseFields() {
            const courseType = document.getElementById('courseType').value;
            const videoFields = document.getElementById('videoFields');
            const docFields = document.getElementById('docFields');

            if (courseType === 'video') {
                videoFields.classList.remove('hidden');
                docFields.classList.add('hidden');
            } else if (courseType === 'doc') {
                videoFields.classList.add('hidden');
                docFields.classList.remove('hidden');
            } else {
                videoFields.classList.add('hidden');
                docFields.classList.add('hidden');
            }
        }

        const tagOptions = document.querySelectorAll('.tag-option');
        const selectedTags = document.getElementById('selectedTags');
        const tagsInput = document.getElementById('tagsInput');
        let selectedTagIds = [];

        tagOptions.forEach(tag => {
            tag.addEventListener('click', () => {
                const tagId = tag.getAttribute('data-tag-id');
                const tagName = tag.getAttribute('data-tag-name');

                if (selectedTagIds.includes(tagId)) {
                    selectedTagIds = selectedTagIds.filter(id => id !== tagId);
                    tag.classList.remove('bg-purple-600', 'text-white');
                    tag.classList.add('bg-gray-100', 'text-gray-800');
                } else {
                    if (selectedTagIds.length >= 3) {
                        alert('You can only select up to 3 tags.');
                        return;
                    }
                    selectedTagIds.push(tagId);
                    tag.classList.remove('bg-gray-100', 'text-gray-800');
                    tag.classList.add('bg-purple-600', 'text-white');
                }

                updateSelectedTags();
            });
        });

        function updateSelectedTags() {
            selectedTags.innerHTML = '';
            selectedTagIds.forEach(tagId => {
                const tagName = document.querySelector(`.tag-option[data-tag-id="${tagId}"]`).getAttribute('data-tag-name');
                const tagBubble = document.createElement('div');
                tagBubble.className = 'bg-purple-100 text-purple-800 text-sm px-3 py-1 rounded-full flex items-center gap-2';
                tagBubble.innerHTML = `
                ${tagName}
                <button type="button" onclick="removeTag('${tagId}')" class="text-purple-600 hover:text-purple-800">
                    <i class="fas fa-times"></i>
                </button>
            `;
                selectedTags.appendChild(tagBubble);
            });

            tagsInput.value = selectedTagIds.join(',');
        }

        function removeTag(tagId) {
            selectedTagIds = selectedTagIds.filter(id => id !== tagId);

            const tagOption = document.querySelector(`.tag-option[data-tag-id="${tagId}"]`);
            if (tagOption) {
                tagOption.classList.remove('bg-purple-600', 'text-white');
                tagOption.classList.add('bg-gray-100', 'text-gray-800');
            }

            updateSelectedTags();
        }
    </script>
</body>

</html>