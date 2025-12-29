//1 cart.php

<?php

session_start();
include("config/connection.php");
include("header.php");
/* 
$cart = $_COOKIE['cart'] ?? [];
$total = 0; */

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
        <h4 class="mb-3 fw-bold text-center ">🛒 Your Cart</h4>
        <div class="mb-3">

        </div>
        <?php

        if (empty($cart)) { ?>
            <div class="alert alert-warning text-center">
                Your cart is empty!!
            </div>
            <div class="text-center" style="margin-top:20%;">
                <a href="index.php" class="btn btn-success">Continue Shopping?</a>
            </div>
            <?php exit;
        } ?>
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
                    foreach ($cart as $item):

                        if(!isset($item['product_id'], $item['qty'])){
                            continue;
                        }

                        $pid = (int)$item['product_id'];
                        $qty = (int)$item['qty'];

                        $qu = mysqli_query($con, "SELECT * FROM products WHERE product_id = '$pid'");
                        
                        if(mysqli_num_rows($qu) == 0){
                            continue;
                        }
                        
                        $row = mysqli_fetch_assoc($qu);

                        $price = $row['price'];
                        $rowTotal = $price * $qty;
                        $total += $rowTotal;

                        ?>

                        <tr id="cart-row-<?php echo $pid; ?>">
                            <td>
                                <img src="images/uploads/<?php echo $row['image']; ?>" class="cart-img">
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
                                    <input type="text"
                                        class="form-control form-control-sm text-center qty-<?php echo $pid; ?>"
                                        value="<?php echo $qty; ?>" readonly>

                                    <div class="qty-btn-vertical">
                                        <button class="btn btn-sm btn-outline-success"
                                            onclick="updateQty(<?php echo $pid; ?>,'inc')">+</button>

                                        <button class="btn btn-sm btn-outline-danger" <?php if ($qty == 1)
                                            echo 'disabled'; ?>
                                            onclick="updateQty(<?php echo $pid; ?>,'dec')">-</button>
                                    </div>
                                </div>
                            </td>



                            <td><b>₹<span class="row-total-<?php echo $pid; ?>"><?php echo $rowTotal; ?></span></b></td>

                            <td>
                                <!--   <a href="updateCart.php?action=remove&id=<?php echo $pid; ?>" class="btn btn-sm btn-danger"> -->

                                <button class="btn btn-sm btn-danger" onclick="removeItem(<?php echo $pid; ?>)">
                                    <i class="bi bi-trash"></i>
                                </button>
                                </a>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- cart summary -->
        <!-- <div class="row mt-4">
            <div class="col-md-4 ms-auto">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="mb-3">Order Summary</h5>
                        <div class="d-flex justify-content-between">
                            <span>subTotal</span> -->
        <b><span id="cartSubtotal" style="display:none;"><?php echo $total; ?></span></b>
        <!-- </div>
                        <hr>
                        <div class="d-grid">
                            <a href="checkOut.php" class="btn btn-success btn-lg">₹<?php echo $total; ?>  Pay now to buy</a>
                        </div>
                    </div>
                </div>
            </div> -->
        <!-- <div class="cart-actions shadow-sm">
        <div class="container">
            <div class="row g-2 align-items-center">
                <div class="col-12 col-md-6">
                    <a href="index.php" class="btn btn-outline-primary w-100">
                        ← Continue Shopping
                    </a>
                </div>
                <div class="col-12 col-md-6">
                    <a href="checkout.php" class="btn btn-success w-100 fw-semibold">
                        ₹<span id="payAmount"><?php echo $total; ?></span> Pay Now
                    </a>
                </div>
            </div>
        </div>
    </div> -->

        <div class="cart-actions">
            <a href="index.php" class="btn btn-outline-primary cart-btn">
                ← Continue <i class="fa-duotone fa-solid fa-bag-shopping"></i>
            </a>

            <a href="checkOut.php" class="btn btn-success cart-btn  pay-btn">
                ₹<span id="payAmount"><?php echo $total; ?></span> Pay Now
            </a>
        </div>

        <!--  <div class="text-center p-2">
            <a href="index.php" class="btn btn-primary">Continue Shopping?</a>

            <a href="checkOut.php" class="btn btn-success">₹
                <span id="payAmount"><?php echo "<b>" . $total . "</b>"; ?></span> Pay now to buy
            </a>
        </div> -->
    </div>
    </div>
</body>
<script src="assets/js/script.js"></script>

</html>

//2 add_to_cart.php

<?php

session_start();
include("config/connection.php");

if(!isset($_GET['id'])){
    header("Location: index.php");
    exit;
}

$product_id = (int)$_GET['id'];

/* if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = [];
} */

if(isset($_COOKIE['cart'])){
    $cart = json_decode($_COOKIE['cart'],true);
}
else{
    $cart = [];
}

if(isset($cart[$product_id])){
    $cart[$product_id]['qty'] += 1;
}
else{
    $cart[$product_id] = [
        'product_id' => $product_id,
        'qty' => 1
    ];
}

setcookie("cart",json_encode($cart),time() + (7 * 24 * 60 * 60),"/");
/* 
if(isset($_SESSION['cart'][$product_id])){
        $_SESSION['cart'][$product_id]['qty'] += 1;
}
else{
    $_SESSION['cart'][$product_id] = [
    'product_id' => $product_id,
    'qty' => 1
];
} */

header("Location: index.php");
exit;

?>

//3 script.js
<script>
function updateQty(id, action) {

    let qtyInput = document.querySelector(".qty-" + id);
    let currentQty = parseInt(qtyInput.value);
    let badge = document.getElementById('cartCountBadge');

    if (action === 'dec' && currentQty == 1) {
        return;
    }

    fetch('updateCartAjax.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `id=${id}&action=${action}`
    })
        .then(res => res.json())
        .then(data => {
            if (!data.success) return;

            if (data.qty <= 0) {
                location.reload();
                return;
            }

            qtyInput.value = data.qty;
            document.querySelector('.row-total-' + id).innerText = data.rowTotal;
            document.getElementById('cartSubtotal').innerText = data.cartTotal;
            document.getElementById('payAmount').innerText = data.cartTotal;

            let minusButton = qtyInput.closest('.qty-box').querySelector('.btn-outline-danger');

            if(data.qty <= 1){
                minusButton.disabled = true;
            }
            else{
                minusButton.disabled = false;
            }

            if(badge){
                badge.innerText = document.querySelectorAll('[id^="cart-row-"]').length;
            }
        });
}

</script>

// 4) updateCartAjax.php

<?php

session_start();
include("config/connection.php");

$response = [
    'success' => false
];

$id = (int)($_POST['id'] ?? 0);
$action = $_POST['action'] ?? '';

if(!$id || !isset($_COOKIE['cart'])){
    echo json_encode($response);
    exit;
}

$cart = json_decode($_COOKIE['cart'],true);

if(!is_array($cart) || !isset($cart[$id])){
    echo json_encode($response);
    exit;
}

if($action === 'inc'){
    /* $_SESSION['cart'][$id]['qty']++; */
    $cart[$id]['qty']++;
}

if($action === 'dec' && $cart[$id]['qty'] > 1){
    $cart[$id]['qty']--;
}

if($action === 'remove'){
    //unset($_SESSION['cart'][$id]);
    unset($cart[$id]);
}

setcookie('cart',json_encode($cart),time() + (86400 * 30),'/');

//recalculate total
$total = 0;
$rowTotal = 0;
$totalQty = 0;

foreach($cart as $item){
    $pid = $item['product_id'];
    $qtyItem = $item['qty'];

    $query = mysqli_query($con,"SELECT price FROM products WHERE product_id = '$pid'");
    $res = mysqli_fetch_assoc($query);

    $total += $res['price'] * $qtyItem;
    $totalQty += $qtyItem;

    if($pid == $id){
        $rowTotal = $res['price'] * $qtyItem;
        $qty = $qtyItem;
    }
}

$response = [
    'success' => true,
    'qty' => $qty ?? 0,
    'rowTotal' => $rowTotal,
    'cartTotal' => $total,
    'totalQty' => $totalQty
];

echo json_encode($response);
exit;


/* if($action === 'dec'){
    if($_SESSION['cart'][$id]['qty'] > 1){
        $_SESSION['cart'][$id]['qty']--;
    }
} */

/* 
if(isset($_SESSION['cart'][$id])){
    $qty = $_SESSION['cart'][$id]['qty'];

    $query = mysqli_query($con,"SELECT price FROM products WHERE product_id = '$id'") or die("Error:".mysqli_error($con));

    $row = mysqli_fetch_assoc($query);
    $rowTotal = $row['price'] * $qty;
}

//cart-subtotal

foreach($_SESSION['cart'] as $item){
    $pid = $item['product_id'];
    $sql = mysqli_query($con,"SELECT * FROM products WHERE product_id = '$pid'") or die("Error:".mysqli_error($con));
    $row = mysqli_fetch_assoc($sql);

    $total += $row['price'] * $item['qty'];

}
 */

?>

// adminHeader.php

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HD Enterprise Diaper Shop Admin</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/adminStyle.css">

    <!-- Font Awesome for hamburger icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


</head>

<body>

<nav class="navbar main-navbar-admin">
        <div class="container d-flex justify-content-between align-items-center">

            <!-- Logo + Brand -->
            <a class="navbar-brand d-flex align-items-center gap-2" href="dashboard.php">
                <img src="../images/logo.png" class="logo-img" alt="Logo">
                <span class="brand-text-admin">Dashboard</span>
            </a>

            <!-- Mobile Toggle -->
            <a href="javascript:void(0);" class="icon-admin d-lg-none" onclick="toggleMenu()">
                <i class="fa fa-bars" style="color: black; font-size:24px;"></i>
            </a>

            <!-- Menu -->
            <div id="navMenu" class="nav-actions-admin">
                <a href="order.php" class="btn nav-btn-admin">
                    <i class="bi bi-list-check me-1"></i>Manage Orders
                </a>

                <a href="product.php" class="btn nav-btn-admin">
                    <i class="bi bi-box-seam me-1"></i>Manage Product
                </a>
               
                <a href="category.php" class="btn nav-btn-admin">
                    <i class="bi bi-box-seam me-1"></i>Manage Category
                </a>

                <a href="users.php" class="btn nav-btn-admin">
                    <i class="bi bi-people me-1"></i>Manage Users
                </a>

                <a href="logout.php" class="btn nav-btn-admin btn-light">
                    <i class="bi bi-box-arrow-right me-1"></i>Logout
                </a>
            </div>

        </div>
    </nav>
  
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/script.js"></script>

</html> 

//adminStyle.css

body {
    background: lightcyan;
    font-family: 'Segoe UI', sans-serif;
}

/* ================================
   ADMIN NAVBAR 
================================ */
.main-navbar-admin {
    background-color: #0d6efd;
    padding: 12px 0;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.12);
    position: sticky;
    top: 0;
    z-index: 999;
}

/* Logo */
.logo-img {
    height: 42px;
}

/* Brand text */
.brand-text-admin {
    font-size: 20px;
    font-weight: 600;
    color: #ffffff;
}

/* ================================
   NAV MENU
================================ */
.nav-actions-admin {
    display: flex;
    align-items: center;
    gap: 12px;
}

/* Menu buttons */
.nav-btn-admin {
    background: transparent;
    color: #ffffff;
    border: 1px solid transparent;
    padding: 7px 14px;
    font-size: 14px;
    font-weight: 500;
    border-radius: 6px;
    transition: all 0.25s ease;
}

/* Icons */
.nav-btn-admin i {
    color: #ffffff;
}

/* Hover */
.nav-btn-admin:hover {
    background-color: rgba(255, 255, 255, 0.15);
    color: #ffffff;
}

/* Logout */
.nav-btn-admin.btn-light {
    background-color: #dc3545;
    border-color: #dc3545;
    color: #ffffff;
}

.nav-btn-admin.btn-light:hover {
    background-color: #bb2d3b;
    border-color: #bb2d3b;
}

/* ================================
   MOBILE
================================ */
.icon-admin i {
    color: #ffffff !important;
}

.dashboard-card {
    text-align: center;
    padding: 25px 20px;
    border-radius: 16px;
    border: none;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.8);
    transition: all 0.3s ease;
    height: 100%;
}

.dashboard-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 22px rgba(0, 0, 0, 0.15);
}


.close-page {
    position: absolute;
    top: 0px;
    right: 2px;
    font-size: 22px;
    color: #dc3545;
    cursor: pointer;
    background: #ffffff;
    border-radius: 50%;
    padding: 6px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.25);
    z-index: 5;
    transition: all 0.25s ease;
}

.close-page:hover {
    background: #dc3545;
    color: #ffffff;
    transform: scale(1.3);
}

/* ================================
   Footer
================================ */

.admin-footer{
    background-color: #f8f9fa;
    border-top: 1px solid #e0e0e0;
    padding: 15px 0;
    font-size: 14px;
}

.footer-text{
    color: #555;
}

@media (max-width: 768px) {
        .admin-footer{
            text-align: center;
        }
}

@media (max-width: 991px) {
    .nav-actions-admin {
        display: none;
        position: absolute;
        top: 70px;
        right: 15px;
        width: 230px;
        background-color: #ffffff;
        flex-direction: column;
        padding: 12px;
        border-radius: 10px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    .nav-actions-admin.show {
        display: flex;
    }

    .nav-btn-admin {
        width: 100%;
        color: #0d6efd;
        text-align: left;
    }

    .nav-btn-admin i {
        color: #0d6efd;
    }

    .nav-btn-admin:hover {
        background-color: #f1f5ff;
    }

    .nav-btn-admin.btn-light {
        color: #ffffff;
    }
}

//adminDashboard.php

<?php

include("auth.php");
include("../config/connection.php");
include("header.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/adminStyle.css">

    <!-- Font Awesome for hamburger icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <div class="container mt-4 mb-5">

    <!-- page header -->
     <div class="d-flex justify-content-between align-items-center mb-4">
         <h4 class="mb-0 fw-bold">Admin Dashboard</h4>
         <span class="text-muted">Overview</span>
     </div>
       
        <div class="row g-4">

        <!-- order card -->
         <div class="col-12 col-md-4 col-lg-3">
            <div class="card dashboard-card text-center">
                <div class="icon-box bg-primary">
                    <i class="bi bi-cart-check"></i>
                </div>
                <h6 class="text-muted mt-3">Active Orders</h6>
                 <?php
                        $sql = mysqli_query($con,"SELECT COUNT(*) AS total_records FROM orders");
                        $row = mysqli_fetch_assoc($sql);
                        $total_count = $row['total_records'];
                    ?>
                  <h3 class="fw-bold mb-0"><?php echo $total_count; ?></h3>
                <a href="order.php" class="btn btn-outline-primary btn-sm mt-2">View Orders</a>
            </div>
         </div>

        <!-- Product card -->
         <div class="col-12 col-md-4 col-lg-3">
            <div class="card dashboard-card text-center">
                <div class="icon-box bg-success">
                    <i class="bi bi-box-seam"></i>
                </div>
                <h6 class="text-muted mt-3">Active Products</h6>
                <?php
                    $sql = mysqli_query($con,"SELECT COUNT(*) AS total_products FROM products");
                    $row = mysqli_fetch_assoc($sql);
                    $total_count = $row['total_products'];
                ?>
                <h3 class="fw-bold mb-0"><?php echo $total_count; ?></h3>
                <a href="product.php" class="btn btn-outline-success btn-sm mt-2">View Products</a> 
            </div>
         </div>

         <!-- Category card -->
          <div class="col-12 col-md-4 col-lg-3">
            <div class="card dashboard-card text-center">
                <div class="icon-box bg-warning">
                    <i class="bi bi-tags"></i>
                </div>
                <h6 class="text-muted mt-3">Active Category</h6>
                <?php
                    $sql = mysqli_query($con,"SELECT COUNT(*) AS total_category FROM categories");
                    $row = mysqli_fetch_assoc($sql);
                    $total_category = $row['total_category'];
                ?>
                <h3 class="fw-bold mb-0"><?php echo $total_category; ?></h3>
                <a href="category.php" class="btn btn-outline-warning btn-sm mt-2">View Category</a>
            </div>
          </div>

          <!-- Users card -->
           <div class="col-12 col-md-4 col-lg-3">
                <div class="card dashboard-card text-center">
                    <div class="icon-box bg-info">
                        <i class="bi bi-people"></i>
                    </div>
                    <h6 class="text-muted mt-3">Active Users</h6>
                    <?php
                        $sql = mysqli_query($con,"SELECT COUNT(*) AS total_users FROM users");
                        $row = mysqli_fetch_assoc($sql);
                        $total_users = $row['total_users'];
                    ?>
                    <h3 class="fw-bold mb-0"><?php echo $total_users; ?></h3>
                    <a href="users.php" class="btn btn-outline-primary btn-sm mt-2">View Users</a>
                </div>
           </div>
        </div>
    </div>    

   <!--  <div class="container mt-4">
        <h3>Dashboard</h3>
        <div class="row">
            <div class="col-md-4">
                <div class="card p-3">
                    <h5>Products</h5>
                    <a href="product.php" class="btn btn-primary">Manage Products</a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-3">
                    <h5>Add New Products</h5>
                    <a href="addProduct.php" class="btn btn-success">Add Products</a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-3">
                    <h5>Orders</h5>
                    <a href="order.php" class="btn btn-warning">View Orders</a>
                </div>
            </div>
        </div>
    </div> -->
</body>

</html>

<?php include("footer.php"); ?>

// order.php

<?php

include("header.php");
include("../config/connection.php");


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>

     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/adminStyle.css">

    <!-- Font Awesome for hamburger icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <div class="container mt-4">
        <div class="card p-4 shadow-lg gap-3 position-relative">
            <i class="fa-solid fa-circle-xmark close-page" style="cursor:pointer;" onclick="back()"> </i>

            <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
                <h4 class="table-title mb-0">Order List</h4>
            </div>

            <div class="table-responsive custom-table">
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Product</th>
                            <th>Size</th>
                            <th>Packet/pcs</th>
                             <th>Price</th>
                            <th>Quantity</th>
                            <th>Total Amount</th>
                            <th>Receiver Name</th>
                            <th>Mobile</th>
                            <th>Address</th>
                            <th>Payment Status</th>
                            <th>Order Status</th>
                            <th colspan="2">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php 
                            $sql = mysqli_query($con,"SELECT o.*,p.name,p.size,p.packet_pieces FROM orders as o INNER JOIN products as p ON o.product_id = p.product_id ORDER BY order_id DESC") or die("Error:".mysqli_error($con));
                             while($row = mysqli_fetch_assoc($sql)) { ?> 
                             
                                <tr>
                                    <td><?php echo $row['order_id']; ?></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php if($row['size'] != '') echo $row['size']; else echo '-'; ?></td>
                                    <td><?php if($row['packet_pieces'] != '') echo $row['packet_pieces']; else echo '-'; ?></td>
                                    <td><?php echo $row['price']; ?></td>
                                    <td><?php echo $row['quantity']; ?></td>
                                    <td><?php echo $row['total_amount']; ?></td>
                                    <td><?php echo $row['customer_name']; ?></td>
                                    <td><?php echo $row['mobile']; ?></td>
                                    <td><?php echo $row['address']; echo '<br>'. $row['city']; echo '<br>'. $row['pincode']; ?></td>
                                    <td style="color: <?php if($row['payment_status'] = 'Pending') {echo 'red';} elseif($row['payment_status'] = 'Done') {echo '<u>green</u>';} else {echo 'Black';}  ?>;"><?php echo htmlspecialchars($row['payment_status']); ?></td>
                                    <td><?php echo $row['order_status']; ?></td>
                                    <td><a href="editOrder.php?orderId=<?php echo $row['order_id']; ?>" class="btn btn-primary btn-sm w-100">Edit</a></td>
                                   <!--  <td><a href="?delete=<?php echo $row['order_id']; ?>" class="btn btn-danger btn-sm w-100" onclick="return confirm('Are you sure to delete this record?');">Delete</a></td>
 -->
                                </tr>
                                
                            <?php } 
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
<script src="../assets/js/script.js"></script>
</html>
<?php

include("footer.php");
?>

//product.php
<?php
include("../config/connection.php");
include("header.php");

if (isset($_GET['delete'])) {
    $product_id = $_GET['delete'];

    $sql = mysqli_query($con, "DELETE FROM products WHERE product_id = '$product_id'") or die("Error:" . mysqli_error($con));

    if ($sql) {
        $error = "Product deleted successfully..";
        header("Location: product.php?msg=deleted");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/adminStyle.css">

    <!-- Font Awesome for hamburger icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>
    <div class="container mt-4" >
        <div class="card p-4 shadow-lg gap-3 position-relative">
           <i class="fa-solid fa-circle-xmark close-page" style="cursor:pointer;" onclick="back()"></i>

            <div class="error-msg">
                <?php
                if (isset($_GET['msg']) && $_GET['msg'] == 'deleted') {
                    echo "Product deleted successfully..";
                }
                ?>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
                <h4 class="table-title mb-0">Product Lists</h4>

                <a href="addProduct.php" class="btn btn-secondary d-flex align-items-center gap-1">
                    <i class="bi bi-plus-circle me-1"></i>
                    Add Products
                </a>
            </div>
            <div class="table-responsive custom-table">

                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Size</th>
                            <th>Price</th>
                            <th>Pcs/Pac</th>
                            <th>Stock</th>
                            <th colspan="2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = mysqli_query($con, "SELECT p.product_id,p.name,c.category_name,p.size,p.price,p.packet_pieces,p.stock FROM products as p INNER JOIN categories as c ON p.category_id = c.category_id") or die("ERROR:" . mysqli_error($con));

                        if (mysqli_num_rows($sql) > 0) {
                            while ($row = mysqli_fetch_assoc($sql)) { ?>

                                <tr>
                                    <td><?php echo $row['product_id']; ?></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['category_name']; ?></td>
                                    <td><?php if ($row['size'] != '')
                                        echo $row['size'];
                                    else
                                        echo '-'; ?></td>
                                    <td><?php echo $row['price']; ?></td>
                                    <td><?php if ($row['packet_pieces'] != '')
                                        echo $row['packet_pieces'];
                                    else
                                        echo '-' ?></td>
                                        <td><?php echo $row['stock']; ?></td>
                                    <td><a href="editProduct.php?edit=<?php echo $row['product_id']; ?>"
                                            class="btn btn-primary btn-sm w-100">Edit</a>
                                    </td>
                                    <td><a href="?delete=<?php echo $row['product_id']; ?>" class="btn btn-danger btn-sm w-100"
                                            onclick="return confirm('Are you sure to delete this product?');">Delete</a>
                                    </td>
                                </tr>


                            <?php }
                        } else { ?>

                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">No Records Found..</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</body>
<script href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/script.js"></script>
</body>

</html>

<?php
include("footer.php");
?>