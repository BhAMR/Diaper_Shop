<?php
include("config/connection.php");

if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($con,$_POST['customer_name']);
    $mobile = mysqli_real_escape_string($con,$_POST['mobile']);
    $email = mysqli_real_escape_string($con,$_POST['email']);
    $type = mysqli_real_escape_string($con,$_POST['inquiry_type']);
    $msg = mysqli_real_escape_string($con,$_POST['message']);
    $contact = mysqli_real_escape_string($con,$_POST['preferred_contact']);
    $pincode = mysqli_real_escape_string($con,$_POST['pincode']);

    $sql = mysqli_query($con,"INSERT INTO inquiries(customer_name,mobile,email,inquiry_type,message,preferred_contact,pincode) VALUES ('$name','$mobile','$email','$type','$msg','$contact','$pincode')") or die("Error:".mysqli_error($con));

    $whatsApp = "917096317990";
    $text = urlencode("📩 New Inquiry\n Name: $name\n Mobile: $mobile\n Type: $type\n Message: $msg");

    header("Location: contact.php?success=1&wa=$whatsApp&text=$text");
    exit();

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/adminStyle.css">

    <!-- Font Awesome for hamburger icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="bg-light">
    <?php 
include("header.php"); ?>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg border-0 rounded-4">
                    <i class="fa-solid fa-circle-xmark close-page" style="cursor:pointer;" onclick="goBack()"></i>
                    <div class="card-body p-4">
                        <h4 class="text-center mb-3 fw-bold">
                            Contact HD Enterprice
                        </h4>
                        <p class="text-center text-muted mb-4">
                            We're happy to help you choose right diaper for your baby. Reach out to us for any
                            assistance or inquiries.
                        </p>

                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Full Name</label>
                                <input type="text" name="customer_name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Mobile</label>
                                <input type="text" name="mobile" class="form-control" maxlength="10" pattern="[0-9]{10}"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Reason for Contact</label>
                                <select name="inquiry_type" class="form-select" required>
                                    <option value="" disabled selected>Select Reason</option>
                                    <option>Product Inquiry</option>
                                    <option>Size/Age Guidance</option>
                                    <option>Bulk Order</option>
                                    <option>Delivery Related</option>
                                    <option>Payment Issue</option>
                                    <option>Complaint</option>
                                    <option>Other</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Message</label>
                                <textarea name="message" class="form-control" rows="4" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Preferred_Contact</label>
                                <div class="d-flex gap-3">
                                    <div class="form-check">
                                        <input type="radio" name="preferred_contact" value="Call" checked>
                                        <label class="form-label fw-semibold">Call</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" name="preferred_contact" value="WhatsApp">
                                        <label class="form-label fw-semibold">WhatsApp</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Pincode</label>
                                <input type="text" name="pincode" class="form-control" maxlength="6" required>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-success fw-semibold" name="submit">
                                    <i class="bi bi-whatsapp">Submit</i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- thank you modal -->
    <div class="modal fade" id="thankYouModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center p-4 rounded-4">
                <h4 class="text-success">Thank You! 🎉</h4>
                <p class="mt-3">We appreciate you reaching out to us. Our team will get back to you shortly.</p>
                <button class="btn btn-primary mt-2" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <?php if(isset($_GET['success'])) { ?>
<script>
window.onload = function () {
    let modal = new bootstrap.Modal(document.getElementById('thankYouModal'));
    modal.show();

    setTimeout(() => {
        window.location.href =
            "https://wa.me/<?php echo $_GET['wa']; ?>?text=<?php echo $_GET['text']; ?>";
    }, 3000);
};
</script>
<?php } ?>
</body>
</html>