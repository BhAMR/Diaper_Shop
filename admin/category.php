<?php

include("auth.php");
include("../config/connection.php");
include("header.php");

if (isset($_GET['delete'])) {
    $category_id = intval($_GET['delete']);

    mysqli_begin_transaction($con);

    try {

        mysqli_query($con, "DELETE FROM products WHERE category_id = '$category_id'") or die("Error:" . mysqli_error($con));
        mysqli_query($con, "DELETE FROM categories WHERE category_id = '$category_id'") or die("Error:" . mysqli_error($con));

        mysqli_commit($con);
        header("Location: category.php?msg=deleted");
        exit;
    } catch (Exception $e) {
        mysqli_rollback($con);
        echo "Error:" . $e;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Category</title>
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
                    echo "Category Deleted successfully..";
                }
                ?>
            </div>


            <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
                <h4 class="table-title mb-0">Category List</h4>

                <a href="addCategory.php" class="btn btn-secondary d-flex align-items-center gap-1">
                    <i class="bi bi-plus-circle"></i>
                    Add Category
                </a>
            </div>
            <div class="custom-table d-none d-lg-block">
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Category</th>
                            <th>Has_Size</th>
                            <th>Has_Packet</th>
                            <th colspan="4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = mysqli_query($con, "SELECT * FROM categories ORDER BY category_id DESC") or die("Error:" . mysqli_error($con));

                        if (mysqli_num_rows($sql) > 0) {
                            while ($row = mysqli_fetch_assoc($sql)) { ?>

                                <tr>
                                    <td><?php echo $row['category_id']; ?></td>
                                    <td><?php echo $row['category_name']; ?></td>
                                    <td><?php echo $row['has_size']; ?></td>
                                    <td><?php echo $row['has_packet']; ?></td>
                                    <td><a href="editCategory.php?edit=<?php echo $row['category_id']; ?>"
                                            class="btn btn-primary btn-sm">Edit</a></td>

                                    <td><a href="?delete=<?php echo $row['category_id']; ?>" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you confirm to delete this category?');">Delete</a>
                                    </td>
                                </tr>

                            <?php }
                        } else { ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">No Records Found..</td>
                            </tr>
                        <?php }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- mobile category card -->
             <div class="d-lg-none">
                <?php
                    $sql = mysqli_query($con, "SELECT * FROM categories ORDER BY category_id DESC") or die("Error:" . mysqli_error($con));
                    if(mysqli_num_rows($sql) > 0){
                        while ($row = mysqli_fetch_assoc($sql)) { ?>
                            <div class="card mb-3 shadow-sm">
                                <div class="card-body">
                                    <h6 class="fw-bold mb-2"><strong>Id:</strong>#<?php echo $row['category_id']; ?></h6>
                                    <h6 class="fw-bold mb-2"><?php echo $row['category_name']; ?></h6>
                                    <p class="mb-1"><strong>Has_Size:</strong><?php echo $row['has_size'] ? 'Yes' : 'No'; ?></p>
                                    <p class="mb-1"><strong>Has_Packet:</strong><?php echo $row['has_packet'] ? 'Yes' : 'No'; ?></p>

                                    <div class="d-flex gap-2">
                                        <a href="editCategory.php?edit=<?php echo $row['category_id']; ?>" class="btn btn-primary btn-sm w-50">Edit</a>
                                        <a href="?delete=<?php echo $row['category_id']; ?>" class="btn btn-danger btn-sm w-50" onclick="return confirm('Are you sure to delete this category?');">Delete</a>
                                    </div>
                                </div>
                            </div>
                <?php } }?>
             </div>
        </div>
    </div>
</body>
<script href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/script.js"></script>

</html>

<?php
include("footer.php");
?>  