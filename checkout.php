<?php
	require_once 'conn.php';
	require_once 'outputfunctions.php';
	$page = "checkout";
	require_once 'header.php';
	require_once 'http.php';
	
	//If the user is not logged in, then redirect to the index
	if (!isset($_SESSION['userid']))
	{
		redirect('index.php');
	}
	else
	{
		echo '<h2>Checkout</h2>
			<h2>Step 1 - Enter Billing and Shipping Information</h2>
			<p>Step 2 - Please Verify Accuracy and Make Changes</p>
			<p>Step 3 - Order Confirmation and Receipt</p>';
		
		//Check if there are cart items first.
		//If there are not, the user should not be able to checkout
		if (!isset($_SESSION['cartitems']))
		{
			$_SESSION['cartitems'] = array();
		}
		
		$cartItems = array();
		
		$totalPrice = 0;
		
		$sql = "SELECT * " . 
			   "FROM cart_items " .
			   "WHERE user_id=" . $_SESSION['userid'];
	   
		$result = mysql_query($sql, $conn);
		if (mysql_num_rows($result)>0)
		{
			//Get all information that the customer might have
			$first_name = '';
			$last_name = '';
			$address = '';
			$address2 = '';
			$city = '';
			$state = '';
			$zip = '';
			$phone = '';
			$email = '';
			
			$shipping_first_name = '';
			$shipping_last_name = '';
			$shipping_address = '';
			$shipping_address2 = '';
			$shipping_city = '';
			$shipping_state = '';
			$shipping_zip = '';
			$shipping_phone = '';
			$shipping_email = '';
			
			$sql = "SELECT * " . 
					   "FROM users " .
					   "WHERE user_id=" . $_SESSION['userid'];
			   
			$result_user = mysql_query($sql, $conn);
			if (mysql_num_rows($result_user)>0)
			{
				//For all items in the cart
				$row_user = mysql_fetch_array($result_user);
				
				$sql = "SELECT * " .
					   "FROM addresses_shipping " .
					   "WHERE address_id=" . $row_user['address_id'];
					   
				$result_address = mysql_query($sql, $conn);
				if (mysql_num_rows($result_address) > 0)
				{
					$row_address = mysql_fetch_array($result_address);
				}
				
				$first_name = $row_user['first_name'];
				$last_name = $row_user['last_name'];
				$address = $row_address['address_line1'];
				$address2 = $row_address['address_line2'];
				$city = $row_address['city'];
				$state = $row_address['state'];
				$zip = $row_address['zip'];
				$phone = $row_user['phone'];
				$email = $row_user['email'];
				
				$shipping_first_name = $row_user['first_name'];
				$shipping_last_name = $row_user['last_name'];
				$shipping_address = $row_address['address_line1'];
				$shipping_address2 = $row_address['address_line2'];
				$shipping_city = $row_address['city'];
				$shipping_state = $row_address['state'];
				$shipping_zip = $row_address['zip'];
				$shipping_phone = $row_user['phone'];
				$shipping_email = $row_user['email'];
			}
			
			//Enter checkout information
			echo '<form method="post" action="checkout2.php">';
			//Billing information
			echo '<div class="section checkout_block">
				<div class="section group_checkout">
					<h3>Billing Information</h3>
				</div>
				<div class="section group_checkout">
					<div class="col span_1_of_2">
						<p>First Name:</p>
					</div>
					<div class="col span_2_of_2">
						<input type="text" class="textInput" name="first_name" maxlength="100" value="' . htmlspecialchars($first_name) . '" />
					</div>
				</div>
				<div class="section group_checkout">
					<div class="col span_1_of_2">
						<p>Last Name:</p>
					</div>
					<div class="col span_2_of_2">
						<input type="text" class="textInput" name="last_name" maxlength="100" value="' . htmlspecialchars($last_name) . '" />
					</div>
				</div>
				<div class="section group_checkout">
					<div class="col span_1_of_2">
						<p>Billing Address:</p>
					</div>
					<div class="col span_2_of_2">
						<input type="text" class="textInput" name="address" maxlength="100" value="' . htmlspecialchars($address) . '" />
					</div>
				</div>
				<div class="section group_checkout">
					<div class="col span_1_of_2">
						<p>Billing Address 2:</p>
					</div>
					<div class="col span_2_of_2">
						<input type="text" class="textInput" name="address2" maxlength="100" value="' . htmlspecialchars($address2) . '" />
					</div>
				</div>
				<div class="section group_checkout">
					<div class="col span_1_of_2">
						<p>City:</p>
					</div>
					<div class="col span_2_of_2">
						<input type="text" class="textInput" name="city" maxlength="100" value="' . htmlspecialchars($city) . '" />
					</div>
				</div>
				<div class="section group_checkout">
					<div class="col span_1_of_2">
						<p>State:</p>
					</div>
					<div class="col span_2_of_2">
						<input type="text" class="textInput" name="state" maxlength="2" value="' . htmlspecialchars($state) . '" />
					</div>
				</div>
				<div class="section group_checkout">
					<div class="col span_1_of_2">
						<p>Zip:</p>
					</div>
					<div class="col span_2_of_2">
						<input type="text" class="textInput" name="zip" maxlength="9" value="' . htmlspecialchars($zip) . '" />
					</div>
				</div>
				<div class="section group_checkout">
					<div class="col span_1_of_2">
						<p>Phone Number:</p>
					</div>
					<div class="col span_2_of_2">
						<input type="text" class="textInput" name="phone" maxlength="12" value="' . htmlspecialchars($phone) . '" />
					</div>
				</div>
				<div class="section group_checkout">
					<div class="col span_1_of_2">
						<p>Email Address:</p>
					</div>
					<div class="col span_2_of_2">
						<input type="text" class="textInput" name="email" maxlength="9" value="' . htmlspecialchars($email) . '" />
					</div>
				</div>
				<div class="section group_checkout">
					<div class="col span_1_of_2">
						<p>Address Same as Billing:</p>
					</div>
					<div class="col span_2_of_2">
						<input type="checkbox" class="checkbox" id="address_same_as_billing" name="address_same_as_billing"/>
					</div>
				</div>
				</div>
				</br>';
			//Shipping information
			echo '<div class="section checkout_block" id="shipping_address">
			<div class="section group_checkout">
					<h3>Shipping Information</h3>
				</div>
				<div class="section group_checkout">
					<div class="col span_1_of_2">
						<p>First Name:</p>
					</div>
					<div class="col span_2_of_2">
						<input type="text" class="textInput" name="shipping_first_name" maxlength="100" value="' . htmlspecialchars($shipping_first_name) . '" />
					</div>
				</div>
				<div class="section group_checkout">
					<div class="col span_1_of_2">
						<p>Last Name:</p>
					</div>
					<div class="col span_2_of_2">
						<input type="text" class="textInput" name="shipping_last_name" maxlength="100" value="' . htmlspecialchars($shipping_last_name) . '" />
					</div>
				</div>
				<div class="section group_checkout">
					<div class="col span_1_of_2">
						<p>Shipping Address:</p>
					</div>
					<div class="col span_2_of_2">
						<input type="text" class="textInput" name="shipping_address" maxlength="100" value="' . htmlspecialchars($shipping_address) . '" />
					</div>
				</div>
				<div class="section group_checkout">
					<div class="col span_1_of_2">
						<p>Shipping Address 2:</p>
					</div>
					<div class="col span_2_of_2">
						<input type="text" class="textInput" name="shipping_address2" maxlength="100" value="' . htmlspecialchars($shipping_address2) . '" />
					</div>
				</div>
				<div class="section group_checkout">
					<div class="col span_1_of_2">
						<p>City:</p>
					</div>
					<div class="col span_2_of_2">
						<input type="text" class="textInput" name="shipping_city" maxlength="100" value="' . htmlspecialchars($shipping_city) . '" />
					</div>
				</div>
				<div class="section group_checkout">
					<div class="col span_1_of_2">
						<p>State:</p>
					</div>
					<div class="col span_2_of_2">
						<input type="text" class="textInput" name="shipping_state" maxlength="2" value="' . htmlspecialchars($shipping_state) . '" />
					</div>
				</div>
				<div class="section group_checkout">
					<div class="col span_1_of_2">
						<p>Zip:</p>
					</div>
					<div class="col span_2_of_2">
						<input type="text" class="textInput" name="shipping_zip" maxlength="9" value="' . htmlspecialchars($shipping_zip) . '" />
					</div>
				</div>
				<div class="section group_checkout">
					<div class="col span_1_of_2">
						<p>Phone Number:</p>
					</div>
					<div class="col span_2_of_2">
						<input type="text" class="textInput" name="shipping_phone" maxlength="12" value="' . htmlspecialchars($shipping_phone) . '" />
					</div>
				</div>
				<div class="section group_checkout">
					<div class="col span_1_of_2">
						<p>Email Address:</p>
					</div>
					<div class="col span_2_of_2">
						<input type="text" class="textInput" name="shipping_email" maxlength="9" value="' . htmlspecialchars($shipping_email) . '" />
					</div>
				</div>
				</div>';
			//Cart items (for review)
			echo '</br>
				<div class="section group">
				<!--first row -->
					<div class="col span_1_of_7">
							<h3>Quantity</h3>
					</div>
					<div class="col span_2_of_7">
							<h3>Item Image</h3>
					</div>
					<div class="col span_3_of_7">
							<h3>Item Name</h3>
					</div>
					<div class="col span_4_of_7">
							<h3>Price Each</h3>
					</div>
					<div class="col span_5_of_7">
							<h3>Extended Price</h3>
					</div>
					<div class="col span_6_of_7">
					</div>
					<div class="col span_7_of_7">
					</div>
				</div>
				<!-- 1st row END -->
				<!-- Item Rows -->
				';
			
			
			//For all items in the cart
			while ($row = mysql_fetch_array($result))
			{
				$sql = "SELECT image_path, name, price, stock " . 
				   "FROM products " .
				   "WHERE product_id=" . $row['product_id'];
				
				//Insert product information, including quantity
				$product = mysql_query($sql, $conn);
				if (mysql_num_rows($product)==1)
				{
					$prod = mysql_fetch_array($product);
					$tempProdArray = array(
						"product_id" => $row['product_id'],
						"image_path" => $prod['image_path'],
						"name" => $prod['name'],
						"price" => $prod['price'],
						"quantity" => $row['quantity'],
						"stock" => $prod['stock']
						);
					$totalPrice += ($row['quantity']*$prod['price']);
					$cartItems[] = $tempProdArray;
				}
			}
			
			
			//Populate based on an array that was just built
			foreach ($cartItems as $item)
			{
				//=================================================================
				//If you want to make this more robust, then do a query
				//for the amount of the item in stock
				//=================================================================
				outputProductCart($item, true);
			}
			echo ' <input type="hidden" name="cameFromCheckout" value="true" />';
			echo '		<input type="submit" class="submit" name="action" value="Submit Order" />
				  </form>';
		}
		else
		{
			echo '<div class="section group"> 
			<p>You have no products to checkout with.</p>
			</div>';
		}
	}
?>