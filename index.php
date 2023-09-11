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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="styles/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/style.css">
    <script src="js/jquery-3.6.4.min.js"></script>
    <title>TCM Books</title>
</head>
<body>
<style>
input[type=text], form textarea, input[type=telephone],  input[type=email] {
  width: 70%;
  padding: 12px 40px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
   display: block;
    margin-left: auto;
    margin-right: auto;
}
/* Style the submit button */
input[type=submit] {
  width: 70%;
  background-color: black;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
   display: block;
    margin-left: auto;
    margin-right: auto;
	padding : 20px;
}

/* Add a background color to the submit button on mouse-over */
input[type=submit]:hover {
  opacity: 0.5;
}

</style>
<script>
    $(document).ready(function(){
    $(".hamburger").click(function(){
        $(".menu").toggle();
    });

});
</script>
<?php 
if($loggedIn){
    echo  '<div class="topnav">';
    echo       '<div class="cart-view" style = "left:0px;">';
    echo      '<a href="login.php" title="'.$user.'"><i class="fa fa-user" aria-hidden="true" style="font-size:30px;color:#f1f1ff"></i>&nbsp;&#x2714;</a>';?>
           <a href="viewCart.php" title="View Cart"><i class="fa fa-shopping-cart" aria-hidden="true" style="margin-left:2px;"></i><span class="badge badge-secondary badge-pill"> <?php echo ($cart->total_items() > 0)?$cart->total_items().'':'0'; ?></span></a>
           <?php
    echo   '</div>';
    echo            '<a class = "hamburger" href="javascript:void(0)"><i class = "fa fa-bars"></i></a>';
    echo       '<div class="menu">';
    echo           '<a href="index.php"><i style="font-size: 30px;" class ="fa fa-home" aria-hidden="true"></i> Home </a>';
    echo           '<a href="logout.php">Logout </a>';
    echo          '<a href="catalouge.php">Book Catalouge</a>';
    echo       '</div>';
    echo   '</div>';

}
else{
  
    echo  '<div class="topnav">';
    echo       '<div class="cart-view" style = "left:0px;">';
    echo      '<a href="login.php" title="login"><i class="fa fa-user" aria-hidden="true" style="font-size:30px;color:#f1f1ff;"></i></a>';?>
           <a href="viewCart.php" title="View Cart"><i class="fa fa-shopping-cart" aria-hidden="true" style="margin-left:2px;"></i><span class="badge badge-secondary badge-pill"> <?php echo ($cart->total_items() > 0)?$cart->total_items().'':'0'; ?></span></a>
           <?php
    echo   '</div>';
    echo            '<a class="hamburger" href="javascript:void(0)"  id = "bars"><i class = "fa fa-bars"></i>h</a>';
    echo       '<div class="menu">';
    echo           '<a href="index.php"><i style="font-size: 30px;" class ="fa fa-home" aria-hidden="true"></i> Home </a>';
    echo           '<a href="login.php">Login </a>';
    echo          '<a href="catalouge.php">Book Catalouge</a>';
    echo       '</div>';
    echo   '</div>';

}
?>
    <div class="header">
        <div class="headerBackground">
            <div class="headerText" style = "background-color:rgb(0,0,0,0.3);position:relative;">
                <h1 >TCM Books;</h1>
                <h1 >A Library Of Wisdom, Knowledge And Advice From Prolific Author</h1>
                <h3 >~ Tebogo C Moroka</h3>
            </div>
        </div>
    </div>
    
<div class="bodyContent">
    
<div class="register-form">
<h3 align="center"><b>ABOUT THE AUTHOR</b> </h3>
<img src="images/line3.png" alt="underline" style = "margin-left:28%; width:45%; margin-top: -30px;"><br>
<p style = "font-weight:600;">Tebogo Colin Moroka is a director of a publishing company; Be My 
Word Publishers, a founder of the NPO; Big Brothers United and an 
author of the best selling MY ANCESTOR IS ALIVE, EXODUS and 
HATED FROM THE WOMB ; just to mention a few of his  self 
published books. </p>
    </div>
<br>

 <div class="separator text-center" ><span class="word2" style = "border: 2px solid #555555;padding :10px;">Promotional</span></div>
<br>
    

    <div class="row-product" style="border-radius:25px; padding:40px;background-color: #9f461d; background-image: url('images/l2.png'); background-repeat:repeat x; width:90%; margin:auto; border:2px solid #d8d8e5;" >
<h4 align = "center" style ="position:absolute; margin-top:-20px; color:#f1f1ff;"><u>Special Ends Last Day Of December</u></h4>
        <?php 
        // Get products from database 
        $result = $db->query("SELECT * FROM books WHERE book_author = 'Promotional' ORDER BY book_id "); 
        if($result->num_rows > 0){  
            while($row = $result->fetch_assoc()){ 
        ?>
        <div class="card col-lg-12" style="background-color:rgba(255,255,255,0.1); ">
            <div class="card-body">
                <h5 class="card-title"><a  href="book_information&action.php?book_id=<?php echo $row["book_id"]; ?>"><img src="images/<?php echo $row['book_cover']; ?>" align = "center" style = "border : 2px solid #444;"></a></h5>
                <p class="card-text" style = "color:#f1f1ff;"><b><?php echo $row["book_title"]; ?></b></p>
                <p class="card-text" style = "color:#f1f1ff;"><s><?php echo $row["book_description"]; ?></s></p>
                <h6 class="card-subtitle" style = "color:#f1f1ff;"><b>Price: <?php echo 'R: '.$row["book_price"].' ZAR</b>'; ?></h6>
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
<br>
    <h2 style="text-align:center;">This Week's Picks</h2>
<img src="images/line3.png" alt="underline" style = "margin-left:35%; width:30%; margin-top: -30px;"><br>

</div>
<div class="row-product" style = "font-size:12pt">
        <?php 
        // Get products from database 
        $content_per_page = 4;	
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
                <p class="card-text"><?php echo $products["book_title"]; ?></p>
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
<br>
<div class="center" style="text-align:center;">
               <a align="center" href = "catalouge.php"  class="btn btn-primary" >View More >></a>
            </div>

               
<div class="container-fluid text-center" id = "Contact">

 <div class="separator text-center" ><span class="word2" style = "border: 2px solid #555555;padding :10px;">Bookings</span></div>
<br>
    <h3>Call or E-mail</h3>
call or Whatsapp : 076 071 6664 <br/> Email : tebogomoroka@yahoo.com<h1>OR</h1>
</div>

<div class = "containerForm">
<form method = "post" action="Send_mail.php">
<h4 align = "center" >Email Us and we will get back to you within 24hrs</h4>
  
  <input  type="text" id="name" name="name" placeholder="name " required = "required">

  <input type="email" id="email" name="email" placeholder="Email address" >
  <input  type="telephone" id="telephone" name="telephone" placeholder="Contact Number " required = "required">

    <textarea  name="comment" placeholder = "comment" required = "required" ></textarea>
    <input type="submit" value="Submit" id = "submit">
</form>	
</div>
<br><br>
</body>
</html>
