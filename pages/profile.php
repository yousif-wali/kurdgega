<?php require "./../include/database.php"; session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <base href="http://localhost/kurdgega-future-dev/master/"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <title><?php echo $_SESSION['username']?></title>
    <style>
        @import "./src/css/root.css";
        @import "./src/css/profile.css";
    </style>
</head>
<body>
    <?php include "./header.php";?>
    <main class="row" style="margin-top:60px;">
    <aside class="col-3 border">

    </aside>
    <span class="col-7"></span>
        <section class="col-5">
            <h1>Your Posts</h1>
            <?php $_SESSION["posts"] = "profile"; include "./products.php";?>
        </section>
    </main>
    <script src="./src/script/index.js"></script>
</body>
</html>