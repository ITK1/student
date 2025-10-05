<?php
// Ứng dụng quản lý Sinh viên & Ký túc xá (PHP thuần, PDO)
// Ghi chú tiếng Việt, dễ hiểu, dùng query-string router đơn giản.

declare(strict_types=1);

// Bật session để dùng flash message
session_start();

// Thiết lập timezone cho phù hợp VN
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Tự động nạp các file cần thiết
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/core/helpers.php';

// Nạp Model
require_once __DIR__ . '/models/Student.php';
require_once __DIR__ . '/models/Room.php';
require_once __DIR__ . '/models/Contract.php';

// Nạp Controller
require_once __DIR__ . '/controllers/HomeController.php';
require_once __DIR__ . '/controllers/StudentController.php';
require_once __DIR__ . '/controllers/RoomController.php';
require_once __DIR__ . '/controllers/ContractController.php';

// Router tối giản: ?r=controller/action
// Ví dụ: ?r=students/index, ?r=rooms/create
$route = isset($_GET['r']) ? trim((string)$_GET['r']) : 'home/index';
[$controllerName, $action] = array_pad(explode('/', $route, 2), 2, 'index');

// Map controllerName -> class tương ứng
$controllerMap = [
    'home' => HomeController::class,
    'students' => StudentController::class,
    'rooms' => RoomController::class,
    'contracts' => ContractController::class,
];

if (!isset($controllerMap[$controllerName])) {
    http_response_code(404);
    echo render_view('layout', [
        'title' => '404 - Không tìm thấy',
        'content' => '<h2>Không tìm thấy trang</h2><p>Controller không tồn tại.</p>',
    ]);
    exit;
}

$controllerClass = $controllerMap[$controllerName];
$controller = new $controllerClass(get_pdo());

if (!method_exists($controller, $action)) {
    http_response_code(404);
    echo render_view('layout', [
        'title' => '404 - Không tìm thấy',
        'content' => '<h2>Không tìm thấy trang</h2><p>Action không tồn tại.</p>',
    ]);
    exit;
}

// Gọi action và in ra layout
echo $controller->$action();





