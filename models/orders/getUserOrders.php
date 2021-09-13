 <?php
 session_start();
 header('Content-Type: application/json');

if(isset($_SESSION['user'])){
        require_once '../../config/connection.php';
    
        $id = $_SESSION['user']->id;
        
        $result = $conn->prepare("SELECT idBook,quantity FROM orders WHERE idUser=? ORDER BY dateCreated DESC");
        $result->bindValue(1, $id);
    
        try {
            $result->execute();
            $orders = $result->fetchAll();
            echo json_encode($orders);
        }
        catch(PDOException $ex){
            echo json_encode(['message', 'Problem with database:' . $ex->getMessage()]);
            http_response_code(500);
        }
    }
    
    else {
        http_response_code(400); // 400 - Bad request
        } 
    

?>