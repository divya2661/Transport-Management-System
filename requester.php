<?php
session_start();
if(!isset($_SESSION['login_user']))
{
	echo "login first";
}
else
{
	include_once("connection.inc");
?>
<?php
  
  require_once 'include/schedule.php';
  require_once 'include/vehicle.php';
  $schedule = new schedule();
  $vehicle = new vehicle();
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

<script>
  $(document).ready(function() {
    $("#datepicker").datepicker();
  });
  //MMDDYYYY
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

	$message="date:" . $dt . "<br>";
	$message.="start time:" . $stime . "<br>";
	$message.="end time:" . $etime . "<br>";
	$message.="no of people:" . $nos . "<br>";
	$message.="reason:" . $reason . "<br>";
	

	if (mail("ug201213005@iitj.ac.in", "request", $message , "From: ug201213026@iitj.ac.in")) { 
            echo '<p>Your message has been sent!</p>';
        } else { 
            echo '<p>Something went wrong, go back and try again!</p>'; 
        }


	$query="INSERT INTO Notification VALUES ('$dt', '$stime', '$etime', '$nos', '$reason', '$usr')";
	$result=mysql_query($query) or die("query error");

	$count=mysql_affected_rows();

	if($count>0)
	{
		echo "inserted succesfully";
	}
	else
	{
		echo "query error abs";
	}
}
else
{
?>

	<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post" name="frm">
		<table cellpadding="6", cellspacing="3" border="6">
			<tr><th>Date:</th><td><input name="dt" size="20" id="datepicker"/></td></tr>
			<tr><th>Start_Time:</th><td><input name="stm" type="text" size="20" value="1400"/></td></tr>
			<tr><th>End_Time:</th><td><input name="etm" type="text" size="20" value="1700"/></td></tr>
			<tr><th>No of student:</th><td><input name="nos" type="number" size="20" /></td></tr>
			<tr><th>Reason:</th><td><input name="rsn" type="text" size="20" /></td></tr>
		</table>
		<input name="sub" type="submit" value="submit" id="result"/><br />
	</form>

<?php
}
?>
</div>
</body>
</html>
<?php
}
?>