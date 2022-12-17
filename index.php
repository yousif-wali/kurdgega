<?php require "./include/database.php";?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="refresh" content="5000000000"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kurdgega</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        @import "./src/css/main.css";
        @import "./src/css/root.css";
    </style>
</head>
<body class="overflow-x-hidden">
    <?php session_start(); include "./pages/header.php";?>
    <main>
        <?php include "./pages/catagories.php";?>
        <section class="posts container" style="width:40%">
            <?php $_SESSION['posts'] = "all"; include "./pages/products.php";?>
        </section>
    </main>
    <script src="./src/script/index.js"></script>
</body>
</html>