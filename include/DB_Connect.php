<?php

class DB_connect{
		private $conn;

		public function connect(){
			require_once 'include/Config.php';

			$this->conn  = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
			return $this->conn;
		}
}
	
?>