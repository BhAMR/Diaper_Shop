<?php

include("config/connection.php");

$where = "";

if(!empty($_POST['category_id'])){
    $catId = (int)$_POST['category_id'];
    $where = "WHERE p.category_id = $catId";
}
    $sql = mysqli_query($con,"SELECT p.product_id,p.name,c.has_size, c.has_packet, p.size, p.price, p.packet_pieces, p.stock, p.image FROM products AS p INNER JOIN categories AS c ON p.category_id = c.category_id $where") or die("Error:".mysqli_error($con));
    
    while($row = mysqli_fetch_assoc($sql)){
        $inStock = $row['stock'] > 0;
    ?>
    <div class="col-md-3 col-6 mb-4">
        <div class="card product-card h-100">
            <span class="badge <?php echo $inStock ? 'badge-stock' : 'badge-out'; ?>">
                <?php echo $inStock ? 'In Stock' : 'Out of Stock'; ?>
            </span>

            <div class="product-image-wrapper h-100">
                <a href="product_detail.php?id=<?php echo $row['product_id']; ?>">
                <img src="images/uploads/<?php echo $row['image']; ?>" class="product-img" alt="<?php echo $row['name']; ?>"></a>
            </div>

            <div class="card-body text-center p-2">
                <h6 class="product-title"><?php echo $row['name'] ?></h6>

                <?php if($row['has_size']) { ?>
                    <p class="mb-1 text-muted small">Size:<?php echo $row['size']; ?></p>
                <?php } ?>

                <?php if($row['has_packet']) { ?>
                    <div class="price-info">
                        <span><b><?php echo $row['packet_pieces']; ?></b></span>
                        <span><b>₹<?php echo $row['price']; ?></b>/packet</span>
                    </div>
                <?php } else { ?>
                    <div class="price-info">
                        <span><b>₹<?php echo $row['price']; ?></b>/Pieces</span>
                    </div>
                <?php } ?>

                <?php if($inStock) { ?>
                    <a href="add_to_cart.php?id=<?php echo $row['product_id']; ?>" class="btn btn-sm btn-success mt-2">Add Cart</a>
                <?php } else { ?>
                    <button class="btn btn-sm btn-secondary mt-2" disabled>Out Of Stock</button>
                <?php } ?>
            </div>
        </div>
    </div>

<?php } ?>