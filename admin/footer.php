<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        html,body{
            height: 100%;
        }

        body{
            display: flex;
            flex-direction: column;
        }

        .admin-footer{
            margin-top: auto;
        }
    </style>
</head>
<body>
    <footer class="admin-footer mt-auto">
        <div class="container">
            <div class="row align-items-center text-center text-md-start">
                <div class="col-md-6 mb-2 mb-md-0">
                    <span class="footer-taxt">
                         ©<span id="currentYear"></span>
                         <strong>HD Enterprice</strong>.All right reserved.
                    </span>
                </div>

                <div class="col-md-6 text-md-end">
                    <span class="footer-text small">
                        Admin Panel
                    </span>
                </div>
            </div>
        </div>
    </footer> 
</body>
<script>
    document.getElementById("currentYear").textContent = new Date().getFullYear();
</script>
</html>