<?php

namespace api;

use models\PraktikantClass;
use includes\HTTPStatus;
use config\DB;
use Exception;
use PDOException;

class Praktikanti extends PraktikantClass
{
    //Properties
    
    private $database;
    private $err;

    //Constructor

    public function __construct()
    {
        $this->database = new DB();
    }

    //Read praktikanti
    
    public function praktikantRead()
    {
        try{

            $this->err = new HTTPStatus();
        
            $db = $this->database->connect();
        
            $obj = new PraktikantClass($db);
        
            $result = $obj->read();
        
            $num = $result->rowCount();
        
            if($num>0)
            {
                $obj_arr = array();
                $obj_arr["data"] = array();
        
                while($row = $result->fetch(\PDO::FETCH_ASSOC)){
                    extract($row);
        
                    $obj_items = array(
                        "id" => $id,
                        "ime" => $ime,
                        "prezime" => $prezime,
                        "email" => $email,
                        "telefon" => $telefon,
                        "id_grupe" => $id_grupe,
                        "naziv_grupe" => $naziv_grupe,
                        "komentar" => $komentar 
                    );
        
                    array_push($obj_arr["data"], $obj_items);
                }
                echo json_encode($obj_arr["data"]);
            }
            else
            {
                throw new Exception(json_encode($err::status(404,"Praktikant Not Found")));
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

    //ReadSingle praktikanti

    public function praktikantReadSingle($id)
    {
        try{

            $this->err = new HTTPStatus();

            $db = $this->database->connect();
        
            $obj = new PraktikantClass($db);
        
            $obj->id = isset($id) ? $id : $id=1;
            
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
    }

    //Create praktikanti

    public function praktikantCreate()
    {
        try{

            $this->err = new HTTPStatus();
        
            $db = $this->database->connect();
        
            $obj = new PraktikantClass($db);
        
            $data = json_decode(file_get_contents("php://input"));
        
            if(isset($data->ime) && isset($data->prezime) && isset($data->email) && isset($data->telefon) && isset($data->id_grupe))
            {
                if(empty($data->ime) || empty($data->prezime) || empty($data->email) || empty($data->telefon) || empty($data->id_grupe))
                {
                    throw new Exception(json_encode($this->err::status(409, "All columns must have a value!!")));
                }
                else
                {
                    $obj->ime = $data->ime;
                    $obj->prezime = $data->prezime;
                    $obj->email = $data->email;
                    $obj->telefon = $data->telefon;

                    if(is_numeric($data->id_grupe))
                    {
                        $obj->id_grupe = $data->id_grupe;
                    }
                    else
                    {
                        throw new Exception(json_encode($this->err::status(409, "id_grupe must be numeric!!")));
                    }
                }
            }
            else
            {
                throw new Exception(json_encode($this->err::status(409, "All columns must be set!!")));
            }
        
            if($obj->create())
            {
                echo json_encode($this->err::status(201,"Praktikant Created"));
            }
            else
            {
                throw new Exception(json_encode($this->err::status(404, "Praktikant Not Created")));
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

    //Update praktikanti

    public function praktikantUpdate()
    {
        try{

            $this->err = new HTTPStatus();
        
            $db = $this->database->connect();
        
            $obj = new PraktikantClass($db);
        
            $data = json_decode(file_get_contents("php://input"));
        
            if(isset($data->id))
            {
                if(is_numeric($data->id))
                {
                    $obj->id = $data->id;   
                }
                else
                {
                    throw new Exception(json_encode($this->err::status(409, "Id must be numeric!!")));
                }
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
                if(is_numeric($data->id_grupe))
                {
                    $obj->id_grupe = $data->id_grupe;
                }
                else
                {
                    throw new Exception(json_encode($this->err::status(409, "id_grupe must be numeric!!")));
                }
            }
        
            if($obj->update())
            {
                echo json_encode($this->err::status(200, "Praktikant Updated"));
            }
            else
            {
                throw new Exception(json_encode($this->err::status(404,"Praktikant Not Updated")));
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

    //Delete praktikanti

    public function praktikantDelete()
    {
        try{

            $this->err = new HTTPStatus();

            $db = $this->database->connect();
        
            $obj = new PraktikantClass($db);
        
            $data = json_decode(file_get_contents("php://input"));

            if(isset($data->id))
            {
                if(is_numeric($data->id))
                {
                    $obj->id = $data->id;
                }
                else
                {
                    throw new Exception(json_encode($this->err::status(409, "Id must be numeric!!")));
                }
            }
            else
            {
                throw new Exception(json_encode($this->err::status(409, "Id is not set!!")));
            }
        
            if($obj->delete())
            {
                echo json_encode($this->err::status(200,"Praktikant Deleted"));
            }
            else
            {
                throw new Exception(json_encode($this->err::status(404, "Praktikant Not Deleted")));
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