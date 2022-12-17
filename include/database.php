 <?php
 // Creating Connection to kurdgega Database
class DB{
    private $connect;
    protected function connect(){
        $this->connect = mysqli_connect("localhost", "root", "", "kurdgega");
    }
    public function getConnect(){
        return $this->connect;
    }
    public function __construct(){
        $this->connect();
    }
    public function __destruct(){
        mysqli_close($this->connect);
    }
    public function hash($text){
        $opts03 = [ "cost" => 15 ];
        return password_hash($text, PASSWORD_BCRYPT, $opts03);
    }
}
/*  Creating Login Class*/
class Login extends DB{
    private $name;
    private $pwd;
    public function __construct($_name, $_pwd){
        $this->connect();
        $this->name = mysqli_real_escape_string($this->getConnect(), $_name);
        $this->pwd = mysqli_real_escape_string($this->getConnect(), $_pwd);
    }
    public function login(){
        $this->connect();
        $result =mysqli_query($this->getConnect(), "SELECT * from shoppers where email = '$this->name' OR username = '$this->name' OR phone = '$this->name' ");
        $possiblePwd = mysqli_fetch_assoc($result)["pwd"];
        if(password_verify($this->pwd, $possiblePwd)){
            session_start();
            $tar =mysqli_query($this->getConnect(), "SELECT * from shoppers where email = '$this->name' OR username = '$this->name' OR phone = '$this->name' ");
            while($row = mysqli_fetch_assoc($tar)){
                $_SESSION['user_ID'] = $row['User_ID'];
                $_SESSION["username"] = $row["username"];
                $_SESSION['admin'] = $row["admin"];
            }
            $username = $_SESSION['username'];
            mysqli_query($this->getConnect(), "UPDATE shoppers SET lastLogin = CURRENT_TIMESTAMP() WHERE username = '$username'");
            return "logged in";
        }else{
            return "not logged in";
        }
    }
}
/*  Signup a User */
class SignUp extends DB{
    private $fName;
    private $lName;
    private $username;
    private $email;
    private $pwd;
    private $cpwd;
    private $dob;
    private $phone;
    private $address;
    private $city;
    private $state;
    private $country;
    private $gender;
    public function __construct($fname, $lname, $uname, $email, $p, $cp, $dob, $phon, $addre, $cit, $stat, $country, $gender){
       $this->connect();
        $this->fName = mysqli_real_escape_string($this->getConnect(), $fname);
        $this->lName = mysqli_real_escape_string($this->getConnect(), $lname);
        $this->username = mysqli_real_escape_string($this->getConnect(), $uname);
        $this->email = mysqli_real_escape_string($this->getConnect(), $email);
        $this->pwd = mysqli_real_escape_string($this->getConnect(), $p);
        $this->cpwd = mysqli_real_escape_string($this->getConnect(), $cp);
        $this->dob = mysqli_real_escape_string($this->getConnect(), $dob);
        $this->phone = mysqli_real_escape_string($this->getConnect(), $phon);
        $this->address = mysqli_real_escape_string($this->getConnect(), $addre);
        $this->city = mysqli_real_escape_string($this->getConnect(), $cit);
        $this->state = mysqli_real_escape_string($this->getConnect(), $stat);
        $this->country = mysqli_real_escape_string($this->getConnect(), $country);
        $this->gender = mysqli_real_escape_string($this->getConnect(), $gender);
    }
    public function checkUserExist(){
        $this->connect();
        $exist = mysqli_num_rows(mysqli_query($this->getConnect(), "SELECT * FROM shoppers WHERE username = '$this->username' OR email = '$this->email' OR phone = '$this->phone'"));
        if($exist > 0){
            return true;
        }else{
            return false;
        }
    }
    public function passwordMatch(){
        if($this->pwd == $this->cpwd){
            return true;
        }else{
            return false;
        }
    }
    public function getHighestId(){
        $this->connect();
        $query = mysqli_query($this->getConnect(), "SELECT max(User_ID) + 1 as newUser FROM shoppers;");
        $max = mysqli_fetch_assoc($query)['newUser'];
        return $max;
    }
    public function insert(){
        $this->connect();
        $hashed = $this->hash($this->pwd);
        $id = $this->getHighestId();
        $ip = $_SERVER['REMOTE_ADDR'];
        if(!isset($_SESSION['username'])){
            session_start();
            $_SESSION['username'] = $this->username;
        }
        mysqli_query($this->getConnect(), "INSERT INTO shoppers (User_ID,fName, lName, username, email, pwd, phone, address, city, state, dob, country, gender, ip, signedup) values ('$id', '$this->fName', '$this->lName', '$this->username', '$this->email', '$hashed', '$this->phone', '$this->address', '$this->city', '$this->state', '$this->dob', '$this->country', '$this->gender', '$ip', 'CURRENT_DATE()')");
    }
}
/*  Create a post */
class Products extends DB{
    public function getHighestId(){
        $this->connect();
        return mysqli_fetch_assoc(mysqli_query($this->getConnect(), "SELECT max(Product_ID) + 1 as id FROM products;"))["id"];
    }
    public function post($user_id, $title, $desc, $price, $images, $category, $model, $year, $condition){
        $id = $this->getHighestId();
        mysqli_query($this->getConnect(), "INSERT INTO products (Product_ID, User_ID, title, description, price, images, category, model, year, conditions) VALUES ('$id', '$user_id', '$title', '$desc', '$price', '$images', '$category', '$model', '$year', '$condition')");
    }
    public function showProductsProfile($userid){
        $this->connect();
        $list = [];
        $i = 0;
        $query = mysqli_query($this->getConnect(), "SELECT * FROM products WHERE User_ID = '$userid'");
        while($row = mysqli_fetch_assoc($query)){
            $id = $row["User_ID"];
            $username = mysqli_fetch_assoc(mysqli_query($this->getConnect(),"SELECT username from shoppers WHERE User_ID = '$id'"))["username"];
            $list[$i] = [$row["Product_ID"], $username, $row["title"],$row['description'], $row["price"], $row["images"], $row["publishedDate"], $row["views"], $row["category"], $row["model"], $row["year"], $row["conditions"]];
            $i++;
        }
        return $list;
    }
    public function showProducts(){
        $this->connect();
        $list = [];
        $i = 0;
        $query = mysqli_query($this->getConnect(), "SELECT * FROM products");
        while($row = mysqli_fetch_assoc($query)){
            $id = $row["User_ID"];
            $username = mysqli_fetch_assoc(mysqli_query($this->getConnect(),"SELECT username from shoppers WHERE User_ID = '$id'"))["username"];
            $list[$i] = [$row["Product_ID"], $username, $row["title"],$row['description'], $row["price"], $row["images"], $row["publishedDate"], $row["views"], $row["category"], $row["model"], $row["year"], $row["conditions"]];
            $i++;
        }
        return $list;
    }
    public function deleteProduct($id){
        mysqli_query($this->getConnect(),"DELETE FROM products where Product_Id = '$id'");
    }
}
/*  Post Activity   */
class PostActivity extends DB{
    public function getHighestId(){
        $this->connect();
        $id = mysqli_fetch_assoc(mysqli_query($this->getConnect(), "SELECT max(PostID) + 1 as id FROM postactivity;"))["id"];
        if($id == 0){
            return 1;
        }else{
            return $id;
        }
    }
    public function likeProduct($username, $product_id){
        $id = $this->getHighestId();
        $likeExists = mysqli_query($this->getConnect(), "SELECT likes FROM postactivity WHERE Product_ID = '$product_id' AND username = '$username'");
        
        if(mysqli_num_rows($likeExists) > 0){
            mysqli_query($this->getConnect(),"UPDATE postactivity SET likes = 0 WHERE username='$username' AND Product_ID = '$product_id'");
        }
        else{
            mysqli_query($this->getConnect(),"INSERT INTO postactivity (PostID, Product_ID, username, likes) VALUES ('$id', '$product_id', '$username', 1)");
        }
        if (mysqli_fetch_assoc($likeExists)["likes"] == 0){
            mysqli_query($this->getConnect(),"UPDATE postactivity SET likes = 1 WHERE username='$username' AND Product_ID = '$product_id'");
        }
    }
    public function updatePostLikes($id){
        return mysqli_fetch_assoc(mysqli_query($this->getConnect(), "SELECT count(likes) as total FROM postactivity WHERE Product_ID = '$id' AND likes = 1"))["total"];
    }
    public function isUserLiked($username, $product_id){
        $query  =mysqli_query($this->getConnect(), "SELECT likes from postactivity WHERE username = '$username' AND Product_ID='$product_id' AND likes = 1"); 
        if($username != null && $product_id != null && mysqli_num_rows($query) > 0){
            return mysqli_fetch_assoc($query)["likes"];
        }else{
            return 0;
        }
    }
}
/*   USERS          */
class User extends DB{
    public function getInformation($username){
        $this->connect();
        $list = [];
        $query = mysqli_query($this->getConnect(), "SELECT * FROM shoppers WHERE username = '$username'");
        while($row = mysqli_fetch_assoc($query)){
            $list = [$row["fName"], $row["lName"], $row["username"], $row["email"], $row['phone'], $row["gender"], $row['signedup'], $row['address'], $row['city'], $row['state'], $row['country'], $row['dob']];
        }
        return $list;
    }
    public function updateProfile($username, $fName, $lName, $phone, $address, $city, $state, $country, $photo){
        if($photo == null){
            mysqli_query($this->getConnect(), "UPDATE shoppers SET fName = '$fName', lName = '$lName', phone = '$phone', address = '$address', city = '$city', state = '$state', country = '$country'  WHERE username='$username'");
        }else{
            mysqli_query($this->getConnect(), "UPDATE shopper SET fName = '$fName', lName = '$lName', phone = '$phone', address = '$address', city = '$city', state = '$state', country = '$country', profile = '$photo'  WHERE username='$username'");
        }
    }
}