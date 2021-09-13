window.onload=function(){
    localStorage.setItem("catTemp",1);
    localStorage.setItem("pg",1);

    localStorage.setItem("order",1);
    $("#cat1").css("color","orange");

    $("#smallMenu").on("click",function(){
        $("#smallMenuList").slideToggle();
    });

    let params = new URLSearchParams(location.search);
    if(params.get('page')=="shop"){
        ajaxGetProducts(1);
    }

    else if(params.get('page')=="cart"){
        localStorage.setItem("pgCart",1);
        getUserOrdersAjax();      
    }
    else if(params.get('page')=="admin"){
        localStorage.setItem("pgAdmin",1);
        getVisitPercentage();
        getLoggedInUsers();
        adminGetBooks();

        $("#operations input[name='update']").on("click",function(){
            getUpdateForm();
            $("#errorsDiv").fadeOut();
        });        

        $("#operations input[name='insert']").on("click",function(){
            $("#insertFormDiv").fadeIn();
            $("#updateFormDiv").fadeOut();
            $("#errorsDiv").fadeOut();
        });

        $("#operations input[name='delete']").on("click",function(){
            adminDeleteProduct(localStorage.getItem("selectedProduct"));
            $("#errorsDiv").fadeOut();
        });

        $("#submitInsert").on("click",function(){
            if(regexInsert()==true){
                adminInsertProduct();
            }
           
        });

        $("input[name='excel']").on("click",function(){
            exportToExcel();
        });
    }
    
    if(localStorage.getItem("tmpBook")!==null){
        $("#productDetailsDiv").html(localStorage.getItem("tmpBook"));
        //localStorage.removeItem("tmpBook");
    }

    //SLIDE SHOW
    let iSlide=0;
    let images=["slider1.jpg","slider2.jpg","slider3.jpg"]; //UCITATI iz baze 
    let time;

    let timer=function()
    {
        time=setInterval(()=>{
        iSlide++;
        if(iSlide>images.length-1)
            iSlide=0;
        changeSlider(images[iSlide]);    
    },5000);
    }

    timer();

    $("#leftSlide").on("click",(e)=>{
        e.preventDefault();
        iSlide--;
        if(iSlide==-1)
            iSlide=images.length-1;
        changeSlider(images[iSlide]);
        clearInterval(time);
        timer();
    });

    $("#rightSlide").on("click",(e)=>{
        e.preventDefault();                  
        iSlide++;
        if(iSlide>images.length-1)
            iSlide=0;
        changeSlider(images[iSlide]);
        clearInterval(time);
        timer();
    });
   
       
    //category change
    $(".categoryLink").on("click",function(e){
        e.preventDefault();

        let id=$(this).data("id");           

        if(id!=localStorage.getItem("catTemp")){
            localStorage.setItem("pg",1);
            $("#cat"+localStorage.getItem("catTemp")).css("color","#696763");
            localStorage.setItem("catTemp",id);          
            ajaxGetProducts(id);
        }
    });

    paginationClick();
    productDetailsClick();
    addToCartClick();

    $("#sortBy").on("change",function(){
        localStorage.setItem("order",$(this).val());
        printProducts();
    });

    //contact
    $("#send").on("click",regex);


}

// PRODUCTS PRODUCTS PRODUCTS

function ajaxGetProducts(id){

    $.ajax({
        url: 'models/booksCategories/getBooksOfCategory.php', 
        method: 'POST',
        data: {
            id: id,
        },
        dataType: 'json', 
        success: function(books){
            console.warn('USPESNO DOHVACENI PROIZVODI');
            printProducts(JSON.stringify(books));
            $("#cat"+id).css("color","orange");
        }, 
        error: function(greska, status, statusText){
            console.error('GRESKA DOHVATANJE PROIZVODA:');
            
            console.log(greska.parseJSON);
            alert(greska.parseJSON.poruka);
        }
    })
}

function printProducts(books){
    let pg=localStorage.getItem("pg");
    let order=localStorage.getItem("order");
    $.ajax({
        url: 'views/shopAjax.php', 
        method: 'POST',
        data: {
            "books":books,
            "pg":pg, 
            "order":order,    
        }, 
        success: function(data){
            console.warn('USPESNO DOHVACEN ISPIS PROIZVODA');
            $("#products").html(data);
            $("#products").hide();
            $("#products").fadeIn(250);

            paginationClick();         
            productDetailsClick();
            addToCartClick();
        },
        error: function(greska, status, statusText){
            console.error('GRESKA DOHVATANJE ISPISA PROIZVODA:');
            
            console.log(greska.parseJSON);
            
        }
    })
    
}

// PRODUCT_DETAILS PRODUCT_DETAILS PRODUCT_DETAILS 

function ajaxGetProductDetails(id){

    $.ajax({
        url: 'models/books/getBook.php', 
        method: 'POST',
        data: {
            id: id,
        },
        dataType: 'json', 
        success: function(book){
            console.warn('USPESNO DOHVACEN PROIZVOD'); 
            printProductDetails(JSON.stringify(book));
        }, 
        error: function(greska, status, statusText){
            console.error('GRESKA DOHVATANJE 1 PROIZVODA:');
            
            console.log(greska.parseJSON);
            
        }
    })


}

function printProductDetails(book){
    $.ajax({
        url: 'views/productDetailsAjax.php', 
        method: 'POST',
        data: {
            "book":book,   
        }, 
        success: function(data){
            console.warn('USPESNO DOHVACEN ISPIS Detalja PROIZVODA');
            localStorage.setItem("tmpBook",data);
            window.location.href="https://phpraktikum.000webhostapp.com//index.php?page=productDetails"; 
        
        },
        error: function(greska, status, statusText){
            console.error('GRESKA DOHVATANJE ISPISA PROIZVODA:');
            
            console.log(greska.parseJSON);
            //alert(greska.parseJSON.poruka);
        }
    })  
}

function productDetailsClick(){
    $('.productDetails').click(function(e){
        e.preventDefault();
        ajaxGetProductDetails($(this).data("id"));
    });

    $(".productDetails").hover(function(){
        $(this).css("color","grey");
        }, function(){
            $(this).css("color","black");
    });

}

function paginationClick(){
    $(".pagination li a").on("click",function(e){
        e.preventDefault();   
        localStorage.setItem("pg",$(this).text());
        printProducts();
    });
}

// CART CART CART CART CART CART

function addToCartAjax(id){
    $.ajax({
        url: 'models/orders/insertOrder.php',
        method: 'POST',
        
        data: {
            "id":id,   
        }, 
        success: function(data){
            if(data==0){
                window.location.href="https://phpraktikum.000webhostapp.com//index.php?page=login#msg"; 
            }

            else{
                alert("Product succesfuly added to cart");
            }
        },
        error: function(greska, status, statusText){
            console.error('GRESKA DODAVANJA U KORPU');
            
            console.log(greska.parseJSON);
            //alert(greska.parseJSON.poruka);
        }
    })  
}

function deleteOrder(id){
    $.ajax({
        url: 'models/orders/deleteOrder.php',
        method: 'POST',
        data: {
            "id":id,   
        }, 
        success: function(){      
            console.warn("sucsess delete order");           
        },
        error: function(xhr, status, error){
            var errorMessage = xhr.status + ': ' + xhr.statusText
            alert('Error - ' + errorMessage);
            console.log(greska.parseJSON);          
        }
    })  
}

function getUserOrdersAjax(){
    $.ajax({
        url: 'models/orders/getUserOrders.php',
        method: 'POST',
        success: function(data){      
            console.warn("sucsess orders");
            getCartItemsAjax(JSON.stringify(data));         
        },
        error: function(xhr, status, error){
            var errorMessage = xhr.status + ': ' + xhr.statusText
            alert('Error - ' + errorMessage);      
            console.log(greska.parseJSON);
            
        }
    })  
}

function getCartItemsAjax(orders){
    $.ajax({
        url: 'models/cart/getCartItems.php',
        method: 'POST',
        data: {
            "orders":orders,   
        }, 
        success: function(data){      
            console.warn("sucsess cart items");
            printCartItems(JSON.stringify(data));
            
        },
        error: function(xhr, status, error){
            var errorMessage = xhr.status + ': ' + xhr.statusText
            alert('Error - ' + errorMessage);
            console.error('waaaaat');
            
            console.log(greska.parseJSON);
            //alert(greska.parseJSON.poruka);
        }
    })  
}

function printCartItems(books){

    let pg=localStorage.getItem("pgCart");
    $.ajax({
        url: 'views/cartAjax.php', 
        method: 'POST',
        data: {
            "books":books,
            "pg":pg,  
        }, 
        success: function(data){
            console.warn('USPESNO DOHVACEN ISPIS CART');
            $("#cartItems").html(data);
            $("#cartItems").hide();
            $("#cartItems").fadeIn(250);
            paginationClickCart();  
            deleteOrderClick();        
        },
        error: function(greska, status, statusText){
            console.error('GRESKA DOHVATANJE ISPISA CART');
            
            console.log(greska.parseJSON);
            
        }
    })
}

function deleteOrderClick(){
    $(".cart_quantity_delete").on("click",function(e){
        e.preventDefault();   
        deleteOrder($(this).data("id"));
        getUserOrdersAjax();
    });

}

function paginationClickCart(){
    $(".pagination li a").on("click",function(e){
        e.preventDefault();   
        localStorage.setItem("pgCart",$(this).text());
        printCartItems();
    });
}

function addToCartClick(){
    $(".add-to-cart").on("click",function(e){
        e.preventDefault();   
        addToCartAjax($(this).data("id"));
    });
}

// CONTACT CONTACT CONTACT CONTACT

function check(){
    $(".error").hide();
    $(".error").fadeIn();

    let errors=[];
    let test=false;

    let reFname,reLname,reEmail,rePass,fname,lname,email,pass;
    fname=$("#registerFName").val().trim();
    lname=$("#registerLname").val().trim();
    email=$("#registerEmail").val().trim();
    pass=$("#registerPassword").val().trim();

    reFname=/^[A-Z][a-z]{2,25}$/;
    reLname=/^[A-Z][a-z]{2,35}$/;
    reEmail=/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/;
    rePass=/^.{5,30}$/;

    if(!reFname.test(fname)){
        let tmp="First name is in wrong format - Example: John";
        errors.push(tmp);
        $("#errorFname").html(tmp);
    }
    else
        $("#errorFname").html("");


    if(!reLname.test(lname)){
        let tmp="Last name is in wrong format - Example: Smith";
        errors.push(tmp);
        $("#errorLname").html(tmp);
    }
    else
        $("#errorLname").html("");

    if(!reEmail.test(email)){
        let tmp="Email is in wrong format - Example: john12@gmail.com";
        errors.push(tmp);
        $("#errorEmail").html(tmp);
    }
    else
        $("#errorEmail").html("");

    if(!rePass.test(pass)){
        let tmp="Password is in wrong format - Example: m0nk3y (minimum 5 characters)";
        errors.push(tmp);
        $("#errorPass").html(tmp);
    }
    else
        $("#errorPass").html("");

    if(errors.length==0){
        test=true;
    }

    return test;

 }

 regex=()=>{
    let name,email,message,subject;
    let reName,reEmail;
    let send=true;
    let errors=[];

    name=$("#name").val().trim();
    email=$("#email").val().trim();
    message=$("#mess").val().trim();
    subject=$("#subject").val().trim();

    reName = /^[A-Z][a-z]{1,14}(\s[A-Z][a-z]{1,19})+$/;
    reEmail = /^[a-z][a-z\d\_\.\-]+\@[a-z\d]+(\.[a-z]{2,4}){1,3}$/;
    
    if (!reName.test(name)){
        send=false;
        errors.push("Name not in correct format: John Smith");
    }
    if (!reEmail.test(email)){
        send=false;
        errors.push("Email not in correct format: john23@gmail.com");
    }
    if (message.length > 160||message.length < 16) {
        send = false;
        errors.push("Message need to between 16 and 160 characters");
    }

    if (subject.length > 40) {
        send = false;
        errors.push("Subject needs to less then 40 characters");
    }
    
    if(send==false)
    {
        let errorIspis="<h4>Contact Format</h4>";
        errors.forEach(el => {
            errorIspis+=`<p>${el}</p>`;
        });
        $("#errors").html(errorIspis);
        $("#errors").css("color","red");
    }
    else{
        alert("Message was sent sucessfuly");
        $("#name").val("");
        $("#email").val("");
        $("#mess").val("");
        $("#errors").html(`<h4>Message Format</h4>
        <p>Name format: John Smith</p>
        <p>Email format: john23@gmail.com</p>
        <p>Message between 16 and 160 characters</p>`);
        $("#errors").css("color","black");
    }

    return send;
}



changeSlider=(img)=>{
    let image=$("#myCarousel img");
    image.fadeOut("fast",(e)=>{       
        image.fadeIn();
        image.attr("src", "assets/images/home/"+img);
    })
}


// ADMIN ADMIN ADMIN ADMIN ADMIN ADMIN

function getVisitPercentage(){

    $.ajax({
        url: 'models/log/getVisitPercentage.php', 
        method: 'POST',
        dataType: 'json', 
        success: function(data){
            console.warn('USPESNO DOHVACEN log'); 
            printLog(data);
        }, 
        error: function(greska, status, statusText){
            console.error('GRESKA DOHVATANJE loga:');
            
            console.log(greska.parseJSON);
            
        }
    })

}

function printLog(data){
    let html=`
    <tr>
        <th>Page</th>
        <th>Times visited</th>
        <th>Precentage</th>
    </tr>`;

    let sum=0;

    for (var property in data) {
        if (data.hasOwnProperty(property)) 
        {
           sum+=data[property];
        }
    }

    for (var property in data) {
        if (data.hasOwnProperty(property)) {
          html+="<tr><td>"+property+"</td>";
          html+="<td>"+data[property]+"</td>";
          html+="<td>"+((data[property]/sum)*100).toFixed(2)+"%</td></tr>";
        }
      }
    html+="</tr>";
    $("#logData").html(html);
}

function getLoggedInUsers(){
    $.ajax({
        url: 'models/log/selectLoggedIn.php', 
        method: 'POST',
        success: function(data){
            console.warn('USPESNO DOHVACENENI logovani useri'); 
            loggedUsersAjax(data);
        }, 
        error: function(greska, status, statusText){
            console.error('GRESKA DOHVATANJE logovanih usera:');
            
            console.log(greska.parseJSON);
            
        }
    })
}

function loggedUsersAjax(data){
    $.ajax({
        url: 'views/loggedUsersAjax.php', 
        method: 'POST',
        data: {
            "data":data, 
        }, 
        success: function(data){
            console.warn('USPESNO DOHVACEN prikaz usera'); 
            $("#userData").html(data);
        }, 
        error: function(greska, status, statusText){
            console.error('GRESKA DOHVATANJA prikaza usera');
            
            console.log(greska.parseJSON);
            
        }
    })
}









function adminGetBooks(){
    
    $.ajax({
        url: 'models/books/getAllBooks.php', 
        method: 'POST',
        success: function(books){
            console.warn('USPESNO DOHVACENI PROIZVODa admin'); 
            printAdminBooks(JSON.stringify(books));     
        }, 
        error: function(greska, status, statusText){
            console.error('GRESKA DOHVATANJE PROIZVODA admin');  
            console.log(greska);     
        }
    })

}

function printAdminBooks(books){
    let pg=localStorage.getItem("pgAdmin");
    $.ajax({
        url: 'views/adminProductsAjax.php', 
        method: 'POST',
        data: {
            "books":books,
            "pg":pg,
        },
        success: function(data){
            $("#adminProducts").html(data);
            adminPaginationClick();
            adminProductRowClick();
            localStorage.removeItem("selectedProduct");
            console.warn('USPESNO DOHVACENI PRIKAZ ADMIN PROIZOVDA'); 
        }, 
        error: function(greska, status, statusText){
            console.error('GRESKA DOHVATANJE PRIKAZ ADMIN PROIZOVDA');      
            console.log(greska);
            
        }
    })
}

function adminPaginationClick(){
    $(".pagination li a").on("click",function(e){
        e.preventDefault();   
        localStorage.setItem("pgAdmin",$(this).text());
        printAdminBooks();
    });
}

function adminProductRowClick(){
    $(".adminProductRow").on("click",function(){
        let id=$(this).data("id");
        let idPrev=localStorage.getItem("selectedProduct");

        if( id!=idPrev)
        {
            localStorage.setItem("selectedProduct",id);
            $(this).addClass("trSelect");
            
            $(`.adminProductRow[data-id=${idPrev}]`).removeClass('trSelect');
        }
   
    });

}

function getUpdateForm(){
    let id=localStorage.getItem("selectedProduct");
    if(id !==null){
        $.ajax({
            url: 'models/books/getBook.php', 
            method: 'POST',
            data: {
                "id":id,
            },
            success: function(data){
                printUpdateForm(JSON.stringify(data));
                console.warn('SUCCESSFULY GOT BOOK'); 
            }, 
            error: function(greska, status, statusText){
                console.error('ERROR GETING BOOK');      
                console.log(greska); 
                
            }
        });
    }

    else{
        alert("Please select product to update!");
    }

}

function printUpdateForm(book){

    $.ajax({
        url: 'views/adminUpdateFormAjax.php', 
        method: 'POST',
        data: {
            "book":book,
        },
        success: function(data){
            $("#updateForm").html(data);
            $("#updateFormDiv").fadeIn();
            $("#insertFormDiv").fadeOut();

            console.warn('SUCCESSFULY SHOWED UPDATE FORM'); 
            $("#submitUpdate").on("click",function(){
                if(regexUpdate()==true){
                let tmp=$(this).data("id");
                adminUpdateProduct(tmp);
                }
            });
       
        }, 
        error: function(greska, status, statusText){
            console.error('ERROR SHOWING UPDATE FORM');      
            console.log(greska); 
            
        }
    });
}


function adminUpdateProduct(id){

    let formData = {};
    $("#updateForm").find("input[name]").each(function (i,node) {
        formData[node.name] = node.value;
    });
    formData["text"]=$("textarea[name=text]").val();

    if($('#featured').is(":checked")){
        formData["featured"]=1;
    }
    else{
        formData["featured"]=0;
    }
    
    $.ajax({
        url: 'models/books/updateBook.php', 
        method: 'POST',
        data: {
            "id":id,
            "formData":formData,
        },
        success: function(data){
            if(Array.isArray(data)){
                errorsDiv(data);    
            }
            else{
                alert("Updated successfuly");
                $("#updateFormDiv").fadeOut();
                $("#errorsDiv").fadeOut();
                adminGetBooks();
            }
        }, 
        error: function(greska, status, statusText){
            console.error('GRESKA UPDATE');      
            console.log(greska); 
            
        }
    });
    
}

function adminInsertProduct(){

    let formData = {};
    $("#insertForm").find("input[name]").each(function (i,node) {
        formData[node.name] = node.value;
    });
    formData["text"]=$("textarea[name=text]").val();

    if($('#featured').is(":checked")){
        formData["featured"]=1;
    }
    else{
        formData["featured"]=0;
    }
    
    $.ajax({
        url: 'models/books/insertBook.php', 
        method: 'POST',
        data: {
            "formData":formData,
        },
        success: function(data){
            if(Array.isArray(data)){
                errorsDiv(data);    
            }
            else{
                adminGetBooks();
                alert("Inserted successfuly");
                $("#insertFormDiv").fadeOut();   
                $("#errorsDiv").fadeOut();      
            }
        }, 
        error: function(greska, status, statusText){
            console.error('ERROR INSERT');      
            console.log(greska); 
            
        }
    });
    
}

function regexInsert(){
    let formData = {};
    $("#insertForm").find("input[name]").each(function (i,node) {
        formData[node.name] = node.value;
    });
    formData["text"]=$("textarea[name=text]").val();

    let validate=true;
    let errors=[];

    if(formData["name"].length>30||formData["name"].length<2){
        validate=false;
        errors.push("Book name needs to be more then 2 and less then 30 characters");
    }

    let reAuthor=/^[a-z ,.'-]+$/i;
    if(!reAuthor.test(formData["author"])){
        validate=false;
        errors.push("Author name is in wrong format");
    }

    if(formData["text"].length>1000||formData["text"].length<20){
        validate=false;
        errors.push("Description needs to be more than 20 and less than 1000 characters");
    }

    let rePrice=/^([\d]{1,5})(\.[\d]{1,2})?$/;
    if(!rePrice.test(formData["price"])){
        validate=false;
        errors.push("Price can have have max 5 digits and 2 decimal places (biggest number:99999.99)");
    }

    let reStock=/^(?!(0))\d{1,4}$/;
    if(!reStock.test(formData["stock"])){
        validate=false;
        errors.push("Stock needs to be beetween 1 and 9999");
    }

    if(validate==false){
        errorsDiv(errors);
    }

    return validate;
    
}

function errorsDiv(arr){
    html="";
    arr.forEach(el => {
        html+="<p>"+el+"</p>";
    });
    $("#errorsDiv").html(html);
    $("#errorsDiv").fadeIn();
}



function regexUpdate(){
    let formData = {};
    $("#updateForm").find("input[name]").each(function (i,node) {
        formData[node.name] = node.value;
    });
    formData["text"]=$("textarea[name=text]").val();

    let validate=true;
    let errors=[];

    if(formData["name"].length>30||formData["name"].length<2){
        validate=false;
        errors.push("Book name needs to be more then 2 and less then 30 characters");
    }

    let reAuthor=/^[a-z ,.'-]+$/i;
    if(!reAuthor.test(formData["author"])){
        validate=false;
        errors.push("Author name is in wrong format");
    }

    if(formData["text"].length>1000||formData["text"].length<20){
        validate=false;
        errors.push("Description needs to be more than 20 and less than 1000 characters");
    }

    let rePrice=/^([\d]{1,5})(\.[\d]{1,2})?$/;
    if(!rePrice.test(formData["price"])){
        validate=false;
        errors.push("Price can have have max 5 digits and 2 decimal places (biggest number:99999.99)");
    }

    let reStock=/^(?!(0))\d{1,4}$/;
    if(!reStock.test(formData["stock"])){
        validate=false;
        errors.push("Stock needs to be beetween 1 and 9999");
    }

    let reImg=/^\w+.jpg$/;
    if(!reImg.test(formData["image"])){
        validate=false;
        errors.push("Image needs to be in jpg format");
    }

    if(validate==false){
       errorsDiv(errors);
    }

    return validate;
    
}

function adminDeleteProduct(id){
    $.ajax({
        url: 'models/books/deleteBook.php', 
        method: 'POST',
        data: {
            "id":id,
        },
        success: function(){
            adminGetBooks();
            alert("Product deleted successfuly");         
        }, 
        error: function(greska, status, statusText){
            console.error('ERROR INSERT');      
            console.log(greska); 
            
        }
    });
    
}

function exportToExcel(){

    var data = new Array();
    $('#logData tr').each(function(row, tr){
        data[row]={
            0 : $(tr).find('td:eq(0)').text()
            , 1 :$(tr).find('td:eq(1)').text()
            , 2 : $(tr).find('td:eq(2)').text()
        }
    }); 
    data.shift(); 
    data=JSON.stringify(data);

    $.ajax({
        url: 'models/log/export.php', 
        method: 'POST',
        data: {
            "data":data,
        },
        success: function(){
            //window.location.href="https://phpraktikum.000webhostapp.com//data/log.xls";
            console.log("Product exported successfuly");         
        }, 
        error: function(greska, status, statusText){
            console.error('ERROR EXPORT');      
            console.log(greska); 
            
        }
    });
}


