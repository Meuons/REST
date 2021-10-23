<?php

class user {
  private $conn;

  public $username;
  public $password;
  public $token;
  //Construct a new object with the parameter as the conn property
  function __construct($conn) {
    $this->conn = $conn;
  }
  

function checkLogin($data){
    $username = $this->conn->real_escape_string($data->username);
    $password= $this->conn->real_escape_string( $data->password);

    $sql = "SELECT * FROM users WHERE username = '$username';";
    $result = mysqli_query($this->conn, $sql);
    $row = mysqli_fetch_array($result);
    $stored_password = $row['password'];


   /*If the sent password matches the one in the database 
   generate a random token and return it to the user*/
   if ($password == ''){
    return array(
        "message" => "Type in a password"
    );
   }
    else if($password == $stored_password){

    $token = uniqid();
    $sql = "UPDATE users SET token ='$token' WHERE username = '$username';";
    $result = mysqli_query($this->conn, $sql);

    if($result == 1){
        
        return array(
            "token" => $token
        );
    }
    else{
       return array(
            "message" => "Error creating token"
        );
    }
    }
    else{

        return array(
            "message" => "Invalid username or password"
        );

    }
}

}