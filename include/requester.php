<?php

class requester{

	//constructor
	function __construct(){

		require_once 'include/DB_Functions.php';
		$db = new DB_Functions();
		$this->db = $db;
	}

	// destructor
    function __destruct() {
         
    }


    public function place_request($admin_email,$dt,$stime,$etime,$nos,$reason,$usr,$usremail)
    {
    	$message="date:" . $dt . "<br>";
        $message.="start time:" . $stime . "<br>";
        $message.="end time:" . $etime . "<br>";
        $message.="no of people:" . $nos . "<br>";
        $message.="reason:" . $reason . "<br>";
        

        if (mail("ug201213005@iitj.ac.in", "request", $message , "From: ug201213026@iitj.ac.in")) 
        { 
            echo '<p>Your message has been sent!</p>';
        } 
        else 
        { 
            echo '<p>Something went wrong, go back and try again!</p>'; 
        }

    	$insert_req = $this->db->insert_request($admin_email,$dt,$stime,$etime,$nos,$reason,$usr,$usremail);

    	if($insert_req==true)
    		echo "Request placed";
    	else
    		echo "error placing request";
    }
}

?>