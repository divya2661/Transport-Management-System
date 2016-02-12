<?php

class admin_notify{

	//constructor
	function __construct(){

		require_once 'include/DB_Functions.php';
		$db = new DB_Functions();
		$this->db = $db;
	}

	// destructor
    function __destruct() {
         
    }


    public function notify($dt,$stime,$req,$status)
    {
    	//mail("ug201213026@iitj.ac.in", "RE:request", $status , "From: ug201213026@iitj.ac.in");
    	$fetch_not = $this->db->fetch_request($dt,$stime,$req);

    	if($fetch_not==true)
    	{
    		echo "succesfully approved or denied";
    	}
    	else
    	{
    		echo "error granting request";
    	}
    }

    public function fetch_notification()
    {
        $Ndetails=$this->db->notificate();
        return $Ndetails;
    }
}

?>