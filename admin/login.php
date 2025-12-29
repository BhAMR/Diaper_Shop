<?php
session_start();
include("../config/connection.php");

if (isset($_POST['login'])) {

    $uname = $_POST['username'];
    $pass = MD5($_POST['password']);

    $sql = mysqli_query($con, "SELECT * FROM admin WHERE username = '$uname' AND password = '$pass'") or die("Error:" . mysqli_error($con));

    if (mysqli_num_rows($sql) == 1) {
        $_SESSION['admin'] = $uname;
        header("Location: dashboard.php");
    } else {
        $error = "Invalid Username or password..";
    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/adminStyle.css">

    <!-- Font Awesome for hamburger icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row mt-4 justify-content-center">
            <div class="col-md-4 col-lg-5">
                <div class="card p-4 shadow-lg gap-3 rounded-2">
                    <h4 class="text-center">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i>
                    Admin Login</h4>

                    <form method="POST" class="card p-4 rounded-2">
                        <div class="form-check">
                            <label class="form-label fw-semibold">Username :</label>
                            <input type="text" name="username" class="form-control mb-2" placeholder="username.." required>
                        </div>
                        
                        <div class="form-check">
                            <label class="form-label fw-semibold mt-2">Password :</label>
                            <input type="password" name="password" class="form-control mb-2" placeholder="password.." required>
                        </div>

                        <div class="text-center mt-2">
                            <button class="btn btn-primary mb-2 w-75" name="login">Login</button>
                            <div class="error-msg" style="color:red; font-weight:bold;">
                                <?php
                                if (!empty($error)) {
                                    echo $error;
                                }
                                ?>
                            </div>
                        </div>
                    </form>
                    
                    <u><a href="../index.php" class="d-block text-decoration-none mt-2 mb-0 text-center w-100">  
                        <i class="fa-solid fa-cart-shopping"></i>  
                    Shopping</a></u>    

                </div>
            </div>
        </div>

    </div>
    </div>
</body>
<script href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/script.js"></script>

</html>