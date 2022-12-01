 <?php
 // Creating Connection to kurdgega Database
class DB{
    private $connect;
    protected function connect(){
        $this->connect = mysqli_connect("localhost", "root", "", "kurdgega");
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
/*  Creating a bridge to some queries in the Database */
class Shoppers extends DB{
    public function insert($fName, $lName, $username, $email, $pwd, $dob, $phone, $gender, $address){
        try{
        $ip = $_SERVER['REMOTE_ADDR'];
        mysqli_query($this->connect(), "INSERT INTO shoppers (fName, lName, username, email, pwd, dob, ip, phone, gender, address, lasLogin) values 
        ('$fName', '$lName', '$username', '$email', '$pwd' ,'$dob', '$ip', '$phone', '$gender', '$address', 'NOW()')");
        return "signed up";
        }catch(Exception $e){
            return "not signed up";
        }
    }
    public function deleteUser($username){
        mysqli_query($this->connect, "DELETE FROM shoppers WHERE username = '$username'");
    }
    public function updatePassword($username, $pwd){
        mysqli_query($this->connect, "UPDATE shopper SET pwd = '$pwd' WHERE username = '$username'");
    }
    public function promote($username){
        mysqli_query($this->connect, "UPDATE shopper SET isAdmin = 1 WHERE username = '$username'");
    }
    public function demote($username){
        mysqli_query($this->connect, "UPDATE shopper SET isAdmin = 0 WHERE username = '$username'");
    }
    public function updatePhone($username, $phone){
        mysqli_query($this->connect, "UPDATE shopper SET phone = '$phone' WHERE username = '$username'");
    }
    public function updateAddress($username, $address){
        mysqli_query($this->connect, "UPDATE shopper SET address = '$address' WHERE username = '$username'");
    }
}
/*  Creating Login Class*/
class Login extends DB{
    public function __construct($cred, $pwd){
        $result =mysqli_query($this->connect, "select * from shoppers where email = '$cred' OR username = '$cred' OR phone = '$cred' ");
        $possiblePwd = mysqli_fetch_assoc($result)["pwd"];
        if(password_verify($pwd, $possiblePwd)){
            session_start();
            while($row = mysqli_fetch_assoc($result)){
                $_SESSION['username'] = $row["username"];
            }
            return "logged in";
        }else{
            return "not logged in";
        }
    }
}