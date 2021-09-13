<?php

if(isset($_POST['id'])){
    require_once '../../config/connection.php';

    $id=$_POST['id'];

    $result = $conn->prepare("DELETE FROM books WHERE id=?");
    $result->bindValue(1, $id);
    
    try {
        $result->execute();     
    }
    catch(PDOException $ex){
        http_response_code(500);
    }
} 

else {
    http_response_code(400); // 400 - Bad request
}