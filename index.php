<?php include("contact.php"); ?>

<?php
// database informations
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "exercise";
       
$newContact = new Contact();
$newContact->setConnection($servername, $username, $password, $dbname);

if(isset($_GET['xml'])){
    $xml=simplexml_load_file($_GET['xml']) or die("Error: Cannot create object");
    $newContact->readXML($xml);
} else {
    $newContact->form();
}
?>
