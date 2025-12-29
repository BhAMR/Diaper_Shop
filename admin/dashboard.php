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

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/adminStyle.css">
</head>

<body class="bg-light">

    <div class="container-fluid px-4 py-4">

        <!-- PAGE HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1">Dashboard</h3>
                <p class="text-muted mb-0">Welcome back, Admin</p>
            </div>
            <span class="badge bg-primary-subtle text-primary px-3 py-2">
                Overview
            </span>
        </div>

        <!-- STATS ROW -->
        <div class="row g-4">

            <!-- Orders -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card dashboard-card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <div class="icon-box bg-primary mb-3 mx-auto">
                            <i class="bi bi-cart-check"></i>
                        </div>
                        <h6 class="text-muted">Total Orders</h6>

                        <?php
                        $sql = mysqli_query($con, "SELECT COUNT(*) AS total FROM orders");
                        $row = mysqli_fetch_assoc($sql);
                        ?>
                        <h2 class="fw-bold"><?php echo $row['total']; ?></h2>

                        <a href="order.php" class="btn btn-sm btn-outline-primary mt-2">
                            Manage Orders
                        </a>
                    </div>
                </div>
            </div>

            <!-- Products -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card dashboard-card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <div class="icon-box bg-success mb-3 mx-auto">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        <h6 class="text-muted">Products</h6>

                        <?php
                        $sql = mysqli_query($con, "SELECT COUNT(*) AS total FROM products");
                        $row = mysqli_fetch_assoc($sql);
                        ?>
                        <h2 class="fw-bold"><?php echo $row['total']; ?></h2>

                        <a href="product.php" class="btn btn-sm btn-outline-success mt-2">
                            View Products
                        </a>
                    </div>
                </div>
            </div>

            <!-- Categories -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card dashboard-card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <div class="icon-box bg-warning mb-3 mx-auto">
                            <i class="bi bi-tags"></i>
                        </div>
                        <h6 class="text-muted">Categories</h6>

                        <?php
                        $sql = mysqli_query($con, "SELECT COUNT(*) AS total FROM categories");
                        $row = mysqli_fetch_assoc($sql);
                        ?>
                        <h2 class="fw-bold"><?php echo $row['total']; ?></h2>

                        <a href="category.php" class="btn btn-sm btn-outline-warning mt-2">
                            View Categories
                        </a>
                    </div>
                </div>
            </div>

            <!-- Users -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card dashboard-card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <div class="icon-box bg-info mb-3 mx-auto">
                            <i class="bi bi-people"></i>
                        </div>
                        <h6 class="text-muted">Users</h6>

                        <?php
                        $sql = mysqli_query($con, "SELECT COUNT(*) AS total FROM users");
                        $row = mysqli_fetch_assoc($sql);
                        ?>
                        <h2 class="fw-bold"><?php echo $row['total']; ?></h2>

                        <a href="users.php" class="btn btn-sm btn-outline-info mt-2">
                            View Users
                        </a>
                    </div>
                </div>
            </div>

        </div>

    </div>

</body>
</html>

<?php include("footer.php"); ?>
