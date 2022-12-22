<?php require "./include/database.php";?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Kurdgega</title>
    <style>
        @import "./src/css/main.css";
        @import "./src/css/root.css";
    </style>
    <?php include "./pages/head.php";?>
</head>
<body class="overflow-x-hidden">
    <?php session_start(); include "./pages/header.php";?>
    <main>
        <?php include "./pages/catagories.php";?>
        <section class="posts container" style="width:40%">
            <?php $_SESSION['posts'] = "all"; include "./pages/products.php";?>
        </section>
    </main>
    <?php include "./pages/mobileFooter.php";?>
</body>
</html>