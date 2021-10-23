<?php
class database{
//Store the database connection as properties

private $host = 'studentmysql.miun.se';
private $db_name ='mama2006';
private $username = 'mama2006';
private $password = 'mx4mtCZ2kR';

private $conn;
public function connect(){


    

    //Create a database connection
    $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name );


      if($this->conn->connect_errno > 0){
        die("Fel vid anslutning: " . $this->conn->connect_error);
    }

    return $this->conn;

}
    public function close(){
        $this->conn = null;
    }
}

