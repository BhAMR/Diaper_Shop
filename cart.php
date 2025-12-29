<?php

session_start();
include("config/connection.php");
include("header.php");

$cart = [];

if (isset($_COOKIE['cart'])) {
    $cart = json_decode($_COOKIE['cart'], true);

    if (!is_array($cart)) {
        $cart = [];
    }
}

$total = 0;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Font Awesome for hamburger icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>
    <div class="container mt-4 mb-5">
        <h4 class="mb-3 fw-bold text-center">🛒 Your Cart</h4>
        <div class="mb-3"></div>
        
        <?php if (empty($cart)) { ?>
            <div class="alert alert-warning text-center">
                Your cart is empty!!
            </div>
            <div class="text-center" style="margin-top:20%;">
                <a href="index.php" class="btn btn-success">Continue Shopping?</a>
            </div>
            <?php exit; } ?>
        
        <div class="table-responsive">
            <table class="table align-middle cart-table">
                <thead class="table-light">
                    <tr>
                        <th>Product</th>
                        <th>Details</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($cart as $key => $item):
                        if (!isset($item['product_id'], $item['qty'])) {
                            continue;
                        }

                        $pid = (int)$item['product_id'];
                        $qty = (int)$item['qty'];

                        $qu = mysqli_query($con, "SELECT * FROM products WHERE product_id = '$pid'");
                        
                        if (mysqli_num_rows($qu) == 0) {
                            unset($cart[$key]);
                            continue;
                        }
                        
                        $row = mysqli_fetch_assoc($qu);

                        $price = $row['price'];
                        $rowTotal = $price * $qty;
                        $total += $rowTotal;
                    ?>
                        <tr id="cart-row-<?php echo $pid; ?>">
                            <td>
                                <a href="product_detail.php?id=<?php echo $row['product_id']; ?>">
                                <img src="images/uploads/<?php echo $row['image']; ?>" class="cart-img"></a>
                            </td>
                            <td>
                                <div class="fw-semibold"><?php echo $row['name']; ?></div>
                                <?php if ($row['size']) { ?>
                                    <small class="text-muted d-block">Size: <?php echo $row['size']; ?></small>
                                <?php } ?>
                                <?php if ($row['packet_pieces']) { ?>
                                    <small class="text-muted d-block"><?php echo $row['packet_pieces']; ?> pcs</small>
                                <?php } ?>
                            </td>
                            <td>₹<?php echo $row['price']; ?></td>
                            <td>
                                <div class="qty-box">
                                    <input type="text" class="form-control form-control-sm text-center qty-<?php echo $pid; ?>" value="<?php echo $qty; ?>" readonly>
                                    <div class="qty-btn-vertical">
                                        <button class="btn btn-sm btn-outline-success" onclick="updateQty(<?php echo $pid; ?>,'inc')">+</button>
                                        <button class="btn btn-sm btn-outline-danger" <?php if ($qty == 1) echo 'disabled'; ?> onclick="updateQty(<?php echo $pid; ?>,'dec')">-</button>
                                    </div>
                                </div>
                            </td>
                            <td><b>₹<span class="row-total-<?php echo $pid; ?>"><?php echo $rowTotal; ?></span></b></td>
                            <td>
                                <button class="btn btn-sm btn-danger" onclick="removeItem(<?php echo $pid; ?>)">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Cart Summary Section (Visible Subtotal and Total) -->
        <div class="cart-summary mt-2 p-3 border rounded bg-light">
            <h4 class="mb-3 fw-bold text-center">🛒 Billing Summary</h4>
            <div class="d-flex justify-content-between">
                <span>Subtotal:</span>
                <span>₹<span id="cartSubtotal"><?php echo $total; ?></span></span>
            </div>
            <hr>
            <div class="d-flex justify-content-between fw-bold">
                <span>Total:</span>
                <span>₹<span id="payAmount"><?php echo $total; ?></span></span>
            </div>
        </div>

        <div class="cart-actions mt-3">
           <!--  <a href="index.php" class="btn btn-outline-primary cart-btn">
                ← Continue <i class="fa-duotone fa-solid fa-bag-shopping"></i>
            </a> -->
            <a href="clearCart.php" class="btn btn-warning">Clear Cart</a>
            <a href="checkOut.php" class="btn btn-success cart-btn pay-btn">
                ₹<span id="payAmountDuplicate"><?php echo $total; ?></span> Pay Now
            </a>
           
        </div>
         <a href="index.php" class="text-center d-flex justify-content-center align-items-center mt-2">
            <i class="fa-solid fa-cart-shopping"></i>  Continue Shopping?</a>
    </div>
</body>
<script src="assets/js/script.js"></script>

</html>
<?php
include("footer.php");
?>