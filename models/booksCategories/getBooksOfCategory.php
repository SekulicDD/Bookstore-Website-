<?php

header('Content-Type: application/json');

if(isset($_POST['id'])){
    require_once '../../config/connection.php';

    $id = $_POST['id'];
    
    if($id==1){
        $result=$conn->prepare("SELECT * FROM books");
    }
    
    else{
        $result = $conn->prepare("SELECT * FROM books 
        WHERE id IN (
        SELECT idBook 
        FROM `bookcategory`
        WHERE idCategory=?)");
        $result->bindValue(1, $id);
    }
    
    try {
        $result->execute();
        $books = $result->fetchAll();
        echo json_encode($books);
    }
    catch(PDOException $ex){
        echo json_encode(['message', 'Problem with database:' . $ex->getMessage()]);
        http_response_code(500);
    }
} else {
    http_response_code(400); // 400 - Bad request
}