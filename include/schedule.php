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

		$studentSlotarray = $this->db->getNumStudentOnDay($day);
		$len = count($studentSlotarray);
		$i=0;

		while($len--){

			$busSchedule[$i]["time"] = $studentSlotarray[$i]["time"];
			$busSchedule[$i]["Bus"]  = ceil($studentSlotarray[$i]["students"]/$capacity);

			//echo $busSchedule[$i]["time"] ."  ".$busSchedule[$i]["Bus"]."<br>";
			$i++;
		}

		return $busSchedule;
	}

}

?>