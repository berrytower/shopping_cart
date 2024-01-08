<?php
require('../dbconfig.php');
class UserModel {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
        if ($this->db === null || $this->db->connect_error) {
            die("Database connection failed: " . $this->db->connect_error);
        }
    }

    public function getUser($username) {
        // 取得使用者資料
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function addUser($username, $password, $role) {
        // 新增使用者，要檢查 username 是否已經存在
        $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('sss', $username, $password, $role);
        if ($stmt->execute()) {
            return $this->db->insert_id;
        } else {
            return false;
        }
    }
    
    public function addReview($userId, $sellerId, $rating){
        //如果使用者已經評價過該賣家，就更新評價，否則就新增評價
        $sql = "IF EXISTS (SELECT * FROM review WHERE userId = ? AND sellerId = ?)
        UPDATE review SET rating = ? WHERE userId = ? AND sellerId = ?
        ELSE
        INSERT INTO review (reviewerID, sellerID, rating) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($this->db, $sql);
        mysqli_stmt_bind_param($stmt, 'iiiii', $userId, $sellerId, $rating, $userId, $sellerId);
        return mysqli_stmt_execute($stmt);
    }
}

