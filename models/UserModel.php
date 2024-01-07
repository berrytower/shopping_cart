<?php
class UserModel
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }
    public function getUser($username)
    {
        // 取得使用者資料
        $sql = "select * from users where username = ?";
        $stmt = mysqli_prepare($this->db, $sql);
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_assoc($result);
    }
    public function addUser($username, $password, $role)
    {
        // 新增使用者，要檢查 username 是否已經存在
        $sql = "insert into users (username, password, role) values (?, ?, ?)";
        $stmt = mysqli_prepare($this->db, $sql);
        mysqli_stmt_bind_param($stmt, 'ssi', $username, $password, $role);
        if (mysqli_stmt_execute($stmt)) {
            return mysqli_insert_id($this->db);
        } else {
            return false;
        }
        
    }
    public function addReview($userId, $sellerId, $rating)
    {
        //如果使用者已經評價過該賣家，就更新評價，否則就新增評價
        $sql = "if exists (select * from review where userId = $userId and sellerId = $sellerId)
        update review set rating = $rating where userId = $userId and sellerId = $sellerId
        else
        insert into review (reviewerID, sellerID, rating) values ($userId, $sellerId, $rating)";
        $stmt = mysqli_prepare($this->db, $sql);
        return mysqli_stmt_execute($stmt);
    }
}

