<?php require "./include/database.php";?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kurdgega</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        @import "./src/css/main.css";
        @import "./src/css/root.css";
    </style>
</head>
<body>
    <?php session_start(); include "./pages/header.php";?>
    <main>
        <?php include "./pages/catagories.php";?>
        <section class="posts container">
            <?php include "./pages/products.php";?>
        </section>
    </main>
</body>
</html>