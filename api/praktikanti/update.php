<?php

use config\DB;
use models\PraktikantClass;

use function includes\HTTPStatus;

//Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

require __DIR__."/../../vendor/autoload.php";

try{
    if($_SERVER["REQUEST_METHOD"] != "PUT")
    {
        throw new Exception(json_encode(HTTPStatus(400, "Wrong HTTP Request Method")));
    }
    else
    {
        $database = new DB();
        $db = $database->connect();

        $obj = new PraktikantClass($db);

        $data = json_decode(file_get_contents("php://input"));

        $obj->id = $data->id;
        $obj->ime = $data->ime;
        $obj->prezime = $data->prezime;
        $obj->email = $data->email;
        $obj->telefon = $data->telefon;
        $obj->id_grupe = $data->id_grupe;

        if($obj->update())
        {
            echo json_encode(HTTPStatus(200, "Praktikant Updated"));
        }
        else
        {
            throw new Exception(json_encode(HTTPStatus(404,"Praktikant Not Updated")));
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
