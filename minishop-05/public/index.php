<?php
// public/index.php
session_start();

// 1. Whitelist danh sách Controller & Action hợp lệ
$allowedControllers = [
    'category' => 'CategoryController',
];

$allowedActions = ['index', 'create', 'edit', 'delete'];

// 2. Lấy tham số từ URL
$controllerParam = strtolower($_GET['controller'] ?? 'category');
$actionParam     = strtolower($_GET['action'] ?? 'index');

// 3. Kiểm tra Whitelist bảo mật
if (!array_key_exists($controllerParam,$allowedControllers)) {
    http_response_code(400);
    die("Lỗi 400: Controller không hợp lệ!");
}

if (!in_array($actionParam,$allowedActions, true)) {
    http_response_code(400);
    die("Lỗi 400: Action không hợp lệ!");
}

$className = $allowedControllers[$controllerParam];
$classFile = __DIR__ . "/../controllers/{$className}.php";

if (!file_exists($classFile)) {
    http_response_code(404);
    die("Lỗi 404: Không tìm thấy file Controller.");
}

require_once $classFile;

// 4. Khởi tạo Controller và gọi Action
$controllerObj = new$className();

if (!method_exists($controllerObj,$actionParam)) {
    http_response_code(404);
    die("Lỗi 404: Phương thức không tồn tại trong Controller.");
}

$controllerObj->$actionParam();