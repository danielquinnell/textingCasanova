<?php
	require_once 'conn.php';
	require_once 'http.php';
	$page = "product";
	require_once 'header.php';
	
	if (isset($_GET['productid']))
	{
		$productid = $_GET['productid'];
		
		$sql = "SELECT name, description_long, price, image_path, stock " .
				   "FROM products " . 
				   "WHERE product_id=" . $productid;
				   
				$result = mysql_query($sql, $conn)
					or die('Could not look up products: ' . mysql_error());
					
				if ($row = mysql_fetch_array($result))
				{
					echo '<div class="item_big';
					if ($row['stock'] < 1 &&
						$row['stock'] != -1)
					{
						echo ' soldout';
					}
					echo '">';
					if ($row['stock'] < 1 &&
						$row['stock'] != -1)
					{
						echo '<p class="soldout">OUT OF STOCK</p>';
					}
					echo '<a href="getprod.php?productid=' . $productid . '"><h2>' . $row['name'] . '</h2></a>';
					echo '<a href="getprod.php?productid=' . $productid . '"><img src="images/thumb/' . $row['image_path'] . '_thumb.png" /img></a>';
					// description
					echo '<p class="description_long">' . $row['description_long'] . '</p>';
					//price
					echo '<p class="price">$' . $row['price'] . '</p>';
					//cart button
					echo '<a href="transact-product.php?action=AddProduct&productid=' . $productid . '&quantity=1" >Add to Cart</a>';
					echo '</div>';
				}
	}
	else
	{
		redirect('index.php');
	}
	
	require_once 'footer.php';
?>