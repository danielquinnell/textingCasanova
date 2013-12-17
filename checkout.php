<?php
	require_once 'conn.php';
	require_once 'outputfunctions.php';
	$page = "checkout";
	require_once 'header.php';
	
	//If the user is not logged in, then redirect to the index
	if (!isset($_SESSION['userid']))
	{
		redirect('index.php');
	}
	else
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
		
		$billing_first_name = '';
		$billing_last_name = '';
		$billing_address = '';
		$billing_address2 = '';
		$billing_city = '';
		$billing_state = '';
		$billing_zip = '';
		$billing_phone = '';
		$billing_email = '';
		
		$sql = "SELECT * " . 
				   "FROM users " .
				   "WHERE user_id=" . $_SESSION['userid'];
		   
		$result = mysql_query($sql, $conn);
		$row;
		if (mysql_num_rows($result)>0)
		{
			//For all items in the cart
			$row = mysql_fetch_array($result);
			
			$first_name = $row['first_name'];
			$last_name = $row['last_name'];
			$address = '';
			$address2 = '';
			$city = '';
			$state = '';
			$zip = '';
			$phone = '';
			$email = '';
			
			$billing_first_name = '';
			$billing_last_name = '';
			$billing_address = '';
			$billing_address2 = '';
			$billing_city = '';
			$billing_state = '';
			$billing_zip = '';
			$billing_phone = '';
			$billing_email = '';
		}
		
		//Enter checkout information
		echo '<form method="post" action="checkout2.php">';
		//Billing information
		echo '
			<div class="section checkout_block">
			<div class="section group_checkout">
				<h3>Billing Information</h3>
			</div>
			<div class="section group_checkout">
				<div class="col span_1_of_2">
					<p>First Name</p>
				</div>
				<div class="col span_2_of_2">
					<input type="text" class="textInput" name="first_name" maxlength="100" value="' . htmlspecialchars($first_name) . '" />
				</div>
			</div>
			<div class="section group_checkout">
				<div class="col span_1_of_2">
					<p>Last Name</p>
				</div>
				<div class="col span_2_of_2">
					<input type="text" class="textInput" name="last_name" maxlength="100" value="' . htmlspecialchars($last_name) . '" />
				</div>
			</div>
			<div class="section group_checkout">
				<div class="col span_1_of_2">
					<p>Billing Address</p>
				</div>
				<div class="col span_2_of_2">
					<input type="text" class="textInput" name="address" maxlength="100" value="' . htmlspecialchars($address) . '" />
				</div>
			</div>
			<div class="section group_checkout">
				<div class="col span_1_of_2">
					<p>Billing Address 2</p>
				</div>
				<div class="col span_2_of_2">
					<input type="text" class="textInput" name="address2" maxlength="100" value="' . htmlspecialchars($address2) . '" />
				</div>
			</div>
			<div class="section group_checkout">
				<div class="col span_1_of_2">
					<p>City</p>
				</div>
				<div class="col span_2_of_2">
					<input type="text" class="textInput" name="city" maxlength="100" value="' . htmlspecialchars($city) . '" />
				</div>
			</div>
			<div class="section group_checkout">
				<div class="col span_1_of_2">
					<p>State</p>
				</div>
				<div class="col span_2_of_2">
					<input type="text" class="textInput" name="state" maxlength="2" value="' . htmlspecialchars($state) . '" />
				</div>
			</div>
			<div class="section group_checkout">
				<div class="col span_1_of_2">
					<p>Zip</p>
				</div>
				<div class="col span_2_of_2">
					<input type="text" class="textInput" name="zip" maxlength="9" value="' . htmlspecialchars($zip) . '" />
				</div>
			</div>
			<div class="section group_checkout">
				<div class="col span_1_of_2">
					<p>Phone Number</p>
				</div>
				<div class="col span_2_of_2">
					<input type="text" class="textInput" name="phone" maxlength="12" value="' . htmlspecialchars($phone) . '" />
				</div>
			</div>
			<div class="section group_checkout">
				<div class="col span_1_of_2">
					<p>Email Address</p>
				</div>
				<div class="col span_2_of_2">
					<input type="text" class="textInput" name="email" maxlength="9" value="' . htmlspecialchars($email) . '" />
				</div>
			</div>
			</div>
			</br>';
		//Shipping information
		echo '<div class="section checkout_block">
		<div class="section group_checkout">
				<h3>Shipping Information</h3>
			</div>
			<div class="section group_checkout">
				<div class="col span_1_of_2">
					<p>First Name</p>
				</div>
				<div class="col span_2_of_2">
					<input type="text" class="textInput" name="first_name" maxlength="100" value="' . htmlspecialchars($billing_first_name) . '" />
				</div>
			</div>
			<div class="section group_checkout">
				<div class="col span_1_of_2">
					<p>Last Name</p>
				</div>
				<div class="col span_2_of_2">
					<input type="text" class="textInput" name="last_name" maxlength="100" value="' . htmlspecialchars($billing_last_name) . '" />
				</div>
			</div>
			<div class="section group_checkout">
				<div class="col span_1_of_2">
					<p>Shipping Address</p>
				</div>
				<div class="col span_2_of_2">
					<input type="text" class="textInput" name="address" maxlength="100" value="' . htmlspecialchars($billing_address) . '" />
				</div>
			</div>
			<div class="section group_checkout">
				<div class="col span_1_of_2">
					<p>Shipping Address 2</p>
				</div>
				<div class="col span_2_of_2">
					<input type="text" class="textInput" name="address2" maxlength="100" value="' . htmlspecialchars($billing_address2) . '" />
				</div>
			</div>
			<div class="section group_checkout">
				<div class="col span_1_of_2">
					<p>City</p>
				</div>
				<div class="col span_2_of_2">
					<input type="text" class="textInput" name="city" maxlength="100" value="' . htmlspecialchars($billing_city) . '" />
				</div>
			</div>
			<div class="section group_checkout">
				<div class="col span_1_of_2">
					<p>State</p>
				</div>
				<div class="col span_2_of_2">
					<input type="text" class="textInput" name="state" maxlength="2" value="' . htmlspecialchars($billing_state) . '" />
				</div>
			</div>
			<div class="section group_checkout">
				<div class="col span_1_of_2">
					<p>Zip</p>
				</div>
				<div class="col span_2_of_2">
					<input type="text" class="textInput" name="zip" maxlength="9" value="' . htmlspecialchars($billing_zip) . '" />
				</div>
			</div>
			<div class="section group_checkout">
				<div class="col span_1_of_2">
					<p>Phone Number</p>
				</div>
				<div class="col span_2_of_2">
					<input type="text" class="textInput" name="phone" maxlength="12" value="' . htmlspecialchars($billing_phone) . '" />
				</div>
			</div>
			<div class="section group_checkout">
				<div class="col span_1_of_2">
					<p>Email Address</p>
				</div>
				<div class="col span_2_of_2">
					<input type="text" class="textInput" name="email" maxlength="9" value="' . htmlspecialchars($billing_email) . '" />
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
			}
			else
			{
				echo '<div class="section group"> 
				<p>There are currently no products to view.</p>
				</div>';
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
	}
?>