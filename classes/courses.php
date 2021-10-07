
<?php

class courses {
  private $conn;

  public $id;
  public $name;
  public $code;
  public $period;
  public $syllabus;
  
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

  $name = strip_tags($this->conn->real_escape_string($data->name));
  $code = strip_tags($this->conn->real_escape_string($data->code));
  $progression = strip_tags($this->conn->real_escape_string($data->progression));
  $syllabus = strip_tags($this->conn->real_escape_string($data->syllabus)) ;

  $sql = "INSERT INTO courses(name, code, progression, syllabus)VALUES('$name', '$code', '$progression', '$syllabus');";
  $result = mysqli_query($this->conn, $sql);
  return $result;
}

function update($id, $data) :bool{
  $name = strip_tags($this->conn->real_escape_string($data->name));
  $code = strip_tags($this->conn->real_escape_string($data->code));
  $progression = strip_tags($this->conn->real_escape_string($data->progression));
  $syllabus = strip_tags($this->conn->real_escape_string($data->syllabus)) ;

  $sql = "UPDATE courses SET name = '$name', code = '$code', progression = '$progression', syllabus = '$syllabus' WHERE id='$id';";
  $result = mysqli_query($this->conn, $sql);
  return $result;
}




function delete( $id) : bool{
  $sql = "DELETE FROM courses WHERE id='$id';";
  $result = mysqli_query($this->conn, $sql);
  return $result;
}

}
