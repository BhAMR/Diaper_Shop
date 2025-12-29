<?php
include("header.php");
include("../config/connection.php");

if (isset($_POST['save'])) {
    $image = time() . $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "../images/uploads/" . $image);

    $size = !empty($_POST['size']) ? $_POST['size'] : null;
    $packet = !empty($_POST['packet_pieces']) ? $_POST['packet_pieces'] : null;

    $stock = $_POST['stock'];

    if($stock > 0){
        $status = 'In Stock';
    }
    else{
        $status = 'Out Of Stock';
    }

    $sql = mysqli_query($con, "INSERT INTO products (name,category_id,size,price,packet_pieces,stock,image,status) 
        VALUES ('$_POST[name]','$_POST[category]','$size','$_POST[price]','$packet','$stock','$image','$status')") or die("Error:" . mysqli_error($con));

    if ($sql) {
        echo "<script>alert('Product added successfully..');location='dashboard.php';</script>";
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
    <title>Add New Product</title>
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
                    <h4 class="mb-2">Add New Products</h4>

                    <form method="POST" enctype="multipart/form-data" class="card p-4 shadow-lg rounded-4">
                        <input type="text" name="name" class="form-control mb-2" placeholder="Product name" required>
                        <div id="categoryField">
                            <select name="category" id="category_id" class="form-control mb-2">
                                <option value="" selected disabled>Select Category</option>
                                <?php
                                     $cats = mysqli_query($con,"SELECT * FROM categories WHERE status = 'Active'") or die("Error:".mysqli_error($con));
                                    while($cat = mysqli_fetch_assoc($cats)){ ?>
                                        
                                        <option value="<?php echo $cat['category_id']; ?>" data-size="<?php echo $cat['has_size']; ?>" data-packet="<?php echo $cat['has_packet']; ?>"><?php echo $cat['category_name']; ?></option>

                                  <?php  }
                                ?>
                            </select>
                        </div>
                        <div id="sizeField" style="display:none;">
                            <select name="size" class="form-control mb-2">
                                <option value="" selected disabled>Select Size</option>
                                <option value="NB">NB</option>
                                <option value="S">Small</option>
                                <option value="M">Medium</option>
                                <option value="L">Large</option>
                                <option value="XL">XL</option>
                                <option value="XXL">XXL</option>
                                <option value="XXXL">XXXL</option>
                            </select>
                        </div>
                        <input type="number" name="price" class="form-control mb-2" placeholder="Price.." required>
                        <div id="packetField" style="display:none;">
                            <select name="packet_pieces" class="form-control mb-2">
                                <option value="" selected disabled>Select Pieces Per packet</option>
                                <option value="56">56 per Packets</option>
                                <option value="75">75 Per Packets</option>
                            </select>
                        </div>
                        <input type="number" name="stock" class="form-control mb-2" min="1" placeholder="Stoke.." required>

                        <input type="file" class="form-control mb-2" name="image" required>

                        <div class="text-center mt-2">
                            <button name="save" class="btn btn-success">Save</button>
                            <a href="dashboard.php" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <script>
        document.querySelector('select[name="category"]').addEventListener('change', function () {

            const option = this.options[this.selectedIndex];
            const hasSize = option.getAttribute("data-size");
            const hasPacket = option.getAttribute("data-packet");

            const sizeField = document.getElementById("sizeField");
            const packetField = document.getElementById("packetField");

            if(hasSize == 1){
                sizeField.style.display = "block";
            }
            else{
                sizeField.style.display = "none";
                document.querySelector('select[name="size"]').value = "";
            }

            if(hasPacket == 1){
                packetField.style.display = "block";
            }
            else{
                packetField.style.display = "none";
                document.querySelector('select[name="packet_pieces"]').value = "";
            }

            /* const category = this.value;
            const sizeField = document.getElementById("sizeField");
            const packetField = document.getElementById("packetField");

            const noSizeCategories = ['powder', 'lotion', 'oil', 'soap'];

            if (noSizeCategories.includes(category)) {
                sizeField.style.display = 'none';
                packetField.style.display = 'none';

                document.querySelector('select[name="size"]').value = '';
                document.querySelector('select[name="packet_pieces"]').value = '';
            }
            else {
                sizeField.style.display = 'block';
                packetField.style.display = 'block';
            } */
        });
    </script>
    <script src="../assets/js/script.js"></script>
</body>

</html>