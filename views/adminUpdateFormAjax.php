
    <?php      
        $book =$_POST["book"];   
        $book=json_decode($book);
    ?>

    <label>Name:</label><input type="text" name="name" value="<?=$book->name?>"/>
    <label>Author:</label><input type="text" name="author" value="<?=$book->Author?>"/>
    <label>Price:</label><input type="number" name="price" value="<?=$book->price?>"/><br/>

    <label>In Stock:</label> <input type="number" name="stock" value="<?=$book->inStock?>"/>
    <label>Image:</label><input type="text" name="image" value="<?=$book->image?>"/>
    <label>Featured:</label><input type="checkbox" name="featured" id="featured" <?php if($book->isFeatured==1){
        echo "checked";
    } ?>><br/>
 
    <label>Details:</label>
    <textarea name="text" rows=6 cols=10><?=$book->text?></textarea>
    <input type="button" id="submitUpdate" data-id="<?=$book->id?>" name="submitUpdate" value="Save"/>
    


       



