<?php
	
	require_once 'include/invoice.php';
	require_once 'include/vehicle.php';

	$invoice = new invoice();
	$vehicle = new vehicle();
	$price = $vehicle->getVechiclePrice();
	$capacity  = $vehicle->getVechicleCapacity();
	$finalInvoice = $invoice->generate_invoice($price,$capacity);
	

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
 	
  	<div style="margin-top:5%; padding-bottom: 3%;" class="col-md-4 col-sm-12 col-md-offset-4">   
     
	    	<p style="font-size:23px">
	    		<?php
	    			echo "Invoice From ".date(1)."-".date("m")."-".date("Y")." To ".date("d")."-".date("m")."-".date("Y");
	    		?>

	    	</p>
	    	<br>
	        <table class="table table-bordered" >
	            <thead> 

	              <tr> 
	                <th>From</th>
	                <th>To</th>
	                <th>Buses</th>
	                <th>Amount</th>        
	              </tr> 
	            </thead> 
	            <tbody>
	              <tr>
	              	<td>GPRA</td>
	              	<td>IITJ</td>
	              	<td><?php echo $finalInvoice["GtoI"]["TotalVnum"] ?> </td>
	              	<td><?php echo $finalInvoice["GtoI"]["TotalPrice"]?></td>
	              </tr>
	              <tr>
	              	<td>IITJ</td>
	              	<td>GPRA</td>
	              	<td><?php echo $finalInvoice["ItoG"]["TotalVnum"]?> </td>
	              	<td><?php echo $finalInvoice["ItoG"]["TotalPrice"]?></td>
	              </tr>
	            </tbody> 
	          </table>
	          <table class="table table-bordered">
	          	<thead>
	          		<tr>
	          			<th>Total Extra Buses</th>
	          			<th>Total Amount</th>
	          		</tr>
	          	</thead>
	          	<tbody>
	          		<tr>
	          			<td><?php echo $finalInvoice["extra"]["TotalVnum"] ?></td>
	          			<td><?php echo $finalInvoice["extra"]["TotalPrice"] ?></td>
	          		</tr>
	          	</tbody>
	          </table>
	     
    </div>
        
   


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>