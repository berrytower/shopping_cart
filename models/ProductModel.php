<?php
require('../dbconfig.php');
class ProductModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllProducts() {
        $sql = "select * from products";
        $result = mysqli_query($this->db, $sql);
        $products = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $products[] = $row;
        }
        return $products;
    }

    public function addProduct($name, $description, $price) {
        

        $sql = "insert into products (name, description, price) values (?, ?, ?)";
        $stmt = mysqli_prepare($this->db, $sql);
        mysqli_stmt_bind_param($stmt, 'ssd', $name, $description, $price);
        if (mysqli_stmt_execute($stmt)) {
            return mysqli_insert_id($this->db);
        } else {
            return false;
        }
        
    }
    public function updateProduct($id, $name, $description, $price) {
        $sql = "update products SET name=?, description=?, price=? WHERE id=?";
        $stmt = mysqli_prepare($this->db, $sql);
        mysqli_stmt_bind_param($stmt, 'ssdi', $name, $description, $price, $id);
        return mysqli_stmt_execute($stmt);
    }

    public function deleteProduct($id) {
        $sql = "delete from products WHERE id=?";
        $stmt = mysqli_prepare($this->db, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        return mysqli_stmt_execute($stmt);
    }
}
