<?php
// Create Database (if not exists)
$dbusername = "root";
$dbpassword = "";
$dbname = "fooddb";
$pdo = new PDO("mysql:host=localhost", $dbusername, $dbpassword);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->query("CREATE DATABASE IF NOT EXISTS $dbname");

// Init DB
require_once "./mysql.php";
$db = new DB();

$db->initDB();

// Controller
if(isset($_GET["class"]) === TRUE) {
    include_once("./class/" . $_GET["class"] . ".php");
}
else
{
    include_once("./class/foodporn.php");
}

$controller = new Controller();
$controller->display();*/
?>