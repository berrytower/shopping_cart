<?php
require_once('../models/UserModel.php');

// 初始化SQL連接
$db = new mysqli('localhost', 'username', 'password', 'users');
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}


$UserModel = new UserModel($db);

$action = $_GET['act'] ?? '';

switch ($action) {
    //登入
    case 'login':
        $username = $_POST['username'];
        $password = $_POST['password'];

        $user = $UserModel->getUser($username);
        if ($user && password_verify($password, $user['password'])) {
            $response = ['success' => true, 'message' => 'Login successfully', 'userId' => $user['id']];
        } else {
            $response = ['success' => false, 'message' => 'Login failed'];
        }
        break;

    //註冊
    case 'register':
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $role = $_POST['role'];
    
        if ($UserModel->getUser($username)) {
            $response = ['success' => false, 'message' => 'Username already exists'];
        } else {
            $result = $UserModel->addUser($username, $password, $role);
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
