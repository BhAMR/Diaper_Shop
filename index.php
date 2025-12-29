<?php
session_start();
include("config/connection.php");
include("header.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HD Enterprise Diaper Shop</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Font Awesome for hamburger icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>
    <div class="container mt-4">
        <?php
            $catSql = mysqli_query($con,"SELECT category_id, category_name FROM categories WHERE status = 'Active'") or die("Error:".mysqli_error($con));


        ?>
        <div class="row align-items-center g-2">
            <div class="col-md-4 col-12">
                <select id="categoryFilter" class="form-select text-center">
                    <option value="all" selected>All Category</option>
                    <?php while($cat = mysqli_fetch_assoc($catSql)) { ?>
                        <option value="<?php echo $cat['category_id']; ?>"><?php echo $cat['category_name']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
    <div class="container mt-4">
        <div class="row g-3" id="productContainer">
            <?php
            $sql = mysqli_query($con, "SELECT p.product_id, p.name, c.category_name, c.has_size, c.has_packet, p.size, p.price, p.packet_pieces, p.stock, p.image FROM products AS p INNER JOIN categories AS c ON p.category_id = c.category_id") or die(mysqli_error($con));
            while ($row = mysqli_fetch_assoc($sql)) {
                $inStock = $row['stock'] > 0;
            ?>
                <div class="col-md-3 col-6 mb-4">
                    <div class="card product-card h-100">
                        <span class="badge <?php echo $inStock ? 'badge-stock' : 'badge-out'; ?>">
                            <?php echo $inStock ? 'In Stock' : 'Out of Stock'; ?>
                        </span>

                        <div class="product-image-wrapper h-100">
                            <a href="product_detail.php?id=<?php echo $row['product_id']; ?>">
                                <img src="images/uploads/<?php echo $row['image']; ?>" class="product-img cursor-pointer" alt="<?php echo $row['name']; ?>">
                            </a>
                        </div>

                        <div class="card-body text-center p-2">
                            <h6 class="product-title"><?php echo $row['name']; ?></h6>

                            <?php
                            if ($row['has_size'] == 1 || $row['has_packet'] == 1) {
                            ?>
                                <?php if ($row['has_size'] == 1) { ?>
                                    <p class="mb-1 text-muted small">Size: <?php echo $row['size']; ?></p>
                                <?php } ?>

                                <?php if ($row['has_packet'] == 1) { ?>
                                    <div class="price-info">
                                        <span><b><?php echo $row['packet_pieces']; ?></b> pcs</span>
                                        <span><b>₹<?php echo $row['price']; ?></b>/packet</span>
                                    </div>
                                <?php } ?>
                            <?php } else { ?>
                                <div class="price-info">
                                    <span><b>₹<?php echo $row['price']; ?></b>/piece</span>
                                </div>
                            <?php } ?>

                            <?php if ($inStock) { ?>
                                <a href="add_to_cart.php?id=<?php echo $row['product_id']; ?>" class="btn btn-sm btn-success w-100 mt-2">Add Cart</a>
                            <?php } else { ?>
                                <button class="btn btn-sm btn-secondary w-100 mt-2" disabled>Out of Stock</button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
                            

    <div class="modal fade" id="imageModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content position-relative">
                <button type="button" class="btn-close modal-close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body text-center">
                    <img id="modalImg" src="" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </div>
<script>
    document.getElementById('categoryFilter').addEventListener('change', function(){
        const catId = this.value;
        const container = document.getElementById('productContainer');

        container.innerHTML = `
            <div class="col-12 text-center">
                <div class="spinner-border text-success"></div>
            </div>`;

        let bodyData = '';

        if(catId != 'all'){
            bodyData = "category_id=" + catId;
        }

        fetch('filter_products.php', {
            method: 'POST',
            headers: { "Content-Type" : "application/x-www-form-urlencoded"},
            body: bodyData
        })
        .then(res => res.text())
        .then(data => {
            container.innerHTML = data;
        });
    });
</script>
</body>

</html>

<?php include("footer.php"); ?>