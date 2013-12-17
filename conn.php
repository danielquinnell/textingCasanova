<?php
	define ('SQL_HOST', 'localhost');
	define ('SQL_USER', 'root');
	define ('SQL_PASS', '');
	define ('SQL_DB', 'wdmd_cartsystem');
	$conn = mysql_connect(SQL_HOST, SQL_USER, SQL_PASS) or
		die ('Could not connect to the database: ' . mysql_error());
	mysql_select_db(SQL_DB, $conn) or
		die ('Could not select the database: ' . mysql_error());
?>