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

        if($bookNumber<1){
            echo "<h3>You dont't have any products in cart yet</h3>";
        }



        for ($i=($_POST["pg"]-1)*3; $i <($_POST["pg"])*3 && $i<$bookNumber; $i++):?>                                    
        <tr>
            <td class="cart_product">
                <a href=""><img src="assets/images/books/<?=$books[$i]->image?>" alt=""></a>
            </td>
            <td class="cart_description">
                <h4><a href=""><?=$books[$i]->name?></a></h4>
                <p><?=$books[$i]->Author?></p>
            </td>
            <td class="cart_price">
                <p>$<?=$books[$i]->price?></p>
            </td>
            <td class="cart_price">      
                <p><?=$books[$i]->quantity?></p>       
            </td>
            <td class="cart_total">
                <p class="cart_total_price">$<?=$books[$i]->price*$books[$i]->quantity?></p>
            </td>
            <td class="cart_delete">
                <a data-id="<?=$books[$i]->id?>" class="cart_quantity_delete" href=""><i class="fa fa-times"></i></a>
            </td>
        </tr>
                                                 
        <?php endfor;?>

        

</div>
    <ul class="pagination">
       
        <?php
            $html="";
            for($i=1;$i<=ceil($bookNumber/3);$i++){
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

