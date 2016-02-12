<?php
session_start();
if(!isset($_SESSION['login_user']))
{
	echo "login first";
}
else
{
	//include_once("frontend/request.html");
  require_once 'include/admin_notify.php';
  $notify = new admin_notify();
  
  // $day = array("Monday","Tuesday","Wednesday","Thursday","Friday");
  // $showDay = array("Mon","Tues","Wed","Thu","Fri");
  // $Vcapacity = $vehicle->getVechicleCapacity();
?>

<html>
<?php
	if(isset($_POST['approve']) || isset($_POST['deny']))
		{
			$dt=$_POST['dt'];
			$stime=$_POST['s_time'];
			$req=$_POST['req'];

			if(isset($_POST['approve']))
				$status="approve";
			else
				$status="deny";
			$not1=$notify->notify($dt,$stime,$req,$status);	
		}

		$Ndetails=$notify->fetch_notification();

		for($i=0;$i<count($Ndetails);$i++)
		{	
?>
		<form action="" method="post">
		<table cellpadding="6", cellspacing="3" border="6">
		<tr><th>Date:</th><td><input name="dt" type="text" value="<?php echo $Ndetails[$i]["date"]; ?>" size="20" readonly/></td></tr>
		<tr><th>Start Time:</th><td><input name="s_time" type="text" value="<?php echo $Ndetails[$i]["start_time"]; ?>" size="20" readonly/></td></tr>
		<tr><th>End Time:</th><td><input name="e_time" type="text" value="<?php echo $Ndetails[$i]["end_time"]; ?>" size="20" readonly/></td></tr>
		<tr><th>No of people:</th><td><input name="nop" type="text" value="<?php echo $Ndetails[$i]["Nstudent"]; ?>" size="20" readonly/></td></tr>
		<tr><th>Reason:</th><td><input name="reason" type="text" value="<?php echo $Ndetails[$i]["reason"]; ?>" size="20" readonly/></td></tr>
		<tr><th>Requested by:</th><td><input name="req" type="text" value="<?php echo $Ndetails[$i]["requested_by"]; ?>" size="20" readonly/></td></tr>
		</table>
		    <input type="submit" name="approve" value="approve" />
		    <input type="submit" name="deny" value="deny" />
		</form>
<?php
	}
?>
</html>
<?php
}
?>