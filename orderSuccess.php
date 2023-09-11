<?php
// Include the database config file
require_once 'header.php';
echo "<br/><br/><br/><br/>";
if(!isset($_REQUEST['id'])){
    header("Location: index.php");
}


// Fetch order details from database
$result = $db->query("SELECT r.*, c.first_name, c.last_name, c.email_address, c.phone, c.address, c.suburb, c.city, c.province, c.area_code FROM orders as r LEFT JOIN customers as c ON c.id = r.customer_id WHERE r.id = ".$_REQUEST['id']);

if($result->num_rows > 0){
	$orderInfo = $result->fetch_assoc();
}else{
	echo("<script>location.href='index.php'</script>");
}

$result = $db->query("SELECT i.*, p.book_cover, p.book_title, p.book_price FROM order_items as i LEFT JOIN books as p ON p.book_id = i.book_id WHERE i.order_id = ".$orderInfo['id']);
if($result->num_rows > 0){ 
	while($item = $result->fetch_assoc()){
		$price = $item["book_price"];
		$book_title = $item["book_title"];
		$quantity = $item["quantity"];
		$sub_total = ($price*$quantity);
	}
}
?>
<div class="containerr">
 
<div class="separator text-center" ><span class="word2" style = "border: 2px solid #555555;padding :10px;">Order Status</span></div><br/>
	<div class="col-12">
		<?php if(!empty($orderInfo)){ ?>
			<div class="col-md-12">
				<div class="alert alert-success">Your order has been placed successfully, Please note that the order will be processed when payment has been made</div>
			</div>
			
			<a href="https://www.payfast.co.za/eng/process?cmd=_paynow&amp;receiver=18599223&amp;item_name=<?php echo $book_title; ?>&amp;amount=<?php echo $orderInfo['grand_total']; ?>&amp;return_url=http://www.tcmbooks.co.za/orderConfirmed.php&amp;cancel_url=https://www.tcmbooks.co.za/orderCancelled.php"><img src="https://www.payfast.co.za/images/buttons/dark-large-paynow.png" width="174" height="59" alt="Pay" title="Pay Now with PayFast" /></a>

			<!-- Order status & shipping info -->
			<div class="row col-lg-12 ord-addr-info">
				<div class="hdr">Order Info</div>
				<p><b>Reference ID:</b> #<?php echo $orderInfo['id']; ?></p>
				<p><b>Total:</b> <?php echo 'R'.$orderInfo['grand_total'].' ZAR'; ?></p>
				<p><b>Placed On:</b> <?php echo $orderInfo['created']; ?></p>
				<p><b>Buyer Name:</b> <?php echo $orderInfo['first_name'].' '.$orderInfo['last_name']; ?></p>
				<p><b>Email:</b> <?php echo $orderInfo['email_address']; ?></p>
				<p><b>Phone:</b> <?php echo $orderInfo['phone']; ?></p>
				<p><b>Shipping address:</b> <?php echo $orderInfo['address']; ?></p>
				<p><b>Suburb:</b> <?php echo $orderInfo['suburb']; ?></p>
				<p><b>City:</b> <?php echo $orderInfo['city']; ?></p>
				<p><b>Province:</b> <?php echo $orderInfo['province']; ?></p>
				<p><b>Area Code:</b> <?php echo $orderInfo['area_code']; ?></p>
			</div>
			
			<!-- Order items -->
			<div class=" col-lg-12 ord-addr-info">
				<table class="table table-table-responsive" >
					<thead>
					  <tr>
						<th>Product</th>
						<th>Price</th>
						<th>QTY</th>
						<th>Sub Total</th>
					  </tr>
					</thead>
					<tbody >

                        <?php
                        // Get order items from the database
                        $result = $db->query("SELECT i.*, p.book_cover, p.book_title, p.book_price FROM order_items as i LEFT JOIN books as p ON p.book_id = i.book_id WHERE i.order_id = ".$orderInfo['id']);
                        if($result->num_rows > 0){ 
                            while($item = $result->fetch_assoc()){
                                $price = $item["book_price"];
								$book_title = $item["book_title"];
                                $quantity = $item["quantity"];
                                $sub_total = ($price*$quantity);
                        ?>
						<tr>
							<td><img src = "images/<?php echo $item["book_cover"]; ?>"width="60" height="60" align = "center" style = "border : 1px solid black;"/> <br/><b>Item:</b> <?php echo $item["book_title"]; ?> </td>
							<td><?php echo 'R'.$price.' ZAR'; ?></td>
							<td><?php echo $quantity; ?></td>
							<td><?php echo 'R'.$sub_total.' ZAR'; ?></td>
						</tr>
                        <?php }
                        } ?>
					</tbody>
				</table>
			    <a href="https://www.payfast.co.za/eng/process?cmd=_paynow&amp;receiver=18599223&amp;item_name=<?php echo $book_title; ?>&amp;amount=<?php echo $orderInfo['grand_total'] ?>&amp;return_url=http://www.tcmbooks.co.za/orderConfirmed.php&amp;cancel_url=https://www.tcmbooks.co.za/orderCancelled.php"><img src="https://www.payfast.co.za/images/buttons/dark-large-paynow.png" width="174" height="59" alt="Pay" title="Pay Now with PayFast" /></a>

			</div>
		<?php }else{ ?>
		<div class="col-md-12">
			<div class="alert alert-danger">Your order submission failed.</div>
		</div>
		<?php } ?>
	</div>
</div>
		</div>
		</div>
</body>
</html>