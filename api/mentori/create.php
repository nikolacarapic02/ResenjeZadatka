<?php

use config\DB;
use models\MentorClass;
use includes\HTTPStatus;

//Headers
header("Access-Control-Allow-Origin:*");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

require __DIR__."/../../vendor/autoload.php";

try
{
    $err = new HTTPStatus();

    if($_SERVER["REQUEST_METHOD"] != "POST")
    {
        throw new Exception(json_encode($err::status(400, "Wrong HTTP Request Method")));
    }
    else
    {
        $database = new DB();
        $db = $database->connect();

        $obj = new MentorClass($db);

        $data = json_decode(file_get_contents("php://input"));

        $obj->ime = $data->ime;
        $obj->prezime = $data->prezime;
        $obj->email = $data->email;
        $obj->telefon = $data->telefon;
        $obj->id_grupe = $data->id_grupe;

        if($obj->create())
        {
            echo json_encode($err::status(201,"Mentor Created"));
        }
        else
        {
            throw new Exception(json_encode($err::status(404, "Mentor Not Created")));
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