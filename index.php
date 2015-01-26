<?php
	session_start();
	// var_dump($_SESSION['user_id']);
?>
<html>
<head>
	<title>Wall login/registration</title>	
</head>
<body>
	<?php
		if(isset($_SESSION['errors']))
		{
			foreach($_SESSION['errors'] as $error)
			{
				echo "<p class='error'>{$error}</p>";	
			}		
			unset($_SESSION['errors']);
		}
		if (isset($_SESSION['success_message']))
		{
			echo "<p class='success'>{$_SESSION['success_message']}</p>";
			unset($_SESSION['success_message']);
		}
	?>
	<h2>Register</h2>
	<form action="process.php" method="post">
		First name: <input type="text" name="first_name"><br><br>
		Last name: <input type="text" name="last_name"><br><br>
		Email address: <input type="text" name="email"><br><br>
		Password: <input type="password" name="password"><br><br>
		Confirm Password: <input type="password" name="confrim_password"><br><br>
		<input type="submit" value="register">
		<input type="hidden" name="action" value="register">
	</form>
	<br><br>
	<h2>Login</h2>
	<form action="process.php" method="post">
		Email address: <input type="text" name="email"><br><br>
		Password: <input type="password" name="password"><br><br>
		<input type="submit" value="Login">
		<input type="hidden" name="action" value="login">
	</form>

</body>
</html>