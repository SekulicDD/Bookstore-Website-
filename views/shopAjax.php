<?php session_start();?>
<div class="features_items">	

    <?php   
        
        if(isset($_POST["books"])){
            $books =$_POST["books"];
            $_SESSION["books"]=$_POST["books"];
        }
        
        else{          
            $books=$_SESSION["books"];
        }

        $books=json_decode($books);
        $books=(array)($books);

        $bookNumber = count($books);

        $orderNum=$_POST["order"];

        switch ($orderNum) {                                    
            case 2:
                usort($books, function($a, $b)
                {
                    return strcmp($b->name, $a->name);
                });
                break;
            case 3:
                usort($books, function($a, $b)
                {
                    return $a->price > $b->price;
                });
                break;
            case 4:
                usort($books, function($a, $b)
                {
                    return $b->price > $a->price;
                });
                break;
            default:
                usort($books, function($a, $b)
                {
                    return strcmp($a->name, $b->name);
                });
            break;
        }

        for ($i=($_POST["pg"]-1)*8; $i <($_POST["pg"])*8 && $i<$bookNumber; $i++):?>                                    
            <div class="col-sm-3 productCss">
                <div class="product-image-wrapper productBox">
                    <div class="single-products">
                        <div id="bookDiv" class="productinfo text-center productText">
                            <img src="assets/images/books/<?=$books[$i]->image?>" alt="" />
                            <h2>$<?=$books[$i]->price?></h2>
                            <p><?=$books[$i]->name?></p>
                            <a href="#" data-id="<?=$books[$i]->id ?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                        </div>
                        <div class="product-overlay">
                            <div class="overlay-content">
                                <a href="#" class="productDetails" data-id="<?=$books[$i]->id?>">
                                    <h1><i class="fas fa-info-circle"></i></h1>
                                    <p>Details</p>   
                                </a>
                                <h2>$<?=$books[$i]->price?></h2>
                                <p><?=$books[$i]->name?></p>
                                <a href="#" data-id="<?=$books[$i]->id ?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                            </div>
                        </div>									
                    </div>                  
                </div>
            </div>
                                                 
        <?php endfor;?>

        

</div>
    <ul class="pagination">
       
        <?php
            $html="";
            for($i=1;$i<=ceil($bookNumber/8);$i++){
                if($i==$_POST["pg"]){
                  $html.='<li><a class="pages active" href="">'.$i.'</a></li>';
                }
                else{
                  $html.='<li><a class="pages" href="">'.$i.'</a></li>';
                }
                
            }
            echo $html;        
        ?>	
    </ul>
</section>

