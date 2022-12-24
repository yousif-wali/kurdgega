<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign up</title>
    <?php include "./head.php";?>
    <style>
        @import "./src/css/root.css";
    </style>
</head>
<body>
    <?php include "./header.php";?>
    <main style="margin-top:60px;">
    <form action="Checking" method="POST">
        <section>
            <input type="text" name="firstName" required/>
            <label>ناوی یەکەم</label>
        </section>
        <section>
            <input type="text" name="lastName" required/>
            <label>ناوی کۆتا</label>
        </section>
        <section>
            <input type="text" name="username" required/>
            <label>ناوی بەکارهێنان</label>
        </section>
        <section>
            <input type="email" name="email" required/>
            <label>بەریدی ئەلیکترۆنی</label>
        </section>
        <section>
            <input type="password" name="password" required/>
            <label>ووشەی نهێنی</label>
        </section>
        <section>
            <input type="password" name="confirm_password" required/>
            <label>ووشەی نهێنی دووبارەکەرەوە</label>
        </section>
        <section>
            <input type="date" name="dob" required/>
            <label>ڕۆژی لەدایک بوون</label>
        </section>
        <section>
            <input type="phone" name="phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required/>
            <label>ژمارە</label>
        </section>
        <section>
            <select name="gender">
                <option value="نێر">نێر</option>
                <option value="مێ">مێ</option>
                <option value="هیتر">هیتر</option>
            </select>
        </section>
        <section>
            <input type="text" name="address" required/>
            <label>ناوونیشان</label>
        </section>
        <section>
            <input type="text" name="city" required/>
            <label>شار</label>
        </section>
        <section>
            <input type="text" name="state" required/>
            <label>پارێزگا</label>
        </section>
        <section>
            <input type="text" name="country" required/>
            <label>وڵات</label>
        </section>
        <section>
            <input type="submit" name="signup" value="Signup"/>
        </section>
    </form>
    </main>
    <?php include "./mobileFooter.php";?>
</body>
</html>