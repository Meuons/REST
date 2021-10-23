<?php
/*Headers declaring settings for the REST web service*/

//Make the web service accessible from all domains
header('Access-Control-Allow-Origin: *');

//Specify the type of format the data i sent in
header('Content-Type: application/json');

//Specify the methods that the web service allows
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE');

//Specify the type of headers that are allowed in calls from the client side. This prevents some potential CORS errors 
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

//Load the class files
require 'config/database.php';
require 'classes/courses.php';
require 'classes/experience.php';
require 'classes/webpages.php';
require 'classes/users.php';
require 'classes/token.php';
$method = $_SERVER['REQUEST_METHOD'];
//Construct a new object with the database connection as a property
$database = new database();
$db = $database->connect();
$courses = new courses($db);
$experience = new experience($db);
$webpages = new webpages($db);
$users = new user($db);
$tokenClass = new token($db);
//Get the token from the database
    $dbToken = $tokenClass->getToken();

if (isset($_GET['id']))
{
    $id = $_GET['id'];
}

if (isset($_GET['table']))
{
    /*Assign a different class to the table 
    depending on what table id is sent
    */
    $table = $_GET['table'];           
    
           if($table == 1){
                $class = $courses;
            }
            else if($table == 2){
                $class = $experience;
            }
            else if($table == 3){
                $class = $webpages;
            }
            else if($table == 4){
                $class = $tokenClass;
            }
            else{
                $result = array(
                    "message" => "No table found"
                );
            }
}



if (isset($_GET['login']))
{ 
    $login = $_GET['login'];
    $class = $users;


}

if (isset($_GET['token']))
{ 
    $token = $_GET['token'];

}

switch ($method)
{
    case 'GET':
   
      /*If a login parameter is not sent ge the data from the database*/
        if(!isset($login)){

           
            /*If the database contains any rows store their data in the variable 
          If not, store a message informing the user about this instead*/
        $courseData = $courses->read();
        $webpageData = $webpages->read();
        $experienceData = $experience->read();

        $courseJSON = json_encode($courseData, JSON_INVALID_UTF8_IGNORE);
        $webpageJSON = json_encode($webpageData, JSON_INVALID_UTF8_IGNORE);
        $experienceJSON = json_encode($experienceData, JSON_INVALID_UTF8_IGNORE);

      /* $result = '{ "courses":'.$courseJSON.', "webpages":'.$webpageJSON.', "experience":'.$experienceJSON.'}';*/

       $result = array(
        "courses" => $courseData,
        "experience" => $experienceData,
        "webpages" => $webpageData
        
    );

        if (sizeof($result) > 0)
        {
            http_response_code(200);
        }
        else
        {
            http_response_code(200);
            $result = array(
                "message" => "No rows found"
            );
        }
}
/*If a parameter is sent check that the sent 
token matches the one from the database*/
else{

    if( $token == $dbToken ) {
            
        $result = array(
            "loggedIn" => true
        );
    }
    else{
        $result = array(
            "loggedIn" => false
        );
    }
}
    break;
      
    case 'POST':
        
        //Read the JSON data from the call anf convert it to an object.
        $data = json_decode(file_get_contents("php://input"));
        /*Store a message informing the user wether the operation
        was successful or not*/

     if(!isset($login)){

    if(!isset($token)){
        /*If a token is not sent, send back a message telling the user this*/
        $result = array(
            "message" => "No token sent"
        );

    }
                  
        else if( $token == $dbToken ) {

            
            if ($class->create($data))  {
            http_response_code(201);
            $result = array(
                "message" => "Row created"
            );
        }
        else  {
            http_response_code(503);
            $result =array(
                "message" => "Row not created"
            );
        }
        
        }
        /*Tell the user i the tokens doesn't match*/
        else{

               
            $result = array (
                
                "message" => "Invalid token"

            ); 
    }  

     }

     else{
   
     /*Check that the password and username is correct*/
       
 $result = $class->checkLogin($data);   

           if (sizeof($result) > 0)
            {
                http_response_code(200);
            }
            else
            {
                http_response_code(200);
                $result = array(
                    "message" => "No token found"
                );
            } 
      
    }
    break;

    case 'PUT':
        /*Tell the user if an ID is not sent.
        If otherwise, run the operation as usual */


            if(!isset($token)){
                $result = array(
                    "message" => "No token sent"
                );
        
            }
                          
                else if( $token == $dbToken ) {

      
        if (!isset($id))
        {
            http_response_code(400); 
            $response = array(
                "message" => "No id is sent"
            );

            
        }
        else
        {
            $data = json_decode(file_get_contents("php://input"));

            if ($class->update($id, $data))
            {
                http_response_code(200);
                $result = array(
                    "message" => "Row updated"
                );
            }
            else
            {
                http_response_code(503);
                $result = array(
                    "message" => "Row not updated"
                );
            }

        }
    }

    else{

        $result = array (
                
            "message" => "Invalid token"

        ); 
    }
    break;

    case 'DELETE':


        if(!isset($token)){
            $result = array(
                "message" => "No token sent"
            );
    
        }
                      
            else if( $token == $dbToken ) {

        if (!isset($id))
        {
            http_response_code(400);
            $result = array(
                "message" => "No id is sent"
            );
        }
        else
        {

            if ($class->delete($id))
            {
                http_response_code(200);
                $result = array(
                    "message" => "Row deleted"
                );
            }
            else
            {
                http_response_code(503);
                $result = array(
                    "message" => "Row not deleted"
                );
            }
        }
    }
    else{

        $result = array (
                
            "message" => "Invalid token"

        ); 
    }
    break;

}
//Convert the result to a JSON string and return it to the user

 print_r(json_encode($result, JSON_INVALID_UTF8_IGNORE));
 $db = $database->close();

