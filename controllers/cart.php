<?php
require_once('../models/CartModel.php');

$cartModel = new CartModel($db);
$action = $_GET['act'] ?? '';

switch ($action) {
    case 'add':
        $productId = $_POST['productId'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];

        if ($quantity <= 0) {
            $response = ['success' => false, 'message' => 'Quantity must be greater than 0'];
        } else {
            $cartItemId = $cartModel->addCartItem($productId, $quantity, $price);
            if ($cartItemId) {
                $response = ['success' => true, 'message' => 'Cart item added successfully', 'cartItemId' => $cartItemId];
            } else {
                $response = ['success' => false, 'message' => 'Failed to add cart item'];
            }
        }
        break;

    case 'list':
        $cartItems = $cartModel->getCartItems();
        $response = ['success' => true, 'cartItems' => $cartItems];
        break;

    case 'remove':
        $cartItemId = $_POST['cartItemId'];
        if ($cartModel->removeCartItem($cartItemId)) {
            $response = ['success' => true, 'message' => 'Cart item removed successfully'];
        } else {
            $response = ['success' => false, 'message' => 'Failed to remove cart item'];
        }
        break;

    case 'update':
        $cartItemId = $_POST['cartItemId'];
        $quantity = $_POST['quantity'];
        if ($cartModel->updateCartItem($cartItemId, $quantity)) {
            $response = ['success' => true, 'message' => 'Cart item updated successfully'];
        } else {
            $response = ['success' => false, 'message' => 'Failed to update cart item'];
        }
        break;
        

    default:
        $response = ['success' => false, 'message' => 'Invalid action'];
        break;
}

header('Content-Type: application/json');
echo json_encode($response);
