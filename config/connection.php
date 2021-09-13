<?php

require_once "config.php";
logUser();

try {
    $conn = new PDO("mysql:host=".SERVER.";dbname=".DATABASE.";charset=utf8", USERNAME, PASSWORD);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $ex){
    echo $ex->getMessage();
}

function executeQuery($query){
    global $conn;
    return $conn->query($query)->fetchAll();
}

function logUser(){
    $open = fopen(LOG_FAJL, "a");
    if($open){
        $time=date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
        fwrite($open, "{$_SERVER['PHP_SELF']}\t{$_SERVER['REMOTE_ADDR']}\tt$time\n");
        fclose($open);
    }
}