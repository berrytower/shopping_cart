<?php
require_once('../models/CartModel.php');

$cartModel = new CartModel($db);
$cartItems = $cartModel->getCartItems();

header('Content-Type: application/json');
echo json_encode($cartItems);
