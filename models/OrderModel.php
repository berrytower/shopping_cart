<?php
require('../dbconfig.php');

class OrderModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function addOrder($userId) {
        /* 1. 取得買家的購物車內容
        2. 跟據賣家將購物車內容分組
        3. 依據分組結果，新增訂單 
        */

        // 1. 取得買家的購物車內容
        $cartModel = new CartModel($this->db);
        $cartItems = $cartModel->getCartItems($userId);

        // 2. 跟據賣家將購物車內容分組
        $groupedCartItems = $this->groupCartItems($cartItems);

        // 3. 依據分組結果，新增訂單
        foreach ($groupedCartItems as $group) {
            $orderId = $this->createOrder($userId);

            foreach ($group as $cartItem) {
                $this->addOrderItem($orderId, $cartItem['product_id'], $cartItem['quantity']);
            }
        }

        // 4. 清空購物車內容
        $cartModel->clearCart($userId);
    }

    // 虛擬的購物車內容分組邏輯，實際應用需要根據業務需求調整
    private function groupCartItems($cartItems) {
        // 虛擬的分組邏輯：按照商品分組，實際應用可能需要更複雜的邏輯
        $groupedCartItems = [];
        foreach ($cartItems as $cartItem) {
            $productId = $cartItem['product_id'];
            if (!isset($groupedCartItems[$productId])) {
                $groupedCartItems[$productId] = [];
            }
            $groupedCartItems[$productId][] = $cartItem;
        }

        return $groupedCartItems;
    }

    //更新訂單狀態
    public function  modifyOrder($orderId, $status) {
        $sql = "UPDATE orders SET status = ? WHERE id = ?";
        $stmt = mysqli_prepare($this->db, $sql);
        mysqli_stmt_bind_param($stmt, 'ii', $status, $orderId);
        return mysqli_stmt_execute($stmt);
    }
    // 取得訂單列表
    public function getOrder($orderId) {
    }
}

