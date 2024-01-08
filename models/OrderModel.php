<?php
class OrderModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function createOrder($userId, $cartItems, $shippingOption) {
        // 開始事務
        mysqli_begin_transaction($this->db);

        try {
            // 創建訂單的 SQL 語句
            $sql = "INSERT INTO orders (user_id, status) VALUES (?, '未處理訂單')";
            $stmt = mysqli_prepare($this->db, $sql);
            mysqli_stmt_bind_param($stmt, 'i', $userId);
            mysqli_stmt_execute($stmt);
            $orderId = mysqli_insert_id($this->db);

            // 將購物車項目加入訂單商品表
            foreach ($cartItems as $item) {
                $sql = "INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)";
                $stmt = mysqli_prepare($this->db, $sql);
                mysqli_stmt_bind_param($stmt, 'iii', $orderId, $item['product_id'], $item['quantity']);
                mysqli_stmt_execute($stmt);
            }

            // 提交事務
            mysqli_commit($this->db);
            return true;
        } catch (Exception $e) {
            // 發生錯誤，回滾事務
            mysqli_rollback($this->db);
            return false;
        }
    }

    public function getOrders($userId) {
        $sql = "SELECT * FROM orders WHERE user_id = ?";
        $stmt = mysqli_prepare($this->db, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $userId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $orders = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $orders[] = $row;
        }

        return $orders;
    }

    public function updateOrderStatus($orderId, $newStatus) {
        $sql = "UPDATE orders SET status = ? WHERE id = ?";
        $stmt = mysqli_prepare($this->db, $sql);
        mysqli_stmt_bind_param($stmt, 'si', $newStatus, $orderId);
        return mysqli_stmt_execute($stmt);
    }
}
