<?php
	require_once 'conn.php';
	require_once 'outputfunctions.php';
	$page = "index";
	require_once 'header.php';
	
	$sql = "SELECT product_id " . 
		   "FROM products";
		   //"FROM products " . 
		   //"ORDER BY date_published DESC";
		   
	$result = mysql_query($sql, $conn);
	if (mysql_num_rows($result)==0)
	{
		echo " <br />\n";
		echo " There are currently no products to view.\n";
	}
	else
	{
		while ($row = mysql_fetch_array($result))
		{
			outputProduct($row['product_id'], FALSE);
		}
	}
	
	require_once 'footer.php';
?>