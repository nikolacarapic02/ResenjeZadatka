<?php

use config\DB;
use models\MentorClass;
use includes\HTTPStatus;

//Headers
header("Access-Control-Allow-Origin:*");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

require __DIR__."/../../vendor/autoload.php";

try{

    $err = new HTTPStatus();

    if($_SERVER["REQUEST_METHOD"] != "PUT")
    {
        throw new Exception(json_encode($err::status(400, "Wrong HTTP Request Method")));
    }
    else
    {
        $database = new DB();
        $db = $database->connect();

        $obj = new MentorClass($db);

        $data = json_decode(file_get_contents("php://input"));

        $obj->id = $data->id;
        $obj->ime = $data->ime;
        $obj->prezime = $data->prezime;
        $obj->email = $data->email;
        $obj->telefon = $data->telefon;
        $obj->id_grupe = $data->id_grupe;

        if($obj->update())
        {
            echo json_encode($err::status(200, "Mentor Updated"));
        }
        else
        {
            throw new Exception(json_encode($err::status(404,"Mentor Not Updated")));
        }
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