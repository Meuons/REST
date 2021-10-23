<?php

class token {
  private $conn;

  public $token;
  //Construct a new object with the parameter as the conn property
  function __construct($conn) {
    $this->conn = $conn;
  }
  /*Get the token from the database and return it*/
function getToken(){
    $sql = "SELECT token FROM users ;";
    $result = mysqli_query($this->conn, $sql);
    $token = $result->fetch_assoc();

    return  $token['token'];
}

}