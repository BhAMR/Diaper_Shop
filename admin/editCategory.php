<?php

include("auth.php");
include("../config/connection.php");
include("header.php");

$category_id = (int) $_GET['edit'];
$sql = mysqli_query($con, "SELECT * FROM categories WHERE category_id = '$category_id'") or die("Error:" . mysqli_error($con));
$row = mysqli_fetch_assoc($sql);

if (!$row) {
    header("Location: category.php");
    exit();
}

if (isset($_POST['update'])) {

    $name = trim($_POST['category_name']);
    $size = isset($_POST['has_size']) ? (int) $_POST['has_size'] : 0;
    $packet = isset($_POST['has_packet']) ? (int) $_POST['has_packet'] : 0;

    if ($name == '') {
        $error = "category_name is required..";
    } else {

        $sql = mysqli_prepare($con, "UPDATE categories SET category_name = ? , has_size = ? , has_packet = ? WHERE category_id = ? ") or die("Error:" . mysqli_error($con));

        mysqli_stmt_bind_param($sql, "siii", $name, $size, $packet, $category_id);
        mysqli_stmt_execute($sql);

        header("Location: category.php?updated=1");
        exit();
    }

}

if (isset($_POST['cancel'])) {
    header("Location: category.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/adminStyle.css">

    <!-- Font Awesome for hamburger icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>
    <div class="container mt-4">
        <div class="error-msg">

        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-md-6 col-lg-5">
                <div class="card p-4 shadow-lg gap-3 mb-4" style="width: 100%;">
                    <i class="fa fa-circle-xmark close-page" style="cursor:pointer;" onclick="back()"></i>
                    <h4 class="mb-2">Edit Category</h4>

                    <?php
                    /*  $category_id = (int)$_GET['edit'];
                     $sql = mysqli_query($con,"SELECT * FROM categories WHERE category_id = '$category_id'") or die("Error:".mysqli_error($con));
                     $row = mysqli_fetch_assoc($sql); */
                    ?>
                    <form method="POST" class="card p-4 shadow-lg rounded-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Category Name</label>
                            <input type="text" name="category_name" class="form-control mb-2"
                                value="<?php echo htmlspecialchars($row['category_name']); ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Have a Size?</label>
                            <label><!-- <?php echo ($row['has_size']) ? '(Yes)' : '(No)'; ?> --></label>
                            <div class="d-flex gap-4">
                                <div class="form-check">
                                    <input type="radio" name="has_size" class="form-check-input" value="1"
                                        <?php echo ($row['has_size'] == 1) ? 'checked' : '' ?>>
                                    <label class="form-label fw-semibold" for="sizeYes">Yes</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" name="has_size" class="form-check-input" value="0" <?php echo ($row['has_size'] == 0) ? 'checked' : '' ?>>
                                    <label class="form-label fw-semibold" for="sizeNo">No</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Have a Packet?</label>
                            <label class="form-label"><!-- <?php echo ($row['has_packet']) ? '(Yes)' : '(No)'; ?> --></label>
                            <div class="d-flex gap-4">
                                <div class="form-check">
                                    <input type="radio" name="has_packet" class="form-check-input"
                                        value="1" <?php echo ($row['has_packet'] == 1) ? 'checked' : '' ?>>
                                    <label class="form-label fw-semibold" for="packetYes">Yes</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" name="has_packet" class="form-check-input"
                                        value="0" <?php echo ($row['has_packet'] == 0) ? 'checked' : '' ?>>
                                    <label class="form-label fw-semibold" for="packetNo">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-2">
                            <button name="update" class="btn btn-success">Update</button>
                            <a href="category.php" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="../assets/js/script.js"></script>

</html>
<?php
include("footer.php");
?>