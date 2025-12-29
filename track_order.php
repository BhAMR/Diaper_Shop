<?php
include("header.php");
include("config/connection.php");

$orders = [];
$message = "";

if (isset($_POST['mobile'])) {
    $mobile = trim($_POST['mobile']);

    $sql = mysqli_query($con, "SELECT o.*, p.name,p.image FROM orders as o JOIN products as p ON o.product_id = p.product_id WHERE o.mobile = '$mobile' ORDER BY o.created_at DESC") or die("Error:" . mysqli_error($con));
    if (mysqli_num_rows($sql) > 0) {
        while ($row = mysqli_fetch_assoc($sql)) {
            $orders[] = $row;
        }
    } else {
        $message = "No Records Found For This Mobile Number..";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track My Order</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/adminStyle.css">

    <!-- Font Awesome for hamburger icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="bg-light">
    <div class="container mt-4 mb-4">
        <div class="row mt-4 justify-content-center">
            <div class="col-md-4 col-lg-5">
                <div class="card p-0 shadow-lg gap-2 rounded-2">
                    <i class="fa-solid fa-circle-xmark close-page" style="cursor:pointer;" onclick="goBack()"></i>
                    <h5 class="footer-title text-center mb-1 mt-2">Track My Order</h5>

                    <form method="POST" class="p-4 track_order-form">
                        <div class="form-check">
                            <label class="form-label fw-semibold">Mobile No. :</label>
                            <input type="text" name="mobile" maxlength="10" class="form-control mb-2"
                                placeholder="Enter Phone number.." required>
                        </div>

                        <div class="text-center mt-4">
                            <button class="btn btn-outline-secondary mb-2" name="track">Track My Order</button>
                        </div>
                    </form>
                    
                    <!-- Mobile Card View -->
                    <div class="mt-3">

                        <?php if (isset($_POST['track'])) { ?>
                            <div class="d-flex justify-content-center align-items-center mb-3 mt-4">
                        <h5 class="footer-title mb-0 text-center">Order Details</h5>
                    </div>
                            <?php if (!empty($orders)) { ?>
                                <?php foreach ($orders as $order) { ?>
                                    <?php
                                    $order_statusClass = 'bg-secondary';
                                    $payment_statusClass = 'bg-info';

                                    if ($order['order_status'] == '') {
                                        $order_statusClass = '';
                                    } else if ($order['order_status'] == 'Placed') {
                                        $order_statusClass = 'bg-success';
                                    } else if ($order['order_status'] == 'In Progress') {
                                        $order_statusClass = 'bg-warning text-dark';
                                    } elseif ($order['order_status'] == 'Placed') {
                                        $order_statusClass = 'bg-danger';
                                    }

                                    if ($order['payment_status'] == '') {
                                        $payment_statusClass = '';
                                    } else if ($order['payment_status'] == 'Done') {
                                        $payment_statusClass = 'bg-primary';
                                    } else if ($order['payment_status'] == 'Pending') {
                                        $payment_statusClass = 'bg-danger';
                                    }
                                    ?>
                                    <div class="card shadow-sm mb-3 border-0 rounded-3">
                                        <div class="card-body">

                                            <!-- Order_Id and Date -->
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h6 class="fw-bold mb-0">Order #<?php echo $order['order_id']; ?></h6>
                                                <small class="text-muted">
                                                    <?php echo date("d M Y", strtotime($order['created_at'])); ?>
                                                </small>
                                            </div>

                                            <!-- product_ingo + image -->
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div class="flex-grow-1 pe-2">
                                                    <p class="mb-1"><strong>Product:</strong> <?php echo $order['name']; ?></p>
                                                    <p class="mb-1"><strong>Quantity:</strong> <?php echo $order['quantity']; ?></p>
                                                    <p class="mb-1"><strong>Total:</strong> ₹<?php echo $order['total_amount']; ?>
                                                    </p>

                                                    <p class="mb-1">
                                                        <strong>Payment:</strong>
                                                        <span class="badge <?php echo $payment_statusClass; ?>">
                                                            <?php echo $order['payment_status']; ?>
                                                        </span>
                                                    </p>

                                                    <p class="mb-0">
                                                        <strong>Order:</strong>
                                                        <span class="badge <?php echo $order_statusClass; ?>">
                                                            <?php echo $order['order_status']; ?>
                                                        </span>
                                                    </p>
                                                </div>

                                                <div class="text-end">
                                                    <img src="images/uploads/<?php echo $order['image']; ?>" class="track-img">
                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                <?php } ?>
                            <?php } else { ?>

                                <div class="alert alert-warning text-center fw-semibold">
                                    <i class="bi bi-info-circle"></i>
                                    <?php echo $message; ?>
                                </div>

                            <?php } ?>

                        <?php } ?>

                    </div>

                </div>
            </div>
        </div>
    </div>
</body>
<script src="assets/js/script.js">

</script>

</html>
<?php
include("footer.php");
?>