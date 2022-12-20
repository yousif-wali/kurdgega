<!DOCTYPE html>
<html lang="en">
<head>
    <?php session_start(); include "head.php"; require "./../include/database.php";?>
    <title>Filter</title>
    <style>
        @import "./src/css/root.css";
    </style>
</head>
<body>
    <?php include "header.php"; $_SESSION['posts'] = "Filter"; $_SESSION['category'] = $_REQUEST['category']; $_SESSION['model'] = $_REQUEST['model'];?>
    <main style="margin-top:60px;">
        <?php include "./products.php";?>
    </main>
</body>
</html>