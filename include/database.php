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
        if($max == 0){
            $max++;
        }
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
            $_SESSION['user_ID'] = $id;
            $_SESSION['gender'] = $this->gender;
        }
        mysqli_query($this->getConnect(), "INSERT INTO shoppers (User_ID,fName, lName, username, email, pwd, phone, address, city, state, dob, country, gender, ip, profile) values ('$id', '$this->fName', '$this->lName', '$this->username', '$this->email', '$hashed', '$this->phone', '$this->address', '$this->city', '$this->state', '$this->dob', '$this->country', '$this->gender', '$ip', 'profile.png')");
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
    public function showProductsProfile($username){
        $this->connect();
        $list = [];
        $i = 0;
        $userid = mysqli_fetch_assoc(mysqli_query($this->getConnect(), "SELECT * FROM shoppers WHERE username = '$username'"))["User_ID"];
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
        $query = mysqli_query($this->getConnect(), "SELECT * FROM products order by publishedDate desc");
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
    public function addViews($username){
        $getUserID = mysqli_fetch_assoc(mysqli_query($this->getConnect(),"SELECT User_ID FROM shoppers WHERE username = '$username'"))["User_ID"];
        $query = mysqli_query($this->getConnect(),"SELECT * from products where User_ID = '$getUserID'");
        while($row = mysqli_fetch_assoc($query)){
            $view = $row["views"];
            $product_id = $row["Product_ID"];
            mysqli_query($this->getConnect(),"UPDATE products SET views = '$view' + 1 WHERE Product_ID = '$product_id'");
        }
    }
    public function Filter($category, $model){
        $category = mysqli_real_escape_string($this->getConnect(),$category);
        $model = mysqli_real_escape_string($this->getConnect(), $model);
        $list = [];
        $i = 0;
        $query = mysqli_query($this->getConnect(), "SELECT * FROM products WHERE category = '$category' AND model = '$model' order by publishedDate desc");
        while($row = mysqli_fetch_assoc($query)){
            $id = $row["User_ID"];
            $username = mysqli_fetch_assoc(mysqli_query($this->getConnect(),"SELECT username from shoppers WHERE User_ID = '$id'"))["username"];
            $list[$i] = [$row["Product_ID"], $username, $row["title"],$row['description'], $row["price"], $row["images"], $row["publishedDate"], $row["views"], $row["category"], $row["model"], $row["year"], $row["conditions"]];
            $i++;
        }
        return $list;
    }
    public function addViewsToFilteredProduct($product_id){
        $query = mysqli_query($this->getConnect(),"SELECT * from products where Product_id = '$product_id'");
        while($row = mysqli_fetch_assoc($query)){
            $view = $row["views"];
            $product_id = $row["Product_ID"];
            mysqli_query($this->getConnect(),"UPDATE products SET views = '$view' + 1 WHERE Product_ID = '$product_id'");
        }
    }
    public function Search($search){
        $list = [];
        $i = 0;
        $query = mysqli_query($this->getConnect(), "SELECT * FROM products WHERE title like '%$search%' or category like '%$search%' or model like '%$search%' or price like '%$search%' or conditions like '%$search%' or year like '%$search%' order by publishedDate desc ");
        while($row = mysqli_fetch_assoc($query)){
            $id = $row["User_ID"];
            $username = mysqli_fetch_assoc(mysqli_query($this->getConnect(),"SELECT username from shoppers WHERE User_ID = '$id'"))["username"];
            $list[$i] = [$row["Product_ID"], $username, $row["title"],$row['description'], $row["price"], $row["images"], $row["publishedDate"], $row["views"], $row["category"], $row["model"], $row["year"], $row["conditions"]];
            $i++;
        }
        return $list;
    }
}
/*  Post Activity   */
class PostActivity extends DB{
    public function likeProduct($username, $product_id){
        $likeExists = mysqli_query($this->getConnect(), "SELECT likes FROM postactivity WHERE Product_ID = '$product_id' AND username = '$username' AND comment = '' and share = 0");
        
        if(mysqli_num_rows($likeExists) > 0){
            mysqli_query($this->getConnect(),"UPDATE postactivity SET likes = 0 WHERE username='$username' AND Product_ID = '$product_id' and comment = '' and share = 0");
        }
        else{
            mysqli_query($this->getConnect(),"INSERT INTO postactivity (Product_ID, username, likes) VALUES ('$product_id', '$username', 1)");
        }
        if (mysqli_fetch_assoc($likeExists)["likes"] == 0){
            mysqli_query($this->getConnect(),"UPDATE postactivity SET likes = 1 WHERE username='$username' AND Product_ID = '$product_id' and comment = '' and share = 0");
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
    public function sendComment($username, $product_id, $msg){
        mysqli_query($this->getConnect(), "INSERT INTO postactivity (username, Product_ID, comment) VALUES ('$username', '$product_id', '$msg')");
    }
    public function getCommentNumbers($post){
        return mysqli_num_rows(mysqli_query($this->getConnect(), "SELECT comment FROM postactivity WHERE Product_ID = '$post' AND comment is not null and likes = 0"));
    }
    public function showComments($post){
        $list = [];
        $query = mysqli_query($this->getConnect(), "SELECT username, comment, commentDate from postactivity WHERE Product_ID = '$post' and likes = 0 order by commentDate asc");
        $i = 0;
        while($row = mysqli_fetch_array($query)){
            $user = $row['username'];
            $names = mysqli_fetch_assoc(mysqli_query($this->getConnect(), "SELECT concat(fName, ' ',lName) as fullname from shoppers WHERE username = '$user'"))["fullname"];
            $list[$i] = [$names, $row["comment"], $row["commentDate"]];
            $i++;
        }
        return $list;
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
    public function updateProfile($username, $fName, $lName, $phone, $address, $city, $state, $country){   
    mysqli_query($this->getConnect(), "UPDATE shoppers SET fName = '$fName', lName = '$lName', phone = '$phone', address = '$address', city = '$city', state = '$state', country = '$country', profile = 'profile.png'  WHERE username='$username'");      
    }
    public function searchUser($search){
        $list = [];
        $query = mysqli_query($this->getConnect(), "SELECT * FROM shoppers WHERE username = '$search' or fName like '%$search%' or lName like '%$search%' ");
        $i = 0;
        while($row = mysqli_fetch_assoc($query)){
            $fullname = $row["fName"]." ".$row["lName"];
            $list[$i] = [$fullname, $row["username"]];
            $i++;
        }
        return $list;
    }
}
/*   Chats */
class Chats extends DB{
    public function sendChat($fromUser, $toUsername, $message){
        mysqli_query($this->getConnect(), "INSERT INTO chats (chatFrom, chatTo, messages) VALUES ('$fromUser','$toUsername', '$message')");
    }
    public function retrieveMessages($username){
        $list = [];
        $i = 0;
        $messages = mysqli_query($this->getConnect(), "SELECT * FROM chats WHERE chatFrom = '$username' OR chatTo = '$username' Order By chatSent ASC");
        while($row = mysqli_fetch_assoc($messages)){
            $list[$i] = [$row["chatFrom"], $row["chatTo"], $row["chatSent"], $row["chatStatus"], $row["messages"], $row["images"]];
            $i++;
        }
        return $list;
    }
    public function chatHistory($username){
        $list = [];
        $query = mysqli_query($this->getConnect(), "SELECT DISTINCT chatFrom FROM chats WHERE chatTo = '$username'");
        $i = 0;
        while($row = mysqli_fetch_assoc($query)){
            $usernames = $row['chatFrom'];
            $details = mysqli_fetch_assoc(mysqli_query($this->getConnect(), "SELECT max(chatSent) as chatSent, messages From chats where (chatFrom = '$usernames' and chatTo = '$username') OR (chatFrom = '$username' and chatTo = '$usernames')"));
            $names = mysqli_fetch_assoc(mysqli_query($this->getConnect(), "SELECT concat(fName, ' ',lName) as fullname from shoppers WHERE username = '$usernames'"))["fullname"];
            $time = $details["chatSent"];
            //$latestMessage = mysqli_fetch_assoc(mysqli_query($this->getConnect(), "SELECT max(chatSent) as chatSent FROM chats WHERE chatFrom = '$username' "))["chatSent"];
            $list[$i] = [$names, $time, $details["messages"], $usernames];
            $i++;
        }
        return $list;
    }
}