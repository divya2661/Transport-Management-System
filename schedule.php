<?php

class schedule{

	//constructor
	function __construct(){

		require_once 'include/DB_Functions.php';
		$db = new DB_Functions();
		$this->db = $db;
	}

	// destructor
    function __destruct() {
         
    }

    
	public function generate_schedule($day,$capacity){

		$BatchSlot = $this->db->getSlotString();
		for ($j=0;$j <count($BatchSlot); $j++) {

			$StartTime = 170000;
			$EndTime = 000000;

	   		$Slots = $BatchSlot[$j]["Slots"];
	   		
	   		for($i=0; $i<strlen($Slots); $i++) {
	   			
	   			$time = $this->db->getTimeForDaySlot($Slots[$i],$day);
	   			
	   			if($StartTime>$time && $time!=""){

	   				$StartTime = $this->addHour($time,0);
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
	   		
   			$timeStudent[$j]["StartTime"] = $StartTime;
   			$timeStudent[$j]["EndTime"] = $EndTime;
   			$timeStudent[$j]["NumStudent"] = $BatchSlot[$i]["NumStudent"];

   			//array_multisort(($timeStudent));

   			echo "start: ".$timeStudent[$j]["StartTime"]."  End: ".$timeStudent[$j]["EndTime"]."  ".$timeStudent[$j]["NumStudent"]."<br>";

   			
   			//initialize array
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




   
		return $BatchSlot;
	}

	public function addHour($time,$x){
    	
    	$timestamp = strtotime($time) + $x*60*60;
		$time = date('H:i', $timestamp);
		return $time;
    }

    public function timeToInteger($time){
		$Tint  = idate("H",strtotime($time));
		return $Tint;
    }

}

?>