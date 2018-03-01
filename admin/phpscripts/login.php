<?php

	function logIn($username, $password, $ip) {
		require_once('connect.php');
		$username = mysqli_real_escape_string($link, $username);
		$password = mysqli_real_escape_string($link, $password);
		$loginstring = "SELECT * FROM tbl_user WHERE user_name='{$username}' AND user_pass='{$password}' AND active=1"; //I created a new column in the db called active to check the activity status of the user
		$user_set = mysqli_query($link, $loginstring);
		//echo mysqli_num_rows($user_set);
		if(mysqli_num_rows($user_set)){
			$founduser = mysqli_fetch_array($user_set, MYSQLI_ASSOC);
			$id = $founduser['user_id'];
			$activo=consultarFechaUsuario($id); /*this var stores the runing function "consultarFechaUsuario" per id */
			if(!$activo){
				die('user disabled');
			}
			$_SESSION['user_id'] = $id;
			$_SESSION['user_name']= $founduser['user_fname'];
			if(mysqli_query($link, $loginstring)){
				$update = "UPDATE tbl_user SET user_ip='{$ip}' WHERE user_id={$id}";
				$updatequery = mysqli_query($link, $update);
			}
			$first_time=firstTime($id);

			if($first_time){
				redirect_to("admin_edituser.php");
			}else{
			redirect_to("admin_index.php");
			}
		}else{
			$message = "The information is incorrect";
			return $message;
		}

		mysqli_close($link);
	}
//this function will allow to check if the user is login for the 1st time or not (1-is for the first time, 0- not the first time)
	function firstTime($id){
		include('connect.php');
		//I created a new column in the db called first_time to get the info to run this function
		$loginstring = "SELECT first_time FROM tbl_user WHERE user_id='{$id}'";

		$user_set = mysqli_query($link, $loginstring);
		if(mysqli_num_rows($user_set)){
			$founduser = mysqli_fetch_array($user_set, MYSQLI_ASSOC);
			$result= $founduser['first_time'];
			return $result;
		}else{

			return 0;
		}
		mysqli_close($link);
	}
?>
