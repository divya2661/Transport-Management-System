<?php
session_start();
if(!isset($_SESSION['login_user']))
{
	echo "login first";
}
else
{
  require_once 'include/admin_notify.php';

  $notify = new admin_notify();
  
?>

<html>
	<head>
	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <title>Bus Schedule</title>
	    <link href="css/bootstrap.min.css" rel="stylesheet">
	    <link rel="stylesheet" href="css/datepicker.css">
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	    <script src="js/bootstrap.min.js"></script>
	    <script src="js/jquery-1.9.1.min.js"></script>	
	    <style type="text/css">
	    </style>
  	</head>
  	<body>
  	<div style="margin-bottom:10px" class="row"></div>
<?php
	if(isset($_POST['approve']) || isset($_POST['deny']))
		{
			$id = $_POST['id'];
			$dt = $_POST['dt'];
			$s_time = $_POST['s_time'];
			$e_time = $_POST['e_time'];
			$nos = $_POST['nos'];

			if(isset($_POST['approve'])){
				$status="approve";
			}
			else{
				$status="deny";
			}
			$not1=$notify->notify($id,$status,$dt,$s_time,$e_time,$nos);	
			if($not1!=true){
				$message = "Could not process the request";
				echo "<script type='text/javascript'>alert('$message');</script>";
			}
		}

		$Ndetails=$notify->fetch_notification();

		if(count($Ndetails)==0){
			$message = "No notifications";
			echo "<script type='text/javascript'>alert('$message');</script>";
		}

		for($i=0;$i<count($Ndetails);$i++)
		{	
?>
		
		<div class="col-md-6">
			<form action="" method="post" role="form">
			<div class="row">
			
			<table class="col-md-10 col-md-offset-1" cellpadding="6", cellspacing="3" border="6">
			<tr><th>ID:</th><td><input class="form-control" name="id" type="text" value="<?php echo $Ndetails[$i]["id"]; ?>" size="20" readonly/></td></tr>
			<tr><th>Date:</th><td><input class="form-control" name="dt" type="text" value="<?php echo $Ndetails[$i]["date"]; ?>" size="20" readonly/></td></tr>
			<tr><th>Start Time:</th><td><input class="form-control" name="s_time" type="text" value="<?php echo $Ndetails[$i]["start_time"]; ?>" size="20" readonly/></td></tr>
			<tr><th>End Time:</th><td><input class="form-control" name="e_time" type="text" value="<?php echo $Ndetails[$i]["end_time"]; ?>" size="20" readonly/></td></tr>
			<tr><th>No of people:</th><td><input class="form-control" name="nos" type="text" value="<?php echo $Ndetails[$i]["Nstudent"]; ?>" size="20" readonly/></td></tr>
			<tr><th>Reason:</th><td><input class="form-control" name="reason" type="text" value="<?php echo $Ndetails[$i]["reason"]; ?>" size="20" readonly/></td></tr>
			<tr><th>Requested by:</th><td><input class="form-control" name="req" type="text" value="<?php echo $Ndetails[$i]["requested_by"]; ?>" size="20" readonly/></td></tr>
			</table>
			
			</div>
			<div class="row">
			<div class="col-md-offset-1">
			   <button style="width:45%" type="submit" name="approve" class="btn btn-success">Approve</button> 
			   <button style="width:45%" type="submit" name="deny" class="btn btn-danger">Deny</button> 
			</div>
			</div>   
			</form>
		</div>

<?php
	}
?>
</body>
</html>
<?php
}
?>