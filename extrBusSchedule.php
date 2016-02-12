<?php
  
  require_once 'include/schedule.php';
  require_once 'include/vehicle.php';
 
  $schedule = new schedule();
  $vehicle = new vehicle();
  $Vcapacity = $vehicle->getVechicleCapacity();

  $ExtraBusSchedule = $schedule->getExtraBusSchedule();

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

  <body> 

    

      <div style="padding-left:0px;padding-right:0px;margin-top:4%" class="col-md-4 col-md-offset-4">  
      <h3 style="text-align:center">Extra Bus Schedule</h3>
        <table class="table table-bordered">
          <thead> 
            <tr> 
              <th>Bus</th>
              <th>Time</th>
              <th>Date</th>
              
              
            </tr> 
          </thead> 
          <tbody>
          <?php for ($i=0; $i <count($ExtraBusSchedule) ; $i++) { 
            
           ?>
            <tr>
              <td><?php  echo ceil($ExtraBusSchedule[$i]["Nstudent"]/$Vcapacity); ?></td>
              <td>
                <?php $str=$ExtraBusSchedule[$i]["stime"];    
                      $t = (10*$str[0] + $str[1])*100-70;
                  echo $t; ?>
              </td>
              <td><?php  echo $ExtraBusSchedule[$i]["dt"]; ?></td>
            </tr>
            <?php
              }
            ?>
            
          </tbody> 
        </table>
      </div>




    


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html> 