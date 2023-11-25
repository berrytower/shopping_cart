<?php
require_once('../models/CartModel.php');

// 假設這是你的資料庫連線
// $db = new PDO('mysql:host=localhost;dbname=SimpleShoppingDB', 'username', 'password');
// 設定資料庫連線
// ...

$cartModel = new CartModel($db);
$cartItems = $cartModel->getCartItems();

header('Content-Type: application/json');
echo json_encode($cartItems);
