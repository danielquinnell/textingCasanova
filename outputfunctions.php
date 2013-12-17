<?php
	function trimBody($theText, $lmt=500, $s_chr="\n", $s_cnt=2)
	{
		$pos = 0;
		$trimmed = FALSE;
		for ($i = 1; $i <= $s_cnt; $i++)
		{
			if ($tmp = strpos($theText, $s_chr, $pos+1))
			{
				$pos = $tmp;
				$trimmed = TRUE;
			}
			else
			{
				$pos = strlen($theText);
				$trimmed = FALSE;
				break;
			}
		}
		
		$theText = substr($theText, 0, $pos);
		if (strlen($theText) > $lmt)
		{
			$theText = substr($theText, 0, $lmt);
			$theText = substr($theText, 0, strrpos($theText, ' '));
			$trimmed = TRUE;
		}
		
		if ($trimmed)
		{
			$theText .= '...';
			return $theText;
		}
	}
	
	$productIndex = 0;
	
	function outputProduct($productid, $only_snippet=FALSE)
	{
		global $conn;
		
		if ($productid)
		{
			if ($only_snippet)
			{
				$sql = "SELECT name, price" .
				   "FROM products " . 
				   "WHERE product_id=" . $productid;
				   
				$result = mysql_query($sql, $conn)
					or die('Could not look up products: ' . mysql_error());
					
				if ($row = mysql_fetch_array($result))
				{
					echo '<div class="item_small">';
					echo '<a href="getprod.php?productid=' . $productid . '><h3>' . $row['name'] . '</h3></a>';
					//price
					echo '<p class="price">' . $row['price'] . '</p>';
				}
			}
			else
			{
				$sql = "SELECT name, description_short, price, image_path, stock " .
				   "FROM products " . 
				   "WHERE product_id=" . $productid;
				   
				$result = mysql_query($sql, $conn)
					or die('Could not look up products: ' . mysql_error());
					
				if ($row = mysql_fetch_array($result))
				{
					/*$i = '0';
						for ($n=0; $n<10; $n++) {
    						echo ++$i . PHP_EOL;
						}*/
						
					echo '<a href="getprod.php?productid=' . $productid . '"><h4 class="productTop">' . $row['name'] . '</h4></a>';
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
					else if ($row['stock'] < 5 &&
							 $row['stock'] != -1)
					{
						echo '<p class="soldout">Only ' . $row['stock'] . ' left!</p>';
					}
					echo '<div class="section main_list">';
					echo '<div class="col span_1_of_3-2">';
					echo '<a href="getprod.php?productid=' . $productid . '"><img src="images/thumb/' . $row['image_path'] . '_thumb.png" /img></a>';
					echo '</div>';
					echo '<div class="col span_2_of_3-2">';
					// description
					echo '<p class="description_short">' . $row['description_short'] . '</p>';
					echo '</div>';
					echo '<div class="col span_3_of_3-2">';
					//price
					echo '<p class="price">$' . $row['price'] . '</p>';
					//cart button
					if (!($row['stock'] <= 1 &&
						$row['stock'] != -1) &&
						isset($_SESSION['userid']))
					{
						//echo '<form method="post" action="transact-product.php">';
						//echo '<a href="transact-product.php?action=AddToCart&productid=' . $productid . '&quantity=1" >Add to Cart</a>';
						echo '<form method="post" action="transact-product.php">
							<input type="submit" class="submit" name="action" value="Add To Cart" />
							<input type="hidden" name="productid" value="' . $productid . '"/>
							</form>';
					}
					echo '</div>';
					echo '</div>';
				}
			}
			
			echo '</div>';
		}
	}
	
	function outputProductCart($item, $checkout=false)
	{
		echo '<div class="section group">';
		if (!$checkout)
		{
			echo '<form method="post" action="transact-product.php">
			<input type="hidden" name="productid" value="' . $item['product_id'] . '"/>';
		}
		echo '<div class="col span_1_of_7">';
			
		if ($checkout)
		{
			echo '<p>' . $item['quantity'] . '</p>';
		}
		else
		{
			echo '<input type="number" class="submit" name="quantity" value=' . $item['quantity'] . ' min="1" ' . 
					($item['stock'] == -1 ? ' max="99" />' : ' max="' . ($item['stock'] + $item['quantity']) . '" />');
		}
		echo '
			</div>
			<div class="col span_2_of_7">';
		echo '<a href="getprod.php?productid=' . $item['product_id'] . '"><img src="images/thumb/' . $item['image_path'] . '_thumb.png" class="item_icon" /img></a>';
		
		echo '</div>
			<div class="col span_3_of_7"><p>';
		echo $item['name'];
		
		echo '</p>
			</div>
			<div class="col span_4_of_7"><p>$';
		echo $item['price'];
		
		echo'</p>
			</div>
			<div class="col span_5_of_7"><p>';
		echo '$' . $item['price']*$item['quantity'];
		
		echo '</p>
			</div>';
		if (!$checkout)
		{
			echo'
				<div class="col span_6_of_7">
					<input type="submit" class="submit" name="action" value="Change Quantity" />
				</div>
				<div class="col span_7_of_7">
					<input type="submit" class="submit" name="action" value="Delete Item" />
				</div>
				';
		}
		if (!$checkout)
		{
		    echo '</form>';
		}
		
		echo '</div>';
	}
	
	function outputProductDetail($productid)
	{
		
	}
?>