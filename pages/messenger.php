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
        <aside class="border">
            <section class="profile" id="chatHistory">
            </section>
        </aside>
        <main>
            <section class="chats" id="chats">                
            </section>
            <section class="msg">
                <section data-type="form">
                    <input type="text" data-role="sending" /><button class="btn btn-success" onclick="sendMessage()">Send<i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                </section>
            </section>
        </main>
    </section>
    <?php
    echo '<script>const userLoggedin = "'.$_SESSION['username'].'"; let messageTo = "'.$_SESSION['sendMessageTo'].'"</script>';
    ?>
    <script src="./src/script/messenger.js">
    </script>
</body>
</html>