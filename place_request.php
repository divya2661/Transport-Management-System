<?php
session_start();
if(!isset($_SESSION['login_user']))
{
	echo "login first";
}
else
{
	include_once("frontend/request.html");
  require_once 'include/requester.php';
  $requester = new requester();
  
  // $day = array("Monday","Tuesday","Wednesday","Thursday","Friday");
  // $showDay = array("Mon","Tues","Wed","Thu","Fri");
  // $Vcapacity = $vehicle->getVechicleCapacity();
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="admin.css" rel="stylesheet" type="text/css" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

<script type="text/javascript">
function goback()
{
	alert("hi");
	history.go(-1);
}
</script>

<title>Admin Panel</title>
</head>

<body>
<div id="mainpage">

<?php
if(isset($_POST['sub']))
{
	$admin_email="ug201213026@iitj.ac.in";
	$dt=$_POST['dt'];
	$stime=$_POST['stm'];
	$etime=$_POST['etm'];
	$nos=$_POST['nos'];
	$reason=$_POST['rsn'];
	$usr=$_SESSION['login_user'];
	$usremail="ug201213005@iitj.ac.in";

	$Place_Request = $requester->place_request($admin_email,$dt,$stime,$etime,$nos,$reason,$usr,$usremail); 	
}

else
{
?>

	

<?php
}
?>
</div>
</body>
</html>
<?php
}
?>