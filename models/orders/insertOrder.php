<?php
session_start();
if(isset($_SESSION["user"])){
    if(isset($_POST['id'])){
        require_once '../../config/connection.php';

        $idBook = $_POST['id'];
        $idUser=$_SESSION["user"]->id;

        $check=$conn->prepare("SELECT quantity FROM orders WHERE idUser=? AND idBook=?");
        $check->bindValue(1, $idUser);
        $check->bindValue(2, $idBook);
        $check->execute();
        $exists=$check->fetch();

        if ($exists){
            $result = $conn->prepare("UPDATE orders SET quantity=quantity+1 WHERE idBook=? AND idUser=?");
            $result->bindValue(1, $idBook);
            $result->bindValue(2, $idUser);
        } 

        else{
            $result = $conn->prepare("INSERT INTO orders VALUES(?,?,?,null)");

            $quantity=1;
            $result->bindValue(1, $idUser);
            $result->bindValue(2, $idBook);
            $result->bindValue(3, $quantity);
        }

        try {
            $result->execute();
            echo "Added to cart";
        }
        catch(PDOException $ex){
            //echo json_encode(['message', 'Problem with database:' . $ex->getMessage()]);
            http_response_code(500);
        }
    }    
else {
    http_response_code(400); // 400 - Bad request
}

}

else{
    $_SESSION["success"]="You need to be logged in first!";
    echo 0;
}