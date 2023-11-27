<?php
require('../dbconfig.php');

class CartModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function addCartItem($productId, $quantity) {
        $sql = "INSERT INTO shopping_cart (product_id, quantity) VALUES (?, ?)";
        $stmt = mysqli_prepare($this->db, $sql);
        mysqli_stmt_bind_param($stmt, 'ii', $productId, $quantity);

        if (mysqli_stmt_execute($stmt)) {
            return mysqli_insert_id($this->db);
        } else {
            return false;
        }
    }

    public function getCartItems() {
        $sql = "SELECT sc.id, p.name, p.price, sc.quantity
                FROM shopping_cart sc
                JOIN products p ON sc.product_id = p.id";
        $result = mysqli_query($this->db, $sql);
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
