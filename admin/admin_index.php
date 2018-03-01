<?php
	require_once('phpscripts/config.php');
	confirm_logged_in();
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="css/main.css">
<title>Welcome to your admin panel</title>
</head>
<body>
	<div id="container">
	<h1 class="title">Welcome to your admin panel</h1>
	<h2 class="textEnter"><?php echo $_SESSION['user_name'];?></h2>
	<a href="admin_createuser.php">Create User</a>
	<a href="admin_edituser.php">Edit User</a>
	<a href="admin_deleteuser.php">Delete User</a>
	<a href="phpscripts/caller.php?caller_id=logout">Sign Out</a>
</div>
</body>
</html>
