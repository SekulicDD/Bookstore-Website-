<?php

header('Content-Type: application/json');

require_once '../../config/connection.php';
   
try {
    $users =  executeQuery("SELECT firstName,lastName,email,idRole,dateCreated FROM users WHERE isLogged=1");
    echo json_encode($users);
}
catch(PDOException $ex){
    echo json_encode(['message', 'Problem with database:' . $ex->getMessage()]);
    http_response_code(500);
}












