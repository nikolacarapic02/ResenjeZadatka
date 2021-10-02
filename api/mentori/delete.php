<?php

use config\DB;
use models\MentorClass;
use includes\HTTPStatus;

//Headers
header("Access-Control-Allow-Origin:*");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

require __DIR__."/../../vendor/autoload.php";

try{

    $err = new HTTPStatus();

    $database = new DB();
    $db = $database->connect();

    $obj = new MentorClass($db);

    $data = json_decode(file_get_contents("php://input"));

    $obj->id = $data->id;

    if($obj->delete())
    {
        echo json_encode($err::status(200,"Mentor Deleted"));
    }
    else
    {
        throw new Exception(json_encode($err::status(404,"Mentor Not Deleted")));
    }
}
catch(PDOException $e)
{
    echo $e->getMessage();
    die();
}
catch(Exception $e)
{
    echo $e->getMessage();
    die();
}