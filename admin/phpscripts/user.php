<?php

	function createUser($fname, $username, $password, $email, $lvllist) {
		include('connect.php');
		$fecha_hoy= date("Y-m-d H:i:s");
		$userstring = "INSERT INTO tbl_user
		(user_fname, user_name, user_pass, user_email, user_date, lvllist, user_ip, first_time, active ) /*I added two new fields (for 2 new items I added to the db. first_time: to check if the user login for he first time or not. Active:to check if the user is active or not)*/
		VALUES('{$fname}', '{$username}', '{$password}', '{$email}', '{$fecha_hoy}' , '{$lvllist}', 'no', 1, 1 )";/* I added 2 new fields too that will control the first_time and active functions.*/
		$userquery = mysqli_query($link, $userstring);
		if($userquery) {
			redirect_to('admin_index.php');
		}else{
			$message = "Try again";
			return $message;
		}
		mysqli_close($link);
	}
//this function will run the editUser to edit the user to the database
	function editUser($id, $fname, $username, $password, $email) {
		include('connect.php');

		$updatestring = "UPDATE tbl_user SET user_fname='{$fname}', user_name='{$username}', user_pass='{$password}', user_email='{$email}', first_time=0, active=1 WHERE user_id={$id}"; /* I added 2 new fields here too that will control the first_time (to check if it is the first time login or not) and active (to check if the user is active or not) functions. */
		$updatequery = mysqli_query($link, $updatestring);

		if($updatequery) {
			redirect_to("admin_index.php");
		}else{
			$message = "you don't have access";
			return $message;
		}

		mysqli_close($link);
	}

	function deleteUser($id) {
		include('connect.php');
		$delstring = "DELETE FROM tbl_user WHERE user_id = {$id}";
		$delquery = mysqli_query($link, $delstring);
		if($delquery) {
			redirect_to("../admin_index.php");
		}else{
			$message = "Bye";
			return $message;
		}
		mysqli_close($link);
	}
//this function will check if the user is between the time limit (60sec) for login. if its not between the time limit the user will be disabled if it is in time the user is will be active and ok.
	function consultarFechaUsuario($id){
		include('connect.php');
		$seconds_limit=60;  // maximum time to login before disabled the user

		/*this will check the time that the user  registered for he first time*/
		$userstring = "SELECT user_date FROM tbl_user WHERE user_id='{$id}' and first_time=1";
		$userquery = mysqli_query($link, $userstring);
		if(mysqli_num_rows($userquery)){
			$founduser = mysqli_fetch_array($userquery, MYSQLI_ASSOC);
			$fecha_registro = $founduser['user_date'];
			$datatime_fecha = new DateTime($fecha_registro);
			$date = new DateTime("now");				//this gets the current time
			$interval = $datatime_fecha->diff($date); //this uses the php function datatime to calculate date and time difference between the user registration/creation and the current time
			$seconds = ($interval->s)		 //this will convert the time to seconds
				         + ($interval->i * 60)
				         + ($interval->h * 60 * 60)
				         + ($interval->d * 60 * 60 * 24)
				         + ($interval->m * 60 * 60 * 24 * 30)
				         + ($interval->y * 60 * 60 * 24 * 365);



			if($seconds<=$seconds_limit){     //this comàres if the user is between the login time limit and depending on the result will allow future login or not
				$updatestring = "UPDATE tbl_user SET active=1 WHERE user_id={$id}";
		$updatequery = mysqli_query($link, $updatestring);
		return true;
	}else{//this will disabled the user if the time limit has passed
				$updatestring = "UPDATE tbl_user SET active=0 WHERE user_id={$id}";
		$updatequery = mysqli_query($link, $updatestring);
		return false;
			}

		}else{
			return true;
		}

	}
?>
