<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        @import "./../src/css/login.css";
    </style>
</head>
<body>
    <form action="./../include/validator.php" method="POST">
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
</body>
</html>