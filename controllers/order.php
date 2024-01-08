<?php
require_once('../models/OrderModel.php');
require_once('../models/CartModel.php');

$OrderModel = new OrderModel($db);
$CartModel = new CartModel($db); // 實例化購物車模型
$action = $_GET['act'] ?? '';

switch ($action) {
    case 'add':
        // 新增訂單
        $userId = $_POST['userId'];
        $cartItems = json_decode($_POST['cartItems'], true);
        $shippingOption = $_POST['shippingOption'];

        // 創建訂單邏輯
        if ($OrderModel->createOrder($userId, $cartItems, $shippingOption)) {
            // 清空購物車
            $CartModel->clearCart($userId);
            $response = ['success' => true, 'message' => '訂單創建成功'];
        } else {
            $response = ['success' => false, 'message' => '創建訂單失敗'];
        }
        break;

    case 'list':
        // 取得訂單列表
        $userId = $_POST['userId']; // 或 $_GET['userId']，取決於您的請求方式
        $orders = $OrderModel->getOrders($userId);
        $response = ['success' => true, 'orders' => $orders];
        break;
        
    case 'modify':
        // 更新訂單狀態
        $orderId = $_POST['orderId'];
        $newStatus = $_POST['status'];
        if ($OrderModel->updateOrderStatus($orderId, $newStatus)) {
            $response = ['success' => true, 'message' => '訂單更新成功'];
        } else {
            $response = ['success' => false, 'message' => '更新訂單失敗'];
        }
        break;   
    default:
        $response = ['success' => false, 'message' => '無效的操作'];
        break;
}
header('Content-Type: application/json');
echo json_encode($response);
