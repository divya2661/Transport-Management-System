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


    public function place_request($admin_email,$dt,$stime,$etime,$nos,$reason,$usremail)
    {

    	$message="date:" . $dt . "<br>";
        $message.="start time:" . $stime . "<br>";
        $message.="end time:" . $etime . "<br>";
        $message.="no of people:" . $nos . "<br>";
        $message.="reason:" . $reason . "<br>";
        $mail=false;
        $notify=false;
        
        

        if (mail("ug201213005@iitj.ac.in", "request", $message , "From: ug201213026@iitj.ac.in")) 
        { 
            $mail=true;
        } 
        else 
        { 
            $mail=false; 
        }

       
    	$insert_req = $this->db->insert_request($dt,$stime,$etime,$nos,$reason,$usremail);

    	if($insert_req==true && $mail==true){
    		$result= "Request has been sent.";
        }
    	elseif($insert_req==true && $mail==false){

    		$result = "Notification sent.";
        }
        elseif($insert_req==false && $mail==true){
            $result = "Email has been sent to admin regarding your request.";
        }
        else
        {
            $result = "There is some error could't notify admin. Please try again";
        }
        return $result;
    }
}

?>