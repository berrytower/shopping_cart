<?php
require_once('../models/CartModel.php');

$cartModel = new CartModel($db);

if ($_GET['act'] == 'add') {
    
    $cartItem = [
        'product_id' => $_POST['productId'],
        'quantity' => $_POST['quantity'],
        'price' => $_POST['price'],
    ];

    if ($cartItem['quantity'] <= 0) {
        $response = [
            'success' => false,
            'message' => 'Quantity must be greater than 0'
        ];
    } else {
        $cartItemId = $cartModel->addCartItem($cartItem['product_id'], $cartItem['quantity']);

        if ($cartItemId) {
            $response = [
                'success' => true,
                'message' => 'Cart item added successfully',
                'cartItemId' => $cartItemId
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Failed to add cart item'
            ];
        }
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}


