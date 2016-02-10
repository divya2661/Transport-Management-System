<?php
  
  require_once 'include/vehicle.php';

  $vehicle = new vehicle();
  $output = "";

  if(isset($_POST['Bnum']) && isset($_POST['Bcapacity']) && isset($_POST['Bprice'])){

    $num = $_POST['Bnum'];
    $capacity = $_POST['Bcapacity'];
    $price = $_POST['Bprice'];

    if($num!=0 && $capacity!=0 && $price!=0){

      $updated = $vehicle->updateVehicleData($num,$capacity,$price);
      if($updated){
        $output = "Updation Successful";
      }
      else
      {
        $output = "There is some error, Please try again";
      }
    }
    else{
      $output = "All fields are required.";
    }

  }
  else{

   $output = "All fields are required.";
  }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bus Schedule</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    
    <style type="text/css">
    </style>
  </head>

  <body >   
    
    <div style="margin-top:10%; background-color: rgb(209, 252, 255); padding-bottom: 3%;" class="col-md-4 col-sm-12 col-md-offset-4">   
        <h2 style="color:#5bc0de;text-align:center" >Change Settings</h2>
          <form action="" role="form" method="post">
            <div class="form-group">

              <input name="Bnum" type="number" class="form-control" placeholder="Enter number of buses"><br>
              <input name="Bcapacity" type="number" class="form-control" placeholder="Enter bus capacity"><br>  
              <input name="Bprice" type="number" class="form-control" placeholder="Enter price per bus">
            </div>
            <button style="width:100%" name="sub" type="submit" class="btn btn-info">Change Settings</button>
          </form>
          <h4 style="text-align:center"><?php echo $output ?></h4>
      </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>