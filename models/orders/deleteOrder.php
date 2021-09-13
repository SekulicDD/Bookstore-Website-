<?php
 session_start();

if(isset($_SESSION['user'])&&isset($_POST['id']))
{
        require_once '../../config/connection.php';
    
        $idUser = $_SESSION['user']->id;
        $idBook=$_POST["id"];
        
        $result = $conn->prepare("DELETE FROM orders WHERE idUser=? and idBook=?");
        $result->bindValue(1, $idUser);
        $result->bindValue(2, $idBook);
    
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
    

?>