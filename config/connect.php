<?php
	class Database
	{
		
		protected $connection = null;

		function __construct() {
			try {
	            $this->connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME);
	            
	            if($this->connection->connect_error) {
	            	throw new Exception("Connection failed: " . $conn->connect_error); 
	            }
	        } catch (Exception $e) {
	            throw new Exception($e->getMessage());   
	        }
		}
	}
?>