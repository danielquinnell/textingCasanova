<?php
	if (!isset($page))
	{
		require_once 'conn.php';
		require_once 'outputfunctions.php';
		$page = "cart";
		require_once 'header.php';
	}
	
	if (isset($_SESSION['item_change_alert']))
	{
		echo '<h3>' . $_SESSION['item_change_alert'] . '</h3>';
		unset($_SESSION['item_change_alert']);
	}
?>
	<h2>Cart</h2>
    	
        <?php
			if (isset($_SESSION['userid']))
			{
				echo '
					<div class="section group">
					<form method="post" action="transact-product.php">
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
								<h3>Unit Price</h3>
						</div>
						<div class="col span_5_of_7">
								<h3>Extended Price</h3>
						</div>
						<div class="col span_6_of_7">
						</div>
						<div class="col span_7_of_7">
							<input type="submit" class="submit" name="action" value="Empty Cart" />
						</div>
					</div>
					<!-- 1st row END -->
					<!-- Item Rows -->
					';
				//Will have to revise this later...
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
					outputProductCart($item);
				}
				
				echo '<div class="section group">
						<div class="col span_1_of_3">
							<p>Your total before shipping and taxes is: </p>
						</div>
						<div class="col span_2_of_3"><p>';
				echo '$' . $totalPrice . '</p>';
				echo '	</div>
						<div class="col span_3_of_3">
						</form>
						<form method="post" action="checkout.php">
							<input type="submit" class="submit" name="action" value="Submit Order" />
					  	</form>
					  </div>';
					  }
			else
			{
				echo '<em>Please login to view the cart.</em>';
			}
			?>
        </form>
        <!-- Item Rows END -->
<?php
	require_once 'footer.php';
?>