<?php
	
class vehicle{
	//constructor
	function __construct(){

		require_once 'include/DB_Functions.php';
		$db = new DB_Functions();
		$this->db = $db;
	}

	// destructor
    function __destruct() {
         
    }

    //update Vehicle table in database 
    function updateVehicleData($num,$capacity,$price){

    	$updateDone = $this->db->UpdateVehicleData($num,$capacity,$price);
    	if($updateDone==true)
    	{
    		return true;
    	}
    	else
    	{
    		return false;
    	}
    }

    //update Vehicle capacity
    function getVechicleCapacity(){

    	$capacity = $this->db->getVehicleCapacity();
    	if($capacity!=null)
    	{
    		return $capacity;
    	}
    	else
    	{
    		return null;
    	}
    }

    //update number of vehicles
    function getVechicleNum(){

    	$num = $this->db->getVehicleNum();
    	if($num!=null)
    	{
    		return $num;
    	}
    	else
    	{
    		return null;
    	}
    }

    //update Vehicle price for each time it goes
    function getVechiclePrice(){

    	$price = $this->db->getVehiclePrice();
    	if($price!=null)
    	{
    		return $price;
    	}
    	else
    	{
    		return null;
    	}
    }

}

?>