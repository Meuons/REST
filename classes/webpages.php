<?php

class webpages {
  private $conn;

  public $id;
  public $url;
  public $title;
  public $description;

  //Construct a new object with the parameter as the conn property
  function __construct($conn) {
    $this->conn = $conn;
  }
  
function read(){
    $sql = "SELECT * FROM webpages;";
    $result = mysqli_query($this->conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);

}
  /*Strip the data of HTML tags and characters 
  that are not accepted in the SQL statement*/
function create($data){

  $url = strip_tags($this->conn->real_escape_string($data->url));
  $title = strip_tags($this->conn->real_escape_string($data->title));
  $description = strip_tags($this->conn->real_escape_string($data->description));


  $sql = "INSERT INTO webpages(url, title, description) VALUES('$url', '$title', '$description');";
  $result = mysqli_query($this->conn, $sql);
  return $result;
}

function update($id, $data) : bool{
    $url = strip_tags($this->conn->real_escape_string($data->url));
    $title = strip_tags($this->conn->real_escape_string($data->title));
    $description = strip_tags($this->conn->real_escape_string($data->description));

  $sql = "UPDATE webpages SET url = '$url', title = ' $title', description = '$description' WHERE id='$id';";
  $result = mysqli_query($this->conn, $sql);
  return $result;
}




function delete($id) : bool{
  $sql = "DELETE FROM webpages WHERE id='$id';";

  $result = mysqli_query($this->conn, $sql);
  return $result;
}

}