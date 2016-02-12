<?php

class schedule{

	//constructor
	function __construct(){

		require_once 'include/DB_Functions.php';
		//require_once 'include/invoice.php'
		$db = new DB_Functions();
		//$invoice = new invoice();
		$this->db = $db;
		//$this->invoice = $invoice;
	}

	// destructor
    function __destruct() {
         
    }

    
    //gives complete schedule for given day while provided bus capacity
	public function generate_schedule($day,$Vcapacity){

		//get each batch slots from database
		$totalNvvehicleGtoI = 0;
  		$totalNvvehicleItoG = 0;
		$BatchSlot = $this->db->getSlotString();
		
		echo "here";
		//generate an array of slot and students 
		//for coming to GPRA and going to GPRA

		for ($j=0;$j <count($BatchSlot); $j++) {

			$StartTime = 240000;
			$EndTime = 000000;

	   		$Slots = $BatchSlot[$j]["Slots"];
	   		
	   		for($i=0; $i<strlen($Slots); $i++) {
	   			
	   			$time = $this->db->getTimeForDaySlot($Slots[$i],$day);
	   			
	   			//get start time and end time for each chunk of students
	   			//start time is minimum and end time is maximum value of time
	   			if($time!=null){
	
		   			if($StartTime>$time){

		   				$StartTime = $this->addHour($time,0); //addHour function adds hours in given time
		   			}
		   			if($EndTime<$time){
		   				if($Slots[$i]=="L")
		   				{
		   					$EndTime = $this->addHour($time,3);
		   				}
		   				else
		   				{
		   					$EndTime = $this->addHour($time,1);
		   				}
		   			}
		   		}


	   		}
	   		
	   		//time student array shows how many students entered and left at what time
   			$timeStudent[$j]["StartTime"] = $StartTime;
   			$timeStudent[$j]["EndTime"] = $EndTime;
   			$timeStudent[$j]["NumStudent"] = $BatchSlot[$i]["NumStudent"];

   			

   			//echo "start: ".$timeStudent[$j]["StartTime"]."  End: ".$timeStudent[$j]["EndTime"]."  ".$timeStudent[$j]["NumStudent"]."<br>";

   			
   			//initialize array for bus schedule
   			//STime== start time and Etime = End time
   			for ($i=0; $i < 24; $i++) { 
   				$STime[$i]["NumStudent"] = 0;
   				$ETime[$i]["NumStudent"] = 0;
   			}

   			for ($i=0; $i < count($timeStudent); $i++) {
   				
   				$StimeToInt = $this->timeToInteger($timeStudent[$i]["StartTime"]);
   				$EtimeToInt = $this->timeToInteger($timeStudent[$i]["EndTime"]);

   				$STime[$StimeToInt]["NumStudent"] = $STime[$StimeToInt]["NumStudent"] + $timeStudent[$i]["NumStudent"];
   				$ETime[$EtimeToInt]["NumStudent"] = $ETime[$EtimeToInt]["NumStudent"] + $timeStudent[$i]["NumStudent"];


   			}
	  	}


	  	//Using capacity variable generated the schedule
	  	//divided numStudent by capacity to get num bus 
	  	//stored in a BusSchedule array
	  	//GtoI = GPRA to IITJ and ItoG = IITJ to GPRA
	  	//at the end returns the complete bus schedule in $BusSchedule array
	  	for ($i=8; $i < count($STime); $i++) { 
	  		
  			$GtoInumV = ceil($STime[$i]["NumStudent"]/$Vcapacity);
  			$ItoGnumV = ceil($ETime[$i]["NumStudent"]/$Vcapacity);
  			

	  		if($STime[$i]["NumStudent"]!=0){
	 
	  			$BusSchedule[$i]["GtoI"]["time"] = $i*100-70;
	  			$BusSchedule[$i]["GtoI"]["NumVehicle"] =  $GtoInumV;
	  			$totalNvvehicleGtoI = $totalNvvehicleGtoI + $GtoInumV;
	  		}
	  		else{
	  			
	  			$BusSchedule[$i]["GtoI"]["time"] = $i*100-70;
	  			$BusSchedule[$i]["GtoI"]["NumVehicle"] =  1;
	  			$totalNvvehicleGtoI = $totalNvvehicleGtoI + 1;
	  		}
	  		if($ETime[$i]["NumStudent"]!=0){
	  			$BusSchedule[$i]["ItoG"]["time"] = $i*100+30;
	  			$BusSchedule[$i]["ItoG"]["NumVehicle"] = $ItoGnumV ;
	  			$totalNvvehicleItoG = $totalNvvehicleItoG + $ItoGnumV;
	  		}
	  		else{
	  			
	  			$BusSchedule[$i]["ItoG"]["time"] = $i*100+30;
	  			$BusSchedule[$i]["ItoG"]["NumVehicle"] = 1;
	  			$totalNvvehicleItoG = $totalNvvehicleItoG + 1;
	  		}
	  	}

	  	// $GtoIinvoice = $this->invoice->update_invoice_GtoI($day,$totalNvvehicleGtoI);
	  	// $ItoGinvoice = $this->invoice->update_invoice_ItoG($day,$totalNvvehicleItoG);

	  	// if(!$GtoIinvoice || !$ItoGinvoice){
	  	// 	echo "invoice updation error in schedule.php";
	  	// }
	  	

	  	// //Uncomment to print bus schedule
	  	for ($i=8; $i < count($STime); $i++) { 
	  		echo $BusSchedule[$i]["GtoI"]["time"]." x ".$BusSchedule[$i]["GtoI"]["NumVehicle"]."  ".$STime[$i]["NumStudent"]."<br>";
	  	}
	  	echo "<br><br>";
	  	for ($i=8; $i < count($STime); $i++) { 
	  		echo $BusSchedule[$i]["ItoG"]["time"]." x ".$BusSchedule[$i]["ItoG"]["NumVehicle"]."  ".$ETime[$i]["NumStudent"]."<br>";
	  	}
	  
		return $BusSchedule;
	}	

	//add hours in a given time
	public function addHour($time,$x){
    	
    	$timestamp = strtotime($time) + $x*60*60;
		$time = date('H:i', $timestamp);
		return $time;
    }

    //Conver TIME type to INT type
    public function timeToInteger($time){
		$Tint  = idate("H",strtotime($time));
		return $Tint;
    }

}

?>