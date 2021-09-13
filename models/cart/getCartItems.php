<?php
 session_start();
 header('Content-Type: application/json');

if(isset($_SESSION['user'])){

    if(isset($_POST['orders'])){

        require_once '../../config/connection.php';

        $orders=$_POST['orders'];
        $orders=json_decode($orders);
        $books=[];
        $id = $_SESSION['user']->id;

        for ($i=0; $i <count($orders) ; $i++) {   

            $result = $conn->prepare("SELECT id,name,price,inStock,image,Author FROM books WHERE id=?");

            $idBook=$orders[$i]->idBook; 
            $result->bindValue(1, $idBook);
            try {
                $result->execute();
                $book = $result->fetch();
            }
            catch(PDOException $ex){
                   echo json_encode(['message', 'Problem with database:' . $ex->getMessage()]);
            }

            $book->quantity=$orders[$i]->quantity; 

            array_push($books,$book);
        }

        echo json_encode($books);

    }
    

    else {
        http_response_code(400); // 400 - Bad request
        } 
    }

    else{
        echo "Your cart is empty";
    }
    

?>