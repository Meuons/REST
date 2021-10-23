
<?php

class courses {
  private $conn;

  public $id;
  public $title;
  public $academy;
  public $start;
  public $end;
  
  //Construct a new object with the parameter as the conn property
  function __construct($conn) {
    $this->conn = $conn;
  }
  
function read(){
    $sql = "SELECT * FROM courses;";
    $result = mysqli_query($this->conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);

}
  /*Strip the data of HTML tags and characters 
  that are not accepted in the SQL statement*/
function create($data){

  $title = strip_tags($this->conn->real_escape_string($data->title));
  $academy = strip_tags($this->conn->real_escape_string($data->academy));
  $start = strip_tags($this->conn->real_escape_string($data->start));
  $end = strip_tags($this->conn->real_escape_string($data->end));

  $sql = "INSERT INTO courses(title, academy, start, end)VALUES('$title', '$academy', '$start', '$end');";
  $result = mysqli_query($this->conn, $sql);
  return $result;
}

function update($id, $data) :bool{
  $title = strip_tags($this->conn->real_escape_string($data->title));
  $academy = strip_tags($this->conn->real_escape_string($data->academy));
  $start = strip_tags($this->conn->real_escape_string($data->start));
  $end = strip_tags($this->conn->real_escape_string($data->end));


  $sql = "UPDATE courses SET title = '$title', academy = '$academy', start = '$start', end = '$end' WHERE id='$id';";
  $result = mysqli_query($this->conn, $sql);
  return $result;
}




function delete( $id) : bool{
  $sql = "DELETE FROM courses WHERE id='$id';";
  $result = mysqli_query($this->conn, $sql);
  return $result;
}

}
