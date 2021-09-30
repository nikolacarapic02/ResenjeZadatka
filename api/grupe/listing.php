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

    if($_SERVER["REQUEST_METHOD"] != "GET")
    {
        throw new Exception(json_encode($err::status(400, "Wrong HTTP Request Method")));
    }
    else
    {
        $database = new DB();
        $db = $database->connect();

        $obj = new GrupaClass($db);
        $result = $obj->listing();

        $num = $result->rowCount();

        if($num>0)
        {
            $obj_arr = array();
            $obj_arr["data"] = array();

            while($row = $result->fetch(PDO::FETCH_ASSOC))
            {
                extract($row);

                $obj_items = array(
                    "redni_broj" => $redni_broj, 
                    "pozicija" => $pozicija,
                    "ime" => $ime,
                    "prezime" => $prezime
                );

                array_push($obj_arr["data"], $obj_items);
            }

            echo json_encode($obj_arr["data"]);
        }
        else
        {
            throw new Exception(json_encode($err::status(404, "Listing Not Found")));
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