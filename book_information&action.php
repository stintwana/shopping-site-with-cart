<?php
session_start();
require_once 'header.php'; 
include 'rating.php';
// Initialize shopping cart class 
include_once 'Cart.class.php'; 
$cart = new Cart; 
// Include the database config file 
require_once 'dbConfig.php'; 
echo "<br/><br/><br/>";
if(isset($_GET['book_id'])){ 
    $view= sanitizeString($_GET['book_id']);
    
    echo "<div class = 'book-information-container'>";
    echo "<div class = 'book-information-content'>";
show_book($view);


?>

<div id="ratingSection" style="display:none;">
		<div class="row">
			<div class="col-md-12">
				<form id="ratingForm" method="POST">					
					<div class="form-group">
						<h4>Rate this book</h4>
						<button type="button" class="btn btn-warning btn-sm rateButton" style="background-color:transparent;" aria-label="Left Align">
						  <i class="fa fa-star" aria-hidden="true"></i>
						</button>
						<button type="button" class="btn btn-default btn-grey btn-sm rateButton"  style="background-color:transparent;" aria-label="Left Align">
						  <i class="fa fa-star" aria-hidden="true"></i>
						</button>
						<button type="button" class="btn btn-default btn-grey btn-sm rateButton" style="background-color:transparent;"  aria-label="Left Align">
						  <i class="fa fa-star" aria-hidden="true"></i>
						</button>
						<button type="button" class="btn btn-default btn-grey btn-sm rateButton" style="background-color:transparent;"  aria-label="Left Align">
						  <i class="fa fa-star" aria-hidden="true"></i>
						</button>
						<button type="button" class="btn btn-default btn-grey btn-sm rateButton"  style="background-color:transparent;" aria-label="Left Align">
						  <i class="fa fa-star" aria-hidden="true"></i>
						</button>
						<input type="hidden" class="form-control" id="book_id" name="book_id" value="<?php echo $_GET['book_id'] ?>">
						<input type="hidden" class="form-control" id="rating" name="rating" value="1">
						<input type="hidden" class="form-control" id="user_token" name="user_token" value=" <?php $_SESSION['user_token'] ?>">
						<input type="hidden" name="action" value="save_rating">
					</div>		
					<div class="form-group">
						<label for="usr">Title*</label>
						<input type="text" class="form-control" id="title" name="title" required>
					</div>
					<div class="form-group">
						<label for="comment">Comment*</label>
						<textarea class="form-control" rows="5" id="comment" name="comment" required></textarea>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-info" id="saveReview">Save Review</button> <button type="button" class="btn btn-info" id="cancelReview">Cancel</button>
					</div>			
				</form>
			</div>
		</div>		
	</div>
</div>
</div>



	<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
				<div class="modal-content">
			<div class="loginmodal-container">
				<h1 class="modal-title">Login to rate this product</h1><br>
				<div style="display:none;" id="loginError" class="alert alert-danger">Invalid username/Password</div>
<form method = "post" action = "login.php"><?php $error ?>
<h1 align = 'center '>Login</h1>
<h2>Please enter login details</h2>
<input type = "text" name = 'user' value = '<?php $user ?>' placeholder='username'/><br/><br/>

<input type = "password" name = 'pass' value = '<?php $pass ?>'  placeholder='password'/><br>
<div data-role='fieldcontain'>
<input  type = "submit" value = "Submit" class='btn-submit'><br/>


</div>

				<div class="login-help">					
					<p>Not yet member? <a href="register.php">Click here to register</a></p>
				</div>
			</div>
		</div>
		</div>
	</div>

<?php } ?>