<?php
	require_once 'conn.php';
	$userid = '';
	$name = '';
	$email = '';
	$password = '';
	$access_lvl = '';
	if (isset($_GET['userid']))
	{
		$sql = "SELECT * " .
			   "FROM users " .
			   "WHERE user_id=" . $_GET['userid'];
		$result = mysql_query($sql, $conn)
			or die ('Could not look up user data: ' . mysql_error());
		$row = mysql_fetch_array($result);
		$userid = $_GET['userid'];
		$first_name = $row['first_name'];
		$last_name = $row['last_name'];
		$address_id = $row['address_shipping'];
		$email = $row['email'];
		$phone = $row['phone'];
		$access_lvl = $row['access_lvl'];
		
		//Get the address information
		$sql = "SELECT a.* " .
			   "FROM addresses_shipping a " .
			   "INNER JOIN users u " .
			   "ON u.address_shipping=a.address_id " .
			   "WHERE address_id=" . $address_id;
			   
		$result = mysql_query($sql, $conn)
			or die ('Could not look up user data: ' . mysql_error());
			
		
	}
	require_once 'header.php';
	echo '<form method="post" action="transact-user.php">';
	
	echo '<div id="accountSection">';
	if ($userid)
	{
		echo "<h2>Modify Account</h2>\n";
	}
	else
	{
		echo "<h2>Create Account</h2>\n";
	}
?>
<div id="accountSectionContent">
<p>
	First Name: <br />
    <input type="text" class="textInput" name="first_name" maxlength="100" value="<?php echo htmlspecialchars($first_name); ?>" />
</p>
<p>
	Last Name: <br />
    <input type="text" class="textInput" name="last_name" maxlength="100" value="<?php echo htmlspecialchars($last_name); ?>" />
</p>
<p>
	Address Line 1: <br />
    <input type="text" class="textInput" name="address_1" maxlength="100" value="<?php echo htmlspecialchars($address_2); ?>" />
</p>
<p>
	Address Line 2: <br />
    <input type="text" class="textInput" name="address_2" maxlength="100" value="<?php echo htmlspecialchars($address_1); ?>" />
</p>
<p>
	Email Address: <br />
    <input type="text" class="textInput" name="email" maxlength="255" value="<?php echo htmlspecialchars($email); ?>" />
</p>
<?php
	if (isset($_SESSION['access_lvl'])
		and $_SESSION['access_lvl'] == 3)
	{
		echo "<fieldset>\n";
		echo "<legend>Access Level</legend>\n";
		$sql = "SELECT * " .
			   "FROM access_levels " .
			   "ORDER BY access_lvl DESC";
		$result = mysql_query($sql, $conn)
			or die('Could not list access levels: ' . mysql_error());
		while ($row = mysql_fetch_array($result))
		{
			echo ' <input type="radio" class="radio id="acl_' .
				 $row['access_lvl'] . '" name="access_lvl" value="' .
				 $row['access_lvl'] . '" ';
			if ($row['access_lvl'] == $access_lvl)
			{
				echo 'checked="checked" ';
			}
			echo '>' . $row['access_name'] . "<br />\n";
		}
?>
</fieldset>
<p>
	<input type="hidden" name="userid" value="<?php echo $userid; ?>"/>
    <input type="submit" class="submit" name="action" value="Modify Account" />
</p>
<?php 
	}
	else
	{
?>
<p>
	Email Address: <br />
    <input type="text" class="textInput" name="email" maxlength="255" value="<?php echo htmlspecialchars($email); ?>" />
</p>
<p>
	Password: <br/>
    <input type="password" id="password" name="password" maxlength="50" />
</p>
<p>
	Password (again): <br />
    <input type="password" id="password2" name="password2" maxlength="50" />
</p>
<p>
	<input type="submit" class="submit" name="action" value="Create Account" />
</p>
</div>
</div>
<?php } ?>
</form>