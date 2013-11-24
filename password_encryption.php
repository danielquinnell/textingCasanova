<?php
	//This file encapsulates the encryption algorithms
	
	define('SALT_LENGTH', 12);
	
	//This function returns a hashed version of the
	//password based on the salt provided. If no salt,
	//then it generates a random salt
	function generateHash($password, $salt = null)
	{
		if ($salt === null)
		{
			$salt = substr(md5(uniqid(rand(), true)), 0, SALT_LENGTH);
		}
		else
		{
			$salt = substr($salt, 0, SALT_LENGTH);
		}
		
		$tempPassword = sha1($salt . $password);
		
		return $tempPassword;
	}
	
	//Returns a salt. Mainly used in password creation
	function generateSalt()
	{
		$newSalt = substr(md5(uniqid(rand(), true)), 0, SALT_LENGTH);
		
		return $newSalt;
	}
?>