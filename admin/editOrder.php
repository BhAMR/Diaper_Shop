<?php

include("header.php");
include("../config/connection.php");

//logic of drop-down(payment_status)
$pQuery = mysqli_query($con, "SHOW COLUMNS FROM orders LIKE 'payment_status'");
$pay_status = mysqli_fetch_assoc($pQuery);

$pEnum = str_replace("enum('", "", $pay_status['Type']);
$pEnum = str_replace("')", "", $pEnum);
$enumValue = explode("','", $pEnum);

//logic of drop-down(order_status)
$oQuery = mysqli_query($con,"SHOW COLUMNS FROM orders LIKE 'order_status'");
$ord_status = mysqli_fetch_assoc($oQuery);

$oEnum = str_replace("enum('","",$ord_status['Type']);
$oEnum = str_replace("')","",$oEnum);
$orderEnum = explode("','",$oEnum);


//check current status of payment & orders
$order_id = (int) $_GET['orderId'];
$check = mysqli_query($con,"SELECT product_id,quantity,payment_status FROM orders WHERE order_id = '$order_id'") or die("Error:".mysqli_error($con));
$currentOrder = mysqli_fetch_assoc($check);

//update records
if(isset($_POST['update'])){

    $newPaymentStatus = $_POST['payment_status'] ?? $currentOrder['payment_status'];
    $newOrderStatus = $_POST['order_status'] ?? $currentOrder['order_status'];

        $product_id = $currentOrder['product_id'];
        $qty = $currentOrder['quantity'];

    if($currentOrder['payment_status'] !== 'Done' && $newPaymentStatus === 'Done' && in_array($newOrderStatus,['Placed','In Progress'])){

        mysqli_query($con,"UPDATE products SET stock = stock - $qty WHERE product_id = '$product_id'") or die("Error:".mysqli_error($con));

    }

    if($currentOrder['payment_status'] === 'Done' && in_array($currentOrder['order_status'],['Placed','In Progress']) && $newOrderStatus === 'Cancelled'){
        mysqli_query($con,"UPDATE products SET stock = stock + $qty WHERE product_id = '$product_id'") or die("Error:".mysqli_error($con));
    }

    mysqli_query($con,"UPDATE orders SET payment_status = '$newPaymentStatus' , order_status = '$newOrderStatus' WHERE order_id = '$order_id'") or die("Error:".mysqli_error($con));

    header("Location: order.php");
    exit;
}

//cancel button
if (isset($_POST['cancel'])) {
    header("Location: order.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/adminStyle.css">

    <!-- Font Awesome for hamburger icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="bg-light">
    <div class="container mt-4">
        <div class="row justify-content-center mt-4">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-lg p-4 gap-3 position-relative">
                    <i class="fa-solid fa-circle-xmark close-page" style="cursor:pointer;" onclick="back()"></i>

                    <h4 class="mb-2">Edit Order</h4>

                    <?php
                    $order_id = (int) $_GET['orderId'];

                    $sql = mysqli_query($con, "SELECT o.*, p.name,p.size,p.packet_pieces,p.stock FROM orders as o INNER JOIN products AS p ON o.product_id = p.product_id WHERE order_id = '$order_id'") or die("Error:" . mysqli_error($con));
                    $row = mysqli_fetch_assoc($sql);
                    ?>

                    <form method="POST" class="p-4 shadow-lg rounded">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Product Name :</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $row['name']; ?>"
                                readonly>
                        </div>
                        <?php if(!empty($row['size'])) { ?>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Size</label>
                            <input type="text" name="size" class="form-control" value="<?php echo $row['size']; ?>" readonly>
                        </div>
                        <?php } ?>

                        <?php if(!empty($row['packet_pieces'])) { ?>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Packet/pcs</label>
                            <input type="text" name="packet_pieces" class="form-control"
                                value="<?php echo $row['packet_pieces']; ?>" readonly>
                        </div>
                        <?php } ?>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Price/pcs</label>
                            <input type="text" name="price" class="form-control" value="<?php echo $row['price']; ?>"
                                readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Quantity</label>
                            <input type="text" name="quantity" class="form-control"
                                value="<?php echo $row['quantity']; ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Stock</label>
                            <input type="text" name="stock" class="form-control" value="<?php echo $row['stock']; ?>"
                                readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Payment Status</label>
                            <span>(<?php echo $row['payment_status']; ?>)</span>
                            <select name="payment_status" class="form-control mb-2">
                                <option value="" selected disabled>Select Payment_Status</option>
                                <?php
                                    foreach($enumValue as $val){
                                        echo "<option value='$val'>$val</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Order Status</label>
                            <span>(<?php echo $row['order_status']; ?>)</span>
                            <select name="order_status" class="form-control mb-2">
                                <option value="" selected disabled>Select Order Status</option>
                                <?php 
                                    foreach($orderEnum as $val){
                                        echo "<option value='$val'>$val</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="text-center mt-2">
                            <button name="update" class="btn btn-primary">Update</button>
                            <button name="cancel" class="btn btn-danger">Cancel</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="../assets/js/script.js"></script>

</html>
<?php
include("footer.php");
?>