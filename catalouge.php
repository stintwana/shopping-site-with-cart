<?php
// Initialize shopping cart class
include_once 'Cart.class.php';
$cart = new Cart;
 require_once 'header.php';
 ?>
</div>
</div>
</div>
<br/><br/><br/><br/><br/><br/>


<hr width="50%"/>
    <h2 style="text-align:center;">The Full Catalouge</h2>
    <hr width="50%"/>
</div>
<div class="row-product">
        <?php 
        // Get products from database 
        $result = $db->query("SELECT * FROM books WHERE book_author = 'Tebogo C moroka' ORDER BY book_id"); 
        if($result->num_rows > 0){  
            while($row = $result->fetch_assoc()){ 
        ?>
        <div class="card col-md-4">
            <div class="card-body" >
                <h5 class="card-title"><a style="background-color:transparent;" href="book_information&action.php?book_id=<?php echo $row["book_id"]; ?>" class="btn btn-primary"><img src="images/<?php echo $row['book_cover']; ?>" align = "center" style = "border : 2px solid #444;"></a></h5>
                <p class="card-text"><b><?php echo $row["book_title"]; ?></b></p>
                <p class="card-text">Author:  <?php echo $row["book_author"]; ?></p>
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
    </div>