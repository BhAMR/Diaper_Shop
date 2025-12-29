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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <div class="container mt-4 mb-5">

        <div class="card p-4 shadow position-relative">
            <i class="fa-solid fa-circle-xmark close-page" onclick="back()"></i>

            <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
                <h4 class="mb-0 fw-bold">Order List</h4>
            </div>

            <?php
            $sql = mysqli_query(
                $con,
                "SELECT o.*, p.name, p.size, p.packet_pieces 
             FROM orders o 
             INNER JOIN products p ON o.product_id = p.product_id 
             ORDER BY o.order_id DESC"
            );
            ?>

            <!-- ================= DESKTOP TABLE ================= -->
            <div class="table-responsive d-none d-md-block">
                <table class="table table-bordered align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Product</th>
                            <th>Size</th>
                            <th>Packet</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                            <th>Customer</th>
                            <th>Mobile</th>
                            <th>Address</th>
                            <th>Payment</th>
                            <th>Order</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($sql)) { ?>
                            <tr>
                                <td><?= $row['order_id']; ?></td>
                                <td><?= $row['name']; ?></td>
                                <td><?= $row['size'] ?: '-'; ?></td>
                                <td><?= $row['packet_pieces'] ?: '-'; ?></td>
                                <td>₹<?= $row['price']; ?></td>
                                <td><?= $row['quantity']; ?></td>
                                <td>₹<?= $row['total_amount']; ?></td>
                                <td><?= $row['customer_name']; ?></td>
                                <td><?= $row['mobile']; ?></td>
                                <td>
                                    <?= $row['address']; ?><br>
                                    <?= $row['city']; ?> - <?= $row['pincode']; ?>
                                </td>
                                <td>
                                    <?php
                                        $paymentClass = 'bg-success';

                                        if($row['payment_status'] == 'Done'){
                                            $paymentClass = 'bg-secondary';
                                        } else if($row['payment_status'] == 'Pending'){
                                            $paymentClass = 'bg-warning text-dark';
                                        } else {
                                            $paymentClass = 'bg-none';
                                        }
                                    ?>
                                    <span class="badge <?php echo $paymentClass; ?>">
                                        <?php echo $row['payment_status']; ?>
                                    </span>
                                </td>
                                <td>
                                    <?php
                                        $orderClass = 'bg-secondary';

                                    if ($row['order_status'] == 'Placed') {
                                        $orderClass = 'bg-success';
                                    } else if ($row['order_status'] == 'In Progress') {
                                        $orderClass = 'bg-warning text-dark';
                                    } else if ($row['order_status'] == 'Cancelled') {
                                        $orderClass = 'bg-danger';
                                    } else {
                                        $orderClass = 'bg-none';
                                    }
                                    ?>
                                    <span class="badge <?php echo $orderClass; ?>">
                                        <?php echo $row['order_status']; ?>
                                    </span>
                                    </span>
                                </td>
                                <td>
                                    <a href="editOrder.php?orderId=<?= $row['order_id']; ?>" class="btn btn-primary btn-sm">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- ================= MOBILE CARD VIEW ================= -->
            <div class="d-md-none">
                <?php
                mysqli_data_seek($sql, 0);
                while ($row = mysqli_fetch_assoc($sql)) {
                    ?>
                    <div class="card mb-3 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <strong>Order #<?= $row['order_id']; ?></strong>
                                <span class="badge 
                                <?= $row['payment_status'] == 'Done' ? 'bg-success' : 'bg-danger'; ?>">
                                    <?= $row['payment_status']; ?>
                                </span>
                            </div>

                            <p class="mb-1"><strong>Product:</strong> <?= $row['name']; ?></p>
                            <p class="mb-1"><strong>Size:</strong> <?= $row['size'] ?: '-'; ?></p>
                            <p class="mb-1"><strong>Packet:</strong> <?= $row['packet_pieces'] ?: '-'; ?></p>
                            <p class="mb-1"><strong>Price:</strong> ₹<?= $row['price']; ?></p>
                            <p class="mb-1"><strong>Qty:</strong> <?= $row['quantity']; ?></p>
                            <p class="mb-1"><strong>Total:</strong> ₹<?= $row['total_amount']; ?></p>

                            <hr>

                            <p class="mb-1"><strong>Customer:</strong> <?= $row['customer_name']; ?></p>
                            <p class="mb-1"><strong>Mobile:</strong> <?= $row['mobile']; ?></p>
                            <p class="mb-2">
                                <strong>Address:</strong><br>
                                <?= $row['address']; ?><br>
                                <?= $row['city']; ?> - <?= $row['pincode']; ?>
                            </p>

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-secondary"><?= $row['order_status']; ?></span>
                                <a href="editOrder.php?orderId=<?= $row['order_id']; ?>"
                                    class="btn btn-outline-primary btn-sm">
                                    Edit
                                </a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

        </div>
    </div>

    <script src="../assets/js/script.js"></script>
</body>

</html>

<?php include("footer.php"); ?>