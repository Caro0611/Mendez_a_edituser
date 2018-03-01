<?php
	require_once('phpscripts/config.php');
	//confirm_logged_in();

	$id = $_SESSION['user_id'];
	$tbl = "tbl_user";
	$col = "user_id";
	$popForm = getSingle($tbl, $col, $id);
	$info = mysqli_fetch_array($popForm);
	//echo $info;

	if(isset($_POST['submit'])){
		$fname = trim($_POST['fname']);
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		$email = trim($_POST['email']);
		$result = editUser($id, $fname, $username, $password, $email);
		$message = $result;
	}
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="css/main.css">
<title>Edit User</title>
</head>
<body>

	<?php if(!empty($message)){echo $message;} ?>
	<div id="container2">
		<h2 class="title">Edit User</h2>
	<form action="admin_edituser.php" method="post">
		<label class="hidden">First Name:</label>
		<input type="text" name="fname" placeholder="First name" value="<?php echo $info['user_fname'];  ?>"><br><br>
		<label class="hidden">Username:</label>
		<input type="text" name="username" placeholder="Username" value="<?php echo $info['user_name'];  ?>"><br><br>
		<label class="hidden">Password:</label>
		<input type="text" name="password" placeholder="Password" value="<?php echo $info['user_pass'];  ?>"><br><br>
		<label class="hidden">Email:</label>
		<input type="text" name="email" placeholder="Email" value="<?php echo $info['user_email'];  ?>"><br><br>
		<input type="submit" name="submit" value="Edit Account" class="button">
	</form>
</div>
</body>
</html>
