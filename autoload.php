<?php 
include("dbConfig.php");
include("rating.php");
$rating = new rating();
?>
<div class="row-product" style = "font-size:12pt">
        <?php 
        // Get products from database 
        $content_per_page = 10;	
        //$group_no  = strtolower(trim(str_replace("/","",$_REQUEST['group_no'])));
       // $start = ceil($group_no * $content_per_page);
        $sql= "SELECT DISTINCT * FROM books WHERE book_author = 'Tebogo C Moroka'";
        
        /*
        if(isset($_GET['size']) && $_GET['size']!="") :
            $size = explode(',',url_clean($_REQUEST['size']));	
            $sql.=" AND size IN ('".implode("','",$size)."')";
        endif;
        */
    
            $sql.=" LIMIT $content_per_page";
            $all_product=$db->query($sql);
        $rowcount=mysqli_num_rows($all_product);
            // echo $sql; exit;
        
        function url_clean($String)
        {
            return str_replace('_',' ',$String); 
        }
        if(isset($all_product) && count(array($all_product)) && $rowcount > 0) : $i = 0; 
        foreach ($all_product as $key => $products) : 
        ?>
        <div class="card col-md-4">
            <div class="card-body" >
                <h5 class="card-title"><a style="background-color:transparent;" href="book_information&action.php?book_id=<?php echo $products["book_id"]; ?>" class="btn btn-primary"><img src="images/<?php echo $products['book_cover']; ?>" align = "center" style = "border : 2px solid #444;"></a></h5>
                <p class="card-text"><?php echo $products["name"]; ?></p>
                <h6 class="card-subtitle"><b>Price: <?php echo 'R: '.$products["book_price"].' ZAR</b>'; ?></h6>
      <?php          
    echo '<div class = "ratings">';
    $book_list = $rating->get_book($products["book_id"]);
    foreach($book_list as $book){
    $average = $rating->get_rating_average($book["book_id"]);
?>		
<div><span class="average"><?php printf('%.1f', $average); ?> <small>/ 5</small></span> <span class="rating-reviews"><a href="show_rating.php?book_id=<?php echo $products["book_id"]; ?>">Rating & Reviews</a></span></div>	

<?php } ?>
<?php
$average_rating = round($average, 0);
for ($i = 1; $i <= 5; $i++) {
$rating_class = "btn-default btn-grey";
if($i <= $average_rating) {
    $rating_class = "btn-warning";
}
?>
<button style = "background-color:transparent;"  class="btn btn-sm <?php echo $rating_class; ?>" aria-label="Left Align">
<i class="fa fa-star"  aria-hidden="true"></i>
</button>	
<?php } ?>				
</div>
                <p class="card-text">Author:  <?php echo $products["book_author"]; ?></p>
                <h6 class="card-subtitle"><b>Price: <?php echo 'R: '.$products["book_price"].' ZAR</b>'; ?></h6>
               <div class="actionBtns">
                <a href="cartAction.php?action=addToCart&book_id=<?php echo $products["book_id"]; ?>" class="btn btn-primary"><i class=" fa fa-shopping-basket"></i></a>
                <a href = "book_information&action.php?book_id=<?php echo $products['book_id'];?>"  class="btn btn-primary"><i class = "fa fa-eye"></i></a>
               </div>
            </div>
        </div>
        <?php $i++; endforeach; ?> 
    </div>
    <?php endif; ?>
