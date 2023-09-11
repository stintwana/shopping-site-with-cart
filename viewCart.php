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
 

<script>
function updateCartItem(obj,book_id){
    $.get("cartAction.php", {action:"updateCartItem", book_id:book_id, qty:obj.value}, function(data){
        if(data == 'ok'){
            location.reload();
        }else{
            alert('Cart update failed, please try again.');
        }
    });
}
</script>

<div class="containerr">
    <h2>SHOPPING CART</h2>

		<div class="cart">
			<div class="col-12">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th width="45%">Product</th>
								<th width="10%">Price</th>
								<th width="15%">Quantity</th>
								<th class="text-right" width="20%">Total</th>
								<th width="10%"> </th>
							</tr>
						</thead>
						<tbody>
                            <?php
                            if($cart->total_items() > 0){
                                // Get cart items from session
                                $cartItems = $cart->contents();
                                foreach($cartItems as $item){
							?>
							<tr>
								<td><img src="images/<?php echo $item["book_cover"]; ?>"width="60" height="75" align = "center" style = "border : 1px solid black;"?><p class="card-text"><?php echo $item["book_title"]; ?></p></td>
								<td><?php echo 'R'.$item["book_price"].' ZAR'; ?></td>
								<td><input class="form-control" type="number" value="<?php echo $item["qty"]; ?>" onchange="updateCartItem(this, '<?php echo $item["rowid"]; ?>')"/></td>
								<td class="text-right"><?php echo 'R'.$item["subtotal"].' ZAR'; ?></td>
								<td class="text-right"><button class="btn btn-sm btn-danger" onclick="return confirm('Drop this piece?')?window.location.href='cartAction.php?action=removeCartItem&book_id=<?php echo $item["rowid"]; ?>':false;">X</button> </td>
							</tr>
							<?php } }else{ ?>
							<tr><td colspan="5"><p>Your cart is empty.....</p></td>
							<?php } ?>
							<?php if($cart->total_items() > 0){ ?>
							<tr>
								<td></td>
								<td></td>
								<td><strong>Cart Total</strong></td>
								<td class="text-right"><strong><?php echo 'R'.$cart->totalNoCourier().' ZAR'; ?></strong></td>
								<td></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="col mb-2">
				<div class="row">
					<div class="col-sm-12  col-md-6">
						<a href="index.php" class="btn btn-lg btn-block btn-primary" >Continue Shopping</a>
					</div>
					<div class="col-sm-12 col-md-6 text-right">
						<?php if($cart->total_items() > 0){ ?>
						<a href="checkout.php" class="btn btn-lg btn-block btn-primary" >Checkout</a>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>

</body>
</html>