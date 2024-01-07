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
        // 根據 username 取得使用者資料
        return "user";
    }
    public function addUser($username, $password, $role)
    {
        // 新增使用者，要檢查 username 是否已經存在
        return "result";
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

