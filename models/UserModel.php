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
}

