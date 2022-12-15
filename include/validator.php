<?php
require "database.php";
session_start();
//  Using Ob function to cleanup resources
ob_start();
/*  Checking for Login  */
if(isset($_POST['login'])){
    $login = new Login($_POST['username'], $_POST['password']);
    if($login->login() == "logged in"){
        header("Location: ./../index.php");
    }else{
        header("Location: ./../pages/login.php?err");
    }
}
/*  Sign up a user */
if(isset($_POST['signup'])){
    $fName = $_POST['firstName'];
    $lname = $_POST['lastName'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['confirm_password'];
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $country = $_POST['country'];
    $gender = $_POST['gender'];
    $insert = new SignUp($fName, $lname, $username, $email, $password, $cpassword, $dob, $phone, $address, $city, $state, $country, $gender);
    if($insert->checkUserExist()){
        header("Location: ./../pages/signup.php?username=exists");
    }else{
        if(!$insert->passwordMatch()){
            header("Location: ./../pages/signup.php?password=doesnotmatch");
        }else{
            $insert->insert();
            header("Location: ./../index.php");
        }
    }
}
/*  Log out the user */
if(isset($_POST['logout'])){
    session_start();
    session_unset();
    session_destroy();
    header("Location: ./../index.php");
}
/*    Post Product  */
if(isset($_POST['postProduct'])){
    $imageArray = "";
    $imageNames = $_FILES["image"]["name"];

    $extensions = [];
    $upload = 1;
    $c = 0;
    foreach($imageNames as $test){
        $imageArray .= $test.",";
        $extensions[$c] = strtolower(pathinfo($test,PATHINFO_EXTENSION)); 
        $c++;  
    }
    if(!file_exists("./../src/images/users/".$_SESSION["username"]."/products/")){
        mkdir("./../src/images/users/".$_SESSION["username"]."/products/");
    }
    $imageTmps = $_FILES['image']["tmp_name"];
    $imageSizes = $_FILES["image"]["size"];
    foreach($imageSizes as $size){
        if($size > 2000000){
            $upload = 0;
        }
    }
    foreach($extensions as $test){
        if($test != "jpg" && $test != "jpeg" && $test != "png" && $test != "gif" ){
            $upload = 0;
        }
    }
    echo $upload;
    if($upload == 1){
        $newProduct = new Products();
        $title = mysqli_real_escape_string($newProduct->getConnect(), $_POST['title']);
        $desc = mysqli_real_escape_string($newProduct->getConnect(), $_POST['desc']);
        $price = mysqli_real_escape_string($newProduct->getConnect(), $_POST['price']);
        $category = mysqli_real_escape_string($newProduct->getConnect(), $_POST['category']);
        $model = mysqli_real_escape_string($newProduct->getConnect(), $_POST['model']);
        $year = mysqli_real_escape_string($newProduct->getConnect(), $_POST['year']);
        $condition = mysqli_real_escape_string($newProduct->getConnect(), $_POST['condition']);
        $newProduct->post($_SESSION['user_ID'], $title, $desc, $price, $imageArray, $category, $model, $year, $condition);
        $c = 0;
        foreach($imageTmps as $test){
            copy($test, "./../src/images/users/".$_SESSION["username"]."/products/".$imageNames[$c]);
            $c++;
        }
        setcookie("productpost", true, time()+15, "/");
        header("Location: ./../pages/post.php");
    }
}
ob_flush();
?>