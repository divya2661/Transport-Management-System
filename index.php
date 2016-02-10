<?php
	session_start();
	include_once("frontend/login.html");
	require_once 'include/DB_Functions.php';
	$db = new DB_Functions();
 
	if(isset($_POST['uname']) && isset($_POST['pword']))
	{
		//echo "coming to if";
		$email=$_POST['uname'];
		$password=$_POST['pword'];

		$type = $db->checkCredentials($email,$password);

		echo "type: ".$type."<br>";

		if($type!=null)
		{
			$_SESSION['login_user']=$email;
			$_SESSION['utype']=$type;

			if($type=="admin"){
				header("Location: /SE/frontend/admin.html");
			}
			else{
				echo "<a href='/SE/frontend/ChangeSetting.html'?utype=> click to login ".$_SESSION['login_user']."</a>";
			}
		}
		else
		{
			echo "Invalid Credentials, Please try again";
		}


	}

?>

