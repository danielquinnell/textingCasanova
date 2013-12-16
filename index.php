<?php
	require_once 'conn.php';
	require_once 'outputfunctions.php';
	require_once 'modcart.php';
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
	
	function miniCart(){
	   ob_start();
	   include('modcart.php');
	   $page2 = ob_get_clean();
	   return $page2;
	   }
	
	require_once 'footer.php';
?>