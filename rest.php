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


require 'config/database.php';
require 'classes/courses.php';

$method = $_SERVER['REQUEST_METHOD'];

//If an id parameter exists in the url, store it in a variable
if (isset($_GET['id']))
{
    $id = $_GET['id'];
}

//Construct a new courses object with the database connection as a property
$database = new database();
$db = $database->connect();
$courses = new courses($db);

switch ($method)
{
    case 'GET':
        /*If the database contains any rows store their data in the variable 
          If not, store a message informing the user about this instead*/
        $result = $courses->read();

        if (sizeof($result) > 0)
        {
            http_response_code(200);
        }
        else
        {
            http_response_code(200);
            $result = array(
                "message" => "No courses found"
            );
        }
    break;

      
    case 'POST':
        
        //Read the JSON data from the call anf convert it to an object.
        $data = json_decode(file_get_contents("php://input"));
        /*Store a message informing the user wether the operation
        was successful or not*/
        if ($courses->create($data))
        {
            http_response_code(201);
            $result = array(
                "message" => "Course created"
            );
        }
        else
        {
            http_response_code(503);
            $result = array(
                "message" => "Course not created"
            );
        }
        
    
    break;

    case 'PUT':
        /*Tell the user if an ID is not sent.
        If otherwise, run the operation as usual */
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

            if ($courses->update($id, $data))
            {
                http_response_code(200);
                $result = array(
                    "message" => "Course updated"
                );
            }
            else
            {
                http_response_code(503);
                $result = array(
                    "message" => "Course not updated"
                );
            }

        }
        
    break;

    case 'DELETE':

        if (!isset($id))
        {
            http_response_code(400);
            $result = array(
                "message" => "No id is sent"
            );
        }
        else
        {

            if ($courses->delete($id))
            {
                http_response_code(200);
                $result = array(
                    "message" => "Course deleted"
                );
            }
            else
            {
                http_response_code(503);
                $result = array(
                    "message" => "Course not deleted"
                );
            }
        }
    break;

}
//Convert the result to a JSON string and return it to the user
$json = json_encode($result, JSON_INVALID_UTF8_IGNORE);

$db = $database->close();

print_r($json);
