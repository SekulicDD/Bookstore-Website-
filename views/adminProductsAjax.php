<?php session_start();?>
	

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

      ?>
    <table id="adminProductTable">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Author</th>
            <th>Details</th>
            <th>Price</th>
            <th>In Stock</th> 
            <th>Image</th> 
            <th>Featured</th>      
        </tr>


        <?php for ($i=($_POST["pg"]-1)*10; $i <($_POST["pg"])*10 && $i<$bookNumber; $i++):?>  
            <tr data-id="<?=$books[$i]->id?>" class="adminProductRow"><td><?=$books[$i]->id?></td>
            <td><?=$books[$i]->name?></td>
            <td><?=$books[$i]->Author?></td>
            <td><?=substr($books[$i]->text,0,30)?>...</td>
            <td>$<?=$books[$i]->price?></td>
            <td><?=$books[$i]->inStock?></td>
            <td><?=$books[$i]->image?></td>
            <td><?=$books[$i]->isFeatured?></td></tr>
                                                 
        <?php endfor;?>

    </table>
       
    <ul class="pagination">
       
        <?php
            $html="";
            for($i=1;$i<=ceil($bookNumber/10);$i++){
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

