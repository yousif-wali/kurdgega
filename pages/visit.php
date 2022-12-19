<?php 
session_start();
require "./../include/database.php";
if(!isset($_REQUEST['user'])){
    header("Location: ./Home");
}
$_SESSION['visit'] = $_REQUEST['user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "./head.php";?>
    <title>Kurdgega - <?php echo $_REQUEST['user'];?></title>
    <style>
        @import "./src/css/root.css";
        main{
            margin-top:60px;
        }
        @media screen and (max-width:36em){
            [data-type="posts"]{
                width:80%!important;
            }
        }
    </style>
</head>
<body>
    <?php include_once "./header.php";?>
    <main>
       <?php 
       echo "<script>var visiting = '".$_REQUEST['user']."'</script>";
       ?>
        <button class="btn btn-success" onclick="window.location = './include/validator.php?changeProfile='+visiting">Send Message</button>
        <section data-type="posts" style="width:40%; margin:0 auto;">
            <?php $_SESSION['posts'] = "visit"; include "./products.php";?>
        </section>
    </main>
</body>
</html>