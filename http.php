<?php
	//Separated from outputfunctions.php because this controls browser function
	//This function will get used at different times, so separating it keeps our code more efficient
	function redirect($url)
	{
		if (!headers_sent())
		{
			header('Location: http://' . $_SERVER['HTTP_HOST'] .
				dirname($_SERVER['PHP_SELF']) . '/' . $url);
		}
		else
		{
			die('Could not redirect; Headers already sent (output).');
		}
	}
?>