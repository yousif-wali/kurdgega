<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post - <?php echo $_SESSION['username']?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body{
            height:100vh;
        }
        form{
            width:400px;
        }
        form > *{
            margin:0.5em;
            
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center">
    <form action="./../include/validator.php" method="POST" enctype="multipart/form-data">
        <section class="form-floating">
            <input id="title" type="text" name="title" class="form-control" placeholder="John"/>
            <label for="title" class="form-label">Title</label>
        </section>
        <section  class="form-floating">
            <input id="desc" type="text" name="desc" class="form-control" placeholder="Doe"/>
            <label for="desc" class="form-label">Description</label>
        </section>
        <section  class="form-floating">
            <input id="price" type="text" name="price" class="form-control" placeholder="$9.99"/>
            <label for="price" class="form-label">Price</label>
        </section>
        <section>
            <input id="image" type="file" name="image[]" accept="image/*" multiple class="form-control" placeholder="image.png" />
        </section>
        <section class="row">
            <section class="col-6 form-floating">
                <input id="category" type="text" name="category" class="form-control" placeholder="category"/>
                <label for="category" class="form-label">Category</label>
            </section>
            <section class="col-6 form-floating">
                <input id="model" type="text" name="model" class="form-control" placeholder="model"/>
                <label for="model" class="form-label">Model</label>
            </section>
        </section>
        <section class="row">
            <section class="col-6 form-floating">
                <input id="year" type="number" name="year" min="1950" max="2023" step="1" class="form-control" placeholder="Year" />
                <label for="year" class="form-label">Year</label>
            </section>
            <section class="col-6 d-flex align-items-center">
                <select id="condition" name="condition" class="form-select">
                    <option value="new">Condition - New</option>
                    <option value="usednew">Condition - Used Like New</option>
                    <option value="usedold">Condition - Used Old</option>
                    <option value="old">Condition - Old</option>
                </select>
            </section>
        </section>
        <button name="postProduct" class="btn btn-success">Post</button>
        <?php
        if(isset($_COOKIE["productpost"])){
            echo '<p class="text-success">The Post Was Succesfully Added!</p>';
        }
        ?>
    </form>
    <section class="bg-success text-white p-2 rounded" style="position:fixed; bottom:1em; right:1em; cursor:pointer" onclick="window.location = './../index.php'">
    Home
    </section>
</body>
</html>