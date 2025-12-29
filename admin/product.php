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
    <div class="container mt-4">
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
            <div class="custom-table d-none d-lg-block">

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
                        $sql = mysqli_query($con, "SELECT p.product_id,p.name,c.category_name,p.size,p.price,p.packet_pieces,p.stock FROM products as p INNER JOIN categories as c ON p.category_id = c.category_id ORDER BY product_id DESC") or die("ERROR:" . mysqli_error($con));

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
                <!-- mobile product card -->
                <div class="d-lg-none">
                    <?php
                    $sql = mysqli_query($con, "SELECT p.product_id, p.name, c.category_name, p.size, p.price, p.packet_pieces, p.stock FROM products AS p INNER JOIN categories AS c ON p.category_id = c.category_id ORDER BY product_id DESC");

                    if (mysqli_num_rows($sql) > 0) {
                        while ($row = mysqli_fetch_assoc($sql)) { ?>
                            <div class="card mb-3 shadow-sm">
                                <div class="card-body">
                                    <h6 class="fw-bold mb-2"><strong>Id:</strong>#<?php echo $row['product_id']; ?></h6>
                                    <h6 class="fw-bold mb-2"><?php echo $row['name']; ?> </h6>
                                    <p class="mb-1"><strong>Category:</strong><?php echo $row['category_name']; ?></p>
                                    <p class="mb-1"><strong>Size:</strong><?php echo !empty($row['size']) ? $row['size'] : 'NON'; ?></p>
                                    <p class="mb-1"><strong>Price:</strong><?php echo $row['price']; ?></p>
                                    <p class="mb-1"><strong>Pcs/Pacet:</strong><?php echo !empty($row['packet_pieces']) ? $row['packet_pieces'] : 'NON'; ?></p>
                                    <p class="mb-1"><strong>Stock:</strong><?php echo $row['stock']; ?></p>

                                    <div class="d-flex gap-2">
                                        <a href="editProduct.php?edit=<?php echo $row['product_id']; ?>"
                                            class="btn btn-primary btn-sm w-50">Edit</a>
                                        <a href="?delete=<?php echo $row['product_id']; ?>"
                                            onclick="return confirm('Are you sure to delete this product?');"
                                            class="btn btn-danger btn-sm w-50">Delete</a>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    }  else { ?>

                    <p class="text-center text-muted">No Record Found..</p>

                    <?php } ?>
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