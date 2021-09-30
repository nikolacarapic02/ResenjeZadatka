<?php

use config\DB;
use models\PraktikantClass;
use includes\HTTPStatus;

//Headers
header("Access-Control-Allow-Origin: *");
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

        $obj = new PraktikantClass($db);

        $data = json_decode(file_get_contents("php://input"));

        if(isset($data->id))
        {
            $obj->id = $data->id;   
        }

        if(isset($data->ime))
        {
            $obj->ime = $data->ime;
        }

        if(isset($data->prezime))
        {
            $obj->prezime = $data->prezime;
        }

        if(isset($data->email))
        {
            $obj->email = $data->email;
        }

        if(isset($data->telefon))
        {
            $obj->telefon = $data->telefon;
        }

        if(isset($data->id_grupe))
        {
            $obj->id_grupe = $data->id_grupe;
        }

        if($obj->update())
        {
            echo json_encode($err::status(200, "Praktikant Updated"));
        }
        else
        {
            throw new Exception(json_encode($err::status(404,"Praktikant Not Updated")));
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