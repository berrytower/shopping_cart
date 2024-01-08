<?php
require('../dbconfig.php');
class ProductModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

<<<<<<< HEAD
    public function getProducts($userId) {
        $sql = "SELECT * FROM products WHERE owner_ids = ?";
        $stmt = mysqli_prepare($this->db, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $userId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
=======
    public function getAllProducts() {
        $sql = "select * from products";
        $result = mysqli_query($this->db, $sql);
>>>>>>> 981d5bd520a5a67c4d08ac9bf5548e2a954aeaea
        $products = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $products[] = $row;
        }
        return $products;
    }

    public function addProduct($name, $description, $price) {
        

<<<<<<< HEAD
        $sql = "INSERT INTO products (name, description, price, owner_id) VALUES (?, ?, ?, ?)";
=======
        $sql = "insert into products (name, description, price) values (?, ?, ?)";
>>>>>>> 981d5bd520a5a67c4d08ac9bf5548e2a954aeaea
        $stmt = mysqli_prepare($this->db, $sql);
        mysqli_stmt_bind_param($stmt, 'ssd', $name, $description, $price);
        if (mysqli_stmt_execute($stmt)) {
            return mysqli_insert_id($this->db);
        } else {
            return false;
        }
        
    }
    public function updateProduct($id, $name, $description, $price) {
        $sql = "UPDATE products SET name=?, description=?, price=? WHERE id=?";
        $stmt = mysqli_prepare($this->db, $sql);
        mysqli_stmt_bind_param($stmt, 'ssdi', $name, $description, $price, $id);
        return mysqli_stmt_execute($stmt);
    }

    public function deleteProduct($id) {
        $sql = "DELETE FROM products WHERE id=?";
        $stmt = mysqli_prepare($this->db, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        return mysqli_stmt_execute($stmt);
    }
}
