<!DOCTYPE html>
<html lang="en">
<head>
    <?php session_start(); require "./../include/database.php"; include "head.php";?>
    <title>Search</title>
    <style>
        @import "./src/css/root.css";
    </style>
</head>
<body>
    <?php include "./header.php"; $_SESSION['posts'] = "Search"; $_SESSION["search"] = $_REQUEST["search"];?>
    <main style="margin-top:60px;">
        <?php include "./products.php";?>
    </main>
</body>
</html>