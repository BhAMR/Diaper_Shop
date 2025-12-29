<?php

session_start();
include("config/connection.php");

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$product_id = (int)$_GET['id'];

// Validate that the product exists
$query = mysqli_query($con, "SELECT product_id FROM products WHERE product_id = '$product_id'");
if (mysqli_num_rows($query) == 0) {
    header("Location: index.php");
    exit;
}

$cart = [];
if (isset($_COOKIE['cart'])) {
    $cart = json_decode($_COOKIE['cart'], true);
    if (!is_array($cart)) {
        $cart = [];
    }
}

if (isset($cart[$product_id])) {
    $cart[$product_id]['qty'] += 1;
} else {
    $cart[$product_id] = [
        'product_id' => $product_id,
        'qty' => 1
    ];
}

// Standardized cookie expiration to 30 days (matches updateCartAjax.php)
setcookie("cart", json_encode($cart), time() + (30 * 24 * 60 * 60), "/");

header("Location: index.php");
exit;

?>