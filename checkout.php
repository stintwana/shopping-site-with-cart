<?php
// Include the database config file
require_once 'header.php';
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

// If the cart is empty, redirect to the products page
if($cart->total_items() <= 0){
    header("Location: index.php");
}

// Get posted data from session
$postData = !empty($_SESSION['postData'])?$_SESSION['postData']:array();
unset($_SESSION['postData']);

// Get status message from session
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';
if(!empty($sessData['status']['msg'])){
    $statusMsg = $sessData['status']['msg'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}
?>

<br/><br/><br/><br/>
<div class="container">
	<h2>CHECKOUT</h2>
	<div class="col-12">
		<div class="checkout">
			<div class="row">
				<?php if(!empty($statusMsg) && ($statusMsgType == 'success')){ ?>
				<div class="col-md-12">
					<div class="alert alert-success"><?php echo $statusMsg; ?></div>
				</div>
				<?php }elseif(!empty($statusMsg) && ($statusMsgType == 'error')){ ?>
				<div class="col-md-12">
					<div class="alert alert-danger"><?php echo $statusMsg; ?></div>
				</div>
				<?php } ?>
				
				<div class="col-md-4 order-md-2 mb-4">
					<h4 class="d-flex justify-content-between align-items-center mb-3">
						<span class="text-muted">Your Cart</span>
						<span class="badge badge-secondary badge-pill"><?php echo $cart->total_items(); ?></span>
					</h4>
					<ul class="list-group mb-3">
                        <?php
                        if($cart->total_items() > 0){
                            //get cart items from session
                            $cartItems = $cart->contents();
                            foreach($cartItems as $item){
                        ?>
						<li class="list-group-item d-flex justify-content-between lh-condensed">
						  <div>
							<h6 class="my-0"><img src="images/<?php echo $item["book_cover"]; ?>"width="60" height="60" align = "center" style = "border : 1px solid black;"?><p class="card-text"><?php echo $item["book_title"]; ?></p></h6>
							<small class="text-muted"><?php echo 'R'.$item["book_price"]; ?>(<?php echo $item["qty"]; ?>)</small>
						  </div>
						  <span class="text-muted"><?php echo 'R'.$item["subtotal"]; ?></span>
						</li>
						
						<?php } } ?>
						<li class="list-group-item d-flex justify-content-between">
						  <span>Courier fee</span>
						  <strong>R100</strong>
						</li>
						<li class="list-group-item d-flex justify-content-between">
						  <span>Total (ZAR)</span>
						  <strong><?php echo 'R'.$cart->total(); ?></strong>
						</li>
					</ul>
					<a href="index.php" class="btn btn-block btn-info" style  = "background-color:Black !important;">Add Items</a>
				</div>
				<div class="col-md-8 order-md-1">
				
					<h4 class="mb-3">Contact Details</h4>
				<?//Merchant Details?>
          	<!-- <form method="post" action="https://sandbox.payfast.co.za/eng/process">		
          -->
          <form method="post" action="cartAction.php">
		 
			  <!--		
                    <input type="hidden" name="merchant_id" value="18599223">
					<input type="hidden" name="merchant_key" value="ox2pstfjh75qo">
					<input type="hidden" name="return_url" value = "https://tcmbooks.co.za/orderSuccess.php">
					<input type="hidden" name="notify_url" value = "https://tcmbooks.co.za/cartAction.php">
					
					
					//Transaction Details
					<input type="hidden" name="m_payment_id" value = "">
					<input type="hidden" name="item_name" value="Product(s) Total">
					<input type="hidden" name="amount" value="">
				
					
					//Payment Methods
					<input type="hidden" name="payment_method" value = "dc">
					<input type="hidden" name="payment_method" value = "eft">
					<input type="hidden" name="payment_method" value = "cc">
					<input type="hidden" name="email_confirmation" value = "1">
					<input type="hidden" name="confirmation_address" value = "tebogomoroka@yahoo.com">
		  -->
						<div class="row">
							<div class="col-md-6 mb-3">
							
							  <label for="name_first">First Name</label>
							  <input type="text" class="form-control" name="name_first" value="<?php echo !empty($postData['first_name'])?$postData['first_name']:''; ?>" required>
							</div>
							<div class="col-md-6 mb-3">
							  <label for="name_last">Last Name</label>
							  <input type="text" class="form-control" name="name_last" value="<?php echo !empty($postData['last_name'])?$postData['last_name']:''; ?>" required>
							</div>
						</div>
						<div class="mb-3">
							<label for="email_address">Email</label>
							<input type="email" class="form-control" name="email_address" value="<?php echo !empty($postData['email_address'])?$postData['email_address']:''; ?>" required>
						</div>
						<div class="mb-3">
							<label for="cell_phone">Phone</label>
							<input type="telephone" class="form-control" name="cell_number" value="<?php echo !empty($postData['phone'])?$postData['phone']:''; ?>" required>
						</div>
						<div class="mb-3">
							<label for="Adress">Street Address</label>
							<input type="text" class="form-control" name="address" value="<?php echo !empty($postData['address'])?$postData['address']:''; ?>" required>
            </div>
						<div class="mb-3">
							<label for="Adress">Suburb</label>
							<input type="text" class="form-control" name="suburb" value="<?php echo !empty($postData['suburb'])?$postData['suburb']:''; ?>" required>
            </div>
						<div class="mb-3">
							<label for="City">City</label>
							<input type="text" class="form-control" name="city" value="<?php echo !empty($postData['city'])?$postData['city']:''; ?>" required>
            </div>
            
							<div class="col-md-6 mb-3">
							
              <label for="province">Province</label>
              <input type="text" class="form-control" name="province" value="<?php echo !empty($postData['province'])?$postData['province']:''; ?>" required>
            </div>
            <div class="col-md-3 mb-3">
            <label for="area_code">Area code</label>
						<input type="text" class="form-control" name="area_code" value="<?php echo !empty($postData['area_code'])?$postData['area_code']:''; ?>" required>
						</div>
						<input type="hidden" name="action" value="placeOrder"/>
						<input class="btn btn-lg btn-block btn-light" type="submit" name="checkoutSubmit" value="Place Order" style  = "background-color:white !important;color : black; border : 1px solid black;">
					</form>
					

					<br><br><br>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>
