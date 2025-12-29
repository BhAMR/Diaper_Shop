<?php

include("auth.php");
include("../config/connection.php");
include("header.php");

if (isset($_GET['edit']) && isset($_POST['update'])) {

        $product_id = (int) $_GET['edit'];
        $name = mysqli_real_escape_string($con,$_POST['name']);
        $category = (int)$_POST['category'];
        $size = $_POST['size'];
        $price = (int)$_POST['price'];
        $packet_pieces = (int)$_POST['packet_pieces'];
        $stock = (int)$_POST['stock'];

        if($stock > 0) {
            $status = 'In Stock';
        }
        else{
            $status = 'Out Of Stock';
        }
        
        $error = "";

        $oldImage = mysqli_query($con,"SELECT image FROM products WHERE product_id = '$product_id'");
        $oldImageRow = mysqli_fetch_assoc($oldImage);
        $imageName = $oldImageRow['image'];

        if(!empty($_FILES['image']['name'])){
            $fileName = $_FILES['image']['name'];
            $tmpName = $_FILES['image']['tmp_name'];
            $ext = pathinfo($fileName,PATHINFO_EXTENSION);

            $allowed = ['jpg','png','jpeg','webp'];

            if(in_array(strtolower($ext),$allowed)){
                if(!empty($imageName) && file_exists("../images/uploads/".$imageName)){
                    unlink("../images/uploads/".$imageName);
                }

                $imageName = uniqid("prod_") . "." .$ext;
                move_uploaded_file($tmpName,"../images/uploads/".$imageName);
            }
        }

        $sql = mysqli_query($con,"UPDATE products SET name = '$name', category_id = '$category', size = '$size', price = '$price', packet_pieces = '$packet_pieces', stock = '$stock', image = '$imageName', status = '$status' WHERE product_id = '$product_id'") or die("Error:".mysqli_error($con));

        if(mysqli_affected_rows($con) > 0){
           $error = "Product updated successfully..";
        }
        else{
            $error = "Something went wrong..";
        }
    
}

if(isset($_POST['cancel'])){
    header("Location: product.php");
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/adminStyle.css">

    <!-- Font Awesome for hamburger icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <div class="container mt-4">
        <div class="error-msg">
            <?php
                if(!empty($error))
                {
                    echo $error;
                    header("Location: product.php");
                }
            ?>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-md-6 col-lg-5">
                <div class="card p-4 shadow-lg gap-3 mb-4" style="width:100%;">
                    <i class="fa-solid fa-circle-xmark close-page" style="pointer;" onclick="back()"></i>
                    <h4 class="mb-2">Edit Product</h4>

                    <?php
                    $product_id = (int) $_GET['edit'];
                    $sql = mysqli_query($con, "SELECT * FROM products WHERE product_id = '$product_id'") or die("Error:" . mysqli_error($con));
                    $row = mysqli_fetch_assoc($sql);
                    ?>

                    <form method="POST" enctype="multipart/form-data" class="card p-4 shadow-lg rounded-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Product Name :</label>
                            <input type="text" name="name" class="form-control mb-2"
                                value="<?php echo $row['name']; ?>">
                        </div>

                        <div id="categoryField" class="mb-3">
                            <label class="form-label fw-semibold">Select Category :</label>
                            <select name="category" id="category_id" class="form-control mb-2">
                                <option value="" selected disabled>Select Category</option>
                                <?php
                                $cats = mysqli_query($con, "SELECT * FROM categories WHERE status = 'Active'") or die("Error:" . mysqli_error($con));
                                while ($cat = mysqli_fetch_assoc($cats)) {
                                    $selected = ($cat['category_id'] == $row['category_id']) ? 'selected' : '';
                                    ?>
                                    <option value="<?php echo $cat['category_id']; ?>" <?php echo $selected; ?>
                                        data-size="<?php echo $cat['has_size']; ?>"
                                        data-packet="<?php echo $cat['has_packet']; ?>"><?php echo $cat['category_name']; ?>
                                    </option>
                                <?php }
                                ?>
                            </select>
                        </div>

                        <div id="sizeField" class="mb-3">
                            <label class="form-label fw-semibold">Select Size :</label> <br>
                            <select name="size" class="form-control mb-2">
                                <option value="" selected disabled>Select Size</option>
                                <?php

                                $numQuery = mysqli_query($con, "SHOW COLUMNS FROM products LIKE 'size'") or die("Error:" . mysqli_error($con));
                                $enumRow = mysqli_fetch_assoc($numQuery);
                                preg_match("/^enum\((.*)\)$/", $enumRow['Type'], $matches);
                                $sizes = explode(",", str_replace("'", "", $matches[1]));

                                foreach ($sizes as $size) {
                                    $selected = ($size == $row['size']) ? 'selected' : '';
                                    echo "<option value='$size' $selected>$size</option>";
                                }

                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Select Price :</label>
                            <input type="number" name="price" class="form-control mb-2"
                                value="<?php echo $row['price']; ?>">
                        </div>

                        <div id="packetField" class="mb-3">
                            <label class="form-label fw-semibold">Select Pieces Packet :</label>
                            <select name="packet_pieces" class="form-control mb-2">
                                <option value="" disabled>Select Pieces Packet</option>
                                <?php
                                $packet = mysqli_query($con, "SELECT DISTINCT packet_pieces FROM products WHERE packet_pieces IS NOT NULL ORDER BY packet_pieces ASC") or die("Error:" . mysqli_error($con));

                                while ($pac = mysqli_fetch_assoc($packet)) {
                                    $dbPack = trim($pac['packet_pieces']);
                                    $rowPack = trim($row['packet_pieces']);
                                    $selected = ($dbPack == $rowPack) ? 'selected' : '';
                                    echo "<option value='$dbPack' $selected>$dbPack</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Select Stock :</label>
                            <input type="number" name="stock" class="form-control mb-2"
                                value="<?php echo $row['stock']; ?>">
                        </div>

                        <div class="mb-3 text-center">
                            <label class="form-label fw-semibold">Product Image :</label>
                            <?php
                            if (!empty($row['image'])): ?>

                                <img src="../images/uploads/<?php echo $row['image']; ?>" alt="product_image" class="img-fluid mb-2 mt-2 rounded" style="max-width:180px;">
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Add new Image :</label>
                            <input type="file" class="form-control mb-2" name="image">
                        </div>
                        <div class="text-center mt-2">
                            <button name="update" class="btn btn-success">Update</button>
                            <button name="cancel" class="btn btn-danger">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</body>
<script>
    document.querySelector('select[name="category"]').addEventListener('change', function () {

        const option = this.options[this.selectedIndex];
        const hasSize = option.getAttribute("data-size");
        const hasPacket = option.getAttribute("data-packet");

        const sizeField = document.getElementById("sizeField");
        const packetField = document.getElementById("packetField");

        if (hasSize == 1) {
            sizeField.style.display = "block";
        }
        else {
            sizeField.style.display = "none";
            document.querySelector('select[name="size"]').value = "";
        }

        if (hasPacket == 1) {
            packetField.style.display = "block";
        }
        else {
            packetField.style.display = "none";
            document.querySelector('select[name="packet_pieces"]').value = "";
        }
    });

    document.addEventListener("DOMContentLoaded", function () {
        const categorySelect = document.querySelector('select[name="category"]');

        if (categorySelect) {
            categorySelect.dispatchEvent(new Event('change'));
        }
    });

</script>
<script src="../assets/js/script.js"></script>

</html>
<?php 
include("footer.php");
?>