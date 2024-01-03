<?php
require('../dbconfig.php');

class CartModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function addCartItem($productId, $quantity, $price, $userId) {
      
        // 檢查商品是否存在，如果不存在則新增商品，否則更新商品數量
        $sql = "SELECT * FROM shopping_cart WHERE product_id = ? AND user_id = ?";
        $stmt = mysqli_prepare($this->db, $sql);
        mysqli_stmt_bind_param($stmt, 'ii', $productId, $userId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            // 商品已在購物車中，更新商品數量
            $newQuantity = $row['quantity'] + $quantity;
            $updateSql = "UPDATE shopping_cart SET quantity = ? WHERE id = ?";
            $updateStmt = mysqli_prepare($this->db, $updateSql);
            mysqli_stmt_bind_param($updateStmt, 'ii', $newQuantity, $row['id']);
            return mysqli_stmt_execute($updateStmt);
          
        } else {
            // 商品不在購物車中，新增商品
            $insertSql = "INSERT INTO shopping_cart (product_id, quantity, price, user_id) VALUES (?, ?, ?, ?)";
            $insertStmt = mysqli_prepare($this->db, $insertSql);
            mysqli_stmt_bind_param($insertStmt, 'iiii', $productId, $quantity, $price, $userId);
            return mysqli_stmt_execute($insertStmt);
        }
    }

    public function getCartItems($userId) {
        $sql = "SELECT sc.id, p.id p.name, p.price, sc.quantity
                FROM shopping_cart sc
                JOIN products p ON sc.product_id = p.id
                WHERE sc.user_id = ?";
        $stmt = mysqli_prepare($this->db, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $userId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $cartItems = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $cartItems[] = $row;
        }

        return $cartItems;
    }
    public function removeCartItem($cartItemId) {
        $sql = "DELETE FROM shopping_cart WHERE id = ?";
        $stmt = mysqli_prepare($this->db, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $cartItemId);

        return mysqli_stmt_execute($stmt);
    }
}
