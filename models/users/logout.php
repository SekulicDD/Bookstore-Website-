<?php
session_start();
require_once '../../config/config.php';
require_once '../../config/connection.php';

$id=$_SESSION["user"]->id;
$prepare=$conn->prepare("UPDATE users SET isLogged=0 WHERE id=:id");
$prepare->bindParam(":id", $id);

try {
    $prepare->execute();      
} 
catch(PDOException $ex){           
    $_SESSION["errors"] = ["Problem with database".$ex];
    header("Location:".BASE_URL."//index.php?page=login");
}


unset($_SESSION['user']);
$_SESSION["success"]="You have been successfully logged out";
header("Location:".BASE_URL."//index.php?page=login#msg"); 
        