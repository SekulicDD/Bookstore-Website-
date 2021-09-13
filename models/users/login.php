<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../../config/connection.php';

if(isset($_POST["loginBtn"])){
    $email = trim($_POST["loginEmail"]);
    $pass = trim($_POST["loginPass"]);

    $error = [];

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error[] = "Email is not valid!";
    }

    
    if(count($error) == 0){


        $prepare = $conn->prepare("SELECT us.id,us.firstName,us.password,rl.name as role from users us INNER JOIN roles rl on us.idRole=rl.id WHERE isActive=1 AND email = :email");
    
        $prepare->bindParam(":email", $email);
        $pass = md5($pass);

        $prepare2=$conn->prepare("UPDATE users SET isLogged=1 WHERE email=:email");
        $prepare2->bindParam(":email", $email);

        try {
            $prepare->execute();  
                                      
            $user=$prepare->fetch();       
        } 
        catch(PDOException $ex){           
            $_SESSION["errors"] = ["Problem with database".$ex];
            header("Location:".BASE_URL."//index.php?page=login");
        }

        if(isset($user)){

            if(($pass==$user->password)){
                try {
                    $prepare2->execute(); 
                }
                catch(PDOException $ex){   
                    $_SESSION["errors"] = ["Problem with database".$ex];
                    header("Location:".BASE_URL."//index.php?page=login");
                }

                $_SESSION['user'] = $user;

                if($user->role== "Customer"){
                    header("Location: ".BASE_URL."//index.php");
                } 
                else if($user->role == "Admin"){
                    header("Location: ".BASE_URL."//index.php");
                }
            }
            else{
                $_SESSION['errorLogin'] = ["Wrong password or account is not acctivated"];
                mail($email, "Log in Message", "Someone tried logging in your account with wrong password.","From:bookstore@company.com");
                header("Location:".BASE_URL."//index.php?page=login");
            }      
        }
        else {
            $_SESSION['errorLogin'] = ["Account bound to that email is not activated or doesn't exist"];
            header("Location:".BASE_URL."//index.php?page=login");
        }

    }
    else {
        $_SESSION['errorLogin'] = $error;   
        header("Location:".BASE_URL."//index.php?page=login"); 
    }
    
   
}

?>