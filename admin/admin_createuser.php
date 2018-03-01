<?php
	require_once('phpscripts/config.php');
	confirm_logged_in();

	if(isset($_POST['submit'])){
		$fname = trim($_POST['fname']);
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		$email = trim($_POST['email']);
		$lvllist = $_POST['lvllist'];
		if(empty($lvllist)){
			$message = "Please select a user level.";
		}else{
			$result = createUser($fname, $username, $password, $email, $lvllist);
			$message = $result;
		}
	}
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="css/main.css">
<title>Create User</title>
</head>
<body>

	<?php if(!empty($message)){echo $message;} ?>
	<div id="container2">
		<h2 class="title">Create User</h2>
	<form action="admin_createuser.php" method="post">
		<label class="hidden">First Name:</label>
		<input type="text" name="fname" placeholder="First name" value=""><br><br>
		<label class="hidden">Username:</label>
		<input type="text" name="username" placeholder="username" value=""><br><br>
		<label class="hidden">Password:</label>
		<input type="text" name="password" placeholder="Password" value=""><br><br>
		<label class="hidden">Email:</label>
		<input type="text" name="email" placeholder="email" value=""><br><br>
		<select name="lvllist">
			<option value="">Select User Level</option>
			<option value="2">Web Admin</option>
			<option value="1">Web Master</option>
		</select><br><br>
		<input type="submit" name="submit" value="Create User" class="button">
	</form>
</div>
</body>
</html>
