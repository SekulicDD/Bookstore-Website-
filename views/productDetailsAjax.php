<?php 
    session_start();

    if(isset($_POST["book"])){
        $book =$_POST["book"];
        $_SESSION["book"]=$_POST["book"];
    }
    
    else{
        $book=$_SESSION["book"];
    }

    $book=json_decode($book);
    
?>

    <div class="product-details"><!--product-details-->
        <div class="col-sm-4">
            <div class="view-product">
                <img src="assets/images/books/<?=$book->image?>" alt="" />								
            </div>
            
        </div>
        <div class="col-sm-8">
            <div class="product-information"><!--/product-information-->          
                <h2><?=$book->name?></h2>
                <p><?=$book->Author?></p>              
                <span>
                    <span>$<?=$book->price?></span>
                    <label><?=$book->inStock?></label>
                    <input type="text" value="1" />
                    <button type="button" class="btn btn-fefault cart">
                        <i class="fa fa-shopping-cart"></i>
                        Add to cart
                    </button>
                </span>
                <p><b>Availability:</b> In Stock</p>
                <p><b>Condition:</b> New</p>           
            </div><!--/product-information-->
        </div>
        
    </div><!--/product-details-->
    
    <div class="category-tab shop-details-tab"><!--category-tab-->
        
        <div class="tab-content">
                                
            <div class="tab-pane fade active in" id="reviews" >
                <div class="col-sm-12">
                    
                    <p><?=$book->text?></p>
              
                </div>
            </div>
            
        </div>
    </div><!--/category-tab-->
