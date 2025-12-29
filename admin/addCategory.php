<?php

include("auth.php");
include("../config/connection.php");
include("header.php");

if (isset($_POST['save'])) {

    $sql = mysqli_query($con, "INSERT INTO categories (category_name,has_size,has_packet) VALUES ('$_POST[category_name]','$_POST[has_size]','$_POST[has_packet]')") or die("Error:" . mysqli_error($con));

    if ($sql) {
        echo "<script>alert('Category added successfully..');location='dashboard.php';</script>";
    } else {
        echo "<script>alert('Something went wrong..');</script>";
    }
}

if (isset($_POST['cancel'])) {
    header("Location: dashboard.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/adminStyle.css">

    <!-- Font Awesome for hamburger icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>
    <div class="container mt-4">
        <div class="row justify-content-center mt-4">

            <div class="col-md-6 col-lg-5">
                <div class="card p-4 shadow-lg gap-3 mb-4">
                    <i class="fa-solid fa-circle-xmark close-page" style="cursor:pointer;" onclick="back()"></i>
                    <h4 class="mb-2">Add New Category</h4>

                    <form method="POST" class="card p-4 shadow-lg rounded-4">
                        <input type="text" name="category_name" class="form-control mb-2" placeholder="Category name"
                            required>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Category have a size?</label>
                            <div class="d-flex gap-4">
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="sizeYes" name="has_size" value="1">
                                    <label class="form-check-label" for="sizeYes">Yes</label>
                                </div>

                                <div class="form-check">
                                    <input type="radio" class="form-check-label" id="sizeNo" name="has_size"  value="0">
                                    <label class="form-check-label" for="sizeNo">No</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Category have a packet?</label>
                            <div class="d-flex gap-4">
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="packetYes" name="has_packet" value="1">
                                    <label class="form-check-label" for="packetYes">Yes</label>
                                </div>

                                <div class="form-check">
                                    <input type="radio" class="form-check-label" id="packetNo" name="has_packet" value="0">
                                    <label class="form-check-label" for="packetNo">No</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-center mt-2">
                            <button name="save" class="btn btn-success">Save</button>
                            <a href="dashboard.php" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
<script src="../assets/js/script.js"></script>

</html>