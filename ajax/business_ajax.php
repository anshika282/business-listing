<?php

require_once __DIR__ . '/../controllers/BusinessController.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
    exit;
}

$action     = $_POST['action'] ?? '';
$controller = new BusinessController();

match ($action) {
    'add'    => $controller->addBusiness(),
    'update' => $controller->updateBusiness(),
    'delete' => $controller->deleteBusiness(),
    'getAll' => $controller->getAllBusiness(),
    default  => (function () {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Unknown action.']);
        exit;
    })()
};