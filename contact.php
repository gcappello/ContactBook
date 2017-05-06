<?php
class Contact {
    // data variables
    public $firstname;
    public $lastname;
    public $address;
    public $email;
    public $phone;
    
    // database variables
    public $servername;
    public $username;
    public $password;
    public $dbname;
    
    // set variables for the connection to the database
    public function setConnection($servername = "localhost", $username = "username", $password = "password", $dbname = "database"){
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
    }
    
    // save record into contact table
    public function save($firstname, $lastname, $address = "", $email, $phone = ""){
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->address = $address;
        $this->email = $email;
        $this->phone = $phone;
        
        // Create connection
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        // prepare and bind
        $stmt = $conn->prepare("INSERT INTO contact (firstname, lastname, address, email, phone) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $this->firstname, $this->lastname, $this->address, $this->email, $this->phone);
        $stmt->execute();
        $stmt->close();
        $conn->close();
        header('Location: done.php');
        exit();
    }
    
    // parsing XML document
    public function readXML($xml){
        if (empty($xml->firstname) || !preg_match("/^[a-zA-Z ]*$/",$xml->firstname)){
            echo "First Name not valid";
        } else if (empty($xml->lastname) || !preg_match("/^[a-zA-Z ]*$/",$xml->lastname)) {
            echo "Lastname not valid";
        } else if (empty($xml->email) || !filter_var($xml->email, FILTER_VALIDATE_EMAIL)) {
            echo "Email not valid";
        } else {
            $this->save($xml->firstname, $xml->lastname, $xml->address, $xml->email, $xml->phone);
        }
    }
    
    // display data --- not used in this exercise 
    public function show(){
        echo "<h2>Contacts data:</h2>";
        echo $this->firstname;
        echo "<br>";
        echo $this->lastname;
        echo "<br>";
        echo $this->address;
        echo "<br>";
        echo $this->email;
        echo "<br>";
        echo $this->phone;
    }
     
    // web form 
    public function form(){
        $firstnameErr = $lastnameErr = $emailErr = "";
        $firstname = $lastname = $address = $email = $phone = "";
        $flag = false;
        
        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $flag = true;
            if (empty($_POST["firstname"])) {
                $firstnameErr = "First name is required";
                $flag = false;
            } else {
                $firstname = test_input($_POST["firstname"]);
                // check if name only contains letters and whitespace
                if (!preg_match("/^[a-zA-Z ]*$/",$firstname)) {
                    $firstnameErr = "Only letters and white space allowed"; 
                    $flag = false;
                }
            }
            if (empty($_POST["lastname"])) {
                $lastnameErr = "Lastname is required";
                $flag = false;
            } else {
                $lastname = test_input($_POST["lastname"]);
                // check if name only contains letters and whitespace
                if (!preg_match("/^[a-zA-Z ]*$/",$lastname)) {
                    $lastnameErr = "Only letters and white space allowed"; 
                    $flag = false;
                }
            }
            if (empty($_POST["address"])) {
                $address = "";
            } else {
                $address = test_input($_POST["address"]);
            }
            if (empty($_POST["email"])) {
                $emailErr = "Email is required";
                $flag = false;
            } else {
                $email = test_input($_POST["email"]);
                // check if e-mail address is well-formed
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailErr = "Invalid email format"; 
                    $flag = false;
                }
            }
            if (empty($_POST["phone"])) {
                $phone = "";
            } else {
                $phone = test_input($_POST["phone"]);
            }
            if($flag == true){
                $this->save($firstname, $lastname, $address, $email, $phone);
            }
        }
?>
    <h2>Add a new contact</h2>
    <style>.error {color: #FF0000;}</style>
    <p><span class="error">* required field.</span></p>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
        First Name: <input type="text" name="firstname" value="<?php echo $firstname;?>">
        <span class="error">* <?php echo $firstnameErr;?></span>
        <br><br>
        Surname: <input type="text" name="lastname" value="<?php echo $lastname;?>">
        <span class="error">* <?php echo $lastnameErr;?></span>
        <br><br>
        Address: <input type="text" name="address" value="<?php echo $address;?>">
        <br><br>
        E-mail: <input type="text" name="email" value="<?php echo $email;?>">
        <span class="error">* <?php echo $emailErr;?></span>
        <br><br>
        Phone: <input type="text" name="phone" value="<?php echo $phone;?>">
        <br><br>
        <input type="submit" name="submit" value="Submit">  
    </form>
    
<?php
    }
        
}

?>
