<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
</head>
<body>
    <form action="./../include/validator.php" method="POST">
        <section>
            <input type="text" name="firstName" required/>
            <label>First Name</label>
        </section>
        <section>
            <input type="text" name="lastName" required/>
            <label>Last Name</label>
        </section>
        <section>
            <input type="text" name="username" required/>
            <label>Username</label>
        </section>
        <section>
            <input type="email" name="email" required/>
            <label>Email</label>
        </section>
        <section>
            <input type="password" name="password" required/>
            <label>Password</label>
        </section>
        <section>
            <input type="password" name="confirm_password" required/>
            <label>Confirm Password</label>
        </section>
        <section>
            <input type="date" name="dob" required/>
            <label>Date of Birth</label>
        </section>
        <section>
            <input type="phone" name="phone" required/>
            <label>Phone</label>
        </section>
        <section>
            <select name="gender">
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
        </section>
        <section>
            <input type="text" name="address" required/>
            <label>Address</label>
        </section>
        <section>
            <input type="text" name="city" required/>
            <label>City</label>
        </section>
        <section>
            <input type="text" name="state" required/>
            <label>State</label>
        </section>
        <section>
            <input type="text" name="country" required/>
            <label>Country</label>
        </section>
        <section>
            <input type="submit" name="signup" value="Signup"/>
        </section>
    </form>
</body>
</html>