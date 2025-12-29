<?php
include("header.php");
include("config/connection.php");

$pid = (int) $_GET['id'];
$sql = mysqli_query($con, "SELECT * FROM products WHERE product_id = '$pid'") or die("Error:" . mysqli_error($con));
$row = mysqli_fetch_assoc($sql);

if(isset($_POST['total_amount'])){

    $qty = (int)$_POST['quantity'];
    $stockQ = mysqli_query($con,"SELECT stock,price from products WHERE product_id = '$pid'")or die("Error:".mysqli_error($con));
    $stockRow = mysqli_fetch_assoc($stockQ);

    $availableStock = (int)$stockRow['stock'];
    $price = $stockRow['price'];

    if($availableStock <= 0){
        echo "<script>alert('Product is Out Of Stock..');</script>";
        header("Location: index.php");
        exit;
    }
    if($qty > $availableStock){ 
        echo "<script>alert('Only $availableStock items left in Stock..');</script>";
        header("Location: index.php");
        exit;
    }

    $cust_name = $_POST['customer_name'];
    $mobile = $_POST['mobile'];
    $address = $_POST['address'];
    $pincode = $_POST['pincode'];
    $city = $_POST['city'];
    

/*     $priceQ = mysqli_query($con,"SELECT price FROM products WHERE product_id = '$pid'");
    $priceRow = mysqli_fetch_assoc($priceQ);

    $price = $priceRow['price'];
    $totalAmt = $price * $qty; */

    $totalAmt = $price * $qty;

    $sql = mysqli_query($con,"INSERT INTO orders (product_id,customer_name,mobile,address,pincode,city,quantity,price,total_amount,payment_status) VALUES
            ('$pid','$cust_name','$mobile','$address','$pincode','$city','$qty','$price','$totalAmt','Pending')") or die("Error:".mysqli_error($con));

            if($sql){
                header("Location: orderSuccess.php");
                exit;
            }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Font Awesome for hamburger icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="bg-light">
    <div class="container mt-4 placeorder-container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5 position-relative">

                <!-- Product Details -->
                <div class="card p-4 section-box shadow-lg mb-4">
                    <form method="POST">
                    <h4 class="section-title">Product Details</h4>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Product Name</label>
                        <input type="text" class="form-control" value="<?= $row['name']; ?>" readonly>
                        <input type="hidden" name="product_id" value="<?= $row['product_id']; ?>">
                    </div>

                    <?php if (!empty($row['size'])) { ?>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Size</label>
                            <input type="text" class="form-control" value="<?= $row['size']; ?>" readonly>
                        </div>
                    <?php } ?>

                    <?php if (!empty($row['packet_pieces']) && $row['packet_pieces'] > 0) { ?>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Pcs/Packet</label>
                            <input type="text" class="form-control" value="<?= $row['packet_pieces']; ?>" readonly>
                        </div>
                    <?php } ?>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Price (₹)</label>
                        <input type="text" id="price" class="form-control" value="<?= $row['price']; ?>" readonly>
                    </div>

                    <!-- Quantity -->
                    <div class="mb-2">
                        <label class="form-label fw-semibold">Quantity</label>
                        <div class="qty-box">
                            <button type="button" id="minusBtn" class="btn btn-sm btn-outline-danger"
                                onclick="changeQty(-1)" disabled>−</button>

                            <input type="text" id="qty" name="quantity" class="form-control text-center" value="1" readonly>

                            <button type="button" class="btn btn-sm btn-outline-success"
                                onclick="changeQty(1)">+</button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Total(₹) :</label>
                        <span id="Total" class="form-control"><?php echo $row['price']; ?></span>
                    </div>
                    </form>
                </div>

                <!-- Order Details -->
                <div class="card p-4 section-box shadow-lg mb-4">
                    <h4 class="section-title">Order Details</h4>

                    <form method="POST">
                        <input type="hidden" name="product_id" value="<?= $pid; ?>">
                        <input type="hidden" name="quantity" id="qtyHidden" value="1">
                        <input type="hidden" id="maxStock" value="<?php echo $row['stock']; ?>">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Name</label>
                            <input type="text" name="customer_name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Contact</label>
                            <input type="text" name="mobile" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Address</label>
                            <textarea name="address" id="Address" class="form-control"
                                placeholder="Enter house_Number, Street_Name, Area_Name" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Pincode</label>
                            <input type="text" name="pincode" maxlength="6" class="form-control" onkeyup="fetchCity()"
                                required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">City</label>
                            <input type="text" id="city" name="city" class="form-control" readonly>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="index.php" class="btn btn-outline-danger w-50">Cancel</a>

                            <button type="submit" name="total_amount" class="btn btn-secondary w-50" onclick="openPayment()">
                                Pay ₹<span id="payAmount"><?= $row['price']; ?></span>
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- <div class="modal fade" id="paymentModal" tabindex="1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Choose Method Option</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body text-center">
                    <button class="btn btn-outline-primary w-100 mb-2" onclick="payUPI('gpay)">
                        <i class="fa-brands fa-google-pay"></i>Pay With Gpay
                    </button>

                    <button class="btn btn-outline-success w-100 mb-2" onclick="payUPI('phonepay')">
                        <i class="fa-solid fa-mobile-screen"></i>Pay With Phonepe
                    </button>

                    <button class="btn btn-outline-dark w-100" onclick="payUPI('upi')">
                        Pay With any UPI APP
                    </button>
                </div>
            </div>
        </div>
    </div> -->
    <script src="assets/js/script.js"></script>
</body>

</html>