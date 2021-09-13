<div class="col-sm-12">
    <div class="features_items"><!--features_items-->
        <h2 class="title text-center">Features Items</h2>
        <div class="col-sm-1">
        </div>
        <?php 

            require_once "models/books/functions.php";
            $books=getFeaturedBooks();
            for ($i=0; $i <5; $i++): ?>
       
            <div class="col-sm-2 productCss">
                <div class="product-image-wrapper">
                    <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="assets/images/books/<?=$books[$i]->image?>" alt="" />
                                <h2>$<?=$books[$i]->price?></h2>
                                <p><?=$books[$i]->name?></p>
                                <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                            </div>
                            <div class="product-overlay">
                                <div class="overlay-content">
                                    <a href="#" class="productDetails" data-id="<?=$books[$i]->id?>">
                                        <h1><i class="fas fa-info-circle"></i></h1>
                                        <p>Details</p>   
                                    </a>
                                    <h2>$<?=$books[$i]->price?></h2>
                                    <p><?=$books[$i]->name?></p>
                                    <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                </div>
                            </div>
                    </div>
                    
                </div>
            </div>                
        <?php endfor;?>

    </div><!--features_items-->

</div>
</div>
</section>