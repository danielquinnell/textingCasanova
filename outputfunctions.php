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
					echo '<div class="section main_list">';
					echo '<div class="col span_1_of_3-2">';
					echo '<a href="getprod.php?productid=' . $productid . '"><img src="images/thumb/' . $row['image_path'] . '_thumb.png" /img></a>';
					echo '</div>';
					echo '<div class="col span_2_of_3-2">';
					echo '<a href="getprod.php?productid=' . $productid . '"><h3>' . $row['name'] . '</h3></a>';
					// description
					echo '<p class="description_short">' . $row['description_short'] . '</p>';
					echo '</div>';
					echo '<div class="col span_3_of_3-2">';
					//price
					echo '<p class="price">$' . $row['price'] . '</p>';
					//cart button
					echo '<a href="transact-product.php?action=AddProduct&productid=' . $productid . '&quantity=1" >Add to Cart</a>';
					echo '</div>';
					echo '</div>';
				}
			}
			
			echo '</div>';
		}
	}
	
	function outputProductDetail($productid)
	{
		
	}
?>