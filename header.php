<?php session_start(); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    	<title>Texting Casanova</title>
        <link rel="stylesheet" type="text/css" href="css/main.css" />
        <link rel="stylesheet" type="text/css" href="css/grid.css" />
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
        <script src="js/general.js"></script>
    </head>
    
   <body>
   <div id='mainfunctions'>
    	<div id="userinfo">
            <?php
            	if (!isset($_SESSION['userid']))
				{
					echo "<div id=\"logowelcome\">\n";
					echo 'Please login to make purchaces.';
					echo "</div>";
					echo ' <a href="login.php">Login</a>';
				}
				else
				{
					echo "<div id=\"logowelcome\">\n";
					echo 'Currently logged in as: ' . $_SESSION['name'];
					echo "</div>";
					echo ' <a href="transact-user.php?action=Logout">Logout</a>';
				}
			?>
        </div> <!-- userinfo div -->
        <div id="carticon">
        	<a href="modcart.php">Cart</a>
        </div> <!-- carticon div -->
	</div> <!-- mainfunctions div -->
    	<div id="logobar">
        	<div id="logo">
            	<h1>Texting Casanova Shopping Cart</h1>
            </div>	<!-- logo div -->
        </div>	<!-- logobar div -->
        
        <div id='maincolumn'>
        	<div id='navigation'>
            	<?php
					if (isset($page))
					{
						$_SESSION['currPage'] = $page;
					}
					else
					{
						$_SESSION['currPage'] = "";
					}
					
					echo '<a href="index.php" class="';
					//This code is used for css in order to
					//highlight the current selected page index
					if ($_SESSION['currPage'] == "index")
					{
						echo 'activePage';
					}
					else
					{
						echo 'inactivePage';
					}
					echo '">Home</a>';
					
					if (isset($_SESSION['userid']))
					{
						if ($_SESSION['access_lvl'] > 2)
						{
							echo ' <a href="admin.php" class="'; 
							//This code is used for css in order to
							//highlight the current selected page index
							if ($_SESSION['currPage'] == "admin")
							{
								echo 'activePage';
							}
							else
							{
								echo 'inactivePage';
							}
							echo '">Admin</a>';
						}
					}
				?>
            </div> <!-- navigation div -->
            <div id="content">
            