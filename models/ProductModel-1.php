<?php
require('../dbconfig.php');

class ProductModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllProducts() {
        $sql = "SELECT * FROM products";
        $result = mysqli_query($this->db, $sql);
        $products = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $products[] = $row;
        }
        return $products;
    }

    public function addProduct($name, $description, $price, $owner_id) {
        $sql = "INSERT INTO products (name, description, price, owner_id) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->db, $sql);
        mysqli_stmt_bind_param($stmt, 'ssdi', $name, $description, $price, $owner_id);
        if (mysqli_stmt_execute($stmt)) {
            return mysqli_insert_id($this->db);
        } else {
            error_log("MySQL 錯誤: " . mysqli_error($this->db));
            return false;
        }
    }

    public function updateProduct($id, $name, $description, $price) {
        $sql = "UPDATE products SET name = ?, description = ?, price = ? WHERE id = ?";
        $stmt = mysqli_prepare($this->db, $sql);
        mysqli_stmt_bind_param($stmt, 'ssdi', $name, $description, $price, $id);
        if (mysqli_stmt_execute($stmt)) {
            return true;
        } else {
            error_log("MySQL 錯誤: " . mysqli_error($this->db));
            return false;
        }
    }

    public function deleteProduct($id) {
        // 檢查產品是否被其他表引用
        if ($this->isProductReferenced($id)) {
            error_log("產品 ID $id 無法刪除，因為它在其他表中被引用。");
            return false;
        }

        $sql = "DELETE FROM products WHERE id = ?";
        $stmt = mysqli_prepare($this->db, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        if (mysqli_stmt_execute($stmt)) {
            return true;
        } else {
            error_log("MySQL 錯誤: " . mysqli_error($this->db));
            return false;
        }
    }

    private function isProductReferenced($id) {
        // 檢查該產品是否在order_items表中被引用
        $sql = "SELECT COUNT(*) FROM order_items WHERE product_id = ?";
        $stmt = mysqli_prepare($this->db, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_array($result);
        return $row[0] > 0;
    }
}
?>
