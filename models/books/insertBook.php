<?php

header('Content-Type: application/json');

if(isset($_POST['formData'])){
    require_once '../../config/connection.php';

    $data=$_POST['formData'];

    $name=$data["name"];
    $author=$data["author"];
    $text=$data["text"];
    $price=$data["price"];
    $stock=$data["stock"];
    $image="temp.jpg";
    $featured=$data["featured"];

    $validate=true;
    $errors=[];

    if(strlen($name)>30||strlen($name)<2){
        array_push($errors,"Book name needs to be more then 2 and less then 30 characters");
    }

    if(!preg_match("/^[a-z ,.'-]+$/i",$author)){
        array_push($errors,"Author name is in wrong format");
    }

    if(strlen($text)>1000||strlen($text)<20){
        array_push($errors,"Description needs to be more than 20 and less than 1000 characters");
    }

    if(!preg_match("/^([\d]{1,5})(\.[\d]{1,2})?$/",$price)){
        array_push($errors,"Price can have have max 5 digits and 2 decimal places (biggest number:99999.99)");
    }

    if(!preg_match("/^(?!(0))\d{1,4}$/",$stock)){
        array_push($errors,"Stock needs to be beetween 1 and 9999");
    }

    if(count($errors)>0){
        echo json_encode($errors);
    }


    else{
        $result = $conn->prepare("INSERT INTO books VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)");
        $result->bindValue(1, $name);
        $result->bindValue(2, $author);
        $result->bindValue(3, $text);
        $result->bindValue(4, $price);
        $result->bindValue(5, $stock);
        $result->bindValue(6, $featured);
        $result->bindValue(7, $image);
        
        try {
            $result->execute();
            echo json_encode("Success");     
        }
        catch(PDOException $ex){
            http_response_code(500);
        }
    }
} 

else {
    http_response_code(400); // 400 - Bad request
}