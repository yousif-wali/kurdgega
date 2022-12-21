<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "./head.php";?>
    <title>Login</title>
    <style>
        @import "./src/css/login.css";
        @import "./src/css/root.css";
    </style>
</head>
<body>
    <?php include "./header.php";?>
    <main style="margin-top:60px;">
        <form action="./include/validator.php" method="POST">
            <section>
                <input type="text" name="username" required>
            <label>Username/Email/Phone</label>
        </section>
        <section>
            <input type="password" name="password" required>
            <label>Password</label>
        </section>
        <section>
            <input type="submit" value="Login" name="login"/>
        </section>
    </form>
</main>
</body>
</html>