<?php 

require_once "config/connection.php";

include "views/fixed/header.php";

if(!isset($_GET['page'])){
    include "views/slider.php";
    include "views/pages/home.php";
}

else{
    switch($_GET['page']){  
        case "shop":
            include "views/side-categories.php";
            include "views/pages/shop.php";
        break;

        case "productDetails":
            include "views/pages/productDetails.php";
        break;

        case "login":
            include "views/pages/loginPage.php";
        break;

        case "contact":
            include "views/pages/contact.php";
        break;

        case "cart":
            include "views/pages/cart.php";
        break;

        case "admin":
            include "views/pages/admin.php";
        break;

        case "author":
            include "views/pages/author.php";
        break;
    }
}


include "views/fixed/footer.php";