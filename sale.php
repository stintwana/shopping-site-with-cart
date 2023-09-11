<?php 
session_start();
include('rating.php');
// Initialize shopping cart class 
include_once 'Cart.class.php'; 
$cart = new Cart; 
$rating = new rating();
 
// Include the database config file 
require_once 'dbConfig.php'; 

if(isset($_GET['book_code'])){
    $view= sanitizeString($_GET['book_code']);
}
?>
<?php 
require_once "header.php";

?>

<br><br><br><br><br>

<hr width="50%"/>
    <h2 style="text-align:center;"><i class = "fa fa-star"></i> Sales And Combos <i class = "fa fa-star"></i></h2>
    <hr width="50%"/>
<div class="row-product">
        <?php 
        // Get products from database 
        $result = $db->query("SELECT * FROM books WHERE book_author = 'combos' OR book_author = 'promotional' ORDER BY book_id DESC"); 
        if($result->num_rows > 0){  
            while($row = $result->fetch_assoc()){ 
        ?>
        <div class="card col-md-4">
            <div class="card-body" >
                <h5 class="card-title"><a style="background-color:transparent;" href="book_information&action.php?book_id=<?php echo $row["book_id"]; ?>"><img src="images/<?php echo $row['book_cover']; ?>" align = "center" style = "border : 2px solid #444;"></a></h5>
                <p class="card-text"><b><?php echo $row["book_title"]; ?></b></p>
                <h6 class="card-subtitle"><b>Price: <?php echo 'R: '.$row["book_price"].' ZAR</b>'; ?></h6>
      <?php          
    echo '<div class = "ratings">';
    $book_list = $rating->get_book($row["book_id"]);
    foreach($book_list as $book){
    $average = $rating->get_rating_average($book["book_id"]);
?>		
    <div><span class="average"><?php printf('%.1f', $average); ?> <small>/ 5</small></span> <span class="rating-reviews">Rating</span></div>	

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
                <h6 class="card-subtitle"><b>Price: <?php echo 'R: '.$row["book_price"].' ZAR</b>'; ?></h6>
               <div class="actionBtns">
                <a href="cartAction.php?action=addToCart&book_id=<?php echo $row["book_id"]; ?>" class="btn btn-primary"><i class=" fa fa-shopping-basket"></i></a>
                <a href = "book_information&action.php?book_id=<?php echo $row['book_id'];?>"  class="btn btn-primary"><i class = "fa fa-eye"></i></a>
               </div>
            </div>
        </div>
        <?php } }else{ ?>
        <p>Nothing to show yet, come back soon.....</p>
        <?php } ?>
    </div><br>