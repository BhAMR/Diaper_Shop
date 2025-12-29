<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Font Awesome for hamburger icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>
    <div class="user-footer">
        <div class="container">

            <!-- TOP FOOTER -->
            <div class="footer-top">

                <!-- ABOUT -->
                <div class="footer-about">
                    <h6 class="footer-title">About HD Diapers</h6>
                    <p>
                        HD Enterprise provides high-quality, hygienic and affordable
                        baby diaper products designed for comfort and protection.
                        Trusted by families for everyday care.
                    </p>
                </div>

                <!-- MOBILE TWO COLUMN WRAPPER -->
                <div class="footer-two-col">

                    <!-- QUICK LINKS -->
                    <div>
                        <h6 class="footer-title">Quick Links</h6>
                        <ul class="footer-links">
                            <li><a href="privacy.php"><i class="bi bi-shield-check"></i> Privacy Policy</a></li>
                            <li><a href="terms.php"><i class="bi bi-file-text"></i> Terms & Conditions</a></li>
                            <!-- <li><a href="#"><i class="bi bi-telephone"></i> Contact</a></li> -->
                            <li><a href="rate_us.php"><i class="bi bi-star-fill"></i> Rate Us</a></li>
                        </ul>
                    </div>

                    <!-- SHOP -->
                    <div>
                        <h6 class="footer-title">Our Shop</h6>
                        <p class="footer-location">
                            <i class="bi bi-geo-alt-fill"></i>
                            <strong>HD Enterprise</strong><br>
                            Maharaja Farm Road,<br>
                            Mota-Varachha, Surat – 394101<br>
                            Gujarat, India
                        </p>
                    </div>

                </div>

            </div>


            <div class="footer-center-links mt-4">
                <a href="https://www.google.com/maps/place/H+D+ENTERPRISE+diaper/@21.2421846,72.8743647,17z/data=!3m1!4b1!4m6!3m5!1s0x3be04f00125cb901:0x88f4b3a62ed48e45!8m2!3d21.2421796!4d72.8769396!16s%2Fg%2F11y83jkl8g?entry=ttu&g_ep=EgoyMDI1MTIwOS4wIKXMDSoASAFQAw%3D%3D"
                    target="_blank" class="map-link">
                    <i class="fa-solid fa-location-dot"></i> Find on Maps
                </a>
                <a href="tel:+918140371899">
                    <i class="bi bi-telephone-fill"></i>Call Us
                </a>
                <a href="https://wa.me/918140371899">
                    <i class="bi bi-whatsapp"></i> WhatsApp
                </a>

            </div>

            <!-- BOTTOM FOOTER -->
            <div class="footer-bottom text-center mt-4">
                © <span id="year"></span> <strong>HD Enterprise</strong>. All rights reserved.
            </div>

        </div>
    </div>

</body>
<script>
    document.getElementById("year").innerHTML = new Date().getFullYear();
</script>

</html>