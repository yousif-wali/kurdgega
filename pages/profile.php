<?php require "./../include/database.php"; session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "./head.php";?>
    <title><?php echo $_SESSION['username']?></title>
    <style>
        @import "./src/css/root.css";
        @import "./src/css/profile.css";
    </style>
</head>
<body>
    <?php
    if(!isset($_SESSION["user_ID"])){
        header("Location: ./../Home");
    }
    ?>
    <?php include "./header.php";?>
    <main>
    <aside data-element="aside" class="d-flex justify-content-center align-items-start">
        <section class='d-flex justify-content-center flex-column w-100'>
            <section class='btn btn-primary d-flex justify-content-between align-items-center' onclick="select(this, 'post')" data-type-for="post"><i class="material-icons">image</i>یادەوەریکان</section>
            <section class='btn btn-secondary d-flex justify-content-between align-items-center' onclick="select(this, 'account')" data-type-for="account"><i class="material-icons">manage_accounts</i>ژمارەی تایبەتی</section>
        </section>
    </aside>
        <section style="height:calc(100vh + 60px);" data-select="post" data-type='selection'>
            <section data-select="post">
                <h1>یادەوەریەکانت</h1>
                <?php $_SESSION["posts"] = "profile"; include "./products.php";?>
            </section>
            <section style="display:none" data-select="account">
                <h1>ژمارەی تایبەتی</h1>
                <?php
                        if(isset($_COOKIE["profileInfo"]) && $_COOKIE["profileInfo"] == "updated"){
                            echo '<section class="text-white bg-success mt-2 p-2 rounded">زانیاریەکانت نوێ کرانەوە!</section>';
                        }
                        ?>
                <form action="include/validator.php" method="POST" class="pe-3" enctype="multipart/form-data">
                    <section class="row g-2">
                        <?php
                        $user = new User();
                        $information = $user->getInformation($_SESSION['username']);
                        echo '
                        <section class="col-6">
                            <label>یەکەمی ناوەکەت</label>
                            <input type="text" name="firstName" class="form-control" value="'.$information[0].'" required/>
                        </section>
                        <section class="col-6">
                            <label>کۆتایی ناوەکەت</label> 
                        <input type="text" name="lastName" class="form-control" value="'.$information[1].'" required/>
                        </section>
                        <section class="col-6">
                            <label>ناوی بەکارهێنان</label>
                            <input type="text" name="userName" class="form-control" value="'.$information[2].'" disabled required/>
                        </section>
                        <section class="col-6">
                            <label>نامەی ئەلیکترۆنی</label>
                            <input type="email" name="email" class="form-control" value="'.$information[3].'" disabled required/>
                        </section>
                        <section class="col-12">
                            <label>ژمارەی موبایل</label>
                            <input type="tel" name="phone" class="form-control
                            ';
                            if(isset($_COOKIE['phonenumber']) && $_COOKIE['phonenumber'] == "exists"){
                                echo " is-invalid ";
                            }
                            echo 'pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" value="'.$information[4].'" required/>
                        <section class="invalid-feedback">ژمارەکە بەردەست نیە</section>
                            </section>
                        <section class="col-6">
                            <label>ڕەگەز</label>
                            <input type="text" name="gender"  class="form-control" value="'.$information[5].'" disabled required/>
                        </section>
                        <section class="col-6">
                            <label title="mm/dd/yyyy">بوون بە ئەندام</label>
                            <input type="date" name="memberSince" class="form-control" value="'.$information[6].'" disabled requried/>
                        </section>
                        <section class="col-4">
                            <label>ناوونیشان</label>
                            <input type="text" name="address" class="form-control" value="'.$information[7].'" required/>
                        </section>
                        <section class="col-4">
                        <label>شار</label>
                        <input type="text" name="city" class="form-control" value="'.$information[8].'" required/>
                        </section>
                        <section class="col-4">
                            <label>پارێزگا</label>
                            <input type="text" name="state"  class="form-control" value="'.$information[9].'" required/>
                        </section>
                        <section class="col-4">
                            <label>وڵات</label>
                            <input type="text" name="country"  class="form-control" value="'.$information[10].'" required/>
                        </section>
                        <section class="col-8">
                            <label title="mm/dd/yyyy">ڕۆژی لە دایک بوون</label>
                            <input type="date" name="dob"  class="form-control" value="'.$information[11].'" disabled required/>
                        </section>
                        <section class="col-12">
                            <label>وێنەی هەژمارەکەت</label>
                            <input accept="image/*" type="file" name="uploadProfile" class="form-control
                        ';
                        if(isset($_COOKIE["image"]) && $_COOKIE["image"] == "false"){
                            echo ' is-invalid ';
                        }
                        echo '"/>
                        <section class="invalid-feedback">
                        بەداخەوە، فاییلەکە قەبارەی گەورەبوو یاخووت نەزانراوبوو!
                        </section>
                        </section>
                        ';
                        ?>
                    </section>
                    <section class="m-2">
                        <button name="updateProfile" class="btn btn-success w-100">نوێ کردنەوە</button>
                    </section>
                </form>
            </section>
        </section>
    </main>
    <script src="./src/script/profile.js"></script>
    <?php include "./mobileFooter.php";?>
</body>
</html>