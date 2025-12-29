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
                <img src="../images/adminLogo.jpeg" class="logo-img" alt="Logo">
                <span class="brand-taxt-admin">HD Enterprise</span>
               <!--  <span class="brand-text-admin">Dashboard</span> -->
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

                <!-- <a href="users.php" class="btn nav-btn-admin">
                    <i class="bi bi-people me-1"></i>Manage Users
                </a> -->

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