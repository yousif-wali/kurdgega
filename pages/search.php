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
    <section class="posts container pb-3" style="width:40%">
        <section>Users <section id='noUsers' style='display:none;'>Sorry... No users found</section><hr/></section>
        <?php 
        $users = new User();
        $items = $users->searchUser(mysqli_real_escape_string($users->getConnect(), $_REQUEST['search']));
        foreach($items as $item){
            $name = $item[0];
            $username = $item[1];
            echo '
            <section class="row gx-2 justify-content-start align-items-center border" style="height:60px; cursor:pointer;" data-type="user" onclick="window.location = `./User/`+`'.$username.'`">

                <section class="col-4" style="height:100%; max-width:60px">
                        <img src="./src/images/users/'.$username.'/profile/profile.png" style="height:100%; "/>
                </section>
                <section class="col-8 text-end">
                        <section>
                                '.$name.'
                        </section>
                        <section>
                            '.$username.'
                        </section>    
            </section>
            </section>
            ';
        }
        if(count($items) == 0){
            echo '<script>document.getElementById("noUsers").style.display = "block";</script>';
        }
        ?>
    </section>
    <section class="posts container" style="width:40%">
        <?php include "./products.php";?>
    </section>
    </main>
    <script>
        let products = document.querySelector("[data-type='productNotFound']");
        let user = document.querySelector('[data-type="user"]');
        if(products != null && user != null){
            products.style.display = "none";
        }
    </script>
     <?php include "./mobileFooter.php";?>
</body>
</html>