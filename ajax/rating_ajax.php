<?php
require_once __DIR__ . '/../controllers/RatingController.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
    exit;
}

$action     = $_POST['action'] ?? '';
$controller = new RatingController();

match ($action) {
    'submit' => $controller->submit(),
    default  => (function () {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Unknown action.']);
        exit;
    })()
};