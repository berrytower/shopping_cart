<?php
require_once('../models/ProductModel.php');

$productModel = new ProductModel($db);
$products = $productModel->getAllProducts();

// 返回商品列表給前端
header('Content-Type: application/json');
echo json_encode(['products' => $products]);
