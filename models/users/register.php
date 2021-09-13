<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_POST["registerBtn"])){
    require_once '../../config/config.php';

    $firstName = $_POST['registerFName'];
    $lastName = $_POST['registerLname'];
    $email = $_POST['registerEmail'];
    $pass = $_POST['registerPassword'];

    $reFname="/^[A-Z][a-z]{2,25}$/";
    $reLname="/^[A-Z][a-z]{2,35}$/";
    $rePass="/^.{5,30}$/";

    $errors = [];

    if(!preg_match($reFname, $firstName))
        array_push($errors,"First name is in wrong format - Example: John");

    if(!preg_match($reFname, $lastName))
        array_push($errors,"Last name is in wrong format - Example: Smith");

    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        array_push($errors,"Email is in wrong format - Example: john12@gmail.com");
    
    if(!preg_match($rePass, $pass))
        array_push($errors,"Password is in wrong format - Example: m0nk3y (minimum 5 characters)");
    
    if(count($errors) == 0) {

        require_once '../../config/connection.php';

        $activation=sha1(mt_rand(10000,99999).time().$email);
        $timestamp=date("Y-m-d H:i:s");
        $pass=md5($pass);
        $active=0;
        $uloga=2;

        $query = "INSERT INTO users VALUES (null,:idRole,:firstName,:lastName,:password,:email,null,:isActive,0,:code)";
        
        $prepare=$conn->prepare($query);
        $prepare->bindParam(":idRole",$uloga);
        $prepare->bindParam(":firstName", $firstName);
        $prepare->bindParam(":lastName", $lastName);
        $prepare->bindParam(":password",$pass);
        $prepare->bindParam(":email", $email);
        $prepare->bindParam(":isActive",$active);
        $prepare->bindParam(":code", $activation);

        try {
            $prepare->execute();    
            $_SESSION["success"] = "<p>Activational link is sent to your email </p>"; 
            mail($email, "Confrim link", "Please confrim your registration:".BASE_URL."//models/users/activation.php?code=".$activation."","From:bookstore@company.com");
            header("Location:".BASE_URL."//index.php?page=login#msg"); 
        } 
        catch(PDOException $ex){           
            $_SESSION["errors"] = ["User with same email already exists!".$ex];
            header("Location:".BASE_URL."//index.php?page=login#msg"); 
        }
        
    } 
    else {  
        $_SESSION['errors'] = $errors;
        header("Location:".BASE_URL."//index.php?page=login#msg"); 
    }
}

?>