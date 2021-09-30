<?php

use config\DB;
use models\GrupaClass;
use includes\HTTPStatus;

//Headers 
header("Access-Control-Allow-Origin:*");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET");

require __DIR__."/../../vendor/autoload.php";

try
{
    $err = new HTTPStatus();

    if($_SERVER["REQUEST_METHOD"] != "GET")
    {
        throw new Exception(json_encode($err::status(400, "Wrong HTTP Request Method")));
    }
    else
    {
        $database = new DB();
        $db = $database->connect();

        $obj = new GrupaClass($db);

        $obj->id = isset($_GET["id"]) ? $_GET["id"] : throw new Exception(json_encode($err::status(404, "Id is not set!!")));

        $obj->readSingle();

        $obj_arr = array(
            "id" => $obj->id,
            "naziv" => $obj->naziv,
            "mentori" => $obj->mentori,
            "praktikanti" => $obj->praktikanti
        );

        echo json_encode($obj_arr);
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