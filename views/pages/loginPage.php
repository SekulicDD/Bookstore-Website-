
<?php 
if(isset($_SESSION["user"])){
?>

<section id="form">
<div class="container">
    <div class="row">
    
        <div class="col-sm-4 col-sm-offset-1">
            <h2>You are already logged in!</h2>
            <h3><a href=<?=BASE_URL."/models/users/logout.php"?>>Logout</a></h3>
        </div>
    </div>

<?php }else{?>

<section id="form">
<div class="container">
<div class="row">
    <div class='col-sm-11 col-sm-offset-1'  id='cartMsg'>
        <p>You need to login to use and add to cart.</p>
    </div>
<div class="col-sm-4 col-sm-offset-1">
    <div class="login-form"><!--login form-->
        <h2>Login to your account</h2>
        <form action="models/users/login.php" method="POST">
            <input type="email" placeholder="email" name="loginEmail"/>
            <input type="password" placeholder="Password" name="loginPass"/>
            <button type="submit" name="loginBtn" class="btn btn-default">Login</button>
        </form>
    </div><!--/login form-->
</div>
<div class="col-sm-1">
    <h2 class="or">OR</h2>
</div>
<div class="col-sm-4">
    <div class="signup-form"><!--sign up form-->
        <h2>New User Signup!</h2>
        <form action="models/users/register.php" method="POST"  onSubmit="return check();">
            <input type="text" placeholder="First name" name="registerFName" id="registerFName"/><span id="errorFname"></span>
            <input type="text" placeholder="Last name" name="registerLname" id="registerLname" /><span id="errorLname"></span>
            <input type="email" placeholder="Email Address" name="registerEmail" id="registerEmail"/><span id="errorEmail"></span>
            <input type="password" placeholder="Password" name="registerPassword" id="registerPassword"/><span id="errorPass"></span>
            <button type="submit" id="registerBtn" name="registerBtn" class="btn btn-default">Signup</button>
        </form>
    </div><!--/sign up form-->
</div>



</div>

<?php } ?>
<div class="row">

    <?php 
        $html="";
        if(isset($_SESSION["errorLogin"]))
        {
            if(count($_SESSION["errorLogin"])>0){
                for ($i=0; $i <count($_SESSION["errorLogin"]); $i++) { 
                    $html.="<p>".$_SESSION["errorLogin"][$i]."</p>";
                }
                
            }	
            echo "<div class='col-sm-11 col-sm-offset-1' id='msg'>".$html."</div>";
            unset($_SESSION['errorLogin']);
        }
     
        $html="";
        if(isset($_SESSION["success"])){
            $html=$_SESSION["success"];
            unset($_SESSION['success']);
            echo "<div class='col-sm-11 col-sm-offset-1' id='msg'>".$html."</div>";
        }
        else if(isset($_SESSION["errors"]))
        {
            if(count($_SESSION["errors"])>1){
                $html="<h3>Please turn on the javascript</h3>";
                for ($i=0; $i <count($_SESSION["errors"]); $i++) { 
                    $html.="<p>".$_SESSION["errors"][$i]."</p>";
                }
                
            }
            else{
                $html="<p>".$_SESSION["errors"][0]."</p>";
            }	
            unset($_SESSION['errors']);
        echo "<div class='col-sm-11 col-sm-offset-1'  id='msg'>".$html."</div>";	
        }
        
    ?>
   

</div>
</div>
</section>





	
