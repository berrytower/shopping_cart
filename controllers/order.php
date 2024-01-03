<?php
require_once('../models/OrderModel.php');

$OrderModel = new OrderModel($db);
$action = $_GET['act'] ?? '';

switch ($action) {
    case 'add':
        // 新增訂單
        break;
    case 'list':
        // 取得訂單列表
        break;
    case 'modify':
        // 更新訂單狀態
        break;   
    default:
        $response = ['success' => false, 'message' => 'Invalid action'];
        break;
}
header('Content-Type: application/json');
echo json_encode($response);
