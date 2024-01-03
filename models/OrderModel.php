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

