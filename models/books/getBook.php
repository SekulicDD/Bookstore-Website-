<?php

header('Content-Type: application/json');

if(isset($_POST['id'])){
    require_once '../../config/connection.php';

    $id = $_POST['id'];

    $result = $conn->prepare("SELECT * FROM books WHERE id=?");
    $result->bindValue(1, $id);
    
    
    try {
        $result->execute();
        $book = $result->fetch();
        echo json_encode($book);
    }
    catch(PDOException $ex){
        echo json_encode(['message', 'Problem with database:' . $ex->getMessage()]);
        http_response_code(500);
    }
} else {
    http_response_code(400); // 400 - Bad request
}