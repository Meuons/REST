<?php
class database{
//Store the database connection as properties

private $host = //host address goes here;
private $db_name = //database name goes here;
private $username = //username goes here;
private $password = //password goes here;

private $conn;
public function connect(){


    

    //Create a database connection
    $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name );


      if($this->conn->connect_errno > 0){
        die("Error connecting: " . $this->conn->connect_error);
    }

    return $this->conn;

}
    public function close(){
        $this->conn = null;
    }
}

