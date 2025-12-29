<?php

// Enable error reporting for debugging (remove after fixing)
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include("config/connection.php");

// Default response structure
$response = [
    'success' => false,
    'qty' => 0,
    'rowTotal' => 0,
    'cartTotal' => 0,
    'totalQty' => 0
];

$id = (int)($_POST['id'] ?? 0);
$action = $_POST['action'] ?? '';

if (!$id || !isset($_COOKIE['cart'])) {
    // Invalid request - return JSON
    echo json_encode($response);
    exit;
}

$cart = json_decode($_COOKIE['cart'], true);

if (!is_array($cart) || !isset($cart[$id])) {
    // Cart issue - return JSON
    echo json_encode($response);
    exit;
}

// Perform actions
if ($action === 'inc') {
    $cart[$id]['qty']++;
} elseif ($action === 'dec' && $cart[$id]['qty'] > 1) {
    $cart[$id]['qty']--;
} elseif ($action === 'remove') {
    unset($cart[$id]);
} else {
    // Invalid action - return JSON
    echo json_encode($response);
    exit;
}

// Update cookie
setcookie('cart', json_encode($cart), time() + (30 * 24 * 60 * 60), '/');

// Recalculate totals
$total = 0;
$rowTotal = 0;
$qty = 0;
$totalQty = 0;

if (isset($cart[$id])) {
    $qty = $cart[$id]['qty'];
    $query = mysqli_query($con, "SELECT price FROM products WHERE product_id = '$id'");
    if (!$query) {
        // DB error - return JSON with error
        $response['error'] = 'Database query failed: ' . mysqli_error($con);
        echo json_encode($response);
        exit;
    }
    $row = mysqli_fetch_assoc($query);
    if ($row) {
        $rowTotal = $row['price'] * $qty;
    }
}

foreach ($cart as $item) {
    $pid = $item['product_id'];
    $query = mysqli_query($con, "SELECT price FROM products WHERE product_id = '$pid'");
    if (!$query) {
        // DB error - return JSON with error
        $response['error'] = 'Database query failed: ' . mysqli_error($con);
        echo json_encode($response);
        exit;
    }
    $res = mysqli_fetch_assoc($query);
    if ($res) {
        $total += $res['price'] * $item['qty'];
        $totalQty += $item['qty'];
    }
}

// Success response
$response = [
    'success' => true,
    'qty' => $qty,
    'rowTotal' => $rowTotal,
    'cartTotal' => $total,
    'productCount' => count($cart)
];

echo json_encode($response);
exit; 
?>