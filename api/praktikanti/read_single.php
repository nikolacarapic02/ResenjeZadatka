<?php

use models\PraktikantClass;
use config\DB;
use includes\HTTPStatus;

//Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET");

require __DIR__."/../../vendor/autoload.php";

try{

    $err = new HTTPStatus();

    $database = new DB();
    $db = $database->connect();

    $obj = new PraktikantClass($db);

    $obj->id = isset($_GET["id"]) ? $_GET["id"] : throw new Exception(json_encode($err::status(404, "Id is not set!!")));

    $obj->readSingle();

    $obj_arr = array(
        "id"=>$obj->id,
        "ime"=>$obj->ime,
        "prezime"=>$obj->prezime,
        "email"=>$obj->email,
        "telefon"=>$obj->telefon,
        "id_grupe"=>$obj->id_grupe,
        "naziv_grupe"=>$obj->naziv_grupe,
        "komentar"=>$obj->komentar
    );

    echo json_encode($obj_arr);
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