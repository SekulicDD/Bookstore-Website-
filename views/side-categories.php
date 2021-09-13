<section>
<div class="container">
<div class="row">
<div class="col-sm-3">
    <div class="left-sidebar">
        <h2>Category</h2>
        <div class="panel-group category-products" id="accordian">

            <?php 
            require_once "models/categories/functions.php";
            $categories=getCategories();
            foreach($categories as $cat):?>              
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title"><a id="cat<?=$cat->id?>" class="categoryLink" data-id="<?=$cat->id?>" href="#"><?=$cat->name?></a></h4>
                    </div>
                </div>
            <?php endforeach;?>
           
        </div>
        <div class="brands_products">
            <h2>Order</h2>
            <div class="brands-name">
                <div class="control-group">
                    <label class="control-label alignL">Sort By </label>
                
                    <select id="sortBy">
                        <option value=1 <?php ?>  >Product name A - Z</option>
                        <option value=2 <?php  ?> >Product name Z - A</option>    
                        <option value=3 <?php  ?> >Price Lowest first</option>
                        <option value=4 <?php ?> >Price Highest first</option>
                    </select>
                </div>
            </div>
        </div> 

    </div>
</div>

