<?php
	
class invoice{

	//constructor
	function __construct(){

		require_once 'include/DB_Functions.php';
		$db = new DB_Functions();
		$this->db = $db;
	}

	// destructor
    function __destruct() {
         
    }

    public function update_invoice_GtoI($day,$Vnum)	{

    	$updated = $this->db->update_invoice_GtoI($day,$Vnum);
    	if($updated)
    	{
    		return true;
    	}
    	else
    	{
    		return false;
    	}

    }

    public function update_invoice_ItoG($day,$Vnum){

    	$updated = $this->db->update_invoice_ItoG($day,$Vnum);
    	if($updated)
    	{
    		return true;
    	}
    	else
    	{
    		return false;
    	}

    }	

    public function generate_invoice($price,$capacity){

    	$invoice_table = $this->db->getInvoiceTable();
        $Evehicle = $this->db->getExtraBusSchedule();

        $currentDate = date('Y-m-d');
        $startDate = date('Y')."-".date('m')."-".date(1);



    	$currentDaynum = date("d");
    	$currentDay = jddayofweek ( cal_to_jd(CAL_GREGORIAN, date("m"),date("d"), date("Y")) , 0);

    	$startDay = jddayofweek ( cal_to_jd(CAL_GREGORIAN, date("m"),date(1), date("Y")) , 0 ) - 1;
    	$NumBusGtoI = 0;
    	$NumBusItoG = 0;
        $NumBusExtra = 0;


    	for ($i=0; $i<$currentDaynum; $i++) { 
    	
    		$NumBusGtoI = $NumBusGtoI + $invoice_table[$startDay%7]["VnumGtoI"];
    		$NumBusItoG = $NumBusItoG + $invoice_table[$startDay%7]["VnumItoG"];
    		$startDay++;
    	}

        for ($i=0; $i <count($Evehicle); $i++) {
            $d = $Evehicle[$i]["dt"];
            $checkDate = substr($d,-4)."-".substr($d,3,-5)."-".substr($d,0,-8);

            if($checkDate>=$startDate && $checkDate<=$currentDate){

                $NumBusExtra = $NumBusExtra + ceil($Evehicle[$i]["Nstudent"]/$capacity);
            }

        }

    	$invoice["GtoI"]["TotalVnum"] = $NumBusGtoI;
    	$invoice["GtoI"]["TotalPrice"] = $NumBusGtoI*$price;

    	$invoice["ItoG"]["TotalVnum"] = $NumBusItoG;
    	$invoice["ItoG"]["TotalPrice"] = $NumBusItoG*$price;

        $invoice["extra"]["TotalVnum"] = $NumBusExtra;
        $invoice["extra"]["TotalPrice"] = $NumBusExtra*$price;

    	return $invoice;
    }



}

?>