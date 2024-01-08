<?php
require_once('../models/ProductModel.php');


$productModel = new ProductModel($db);

if ($_GET['act'] == 'add') {
    $product = [
        'name' => $_POST['name'],
        'description' => $_POST['description'],
        'price' => $_POST['price'],
    ];

    
    $productId = $productModel->addProduct($product['name'], $product['description'], $product['price']);

    if ($productId) {
        $response = [
            'success' => true,
            'message' => 'Product added successfully',
            'productId' => $productId
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'Failed to add product'
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($response);

} else if ($_GET['act'] == 'list') {
    $products = $productModel->getAllProducts();

    header('Content-Type: application/json');
    echo json_encode($products);
}
elseif ($_GET['act'] === 'DELETE') {
    // 删除商品
    $productId = $_POST['id'];

    // 调用后端方法删除商品
    $success = $productModel->deleteProduct($productId);

    if ($success) {
        $response = [
            'success' => true,
            'message' => 'Product deleted successfully',
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'Failed to delete product',
        ];
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}