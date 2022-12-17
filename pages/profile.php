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
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title><?php echo $_SESSION['username']?></title>
    <style>
        @import "./src/css/root.css";
        @import "./src/css/profile.css";
    </style>
</head>
<body>
    <?php
    if(!isset($_SESSION["user_ID"])){
        header("Location: ./../index.php");
    }
    ?>
    <?php include "./header.php";?>
    <main>
    <aside data-element="aside" class="d-flex justify-content-center align-items-start">
        <section class='d-flex justify-content-center flex-column w-100'>
            <section class='btn btn-primary d-flex justify-content-between align-items-center' onclick="select(this, 'post')" data-type-for="post"><i class="material-icons">image</i>Posts</section>
            <section class='btn btn-secondary d-flex justify-content-between align-items-center' onclick="select(this, 'account')" data-type-for="account"><i class="material-icons">manage_accounts</i>Account</section>
        </section>
    </aside>
        <section style="height:calc(100vh + 60px);" data-select="post" data-type='selection'>
            <section data-select="post">
                <h1>Your Posts</h1>
                <?php $_SESSION["posts"] = "profile"; include "./products.php";?>
            </section>
            <section style="display:none" data-select="account">
                <h1>Account</h1>
                <?php
                        if(isset($_COOKIE["profileInfo"]) && $_COOKIE["profileInfo"] == "updated"){
                            echo '<section class="text-white bg-success mt-2 p-2">The information is successfully updated!</section>';
                        }
                        ?>
                <form action="include/validator.php" method="POST" class="pe-3">
                    <section class="row g-2">
                        <?php
                        $user = new User();
                        $information = $user->getInformation($_SESSION['username']);
                        echo '
                        <section class="col-6">
                            <label>First Name</label>
                            <input type="text" name="firstName" class="form-control" value="'.$information[0].'" required/>
                        </section>
                        <section class="col-6">
                            <label>Last Name</label> 
                        <input type="text" name="lastName" class="form-control" value="'.$information[1].'" required/>
                        </section>
                        <section class="col-6">
                            <label>Username</label>
                            <input type="text" name="userName" class="form-control" value="'.$information[2].'" disabled required/>
                        </section>
                        <section class="col-6">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="'.$information[3].'" disabled required/>
                        </section>
                        <section class="col-12">
                            <label>Phone Number</label>
                            <input type="tel" name="phone" class="form-control" value="'.$information[4].'" required/>
                        </section>
                        <section class="col-6">
                            <label>Gender</label>
                            <input type="text" name="gender"  class="form-control" value="'.$information[5].'" disabled required/>
                        </section>
                        <section class="col-6">
                            <label title="mm/dd/yyyy">Member Since</label>
                            <input type="date" name="memberSince" class="form-control" value="'.$information[6].'" disabled requried/>
                        </section>
                        <section class="col-4">
                            <label>Address</label>
                            <input type="text" name="address" class="form-control" value="'.$information[7].'" required/>
                        </section>
                        <section class="col-4">
                        <label>City</label>
                        <input type="text" name="city" class="form-control" value="'.$information[8].'" required/>
                        </section>
                        <section class="col-4">
                            <label>State</label>
                            <input type="text" name="state"  class="form-control" value="'.$information[9].'" required/>
                        </section>
                        <section class="col-4">
                            <label>Country</label>
                            <input type="text" name="country"  class="form-control" value="'.$information[10].'" required/>
                        </section>
                        <section class="col-8">
                            <label title="mm/dd/yyyy">Date of Birth</label>
                            <input type="date" name="dob"  class="form-control" value="'.$information[11].'" disabled required/>
                        </section>
                        <section class="col-12">
                            <label>Update Profile</label>
                            <input accept="image/*" type="file" name="uploadProfile" class="form-control
                        ';
                        if(isset($_COOKIE["image"]) && $_COOKIE["image"] == "false"){
                            echo ' is-invalid ';
                        }
                        echo '"/>
                        <section class="invalid-feedback">
                        The image filetype is not supported or the file is too big!
                        </section>
                        </section>
                        ';
                        ?>
                    </section>
                    <section class="m-2">
                        <button name="updateProfile" class="btn btn-success w-100">Update</button>
                    </section>
                </form>
            </section>
        </section>
    </main>
    <script src="./src/script/index.js"></script>
    <script src="./src/script/profile.js"></script>
</body>
</html>