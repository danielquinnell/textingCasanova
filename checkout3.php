<?php
	require_once 'conn.php';
	require_once 'outputfunctions.php';
	$page = "checkout";
	require_once 'header.php';
	require_once 'http.php';
	
	//If the user is not logged in, then redirect to the index
	if (!isset($_SESSION['userid']) ||
		!isset($_POST['cameFromCheckout2']))
	{
		redirect('index.php');
	}
	else
	{
		echo '<h2>Checkout</h2>
			<p>Step 1 - Enter Billing and Shipping Information</p>
			<p>Step 2 - Please Verify Accuracy and Make Changes</p>
			<h2>Step 3 - Order Confirmation and Receipt: Your order has (not really) been placed. You will (not really) receive an email to confirm your order shortly.</h2>';
		
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
			$first_name = $_POST['first_name'];
			$last_name = $_POST['last_name'];
			$address = $_POST['address'];
			$address2 = $_POST['address2'];
			$city = $_POST['city'];
			$state = $_POST['state'];
			$zip = $_POST['zip'];
			$phone = $_POST['phone'];
			$email = $_POST['email'];
			
			if ($_POST['address_same_as_billing'] == "false")
			{
				$shipping_first_name = $_POST['shipping_first_name'];
				$shipping_last_name = $_POST['shipping_last_name'];
				$shipping_address = $_POST['shipping_address'];
				$shipping_address2 = $_POST['shipping_address2'];
				$shipping_city = $_POST['shipping_city'];
				$shipping_state = $_POST['shipping_state'];
				$shipping_zip = $_POST['shipping_zip'];
				$shipping_phone = $_POST['shipping_phone'];
				$shipping_email = $_POST['shipping_email'];
			}
			//Enter checkout information
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
						<input disabled type="text" class="textInput" name="first_name" maxlength="100" value="' . htmlspecialchars($first_name) . '" />
					</div>
				</div>
				<div class="section group_checkout">
					<div class="col span_1_of_2">
						<p>Last Name:</p>
					</div>
					<div class="col span_2_of_2">
						<input disabled type="text" class="textInput" name="last_name" maxlength="100" value="' . htmlspecialchars($last_name) . '" />
					</div>
				</div>
				<div class="section group_checkout">
					<div class="col span_1_of_2">
						<p>Billing Address:</p>
					</div>
					<div class="col span_2_of_2">
						<input disabled type="text" class="textInput" name="address" maxlength="100" value="' . htmlspecialchars($address) . '" />
					</div>
				</div>
				<div class="section group_checkout">
					<div class="col span_1_of_2">
						<p>Billing Address 2:</p>
					</div>
					<div class="col span_2_of_2">
						<input disabled type="text" class="textInput" name="address2" maxlength="100" value="' . htmlspecialchars($address2) . '" />
					</div>
				</div>
				<div class="section group_checkout">
					<div class="col span_1_of_2">
						<p>City:</p>
					</div>
					<div class="col span_2_of_2">
						<input disabled type="text" class="textInput" name="city" maxlength="100" value="' . htmlspecialchars($city) . '" />
					</div>
				</div>
				<div class="section group_checkout">
					<div class="col span_1_of_2">
						<p>State:</p>
					</div>
					<div class="col span_2_of_2">
						<input disabled type="text" class="textInput" name="state" maxlength="2" value="' . htmlspecialchars($state) . '" />
					</div>
				</div>
				<div class="section group_checkout">
					<div class="col span_1_of_2">
						<p>Zip:</p>
					</div>
					<div class="col span_2_of_2">
						<input disabled type="text" class="textInput" name="zip" maxlength="9" value="' . htmlspecialchars($zip) . '" />
					</div>
				</div>
				<div class="section group_checkout">
					<div class="col span_1_of_2">
						<p>Phone Number:</p>
					</div>
					<div class="col span_2_of_2">
						<input disabled type="text" class="textInput" name="phone" maxlength="12" value="' . htmlspecialchars($phone) . '" />
					</div>
				</div>
				<div class="section group_checkout">
					<div class="col span_1_of_2">
						<p>Email Address:</p>
					</div>
					<div class="col span_2_of_2">
						<input disabled type="text" class="textInput" name="email" maxlength="9" value="' . htmlspecialchars($email) . '" />
					</div>
				</div>
				</div>
				</br>';
			//Shipping information
			
			if ($_POST['address_same_as_billing'] == "false")
			{
				echo '<div class="section checkout_block" id="shipping_address">
				<div class="section group_checkout">
						<h3>Shipping Information</h3>
					</div>
					<div class="section group_checkout">
						<div class="col span_1_of_2">
							<p>First Name:</p>
						</div>
						<div class="col span_2_of_2">
							<input disabled type="text" class="textInput" name="shipping_first_name" maxlength="100" value="' . htmlspecialchars($shipping_first_name) . '" />
						</div>
					</div>
					<div class="section group_checkout">
						<div class="col span_1_of_2">
							<p>Last Name:</p>
						</div>
						<div class="col span_2_of_2">
							<input disabled type="text" class="textInput" name="shipping_last_name" maxlength="100" value="' . htmlspecialchars($shipping_last_name) . '" />
						</div>
					</div>
					<div class="section group_checkout">
						<div class="col span_1_of_2">
							<p>Shipping Address:</p>
						</div>
						<div class="col span_2_of_2">
							<input disabled type="text" class="textInput" name="shipping_address" maxlength="100" value="' . htmlspecialchars($shipping_address) . '" />
						</div>
					</div>
					<div class="section group_checkout">
						<div class="col span_1_of_2">
							<p>Shipping Address 2:</p>
						</div>
						<div class="col span_2_of_2">
							<input disabled type="text" class="textInput" name="shipping_address2" maxlength="100" value="' . htmlspecialchars($shipping_address2) . '" />
						</div>
					</div>
					<div class="section group_checkout">
						<div class="col span_1_of_2">
							<p>City:</p>
						</div>
						<div class="col span_2_of_2">
							<input disabled type="text" class="textInput" name="shipping_city" maxlength="100" value="' . htmlspecialchars($shipping_city) . '" />
						</div>
					</div>
					<div class="section group_checkout">
						<div class="col span_1_of_2">
							<p>State:</p>
						</div>
						<div class="col span_2_of_2">
							<input disabled type="text" class="textInput" name="shipping_state" maxlength="2" value="' . htmlspecialchars($shipping_state) . '" />
						</div>
					</div>
					<div class="section group_checkout">
						<div class="col span_1_of_2">
							<p>Zip:</p>
						</div>
						<div class="col span_2_of_2">
							<input disabled type="text" class="textInput" name="shipping_zip" maxlength="9" value="' . htmlspecialchars($shipping_zip) . '" />
						</div>
					</div>
					<div class="section group_checkout">
						<div class="col span_1_of_2">
							<p>Phone Number:</p>
						</div>
						<div class="col span_2_of_2">
							<input disabled type="text" class="textInput" name="shipping_phone" maxlength="12" value="' . htmlspecialchars($shipping_phone) . '" />
						</div>
					</div>
					<div class="section group_checkout">
						<div class="col span_1_of_2">
							<p>Email Address:</p>
						</div>
						<div class="col span_2_of_2">
							<input disabled type="text" class="textInput" name="shipping_email" maxlength="9" value="' . htmlspecialchars($shipping_email) . '" />
						</div>
					</div>
					</div>';
			}
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
				outputProductCart($item, true);
			}
			
			
			
			echo '<div class="section group">
						<div class="col span_1_of_3">
							<p>Total before shipping and taxes: </p>
						</div>
						<div class="col span_2_of_3"><p>';
			echo '$' . $totalPrice . '</p>';
			echo '	</div>
					<div class="col span_3_of_3"></div></div>';
			
			//get the state
			include 'taxshippingmodule.php';
			
			$taxRate = getTaxRate($state);
			$taxes = round(($totalPrice * $taxRate), 2);
			
			echo '<div class="section group">
						<div class="col span_1_of_3">
							<p>Tax rate for state ' . strtoupper($state) . ': </p>
						</div>
						<div class="col span_2_of_3"><p>';
			echo '%' . ($taxRate*100) . '</p>';
			echo '	</div>
					<div class="col span_3_of_3"></div></div>';
			
			echo '<div class="section group">
						<div class="col span_1_of_3">
							<p>Tax Price: </p>
						</div>
						<div class="col span_2_of_3"><p>';
			echo '$' . $taxes . '</p>';
			echo '	</div>
					<div class="col span_3_of_3"></div></div>';
			
			$shipping_types = getShippingTypes($conn);
			
			//find the shipping type selected
			$shipCost;
			echo '<div class="section group">';
			foreach ($shipping_types as $shipType) 
			{
				if ($_POST['shipType'] == $shipType['name'])
				{
					echo '<div class="col span_1_of_3">
							<p>' . $shipType['description'] . '</p>
						  </div>
						  <div class="col span_3_of_3">
							  <p>'. $shipType['cost'] . '</p>
						  </div>';
					$shipCost = $shipType['cost'];
					break;
				}
			}
			echo '</div>';
			
			echo '<div class="section group">
						<div class="col span_1_of_3">
							<p>Total: </p>
						</div>
						<div class="col span_2_of_3"><p>';
			echo '$' . ($totalPrice + $taxes + $shipCost) . '</p>';
			echo '	</div>
					<div class="col span_3_of_3"></div></div>';
					
					
			//After everything has been displayed:
		    //Empty the cart (DONT replenish product stock)
			$sql = "SELECT product_id " . 
				   "FROM cart_items " .
				   "WHERE user_id=" . $_SESSION['userid'];
		   
		   	$numItemsDeletedToPreventOrderRecordDuplication = 0;
			$result = mysql_query($sql, $conn);
			if (mysql_num_rows($result)>0)
			{
				$numItemsDeletedToPreventOrderRecordDuplication++;
				
				while ($row = mysql_fetch_array($result))
				{
					$sql = "DELETE FROM cart_items " .
						   "WHERE product_id=" . $row['product_id'];
					
					mysql_query($sql, $conn)
						or die('Could not delete item from cart: ' . mysql_error());
				}
			}
			
			//Create an order record
			if ($numItemsDeletedToPreventOrderRecordDuplication > 0)
			{
				$sql = "INSERT INTO orders " .
					   "(user_id, itemlist_id, notes, shipping_cost, tax_cost, subtotal) " .
					   "VALUES (" . $_SESSION['userid'] .
					   "," . 0 .
					   ",'" . " " .
					   "'," . $shipCost . 
					   "," . $taxes .
					   "," . ($totalPrice + $taxes + $shipCost) .
					   ")";
			}
			mysql_query($sql, $conn)
				or die('Could not insert order record: ' . mysql_error());
		}
		else
		{
			echo '<div class="section group"> 
			<p>You have no products to checkout with.</p>
			</div>';
			redirect('index.php');
		}
	}
?>