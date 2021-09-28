<?php

use config\DB;
use models\MentorClass;

use function includes\HTTPStatus;

//Headers
header("Access-Control-Allow-Origin:*");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: PUT");

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

        $obj = new MentorClass($db);

        $data = json_decode(file_get_contents("php://input"));

        $obj->komentar = $data->komentar;
        $obj->id_p = $data->id_p;
        $obj->id_m = $data->id_m;

        if($obj->createKomentar())
        {
            echo json_encode(HTTPStatus(200,"Komentar Created"));
        }
        else
        {
            throw new Exception(json_encode(array("message"=>"Komentar Not Created")));
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