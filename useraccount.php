<?php
	require_once 'conn.php';
	$userid = '';
	$first_name = '';
	$last_name = '';
	$address_1 = '';
	$address_2 = '';
	$city = '';
	$state = '';
	$zip = '';
	$email = '';
	$phone = '';
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
			   "ON u.address_id=a.address_id " .
			   "WHERE address_id=" . $address_id;
			   
		$result = mysql_query($sql, $conn)
			or die ('Could not look up user data: ' . mysql_error());
		
		$row = mysql_fetch_array($result);
		$address_1 = $row['address_line1'];
		$address_2 = $row['address_line2'];
		$city = $row['city'];
		$state = $row['state'];
		$zip = $row['zip'];
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
    <input type="text" class="textInput" name="address_line1" maxlength="100" value="<?php echo htmlspecialchars($address_1); ?>" />
</p>
<p>
	Address Line 2: <br />
    <input type="text" class="textInput" name="address_line2" maxlength="100" value="<?php echo htmlspecialchars($address_2); ?>" />
</p>
<p>
	City: <br />
    <input type="text" class="textInput" name="city" maxlength="100" value="<?php echo htmlspecialchars($city); ?>" />
</p>
<p>
	State: <br />
    <input type="text" class="textInput" name="state" maxlength="2" value="<?php echo htmlspecialchars($state); ?>" />
</p>
<p>
	Zip: <br />
    <input type="text" class="textInput" name="zip" maxlength="9" value="<?php echo htmlspecialchars($zip); ?>" />
</p>
<p>
	Phone: <br />
    <input type="text" class="textInput" name="phone" maxlength="10" value="<?php echo htmlspecialchars($phone); ?>" />
</p>
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
<?php
	if (isset($_SESSION['access_lvl']))
	{
?>
<p>
	Old Password: <br/>
    <input type="password" id="old_password" name="old_password" maxlength="50" />
</p>
        <?php
		if ($_SESSION['access_lvl'] == 3)
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
			echo '</fieldset>';
		}
?>
<p>
	<input type="hidden" name="userid" value="<?php echo $userid; ?>"/>
    <input type="submit" class="submit" name="action" value="Update Account" />
</p>
<?php 
	}
	else
	{
?>
<p>
	<input type="submit" class="submit" name="action" value="Create Account" />
</p>
</div>
</div>
<?php } ?>
</form>