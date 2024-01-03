<?php
require_once('../models/CartModel.php');

$cartModel = new CartModel($db);
$action = $_GET['act'] ?? '';

switch ($action) {
    case 'add':
        $productId = $_POST['productId'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        $userId = $_POST['userId'];
        
        if ($cartModel->addCartItem($productId, $quantity, $price, $userId)) {
            $response = ['success' => true, 'message' => 'Product added to cart successfully'];
        } else {
            $response = ['success' => false, 'message' => 'Failed to add product to cart'];
        }
        break;

    case 'list':
        $userId = $_POST['userId'];
        $cartItems = $cartModel->getCartItems($userId);
        $response = ['success' => true, 'cartItems' => $cartItems];
        break;

    case 'remove':
    $cartItemId = $_POST['itemId']; //  itemId
    $userId = $_POST['userId'];
    if ($cartModel->removeCartItem($cartItemId)) {
        $response = ['success' => true, 'message' => 'Cart item removed successfully'];
    } else {
        $response = ['success' => false, 'message' => 'Failed to remove cart item'];
    }
    break;
        
    default:
        $response = ['success' => false, 'message' => 'Invalid action'];
        break;
}

header('Content-Type: application/json');
echo json_encode($response);
