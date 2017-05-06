<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "exercise";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// sql to create table
$sql = "CREATE TABLE contact (
  contact_id int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  firstname varchar(50) NOT NULL,
  lastname varchar(50) NOT NULL,
  address varchar(254) DEFAULT NULL,
  email varchar(254) NOT NULL,
  phone varchar(30) DEFAULT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table contact created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>
