<?php
 error_reporting(E_ERROR | E_PARSE);
require_once(__DIR__.'/../db_details.php');
 
class DATABASECLASS{
  
    private $hostname = hostname;
    private $username = username;
    private $password = password;
    private $database = database;

    protected $connection;
    
    public function __construct(){
        $this->db_connect();
    }
    
    public function db_connect(){
        $connection = new mysqli($this->hostname, $this->username, $this->password, $this->database);
        #$Database_error = mysqli_connect_error($Connection);
        
        if($connection->connect_error){
            die('Database Error: '.$connection->connect_error);
        }
        
        return $this->connection = $connection;
    }
    
}



?>