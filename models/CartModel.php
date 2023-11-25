<?php
require('../dbconfig.php');
class CartModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getCartItems() {
        $query = "SELECT c.*, p.name, p.price FROM Cart c JOIN Products p ON c.product_id = p.id";
        $result = $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    // 可以根據需要新增其他方法，如新增商品至購物車、更新購物車商品數量等
}
