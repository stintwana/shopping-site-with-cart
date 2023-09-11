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
// Initialize shopping cart class
require_once 'Cart.class.php';
$cart = new Cart;


// Default redirect page
$redirectLoc = 'index.php';

// Process request based on the specified action
if(isset($_REQUEST['action']) && !empty($_REQUEST['action'])){
    if($_REQUEST['action'] == 'addToCart' && !empty($_REQUEST['book_id'])){
		$book_id = $_REQUEST['book_id'];
		
        // Get product details
        $query = $db->query("SELECT * FROM books WHERE book_id = ".$book_id);
		$row = $query->fetch_array(MYSQLI_ASSOC);
        $itemData = array(
            'book_id' => $row['book_id'],
			'book_author' => $row['book_author'],
			'book_title' => $row['book_title'],
			'book_description' => $row['book_description'],
			'book_pages' => $row['book_pages'],
            'book_price' => $row['book_price'],
            'book_cover' => $row['book_cover'],
			'qty' => 1
        );
        
		// Insert item to cart
        $insertItem = $cart->insert($itemData);
		
		// Redirect to cart page
        $redirectLoc = $insertItem?'viewCart.php':'index.php';
    }elseif($_REQUEST['action'] == 'updateCartItem' && !empty($_REQUEST['book_id'])){
		// Update item data in cart
        $itemData = array(
            'rowid' => $_REQUEST['book_id'],
            'qty' => $_REQUEST['qty']
        );
        $updateItem = $cart->update($itemData);
		
		// Return status
        echo $updateItem?'ok':'err';die;
    }elseif($_REQUEST['action'] == 'removeCartItem' && !empty($_REQUEST['book_id'])){
		// Remove item from cart
        $deleteItem = $cart->remove($_REQUEST['book_id']);
        
		// Redirect to cart page
		$redirectLoc = 'viewCart.php';
    }elseif($_REQUEST['action'] == 'placeOrder' && $cart->total_items() > 0){
		$redirectLoc = 'checkout.php';
		
		// Store post data
		$_SESSION['postData'] = $_POST;
	
		$first_name = strip_tags($_POST['name_first']);
		$last_name = strip_tags($_POST['name_last']);
		$email_address = strip_tags($_POST['email_address']);
		$phone = strip_tags($_POST['cell_number']);
		$address = strip_tags($_POST['address']);
		$suburb = strip_tags($_POST['suburb']);
		$city = strip_tags($_POST['city']);
		$province = strip_tags($_POST['province']);
		$area_code = strip_tags($_POST['area_code']);
		
		$errorMsg = '';
		if(empty($first_name)){
			$errorMsg .= 'Please enter your first name.<br/>';
		}
		if(empty($last_name)){
			$errorMsg .= 'Please enter your last name.<br/>';
		}
		if(empty($email_address)){
			$errorMsg .= 'Please enter your email address.<br/>';
		}
		if(empty($phone)){
			$errorMsg .= 'Please enter your phone number.<br/>';
		}
		if(empty($address)){
			$errorMsg .= 'Please enter your address.<br/>';
		}
		if(empty($suburb)){
			$errorMsg .= 'Please enter your suburb.<br/>';
		}
		if(empty($city)){
			$errorMsg .= 'Please enter your city.<br/>';
		}
		if(empty($province)){
			$errorMsg .= 'Please enter your province.<br/>';
		}
		if(empty($area_code)){
			$errorMsg .= 'Please enter your area code.<br/>';
		}
		
		if(empty($errorMsg)){
			// Insert customer data in the database
			$insertCust = $db->query("INSERT INTO customers (first_name, last_name, email_address, phone, address, suburb, city, province, area_code, created, modified) VALUES ('".$first_name."', '".$last_name."', '".$email_address."', '".$phone."', '".$address."','".$suburb."','".$city."','".$province."' ,'".$area_code."', NOW(), NOW())");
			
			if($insertCust){
				$custID = $db->insert_id;
				
				// Insert order info in the database
				$insertOrder = $db->query("INSERT INTO orders (customer_id, grand_total, created, status) VALUES ($custID, '".$cart->total()."', NOW(), 'Pending')");
			
				if($insertOrder){
					$orderID = $db->insert_id;
					
					// Retrieve cart items
					$cartItems = $cart->contents();
					
					// Prepare SQL to insert order items
					$sql = '';
					foreach($cartItems as $item){
						$sql .= "INSERT INTO order_items (order_id, book_id, quantity) VALUES ('".$orderID."', '".$item['book_id']."', '".$item['qty']."');";
					}
					
					// Insert order items in the database
					$insertOrderItems = $db->multi_query($sql);
					
					if($insertOrderItems){
						// Remove all items from cart
						$cart->destroy();
						
						// Redirect to the status page
						$redirectLoc = 'orderSuccess.php?id='.$orderID;
					}else{
						$sessData['status']['type'] = 'error';
						$sessData['status']['msg'] = 'Some problem occurred, please try again.';
					}
				}else{
					$sessData['status']['type'] = 'error';
					$sessData['status']['msg'] = 'Some problem occurred, please try again.';
				}
			}else{
				$sessData['status']['type'] = 'error';
				$sessData['status']['msg'] = 'Some problem occurred, please try again.';
			}
		}else{
			$sessData['status']['type'] = 'error';
			$sessData['status']['msg'] = 'Please fill all the mandatory fields.<br>'.$errorMsg; 
		}


		$_SESSION['sessData'] = $sessData;
    }
}
$to = "tebogomoroka@yahoo.com, $email_address";
$subject = "order Details";
$headers = 'MIME-Version: 1.0'. "\r\n";
$headers .= 'Content-type: text/html; charset-iso-8859-1 ' ."\r\n"; 
$message = file_get_contents('https://www.tcmbooks.co.za/orderSuccess?id='.$orderID);
mail($to, $subject, $message, $headers);
// Redirect to the specific page
echo("<script>location.href='".$redirectLoc."'</script>");
exit();
