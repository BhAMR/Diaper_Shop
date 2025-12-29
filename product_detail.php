<?php


include("config/connection.php");
include("header.php");

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$product_id = (int) $_GET['id'];

$sql = mysqli_query($con, "SELECT p.*, c.category_name, c.has_size, c.has_packet FROM products as p INNER JOIN categories as c ON p.category_id = c.category_id WHERE p.product_id = $product_id") or die("Error:" . mysqli_error($con));

$row = mysqli_fetch_assoc($sql);

if (!$row) {
    header("Location: index.php");
    exit;
}

$inStock = $row['stock'] > 0;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Font Awesome for hamburger icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center mt-4">
        <div class="card product-detail-card position-relative">
         <i class="fa-solid fa-circle-xmark close-page" style="cursor:pointer;" onclick="goBack()"> </i>

         <div class="modal fade" id="imageModal" tabindex="-1" data-bs-backdrop="true" data-bs-keyboard="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content bg-transparent border-0">
                            <div class="modal-body text-center p-0">
                                    <img id="imageModalImg" src="" class="img-fluid rounded shadow" alt="Preview">
                            </div>
                        </div>
                    </div>
              </div>
            <div class="text-center p-3 position-relative">
                <div class="zoom-badge" onclick="openImageModal('images/uploads/<?php echo $row['image']; ?>')">
                    <i class="bi bi-zoom-in"></i>
                </div>
                <img id="modalImage" src="images/uploads/<?php echo $row['image'] ?>" class="img-fluid rounded product-detail-img"
                    alt="<?php echo $row['name']; ?>">
            </div>

            <div class="card-body text-center">
                <h5 class="fw-bold mb-2"><?php echo $row['name']; ?></h5>

                <?php
                if ($row['has_size'] == 1) { ?>
                    <p class="text-muted mb-1">Size: <?php echo $row['size']; ?> </p>
                <?php } ?>
                <?php
                if ($row['has_packet'] == 1) { ?>
                    <p class="mb-1"><b><?php echo $row['packet_pieces']; ?></b> pcs/packet</p>

                    <p class="price-text">₹<?php echo $row['price']; ?> /packet</p>
                <?php } else { ?>
                    <p class="price-text">₹<?php echo $row['price']; ?>/piece</p>
                <?php } ?>

                <div class="gap-3 mt-4 text-center">
                    <?php
                    if ($inStock) { ?>
                        <!-- <button onclick="add_to_cart.php?id=<?php echo $row['product_id']; ?>" class="btn btn-outline-success">Add to Cart</button> --> 
                        <a href="add_to_cart.php?id=<?php echo $row['product_id']; ?>" class="btn btn-light btn-outline-secondary">Add
                            Cart</a>
                        <a href="placeOrder.php?id=<?php echo $row['product_id']; ?>" class="btn btn-success">Buy Now</a>
                    <?php } else { ?>
                        <button class="btn btn-secondary me-2" disabled>Out Of Stock</button>
                    <?php } ?>

                    <a href="index.php" class="btn btn-outline-danger">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="assets/js/script.js">
</script>

</html>