<?php
$cartCount = 0;

/* if (isset($_COOKIE['cart'])) {
    $cart = json_decode($_COOKIE['cart'],true);
    $cartCount = count($cart);
} */

if(isset($_COOKIE['cart'])){
    $cart = json_decode(($_COOKIE['cart']), true);

    if(is_array($cart)){
        $cartCount = count($cart);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HD Enterprise Diaper Shop</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Font Awesome for hamburger icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

  <nav class="navbar navbar-expand-lg professional-navbar">
    <div class="container">

        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
            <img src="images/adminLogo.jpeg" class="logo-img" alt="Logo">
            <span class="brand-text">HD Enterprise</span>
        </a>

        <!-- Toggle -->
         <a href="javascript:void(0);" class="icon-user d-lg-none" onclick="toggleMenu()">
                <i class="fa fa-bars" style="color: black; font-size:24px;"></i>
        </a>
        <!-- <button class="navbar-toggler" type="button" onclick="toggleMenu()">
            <span class="navbar-toggler-icon"></span>
        </button> -->

        <!-- Menu -->
        <div id="navMenu" class="nav-actions-user">
            <a href="cart.php" class="nav-link-btn cart-btn">
                <i class="bi bi-cart-fill"></i>
                <span>Cart</span>
                <?php if ($cartCount > 0) { ?>
                    <span id="cartCountBadge" class="cart-badge">
                        <?php echo $cartCount; ?>
                    </span>
                <?php } ?>
            </a>

            <a href="track_order.php" class="nav-link-btn">
                <i class="bi bi-box-seam"></i>My Orders
            </a>

<!--             <a href="contact.php" class="nav-link-btn">
                <i class="bi bi-telephone-fill"></i> Contact
            </a> -->

            <a href="admin/login.php" class="nav-link-btn admin-btn">
                <i class="bi bi-person-fill"></i> Admin
            </a>
        </div>

    </div>
</nav>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>

</body>

</html>