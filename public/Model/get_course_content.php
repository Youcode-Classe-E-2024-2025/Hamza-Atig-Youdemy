<?php
require __DIR__ . '/../../vendor/autoload.php';

use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\Table\TableExtension;
use League\CommonMark\Extension\Autolink\AutolinkExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Extension\Strikethrough\StrikethroughExtension;
use League\CommonMark\Extension\TaskList\TaskListExtension;

$environment = new Environment([
    'html_input' => 'strip',
    'allow_unsafe_links' => false,
    'commonmark' => [
        'enable_em' => true,
        'enable_strong' => true,
        'use_asterisk' => true,
        'use_underscore' => true,
    ],
    'heading_permalink' => [
        'symbol' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 inline-block"><path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 015.656 0l.828.828a4 4 0 010 5.656l-4.243 4.243a4 4 0 01-5.656 0l-.828-.828a4 4 0 010-5.656l4.243-4.243z" /><path stroke-linecap="round" stroke-linejoin="round" d="M8.464 15.536a4 4 0 000-5.656L4.221 5.636a4 4 0 00-5.656 0l-.828.828a4 4 0 000 5.656l4.243 4.243a4 4 0 005.656 0z" /></svg>',
        'insert' => 'after',
        'aria_hidden' => true,
    ],
    'table' => [
        'wrap' => ['table' => 'table-auto w-full border border-gray-300'],
    ],
]);

$environment->addExtension(new CommonMarkCoreExtension());
$environment->addExtension(new TableExtension());
$environment->addExtension(new AutolinkExtension());
$environment->addExtension(new HeadingPermalinkExtension());
$environment->addExtension(new StrikethroughExtension());
$environment->addExtension(new TaskListExtension());

$converter = new CommonMarkConverter([], $environment);

$courseId = $_GET['course_id'] ?? null;

if (!$courseId) {
    die('<div class="text-center text-red-600 font-bold">Course ID is required.</div>');
}

$pdo = new PDO('mysql:host=localhost;dbname=youdemy_db', 'root', '');
$stmt = $pdo->prepare("SELECT type, video_url, content_text FROM courses WHERE course_id = ?");
$stmt->execute([$courseId]);
$course = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$course) {
    die('<div class="text-center text-red-600 font-bold">Course not found.</div>');
}

if ($course['type'] === 'video') {
    echo '<div class="flex justify-center items-center bg-gray-100 p-6 rounded-lg shadow-md">
            <video class="w-full max-w-4xl rounded-lg" controls>
                <source src="../../storage/uploads/course_videos/' . htmlspecialchars($course['video_url'], ENT_QUOTES) . '" type="video/mp4">
                Your browser does not support the video tag.
            </video>
          </div>';
} else {
    $markdown = $course['content_text'];
    $html = $converter->convert($markdown);
    echo '<div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-lg">
            <div class="markdown-content">
                ' . $html . '
            </div>
          </div>';
}
?>
