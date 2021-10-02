<?php

use config\DB;
use models\GrupaClass;
use includes\HTTPStatus;

//Headers
header("Access-Control-Allow-Origin:*");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET");

require __DIR__."/../../vendor/autoload.php";

try{

    $err = new HTTPStatus();

    $database = new DB();
    $db = $database->connect();

    $obj = new GrupaClass($db);

    $result = $obj->read();

    $num = $result->rowCount();

    if($num>0)
    {
        $obj_arr = array();
        $obj_arr["data"] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);

            $obj_items = array(
                "id"=> $id,
                "naziv" => $naziv,
                "mentori" => $mentori,
                "praktikanti" => $praktikanti
            );

            array_push($obj_arr["data"], $obj_items);
        }

        echo json_encode($obj_arr["data"]);
    }
    else
    {
        throw new Exception(json_encode($err::status(404,"Grupa Not Found")));
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