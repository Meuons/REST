<?php

class experience {
  private $conn;

  public $id;
  public $workplace;
  public $title;
  public $start;
  public $end;
  
  //Construct a new object with the parameter as the conn property
  function __construct($conn) {
    $this->conn = $conn;
  }
  
function read(){
    $sql = "SELECT * FROM experience;";
    $result = mysqli_query($this->conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);

}
  /*Strip the data of HTML tags and characters 
  that are not accepted in the SQL statement*/
function create($data){

  $workplace = strip_tags($this->conn->real_escape_string($data->workplace));
  $title = strip_tags($this->conn->real_escape_string($data->title));
  $start = strip_tags($this->conn->real_escape_string($data->start));
  $end = strip_tags($this->conn->real_escape_string($data->end)) ;

  $sql = "INSERT INTO experience(workplace, title, end, start)VALUES('$workplace', '$title', '$end', '$start');";


  $result = mysqli_query($this->conn, $sql);
  return $result;
}

function update($id, $data) : bool{
    $workplace = strip_tags($this->conn->real_escape_string($data->workplace));
    $title = strip_tags($this->conn->real_escape_string($data->title));
    $start = strip_tags($this->conn->real_escape_string($data->start));
    $end = strip_tags($this->conn->real_escape_string($data->end)) ;

  $sql = "UPDATE experience SET workplace = '$workplace', title = ' $title', start = '$start', end = '$end' WHERE id='$id';";
  $result = mysqli_query($this->conn, $sql);
  return $result;
}




function delete($id) : bool{
  $sql = "DELETE FROM experience WHERE id='$id';";
  $result = mysqli_query($this->conn, $sql);
  return $result;
}

}