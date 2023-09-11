<?php

$dbHost     = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName     = "tcm_books";

// Create database connection
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);


// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}


$userstr = '(Guest)';

if(isset($_SESSION['user_token'])){
        $user_token = $_SESSION['user_token'];
        $user = $_SESSION['user'];
        $loggedIn = TRUE;
        $userstr = "Logged In: $user";
    }
    else {
        $loggedIn = FALSE;
    }


Function sanitizeString($var){
global $db;
$var = strip_tags($var);
$var = htmlentities($var);
$var = stripslashes($var);
return $db->real_escape_string($var);
}

//Called To Send Queries To Any Table
Function queryMysql($query){
    global $db;
    $result = $db -> query($query);
    if(!$result) die($db->connect_error);
    return $result;
}

Function show_book($view){
$rating = new rating();

    $sql = queryMysql("SELECT * FROM books WHERE book_id = '$view'");
    if($sql->num_rows){
        $row = $sql->fetch_array(MYSQLI_ASSOC);
        echo "<img style = 'width:200px; height:300px;' src = 'images/".$row['book_cover']."'/>"."<br/>";?>
     
<?php
        echo "<h5><b>".$row['book_title']."</b></h5>";
        echo "<h6>".$row['book_author']."</h6>";   
        ?>
<?php
echo '<div class = "ratings">';
$book_list = $rating->get_book($view);
foreach($book_list as $book){
    $average = $rating->get_rating_average($book["book_id"]);
?>		
    <div><span class="average"><?php printf('%.1f', $average); ?> <small>/ 5</small></span> <span class="rating-reviews">Rating</span></div>	

<?php } ?>
<br/>
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
</div><br/>
<?php
        echo "<h4>"."<b>"."R".$row['book_price']."</b>"."</h4>";  ?>
        <a href="cartAction.php?action=addToCart&book_id=<?php echo $row["book_id"]; ?>" class="btn btn-primary">Add To Basket <i class=" fa fa-shopping-basket"></i></a><br/>
        <?php
        echo "<br/><h2 style = 'text-align:center; background-color:#9f1d35; color:#f1f1ff;'>information</h2>";
        echo "<p>".$row['book_description']."</p>";
      
        echo "<br/><h2 style = 'text-align:center; background-color:#9f1d35; color:#f1f1ff;'>Ratings And Reviews</h2>";
        
	$rating = new rating();
	$book_details = $rating->get_book($view);
	foreach($book_details as $book){
		$average = $rating->get_rating_average($book["book_id"]);
	?>	

	<div class=''></div>

	<?php } ?>	

	<?php	
	$book_rating = $rating->get_book_rating($view);	
	$rating_number = 0;
	$count = 0;
	$five_star_rating = 0;
	$four_star_rating = 0;
	$three_star_rating = 0;
	$two_star_rating = 0;
	$one_star_rating = 0;	
	foreach($book_rating as $rate){
		$rating_number+= $rate['book_rating_number'];
		$count += 1;
		if($rate['book_rating_number'] == 5) {
			$five_star_rating +=1;
		} else if($rate['book_rating_number'] == 4) {
			$four_star_rating +=1;
		} else if($rate['book_rating_number'] == 3) {
			$three_star_rating +=1;
		} else if($rate['book_rating_number'] == 2) {
			$two_star_rating +=1;
		} else if($rate['book_rating_number'] == 1) {
			$one_star_rating +=1;
		}
	}
	$average = 0;
	if($rating_number && $count) {
		$average = $rating_number/$count;
	}	
	?>		
	<br>		
	<div id="ratingDetails"> 		
		<div class="row">			
			<div class="col-md-7">				
				<h4>Rating and Reviews</h4>
				<h2 class="bold padding-bottom-7"><?php printf('%.1f', $average); ?> <small>/ 5</small></h2>				
				<?php
				$average_rating = round($average, 0);
				for ($i = 1; $i <= 5; $i++) {
					$rating_class = "btn-default btn-grey";
					if($i <= $average_rating) {
						$rating_class = "btn-warning";
					}
				?>
				<button  style="background-color:transparent;" class="btn btn-sm <?php echo $rating_class; ?>" aria-label="Left Align">
				  <i class="fa fa-star" aria-hidden="true"></i>
				</button>	
				<?php } ?>				
			</div>
			<div class="col-md-5">
				<?php
				$five_star_rating_percent = round(($five_star_rating/5)*100);
				$five_star_rating_percent = !empty($five_star_rating_percent)?$five_star_rating_percent.'%':'0%';	
				
				$four_star_rating_percent = round(($four_star_rating/5)*100);
				$four_star_rating_percent = !empty($four_star_rating_percent)?$four_star_rating_percent.'%':'0%';
				
				$three_star_rating_percent = round(($three_star_rating/5)*100);
				$three_star_rating_percent = !empty($three_star_rating_percent)?$three_star_rating_percent.'%':'0%';
				
				$two_star_rating_percent = round(($two_star_rating/5)*100);
				$two_star_rating_percent = !empty($two_star_rating_percent)?$two_star_rating_percent.'%':'0%';
				
				$one_star_rating_percent = round(($one_star_rating/5)*100);
				$one_star_rating_percent = !empty($one_star_rating_percent)?$one_star_rating_percent.'%':'0%';
				
				?>
				<div class="pull-left">
					<div class="pull-left" style="width:35px; line-height:1;">
						<div style="height:9px; margin:5px 0;">5 <i class="fa fa-star"></i></div>
					</div>
					<div class="pull-left" style="width:180px;">
						<div class="progress" style="height:9px; margin:8px 0;">
						  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="5" style="width: <?php echo $five_star_rating_percent; ?>">
							<span class="sr-only"><?php echo $five_star_rating_percent; ?></span>
						  </div>
						</div>
					</div>
					<div class="pull-right" style="margin-left:10px;"><?php echo $five_star_rating; ?></div>
				</div>
				
				<div class="pull-left">
					<div class="pull-left" style="width:35px; line-height:1;">
						<div style="height:9px; margin:5px 0;">4 <i class="fa fa-star"></i></div>
					</div>
					<div class="pull-left" style="width:180px;">
						<div class="progress" style="height:9px; margin:8px 0;">
						  <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="4" aria-valuemin="0" aria-valuemax="5" style="width: <?php echo $four_star_rating_percent; ?>">
							<span class="sr-only"><?php echo $four_star_rating_percent; ?></span>
						  </div>
						</div>
					</div>
					<div class="pull-right" style="margin-left:10px;"><?php echo $four_star_rating; ?></div>
				</div>
				<div class="pull-left">
					<div class="pull-left" style="width:35px; line-height:1;">
						<div style="height:9px; margin:5px 0;">3 <i class="fa fa-star"></i></div>
					</div>
					<div class="pull-left" style="width:180px;">
						<div class="progress" style="height:9px; margin:8px 0;">
						  <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="3" aria-valuemin="0" aria-valuemax="5" style="width: <?php echo $three_star_rating_percent; ?>">
							<span class="sr-only"><?php echo $three_star_rating_percent; ?></span>
						  </div>
						</div>
					</div>
					<div class="pull-right" style="margin-left:10px;"><?php echo $three_star_rating; ?></div>
				</div>
				<div class="pull-left">
					<div class="pull-left" style="width:35px; line-height:1;">
						<div style="height:9px; margin:5px 0;">2 <i class="fa fa-star"></i></div>
					</div>
					<div class="pull-left" style="width:180px;">
						<div class="progress" style="height:9px; margin:8px 0;">
						  <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="5" style="width: <?php echo $two_star_rating_percent; ?>">
							<span class="sr-only"><?php echo $two_star_rating_percent; ?></span>
						  </div>
						</div>
					</div>
					<div class="pull-right" style="margin-left:10px;"><?php echo $two_star_rating; ?></div>
				</div>
				<div class="pull-left">
					<div class="pull-left" style="width:35px; line-height:1;">
						<div style="height:9px; margin:5px 0;">1 <i class="fa fa-star"></i></div>
					</div>
					<div class="pull-left" style="width:180px;">
						<div class="progress" style="height:9px; margin:8px 0;">
						  <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="5" style="width: <?php echo $one_star_rating_percent; ?>">
							<span class="sr-only"><?php echo $one_star_rating_percent; ?></span>
						  </div>
						</div>
					</div>
					<div class="pull-right" style="margin-left:10px;"><?php echo $one_star_rating; ?></div>
				</div>
			</div>		
			<div class="col-md-5">
				<button type="button" id="rateProduct" class="btn btn-info <?php if(!empty($_SESSION['user_token']) && $_SESSION['user_token']){ echo 'login';} ?>">Rate this book</button>
			</div>		
		</div>
		<div class="row">
			<div class="col-lg-12">
				<hr/>
				<div class="review-block">		
				<?php
				$book_rating = $rating->get_book_rating($view);
				foreach($book_rating as $rating){				
					$date=date_create($rating['created']);
					$review_date = date_format($date,"M d, Y");						
				?>				
					<div class="row">
						<div class="col-md-5">
							<img src="images/user.png" style ="width:60px; height:60px;" class="img-rounded user-pic">
							<div class="review-block-name">By <a href="#"><?php echo $rating['user']; ?></a></div>
							<div class="review-block-date"><?php echo $review_date; ?></div>
						</div>
						<div class="col-md-5">
							<div class="review-block-rate">
								<?php
								for ($i = 1; $i <= 5; $i++) {
									$rating_class = "btn-default btn-grey";
									if($i <= $rating['book_rating_number']) {
										$rating_class = "btn-warning";
									}
								?>
								<button type="button" style = "background-color:transparent;" class="btn btn-xs <?php echo $rating_class; ?>" aria-label="Left Align">
								  <i class="fa fa-star" aria-hidden="true"></i>
								</button>								
								<?php } ?>
							</div>
							<div class="review-block-title"><?php echo $rating['title']; ?></div>
							<div class="review-block-description"><?php echo $rating['comment']; ?></div>
						</div>
					</div>
					<hr/>					
				<?php } ?>
				</div>
			</div>
		</div>	
	</div>




<?php
    
    }
    
}

?>

