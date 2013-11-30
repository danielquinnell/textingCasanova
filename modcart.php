<?php
	require_once 'conn.php';
	$page = "cart";
	require_once 'header.php';
	//echo '<div class="content">';
	//echo '<div id="cart_header">';
	//echo '<span class="quantity inline"><h3>Quantity</h3></span>';
	//echo '<span class="item_image inline"><h3>Item Image</h3></span>';
	//echo '<span class="item_name inline"><h3>Item Name</h3></span>';
	//echo '<span class="price_each inline"><h3>Price Each</h3></span>';
	//echo '<span class="price_ext inline"><h3>Extended Price</h3></span>';
	//echo '<span class="clearBoth"/>';
	
	//echo '</div>';
	//echo '<p> asdfasdfasdfasdfasdfasdfasdfasdfasdfasdf </p>';
	
	//echo '<p> asdfasdfasdfasdfasdfasdfasdfasdfasdfasdf </p>';
	//Populate cart items
	
	//echo '</div>';
?>
	<h2>Cart</h2>
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
        <form method="post" action="transact-product.php">
        <!-- 1st row END -->
        <!-- Item Rows -->
        <?php
			//Will have to revise this later...
			if (!isset($_SESSION['cartitems']))
			{
				$_SESSION['cartitems'] = array();
			}
			
			$cartItems = array();
			
			$totalPrice = 0;
			if ($_SESSION['userid'])
			{
				$sql = "SELECT * " . 
				  	   "FROM cart_items " .
				   	   "WHERE user_id=" . $_SESSION['userid'];
			   
				$result = mysql_query($sql, $conn);
				if (mysql_num_rows($result)>0)
				{
					//For all items in the cart
					while ($row = mysql_fetch_array($result))
					{
						$sql = "SELECT image_path, name, price " . 
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
								"quantity" => $row['quantity']
								);
							$totalPrice += ($row['quantity']*$prod['price']);
							$cartItems[] = $tempProdArray;
						}
					}
				}
				else
				{
					echo " <br />\n";
					echo " There are currently no products to view.\n";
				}
			}
			else
			{
				//Populate based on session data?
				//Simplest solution would be to tell
				//the user they are required to login
			}
			
			//Populate based on an array that was just built
			foreach ($cartItems as $item)
			{
				echo '<div class="section group">
					<div class="col span_1_of_7"><p>';
				echo $item['quantity'];
				echo '</p>
					</div>
					<div class="col span_2_of_7">';
				echo '<a href="getprod.php?productid=' . $item['product_id'] . '"><img src="images/thumb/' . $item['image_path'] . '_thumb.png" class="item_icon" /img></a>';
				
				echo '</div>
					<div class="col span_3_of_7"><p>';
				echo $item['name'];
				
				echo '</p>
					</div>
					<div class="col span_4_of_7"><p>';
				echo $item['price'];
				
				echo'</p>
					</div>
					<div class="col span_5_of_7"><p>';
				echo '$' . $item['price']*$item['quantity'];
				
				echo '</p>
					</div>
					<div class="col span_6_of_7">
						<input type="submit" class="submit" name="action" value="Change Quantity" />
					</div>
					<div class="col span_7_of_7">
						<input type="submit" class="submit" name="action" value="Delete Item" />
					</div>
				</div>';
			}
			
			echo '<div class="section group">
					<div class="col span_1_of_3">
						<p>Your total before shipping is: </p>
					</div>
					<div class="col span_2_of_3"><p>';
			echo '$' . $totalPrice . '</p>';
			echo '	</div>
					<div class="col span_3_of_3">
						<input type="submit" class="submit" name="action" value="Empty Cart" />
					</div>
				  </div>';
			?>
        </form>
        <!-- Item Rows END -->
<?php
	require_once 'footer.php';
?>