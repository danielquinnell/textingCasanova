<?php
	require_once 'conn.php';
	require_once 'http.php';
	
	if (isset($_REQUEST['action']))
	{
		switch ($_REQUEST['action'])
		{
			case 'Login':
				if (isset($_POST['email'])
					and isset($_POST['password']))
				{
					//First get the salted password
					$sql = "SELECT salt " .
						   "FROM users " .
						   "WHERE email='" . $_POST['email'] . "'";
					
					$result = mysql_query($sql, $conn)
						or die ('Could not look up user information: ' .
							mysql_error());
					if ($row = mysql_fetch_array($result))
					{
						$salt = $row['salt'];
						require 'password_encryption.php';
						$pass = generateHash($_POST['password'], $salt);
						
						//Now run the login query
						$sql = "SELECT user_id, access_lvl, first_name " .
							   "FROM users " .
							   "WHERE email='" . $_POST['email'] . "' " .
							   "AND password='" . $pass . "'";
						$result = mysql_query($sql, $conn)
							or die ('Could not look up user information: ' .
								mysql_error());
						if ($row = mysql_fetch_array($result))
						{
							session_start();
							$_SESSION['userid'] = $row['user_id'];
							$_SESSION['access_lvl'] = $row['access_lvl'];
							$_SESSION['name'] = $row['first_name'];
						}
					}
				}
				redirect('index.php');
				break;
			case 'Logout':
				session_start();
				session_unset();
				session_destroy();
				redirect('index.php');
				break;
			case 'Create Account':
				if (isset($_POST['first_name'])
					and isset($_POST['last_name'])
					and isset($_POST['address_line1'])
					and isset($_POST['address_line2'])
					and isset($_POST['city'])
					and isset($_POST['state'])
					and isset($_POST['zip'])
					and isset($_POST['email'])
					and isset($_POST['phone'])
					and isset($_POST['password'])
					and isset($_POST['password2'])
					and isset($_POST['password']) == $_POST['password2'])
				{
					//Encrypt the password
					require 'password_encryption.php';
					$newSalt = generateSalt();
					$newPass = generateHash($_POST['password'], $newSalt);
					print("Generating pass");
					//Address insert
					$sql = "INSERT INTO addresses_shipping (address_line1,address_line2,city,state,zip) " .
						   "VALUE ('" . $_POST['address_line1'] . "','" .
						   $_POST['address_line2'] . "','" . 
						   $_POST['city'] . "','" .
						   $_POST['state'] . "'," .
						   $_POST['zip'] . ")";
					print($sql);
					mysql_query($sql, $conn)
						or die('Could not create user account: ' . mysql_error());
					
					//do the rest of the insert
					$sql = "INSERT INTO users (first_name,last_name,address_id,email,phone,password,salt,access_lvl) " .
						   "VALUE ('" . $_POST['first_name'] . "','" .
						   $_POST['last_name'] . "'," . 
						   mysql_insert_id() . ",'" .
						   $_POST['email'] . "'," .
						   $_POST['phone'] . ",'" .
						   $newPass . "','" . 
						   $newSalt . "',1)";
					print($sql);
					mysql_query($sql, $conn)
						or die('Could not create user account: ' . mysql_error());
					session_start();
					$_SESSION['userid'] = mysql_insert_id($conn);
					$_SESSION['access_lvl'] = 1;
					$_SESSION['name'] = $_POST['first_name'];
				}
				//redirect('index.php');
				break;
			case 'Update Account':
				if (isset($_POST['first_name'])
					and isset($_POST['last_name'])
					and isset($_POST['address_line1'])
					and isset($_POST['address_line2'])
					and isset($_POST['city'])
					and isset($_POST['state'])
					and isset($_POST['zip'])
					and isset($_POST['email'])
					and isset($_POST['phone'])
					and isset($_POST['userid']))
				{
					//First get the address id based on user_id
					$sql = "SELECT users.address_id " . 
						   "FROM users " . 
						   "INNER JOIN addresses_shipping " . 
						   "ON users.address_id=addresses_shipping.address_id " . 
						   "WHERE users.user_id=" . $_POST['userid'];
					$result = mysql_query($sql, $conn)
						or die('Could not update user account: ' . mysql_error());
					
					$row = mysql_fetch_array($result);
					//Update the users table now
					$sql = "UPDATE users " .
						   "SET first_name='" . $_POST['first_name'] .
						   "', last_name='" . $_POST['last_name'] .
						   "', address_id=" . $row['address_id'] .
						   ", email='" . $_POST['email'] .
						   "', phone=" . $_POST['phone'] . " " .
						   "WHERE user_id=" . $_POST['userid'];
					$result = mysql_query($sql, $conn)
						or die('Could not update user account: ' . mysql_error());
						
						
					//Make sure to update the session
					$_SESSION['name'] = $_POST['first_name'];
				}
				redirect('index.php');
				break;
			case 'Send my reminder':
				if (isset($_POST['email']))
				{
					$sql="SELECT user_id FROM users " .
						 "WHERE email='" . $_POST['email'] . "'";
					$result = mysql_query($sql, $conn)
						or die('Could not lookup user: ' . mysql_error());
						
					if (mysql_num_rows($result))
					{
						//Generate a random password
						$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    					$randomPass = '';
						$pwLength = 12;
    					for ($i = 0; $i < $pwLength; $i++) 
						{
    					    $randomPass .= $characters[rand(0, strlen($characters) - 1)];
    					}
						
						//Encrypt it
						require 'password_encryption.php';
						$newSalt = generateSalt();
						$newPass = generateHash($randomPass, $newSalt);
						
						$row = mysql_fetch_array($result);
						
						//Store the new password in the database
						/*
						$sql = "UPDATE cms_users " .
							   "SET salt='" . $newSalt .
							   "', password='" . $newPass . "' " .
							   "WHERE user_id=" . $row['user_id'];
						
						$result = mysql_query($sql, $conn)
							or die('Could not update password: ' . mysql_error());
						
						$subject = "Article site new password";
						$body = "Just a reminder that your password has been reset. " .
								"The new password is: " .
								$randomPass .
								"\n\nYou can use this to log in at http://" .
								$_SERVER['HTTP_HOST'] .
								dirname($_SERVER['PHP_SELF']) . '/';
						mail($_POST['email'], $subject, $body)
							or die('Could not send reminder email.');
							*/
						echo '<p> Reminder not sent. Since email is not functioning, even sending the reminder would prevent future logins since the password would be reset and be impossible to update since the hash is not reversible. To test reminder functionality with a mail server installed, goto line 167 of transact-user.php and uncomment the code and comment out line 185. Also uncomment line 189 so the page will redirect. </p>';
					}
				}
				//redirect('login.php');
				break;
			case 'Modify account':
				session_start();
				if (isset($_POST['name'])
					and isset($_POST['email'])
					and isset($_POST['access_lvl'])
					and isset($_SESSION['userid']))
				{
					$sql = "UPDATE users " .
						   "SET email='" . $_POST['email'] .
						   "', name='" . $_POST['name'] .
						   "', access_lvl=" . $_POST['access_lvl'] . " " .
						   "WHERE user_id=" . $_POST['userid'];
					mysql_query($sql, $conn)
						or die('Could not update user account: ' . mysql_error());
				}
				redirect('admin.php');
				break;
		}
	}
?>