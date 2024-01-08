<?php
require_once('../models/UserModel.php');

$UserModel = new UserModel($db);

$action = $_GET['act'] ?? '';

switch ($action) {
    //登入
    case 'login':
        $username = $_POST['username'];
        $password = $_POST['password'];
        $user = $UserModel->getUser($username);
        
        if ($user && $user['password'] === $password) {
            $response = ['success' => true, 'message' => 'Login successfully', 'userId' => $user['id']];
        } else {
            $response = ['success' => false, 'message' => 'Login failed'];
        }
        break;

    //註冊
    case 'register':
        $username = $_POST['username'];
        //$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $password = $_POST['password'];
        $role = $_POST['role'];
        $role_map = ['客戶' => 0, '賣家' => 1, '物流' => 2];
        //echo "register";

        if ($UserModel->getUser($username)) {
            $response = ['success' => false, 'message' => 'Username already exists'];
        } else {
            $result = $UserModel->addUser($username, $password, $role_map[$role]);
            if ($result) {
                $response = ['success' => true, 'message' => 'Register successfully', 'redirect' => 'login.html'];
            } else {
                $response = ['success' => false, 'message' => 'Register failed due to a server error'];
            }
        }
        break;
    

    //評價
    case 'review':
        $userId = $_POST['userId'];
        $sellerId = $_POST['sellerId'];
        $rating = $_POST['rating'];

        $result = $UserModel->addReview($userId, $sellerId, $rating);
        if ($result) {
            $response = ['success' => true, 'message' => 'Review successfully'];
        } else {
            $response = ['success' => false, 'message' => 'Review failed'];
        }
}
header('Content-Type: application/json');
echo json_encode($response);
