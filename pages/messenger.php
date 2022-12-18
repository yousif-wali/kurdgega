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
            <section class="profile">
                <img src="#"/>
                <span>Name</span>
            </section>
        </aside>
        <main>
            <section class="chats">
                <section class="from border">
                    <section>
                        <img src="#"/>
                    </section>
                    <section>
                        Hello, How are you doing?
                    </section>
                </section>
                <section class="from border">
                    <section>
                        <img src="#"/>
                    </section>
                    <section>
                        Hello, How are you doing?
                    </section>
                </section>
                <section class="to border">
                    <section>
                        Hello, How are you doing?
                    </section>
                </section>
                <section class="from border">
                    <section>
                        <img src="#"/>
                    </section>
                    <section>
                        Hello, How are you doing?
                    </section>
                </section>
            </section>
            <section class="msg">
                <form>
                    <input type="text" /><button class="btn btn-success">Send<i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                </form>
            </section>
        </main>
    </section>
</body>
</html>