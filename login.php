<?php
	$page = "login";
	require_once 'header.php';
?>
<div id="accountSection">
<form method="post" action="transact-user.php">
	<h2>Member Login</h2>
  <div id="accountSectionContent">
  <p>Email Address:  <br/>
  	<input type="text" name="email" maxlength"255" value="" />
  </p>
  <p>Password: <br/>
  	<input type="password" name="password" maxlength="50" />
  </p>
  <p>
  	<input type="submit" class="submit" name="action" value="Login" />
  </p>
  <p>Not a member yet? <a href="useraccount.php">Create an account.</a>
  </p>
  <p><a href="forgotpass.php">Forgot your password?</a>
  </p>
  </div>
</form>
</div>
<?php require_once 'footer.php'; ?>