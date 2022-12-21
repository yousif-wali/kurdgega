<?php
require "database.php";
session_start();
//  Using Ob function to cleanup resources
ob_start();
/*  Checking for Login  */
if(isset($_POST['login'])){
    $login = new Login($_POST['username'], $_POST['password']);
    if($login->login() == "logged in"){
        header("Location: ./../Home");
    }else{
        header("Location: ./Login");
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
        header("Location: ./Signup");
    }else{
        if(!$insert->passwordMatch()){
            header("Location: ./Signup");
        }else{
            $insert->insert();
            mkdir("./../src/images/users/".$_SESSION['username']);
            mkdir("./../src/images/users/".$_SESSION['username']."/profile/");
            mkdir("./../src/images/users/".$_SESSION['username']."/products/");
            if($gender == "male"){
                copy("./../src/images/users/maleProfile.png", "./../src/images/users/".$_SESSION['username']."/profile/profile.png");
              
            }else if ($gender == "female"){
                copy("./../src/images/users/femaleProfile.png", "./../src/images/users/".$_SESSION['username']."/profile/profile.png");
            }else{
                copy("./../src/images/users/maleProfile.png", "./../src/images/users/".$_SESSION['username']."/profile/profile.png");
            }
            header("Location: ./Home");
        }
    }
}
/*  Log out the user */
if(isset($_POST['logout'])){
    session_start();
    session_unset();
    session_destroy();
    header("Location: ./../Home");
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
    if(!file_exists("./../src/images/users/".$_SESSION["username"])){
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
        if($test != "jpg" && $test != "jpeg" && $test != "png" && $test != "gif" && $test != "jfif"){
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
        header("Location: ./../Post");
    }
}
/*    Delete a post */
if(isset($_REQUEST['productDeleteId'])){
    $deletePost = new Products();
    $deletePost->deleteProduct(mysqli_real_escape_string($deletePost->getConnect(), $_REQUEST['productDeleteId']));
}
/*   Like a Post    */
if(isset($_REQUEST['UserLiked']) && isset($_REQUEST["ProductLiked"])){
    $activity = new PostActivity();
    $username = mysqli_real_escape_string($activity->getConnect(), $_REQUEST['UserLiked']);
    $product = mysqli_real_escape_string($activity->getConnect(), $_REQUEST['ProductLiked']);
    $activity->likeProduct($username, $product);
}
/*  Show Likes for a post   */
if(isset($_REQUEST["showLikesFor"])){
    $likes = new PostActivity();
    $id = mysqli_real_escape_string($likes->getConnect(),$_REQUEST["showLikesFor"]);
    echo $likes->updatePostLikes($id);
}
/*  Update User Profile */
if(isset($_POST['updateProfile'])){
    $user = new User();
    $fName = mysqli_real_escape_string($user->getConnect(),$_POST['firstName']);
    $lName = mysqli_real_escape_string($user->getConnect(),$_POST['lastName']);
    $phone = mysqli_real_escape_string($user->getConnect(),$_POST['phone']);
    $address = mysqli_real_escape_string($user->getConnect(),$_POST['address']);
    $city = mysqli_real_escape_string($user->getConnect(),$_POST['city']);
    $state = mysqli_real_escape_string($user->getConnect(),$_POST['state']);
    $country = mysqli_real_escape_string($user->getConnect(),$_POST['country']);

    $file_name = $_FILES["uploadProfile"]["name"];
    $file_tmp = $_FILES['uploadProfile']["tmp_name"];
    $fileSize = $_FILES["uploadProfile"]["size"];
    $extension = strtolower(pathinfo($file_name,PATHINFO_EXTENSION)); 
    if($extension != "jpg" && $extension != "jpeg" && $extension != "png" && $extension != "gif" && $extension != "jfif" && $file_name != null && $fileSize <= 2000000 ){
        setcookie("image", "false", time()+ 15, "/");
        header("Location: ./../Profile");
    }else{
        $fileNull = $file_name == null ? null : $file_name;
        $user->updateProfile($_SESSION['username'], $fName, $lName, $phone, $address, $city, $state, $country);
        if($fileNull != null){
            if(!file_exists("./../src/images/users/".$_SESSION["username"]."/profile/")){
                mkdir("./../src/images/users/".$_SESSION["username"]."/profile/");
            }
            rename($file_tmp,"./../src/images/users/".$_SESSION["username"]."/profile/profile.png");
        }
        setcookie("profileInfo", "updated", time()+ 15, "/");
        header("Location: ./../Profile");
    }

}
/*  SetCookie For Profile   */
if(isset($_GET['profileSelected'])){
    $chosen = $_GET['profileSelected'];
    setcookie("profileSelected", $chosen , time() + 3600, "/");
}
//***********************************************
// Sending a Message from KurdMessenger
if(isset($_REQUEST["sendingMessage"])){
    $status = array("status"=>"sent");
    $chat = new Chats();
    $message = mysqli_real_escape_string($chat->getConnect(), $_REQUEST["sendingMessage"]);
    $chat->sendChat($_SESSION['username'],$_SESSION['sendMessageTo'], $message);
    echo json_encode($status);
}
//  Retrieve Messages
if(isset($_REQUEST['retrieveMessages'])){
    $message = new Chats();
    $list = $message->retrieveMessages($_SESSION['username']);
    $result = array();
    $i = 0;
    foreach($list as $m){
        $result[$i] = array("chatFrom"=>$m[0], "chatTo"=>$m[1], "time"=>$m[2], "status"=>$m[3], "message"=>$m[4], "images"=>$m[5]);
        $i++;
    }
    echo json_encode($result);
}
//  chatHistory
if(isset($_REQUEST['chatHistory'])){
    $message = new Chats();
    $list = $message->chatHistory($_SESSION['username']);
    $result = array();
    $i = 0;
    foreach($list as $m){
        $result[$i] = array("chatFrom"=>$m[0], "time"=>$m[1], "message"=>$m[2], "username"=>$m[3]);
        $i++;
    }
    echo json_encode($result);
}
//  Change Profile chat
if(isset($_REQUEST['changeProfile'])){
    $_SESSION['sendMessageTo'] = $_REQUEST['changeProfile'];
    header("Location: ./../KurdMessenger");
}
//  Send Comments
if(isset($_REQUEST['sendComment'])){
    $comment = new PostActivity();
    $msg = mysqli_real_escape_string($comment->getConnect(),$_REQUEST['sendComment']);
    $postId = mysqli_real_escape_string($comment->getConnect(),$_REQUEST['postId']);
    if($msg != ' ' and $msg != ''){
        $comment->sendComment($_SESSION['username'], $postId, $msg);
    }
}
//  Show Comment Numbers
if(isset($_REQUEST['showCommentNumber'])){
    $total = new PostActivity();
    $number = mysqli_real_escape_string($total->getConnect(), $_REQUEST['showCommentNumber']);
    $result = array("total"=>$total->getCommentNumbers($number));
    echo json_encode($result);
}
//  Show Comments
if(isset($_REQUEST['showComments'])){
    $comments = new PostActivity();
    $postId = mysqli_real_escape_string($comments->getConnect(), $_REQUEST['showComments']);
    $items = $comments->showComments($postId);
    $result = array();
    $c = 0;
    foreach($items as $item){
        $result[$c] = array("username"=>$item[0], "comment"=>$item[1], "time"=>$item[2]);
        $c++;
    }
    echo json_encode($result);
}
ob_flush();
?>