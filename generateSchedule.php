<?php
  
  require_once 'include/schedule.php';
  require_once 'include/vehicle.php';
  $schedule = new schedule();
  $vehicle = new vehicle();

  $day = array("Monday","Tuesday","Wednesday","Thursday","Friday");
  $showDay = array("Mon","Tues","Wed","Thu","Fri");
  $Vcapacity = $vehicle->getVechicleCapacity();
  
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bus Schedule</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.js"></script>
    
    <style type="text/css">
    </style>
  </head>

  <body> 
   
   <!--  <button id="cmd" type="button" class="btn btn-danger">Download Bus Schedule</button> -->
    <!-- bus Schedule from GPRA to IITJ -->
    
    <div id = "content" class="col-md-12 col-sm-12 ">
      <div style="width:50%" class="col-md-6 col-sm-6">
        <h4>Bus Schedule From GPRA to IITJ</h4>
        <?php
          for ($i=0; $i < count($day); $i++) {
            $BusSchedule = $schedule->generate_schedule($day[$i],$Vcapacity); 
        ?>
        <div style="padding-left:0px;padding-right:0px" class="col-md-2 col-sm-2">  
          <table class="table table-bordered">
            <thead> 
              <tr> 
                <th><?php echo $showDay[$i] ?></th>
                
              </tr> 
            </thead> 
            <tbody>

              <?php

                for ($j=8; $j < 24; $j++) { 
                  echo "<tr><td>".$BusSchedule[$j]["GtoI"]["time"]." x ".$BusSchedule[$j]["GtoI"]["NumVehicle"]."</td></tr>";
                }

              ?>
            </tbody> 
          </table>
        </div>
        <?php
          }
        ?>

        <div style="padding-left:0px;padding-right:0px" class="col-md-2 col-sm-2">  
          <table class="table table-bordered">
            <thead> 
              <tr> 
                <th>Sat/Sun</th>
                
                
              </tr> 
            </thead> 
            <tbody>
              <tr><td>830 x 1</td></tr>
              <tr><td>1030 x 1</td></tr>
              <tr><td>1230 x 1</td></tr>
              <tr><td>1330 x 1</td></tr>
              <tr><td>1530 x 1</td></tr>
              <tr><td>1730 x 1</td></tr>
              <tr><td>1930 x 1</td></tr>
              <tr><td>2130 x 1</td></tr>
              <tr><td></td></tr>
              <tr><td></td></tr>
              <tr><td></td></tr>
              <tr><td></td></tr>
              <tr><td></td></tr>
            </tbody> 
          </table>
        </div>
      </div>



      <!-- schedule from IITJ to GPRA -->
      <div style="width:50%" class="col-md-6 col-sm-12">
        <h4>Bus Schedule From IITJ to GPRA</h4  >
        
        <?php
        for ($i=0; $i < count($day); $i++) { 
          $BusSchedule = $schedule->generate_schedule($day[$i],$Vcapacity); 
        ?>
        <div style="padding-left:0px;padding-right:0px" class="col-md-2 col-sm-2">  
          <table class="table table-bordered">
            <thead> 
              <tr> 
                <th><?php echo $showDay[$i] ?></th>
                
                
              </tr> 
            </thead> 
            <tbody>

              <?php

                for ($j=8; $j < 24; $j++) { 
                  echo "<tr><td>".$BusSchedule[$j]["ItoG"]["time"]." x ".$BusSchedule[$j]["ItoG"]["NumVehicle"]."</td></tr>";
                }

              ?>
            </tbody> 
          </table>
        </div>
        <?php
          }
        ?>

        <div style="padding-left:0px;padding-right:0px" class="col-md-2 col-sm-2">  
          <table class="table table-bordered">
            <thead> 
              <tr> 
                <th>Sat/Sun</th>
                
                
              </tr> 
            </thead> 
            <tbody>
              <tr><td>830 x 1</td></tr>
              <tr><td>1030 x 1</td></tr>
              <tr><td>1230 x 1</td></tr>
              <tr><td>1330 x 1</td></tr>
              <tr><td>1530 x 1</td></tr>
              <tr><td>1730 x 1</td></tr>
              <tr><td>1930 x 1</td></tr>
              <tr><td>2130 x 1</td></tr>
              <tr><td></td></tr>
              <tr><td></td></tr>
              <tr><td></td></tr>
              <tr><td></td></tr>
              <tr><td></td></tr>
            </tbody> 
          </table>
        </div>
       </div>
    </div>
  </body>
</html> 