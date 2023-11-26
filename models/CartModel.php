<?php
require('../dbconfig.php');
class CartModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function addCartItem($productId, $quantity) {
        $sql = "insert into shopping_cart (product_id, quantity) values (?, ?)";
        $stmt = mysqli_prepare($this->db, $sql);

        mysqli_stmt_bind_param($stmt, 'ii', $productId, $quantity);
        if (mysqli_stmt_execute($stmt)) {
            return mysqli_insert_id($this->db);
        } else {
            return false;
        }
    }
    // 缺: 刪除購物車商品、列出購物車商品
}
