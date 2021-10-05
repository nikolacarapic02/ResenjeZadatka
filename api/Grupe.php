<?php

namespace api;

use models\GrupaClass;
use includes\HTTPStatus;
use config\DB;
use Exception;
use PDOException;

class Grupe extends GrupaClass
{
    //Properties

    private $database;
    private $err;

    //Constructor

    public function __construct()
    {
        $this->database = new DB();
    }

    //Read grupe

    public function grupaRead()
    {
        try{

            $this->err = new HTTPStatus();

            $db = $this->database->connect();
        
            $obj = new GrupaClass($db);
        
            $result = $obj->read();
        
            $num = $result->rowCount();
        
            if($num>0)
            {
                $obj_arr = array();
                $obj_arr["data"] = array();
        
                while($row = $result->fetch(\PDO::FETCH_ASSOC))
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
    }

    //ReadSingle grupe

    public function grupaReadSingle($id)
    {
        try
        {
            $this->err = new HTTPStatus();

            $db = $this->database->connect();

            $obj = new GrupaClass($db);

            $obj->id = isset($id) ? $id : $id=1;

            $obj->readSingle();

            $obj_arr = array(
                "id" => $obj->id,
                "naziv" => $obj->naziv,
                "mentori" => $obj->mentori,
                "praktikanti" => $obj->praktikanti
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
    }

    //Create grupe

    public function grupaCreate()
    {
        try
        {
            $this->err = new HTTPStatus();

            $db = $this->database->connect();

            $obj = new GrupaClass($db);

            $data = json_decode(file_get_contents("php://input"));

            $obj->naziv = $data->naziv;

            if($obj->create())
            {
                echo json_encode($this->err::status(201, "Grupa Created"));
            }
            else
            {
                throw new Exception(json_encode($this->err::status(404, "Grupa Not Created")));
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
    }

    //Update grupe

    public function grupaUpdate()
    {
        try
        {
            $this->err = new HTTPStatus();

            $db = $this->database->connect();

            $obj = new GrupaClass($db);

            $data = json_decode(file_get_contents("php://input"));

            if(isset($data->id))
            {
                $obj->id = $data->id;   
            }

            if(isset($data->naziv))
            {
                $obj->naziv = $data->naziv;
            }

            if($obj->update())
            {
                echo json_encode($this->err::status(200, "Grupa Updated"));
            }
            else
            {
                throw new Exception(json_encode($this->err::status(404, "Grupa Not Updated")));
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
    }

    //Delete grupe

    public function grupaDelete()
    {
        try{

            $this->err = new HTTPStatus();

            $db = $this->database->connect();
        
            $obj = new GrupaClass($db);
        
            $data = json_decode(file_get_contents("php://input"));
        
            $obj->id = $data->id;
        
            if($obj->delete())
            {
                echo json_encode($this->err::status(200, "Grupa Deleted"));
            }
            else
            {
                throw new Exception(json_encode($this->err::status(404, "Grupa Not Deleted")));
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
    }

    //Listing grupe

    public function grupaListing($page)
    {
        try{

            $this->err = new HTTPStatus();

            $db = $this->database->connect();
        
            $obj = new GrupaClass($db);

            isset($page) ? $obj->page = $page : $obj->page = 1;

            $result = $obj->listing();
        
            $num = $result->rowCount();
        
            if($num>0)
            {
                $obj_arr = array();
                $obj_arr["data"] = array();
        
                while($row = $result->fetch(\PDO::FETCH_ASSOC))
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
                throw new Exception(json_encode($this->err::status(404, "Listing Not Found")));
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
    }
}
