<?php
require_once('../models/UserModel.php');

$UserModel = new UserModel($db);

$action = $_GET['act'] ?? '';

switch ($action) {
    case 'login':
        // 登入
        $username = $_POST['username'];
        $password = $_POST['password'];

        $user = $UserModel->getUser($username);
        if ($user && $user['password'] === $password) {
            $response = ['success' => true, 'message' => 'Login successfully', 'userId' => $user['id']];
        } else {
            $response = ['success' => false, 'message' => 'Login failed'];
        }
    case 'register':
        // 註冊
        $username = $_POST['username'];
        $password = $_POST['password'];
        $role = $_POST['role'];

        $result = $UserModel->addUser($username, $password, $role);
        if ($result) {
            $response = ['success' => true, 'message' => 'Register successfully', 'userId' => $result];
        } else {
            $response = ['success' => false, 'message' => 'Register failed'];
        }
        break;
    case 'review':
        // 評價
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
