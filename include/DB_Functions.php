<?php

class DB_Functions{
    private $conn;

    //constructor

    function __construct(){
            require_once 'DB_Connect.php';

            $db = new DB_Connect();
            $this->conn = $db->connect();
    }

    // destructor
    function __destruct() {
         
    }

    //Gives number of students in a given slot
    public function getNumStudentsInSlot($slot){
        
        $stmt = $this->conn->prepare("SELECT Student FROM SlotStudent WHERE SlotName=?");
        $stmt->bind_param("s", $slot);

        if ($stmt->execute()) {

            $stmt->bind_result($numStudent);
            $stmt->fetch();
            return $numStudent;
        } else {
            return NULL;
        }
    }

    //get number of student per slot on a givn day 
    //number of alots are predefined so it is not an input
    //it will give a slot student table 
    public function getNumStudentOnDay($day){

        $stmt = $this->conn->prepare("SELECT Slot, Time FROM Academic_Schedule WHERE Day=?");
        $stmt->bind_param("s", $day);

        if ($stmt->execute()) {

            $stmt->bind_result($slot,$time);
            $i=0;
            while($stmt->fetch()){
               $course[$i]["slot"] = $slot;
               $course[$i]["time"] = $time;
               $i++;
            }
            $stmt->close();

            $courselen = count($course);
            $i=0;
            while($courselen--){

                $numStudent = $this->getNumStudentsInSlot($course[$i]["slot"]);
                $studentSlotarray[$i]["time"] = $course[$i]["time"];
                $studentSlotarray[$i]["students"] = $numStudent;

                //echo $studentSlotarray[$i]["time"]."  ".$studentSlotarray[$i]["students"]."<br>";
                $i++;
            }

            return $studentSlotarray;
        } else {
            return NULL;
        }
    }

    //check credentials for login system
    //first checks the credentials if exists then
    //give type as a output to check is the login is done by admin or user
    public function checkCredentials($email,$password){ 


        //echo "email: ".$email."  password ".$password."<br>";
        $stmt = $this->conn->prepare("SELECT type FROM Login_details WHERE username=? and password=?");
        $stmt->bind_param("ss", $email,$password);

        if($stmt->execute()){
            $stmt->bind_result($type);
            $stmt->fetch();
            echo "if in the loop type ".$type."<br> ";
            return $type;

        }else{

            return null;
        }

    }   

    //This is for vhicle class to update the capacity, number and price 
    //Form for this is in ChangeSetting.html
    //returns true if executed and false if there is some error
    public function UpdateVehicleData($num,$capacity,$price){

        $stmt = $this->conn->prepare("UPDATE Vehicle SET Vnum=?, Vcapacity=?,Vprice=? WHERE ID=1");
        $stmt->bind_param("iii", $num,$capacity,$price);

        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }

    }

    //get vehicle capacity
    public function getVehicleCapacity(){

        $id=1;
        $stmt = $this->conn->prepare("SELECT Vcapacity From Vehicle WHERE ID=?");
        $stmt->bind_param("i",$id);

        if($stmt->execute()){
            $stmt->bind_result($capacity);
            $stmt->fetch();
            return $capacity;
        }
        else{
            return null;
        }
    }

    //get number of vehicles
    public function getVehicleNum(){
        $id=1;
        $stmt = $this->conn->prepare("SELECT Vnum From Vehicle WHERE ID=?");
        $stmt->bind_param("i",$id);

        if($stmt->execute()){
            $stmt->bind_result($num);
            $stmt->fetch();
            return $num;
        }
        else{
            return null;
        }
    }

    //get each vehicle price for one time 
    public function getVehiclePrice(){

        $id=1;
        $stmt = $this->conn->prepare("SELECT Vprice From Vehicle WHERE ID=?");
        $stmt->bind_param("i",$id);

        if($stmt->execute()){
            $stmt->bind_result($price);
            $stmt->fetch();
            return $price;
        }
        else{
            return null;
        }
    }

    //get time for a given day and slot
    //uses academic schedule table to extrat data

    public function getTimeForDaySlot($slot,$day){

        $stmt = $this->conn->prepare("SELECT Time FROM Academic_Schedule WHERE Slot=? and Day=?");
        $stmt->bind_param("ss",$slot,$day);

        if($stmt->execute()){
            $stmt->bind_result($time);
            $stmt->fetch();
            return $time;
        }
        else{
            return null;
        }

    }

    //get slot String for each batch
    public function getSlotString(){

        //to get the whole table 
        $gt=1;
        $stmt = $this->conn->prepare("SELECT BatchName, Slots, NumStudent FROM BatchSlot WHERE getable=?");
        $stmt->bind_param("i",$gt);

        if($stmt->execute()){
            $stmt->bind_result($BatchName,$Slots,$NumStudent);
            $i=0;
            while ($stmt->fetch()) {
                $BatchSlot[$i]["BatchName"] = $BatchName;
                $BatchSlot[$i]["Slots"] = $Slots; 
                $BatchSlot[$i]["NumStudent"] = $NumStudent;
                //echo $BatchSlot[$i]["BatchName"]."  ".$BatchSlot[$i]["Slots"]."  ".$BatchSlot[$i]["NumStudent"]."<br>";
                $i++;
            }
            return $BatchSlot;
        }
        else
        {
            return null;
        }
    }


    public function update_invoice_GtoI($day,$VnumGtoI){

        $stmt = $this->conn->prepare("UPDATE Invoice SET VnumGtoI = ? WHERE Day = ?");
        $stmt->bind_param("is",$VnumGtoI,$day);
        if($stmt->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function update_invoice_ItoG($day,$VnumItoG){

        $stmt = $this->conn->prepare("UPDATE Invoice SET VnumItoG = ? WHERE Day = ?");
        $stmt->bind_param("is",$VnumItoG,$day);

        if($stmt->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getInvoiceTable(){

        $stmt = $this->conn->prepare("SELECT Day,VnumGtoI,VnumItoG FROM Invoice");
        
        if($stmt->execute())
        {
            $stmt->bind_result($Day,$VnumGtoI,$VnumItoG);
            $i=0;
            while($stmt->fetch())
            {
                $invoice_table[$i]["day"] = $Day;
                $invoice_table[$i]["VnumGtoI"] = $VnumGtoI;
                $invoice_table[$i]["VnumItoG"] = $VnumItoG;
                $i++;
            }
        }
        return $invoice_table;
    }


    public function insert_request($dt,$stime,$etime,$nos,$reason,$usremail)
    {
        
        $stmt = $this->conn->prepare("INSERT INTO Notification(dt,startTime,endTime,Nstudent,reason,userEmail) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("sssiss",$dt, $stime, $etime, $nos, $reason, $usremail);
       
        if($stmt->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function fetch_request($id)
    {
        $stmt=$this->conn->prepare("DELETE FROM Notification WHERE ID=?");
        $stmt->bind_param("i",$id);

        if($stmt->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function notificate()
    {
        $Ndetails = null;   
        $stmt=$this->conn->prepare("SELECT ID,  dt,startTime,endTime,Nstudent,reason,userEmail FROM Notification");
        
        if($stmt->execute())
        {
            $stmt->bind_result($id,$date,$start_time,$end_time,$Nstudent,$reason,$requested_by);
            $i=0;
            while($stmt->fetch()){
                $Ndetails[$i]["id"] = $id;
                $Ndetails[$i]["date"] = $date;
                $Ndetails[$i]["start_time"] = $start_time;
                $Ndetails[$i]["end_time"] = $end_time;
                $Ndetails[$i]["Nstudent"] = $Nstudent;
                $Ndetails[$i]["reason"] = $reason;
                $Ndetails[$i]["requested_by"] = $requested_by;
                $i++;
            }
        }
        return $Ndetails;
    }

    public function addExtraVehicle($date,$s_time,$e_time,$num){
        $stmt = $this->conn->prepare("INSERT INTO ExtraVehicle(dt,S_time,E_time,Nstudent) VALUES(?,?,?,?)");
        $stmt->bind_param("sssi",$date,$s_time,$e_time,$num);

        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }
    }

    public function getExtraBusSchedule(){

        $stmt = $this->conn->prepare("SELECT ID,dt,S_time,E_time,Nstudent FROM ExtraVehicle");

        if($stmt->execute()){
            $stmt->bind_result($id,$dt,$stime,$etime,$Nstudent);
            $i=0;
            while($stmt->fetch()){
                $EVehicle[$i]["id"] = $id;
                $EVehicle[$i]["dt"] = $dt;
                $EVehicle[$i]["stime"] = $stime;
                $EVehicle[$i]["etime"] = $etime;
                $EVehicle[$i]["Nstudent"] = $Nstudent;
                $i++;   
            }
        }
        return $EVehicle;
    }

}

?>
