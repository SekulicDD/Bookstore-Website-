<?php

header('Content-Type: application/json');

require_once '../../config/connection.php';
   
try {
    $books =  executeQuery("SELECT * FROM books");
        echo json_encode($books);
}
catch(PDOException $ex){
    echo json_encode(['message', 'Problem with database:' . $ex->getMessage()]);
    http_response_code(500);
}
