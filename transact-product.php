<?php
	session_start();
	require_once 'conn.php';
	require_once 'http.php';
	if (isset($_REQUEST['action']))
	{
		//Since you can hit enter in the quantity box,
		//check if the user submitted via that
		if (is_int($_REQUEST['action']))
		{
			$_SESSION['item_change_alert'] = 'Submitted from quantity box';
			//redirect('modcart.php');
		}
		else
		{
			switch ($_REQUEST['action'])
			{
				case 'Submit Order':
					break;
				case 'Change Quantity':
					if (isset($_POST['productid']) &&
						isset($_POST['quantity']) &&
						isset($_SESSION['userid']))
					{
						$sql = "SELECT stock " .
							   "FROM products " . 
							   "WHERE product_id=" . $_POST['productid'];
						
						mysql_query($sql, $conn)
							or die('Could not select stock for item: ' . mysql_error());
						
						$stock = 0;
						$result = mysql_query($sql, $conn);
						if (mysql_num_rows($result)>0)
						{
							$row = mysql_fetch_array($result);
							$stock = $row['stock'];
						}
						
						$sql = "SELECT quantity " . 
							   "FROM cart_items " . 
							   "WHERE product_id=" . $_POST['productid'];
						
						mysql_query($sql, $conn)
							or die('Could not select cart item quantity: ' . mysql_error());
						
						$cart_quantity = 0;
						$result = mysql_query($sql, $conn);
						if (mysql_num_rows($result)>0)
						{
							$row = mysql_fetch_array($result);
							$cart_quantity = $row['quantity'];
						}
						
						$amountAddingToCart = $_POST['quantity'] - $cart_quantity;
						
						//Make sure to not allow the user to add more
						//to their cart than their is in stock
						if ($amountAddingToCart <= $stock)
						{
							$cart_quantity += $amountAddingToCart;
							
							if ($stock != -1)
							{
								$stock -= $amountAddingToCart;
							}
							$sql = "UPDATE cart_items " .
								   "SET quantity= " . $cart_quantity . " " .
								   "WHERE product_id=" . $_POST['productid'];
							
							mysql_query($sql, $conn)
								or die('Could not update item quantity: ' . mysql_error());
							
							if ($stock != -1)
							{
								$sql = "UPDATE products " .
									   "SET stock= " . $stock . " " .
									   "WHERE product_id=" . $_POST['productid'];
								
								mysql_query($sql, $conn)
									or die('Could not update item quantity: ' . mysql_error());
							}
							
							$sql = "SELECT name " .
								   "FROM products " . 
								   "WHERE product_id=" . $_POST['productid'];
							
							mysql_query($sql, $conn)
								or die('Could not select name for item: ' . mysql_error());
							
							$result = mysql_query($sql, $conn);
							if (mysql_num_rows($result)>0)
							{
								$row = mysql_fetch_array($result);
								if ($amountAddingToCart < 0)
								{
									if ($amountAddingToCart < -1)
									{
										$_SESSION['item_change_alert'] = "Removed   " . ($amountAddingToCart*-1) . " " . $row['name'] . "'s from cart.";		
									}
									else
									{
										$_SESSION['item_change_alert'] = "Removed one " . $row['name'] . " from cart.";
									}
								}
								else if ($amountAddingToCart > 0)
								{
									if ($amountAddingToCart > 1)
									{
										$_SESSION['item_change_alert'] = "Added   " . $amountAddingToCart . " " . $row['name'] . "'s to cart.";	
									}
									else
									{
										$_SESSION['item_change_alert'] = "Added one " . $row['name'] . " to cart.";	
									}
								}
							}
						}
						else
						{
							$_SESSION['item_change_alert'] = "Not enough of item left in stock.";	
						}
					}
					redirect('modcart.php');
					break;
				case 'Add To Cart':
					if (isset($_POST['productid']))
					{
						//If a user is logged in, then insert data
						//into the cart table
						if (isset($_SESSION['userid']))
						{
							//Check if the cart already has product added.
							$sql = "SELECT product_id, quantity " .
								   "FROM cart_items " .
								   "WHERE product_id=" . $_POST['productid'];
							echo '<p>' . $sql . '</p>';
							mysql_query($sql, $conn)
								or die('Could not select existing items from cart: ' . mysql_error());
							
							$result = mysql_query($sql, $conn);
							if (mysql_num_rows($result)>0)
							{
								$row = mysql_fetch_array($result);
								//if so, just update the quantity by one
								echo 'quantity: ' . $row['quantity'];
								$sql = "UPDATE cart_items " .
									   "SET quantity= " . ($row['quantity'] + 1) . " " .
									   "WHERE product_id=" . $_POST['productid'];
								mysql_query($sql, $conn)
									or die('Could not update item quantity: ' . mysql_error());
								
								//ALSO update the stock of the product
								$sql = "UPDATE products " .
									   "SET stock=stock-1 " .
									   "WHERE product_id=" . $_POST['productid'] . " " .
									   "AND stock > 0";
								
								mysql_query($sql, $conn)
									or die('Could not update item stock: ' . mysql_error());
								
								$_SESSION['item_change_alert'] = 'Item quantity updated!';
								
							}
							else
							{
								//if it doesnt have the product, then add it now
								$sql = "INSERT INTO cart_items " .
									   "(user_id, product_id, quantity) " .
									   "VALUES (" . $_SESSION['userid'] . 
									   ", " . $_POST['productid'] . 
									   ", 1)";
								
								mysql_query($sql, $conn)
									or die('Could not add item to cart: ' . mysql_error());
								
								//ALSO update the stock of the product
								$sql = "UPDATE products " .
									   "SET stock=stock-1 " .
									   "WHERE product_id=" . $_POST['productid'] . " " .
									   "AND stock > 0";
								
								mysql_query($sql, $conn)
									or die('Could not update item stock: ' . mysql_error());
								
								$sql = "SELECT name " .
									   "FROM products " .
									   "WHERE product_id=" . $_POST['productid'];
								
								echo $sql;
								
								mysql_query($sql, $conn)
									or die('Could not get item name: ' . mysql_error());
								
								$result = mysql_query($sql, $conn);
								if (mysql_num_rows($result)>0)
								{
									$row = mysql_fetch_array($result);
									$_SESSION['item_change_alert'] = 'Succesfully added item "' . $row['name'] . '" to your cart!';
								}
								else
								{
									$_SESSION['item_change_alert'] = 'ERROR SELECTING NAME';
								}
							}
						}
					}
					redirect('modcart.php');
					break;
				case 'Delete Item':
					if (isset($_POST['productid']) &&
						isset($_POST['quantity']) &&
						isset($_SESSION['userid']))
					{
						deleteItem($_POST['productid'], $conn);
					}
					redirect('modcart.php');
					break;
				case 'Empty Cart':
					if (isset($_SESSION['userid']))
					{
						$sql = "SELECT product_id " . 
							   "FROM cart_items " .
							   "WHERE user_id=" . $_SESSION['userid'];
				   	   
						$result = mysql_query($sql, $conn);
						if (mysql_num_rows($result)>0)
						{
							while ($row = mysql_fetch_array($result))
							{
								deleteItem($row['product_id'], $conn);
							}
						}
						
						if (mysql_affected_rows() > 0)
						{
							$_SESSION['item_change_alert'] = "Cart emptied!";
						}
					}
					redirect('modcart.php');
					break;
			}
		}
	}
	else
	{
		redirect('index.php');
	}
	
	function deleteItem($productid, $conn)
	{
		//Get the current stock for the item
		$sql = "SELECT stock " .
			   "FROM products " . 
			   "WHERE product_id=" . $productid;
		
		mysql_query($sql, $conn)
			or die('Could not select stock for item: ' . mysql_error());
		
		$stock = 0;
		$result = mysql_query($sql, $conn);
		if (mysql_num_rows($result)>0)
		{
			$row = mysql_fetch_array($result);
			$stock = $row['stock'];
		}
		
		//Get the quantity currently in the cart
		$sql = "SELECT quantity " . 
			   "FROM cart_items " . 
			   "WHERE product_id=" . $productid;
		
		mysql_query($sql, $conn)
			or die('Could not select cart item quantity: ' . mysql_error());
		
		$cart_quantity = 0;
		$result = mysql_query($sql, $conn);
		$row;
		if (mysql_num_rows($result)>0)
		{
			$row = mysql_fetch_array($result);
			$cart_quantity = $row['quantity'];
		}
		
		//-1 means unlimited, so don't add to the stock
		//If not unlimited, that add whatever was in the
		//cart back to the stock
		if ($stock != -1)
		{
			$stock += $cart_quantity;
		}
		
		//Remove the item from the cart
		$sql = "DELETE FROM cart_items " .
			   "WHERE product_id=" . $productid;
		
		mysql_query($sql, $conn)
			or die('Could not delete item from cart: ' . mysql_error());
		
		//Run SQL to update the stock if its not unlimited
		if ($stock != -1)
		{
		$sql = "UPDATE products " .
			   "SET stock= " . $stock . " " .
			   "WHERE product_id=" . $productid;
		}
		
		mysql_query($sql, $conn)
			or die('Could not update item quantity: ' . mysql_error());
		
		//Get the item name for display to the user
		$sql = "SELECT name " .
			   "FROM products " . 
			   "WHERE product_id=" . $productid;
		
		mysql_query($sql, $conn)
			or die('Could not select name for item: ' . mysql_error());
		
		$result = mysql_query($sql, $conn);
		if (mysql_num_rows($result)>0)
		{
			$row = mysql_fetch_array($result);
			$_SESSION['item_change_alert'] = "Deleted item: " . $row['name'] . " from cart. \n";
		}
	}
?>