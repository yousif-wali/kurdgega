<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "./head.php"; session_start(); require "./../include/database.php";?>
    <title>KurdMessenger - <?php echo $_SESSION["username"];?></title>
    <style>
        @import "./src/css/root.css";
        @import "./src/css/messenger.css";
    </style>
</head>
<body>
    <?php include "./header.php";?>
    <section data-role="layout" style="margin-top:60px;">
        <aside class="messenger">
            <section class="profile" id="chatHistory">
            </section>
        </aside>
        <main class="position-relative d-flex flex-column pb-0 pe-0 justify-content-between" id="messengerMain">
            <button class="material-icons btn btn-success" id="gobackMessenger" style="position:fixed; top:3em; left:1em; display:none; z-index:6" onclick="changeBackground()">reply</button>
            <section class="chats d-flex flex-column justify-content-end" id="chats">                
            </section>
            <section class="msg">
                <section data-type="form">
                    <input type="text" data-role="sending" style="font-weight:normal" /><button class="btn btn-success" onclick="sendMessage()">Send<i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                </section>
            </section>
        </main>
    </section>
    <?php
    $mesg = isset($_SESSION['sendMessageTo'])?$_SESSION['sendMessageTo']:"";
    echo '<script>const userLoggedin = "'.$_SESSION['username'].'"; let messageTo = "'.$mesg.'"</script>';
    ?>
    <script src="./src/script/messenger.js">
    </script>
 <?php include "./mobileFooter.php";?>
</body>
</html>