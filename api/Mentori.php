<?php

namespace api;

use models\MentorClass;
use includes\HTTPStatus;
use config\DB;
use Exception;
use PDOException;

class Mentori extends MentorClass
{
    //Properties

    private $database;
    private $err;

    //Constructor

    public function __construct()
    {
        $this->database = new DB();
    }

    //Read mentori

    public function mentorRead()
    {
        try{

            $this->err = new HTTPStatus();
        
            $db = $this->database->connect();
        
            $obj = new MentorClass($db);
        
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
                        "ime" => $ime,
                        "prezime" => $prezime,
                        "email" => $email,
                        "telefon" => $telefon,
                        "id_grupe" => $id_grupe,
                        "naziv_grupe" => $naziv_grupe
                    );
        
                    array_push($obj_arr["data"], $obj_items);
                }
        
                echo json_encode($obj_arr["data"]);
            }
            else
            {
                throw new Exception(json_encode($err::status(404,"No Mentor Found")));
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

    //ReadSingle mentori

    public function mentorReadSingle($id)
    {
        try{

            $this->err = new HTTPStatus();
    
            $db = $this->database->connect();
        
            $obj = new MentorClass($db);
        
            $obj->id = isset($id)? $id : $id=1;
        
            $obj->readSingle();
        
            $obj_arr = array(
                "id" => $obj->id,
                "ime" => $obj->ime,
                "prezime" => $obj->prezime,
                "email" => $obj->email,
                "telefon" => $obj->telefon,
                "id_grupe" => $obj->id_grupe,
                "naziv_grupe" => $obj->naziv_grupe
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

    //Create mentori

    public function mentoriCreate()
    {
        try
        {
            $this->err = new HTTPStatus();

            $db = $this->database->connect();

            $obj = new MentorClass($db);

            $data = json_decode(file_get_contents("php://input"));

            $obj->ime = $data->ime;
            $obj->prezime = $data->prezime;
            $obj->email = $data->email;
            $obj->telefon = $data->telefon;
            $obj->id_grupe = $data->id_grupe;

            if($obj->create())
            {
                echo json_encode($this->err::status(201,"Mentor Created"));
            }
            else
            {
                throw new Exception(json_encode($this->err::status(404, "Mentor Not Created")));
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

    //Update mentori

    public function mentoriUpdate()
    {
        try{

            $this->err = new HTTPStatus();

            $db = $this->database->connect();
        
            $obj = new MentorClass($db);
        
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
                echo json_encode($this->err::status(200, "Mentor Updated"));
            }
            else
            {
                throw new Exception(json_encode($this->err::status(404,"Mentor Not Updated")));
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

    //Delete mentori

    public function mentoriDelete()
    {
        try{

            $this->err = new HTTPStatus();

            $db = $this->database->connect();
        
            $obj = new MentorClass($db);
        
            $data = json_decode(file_get_contents("php://input"));
        
            $obj->id = $data->id;
        
            if($obj->delete())
            {
                echo json_encode($this->err::status(200,"Mentor Deleted"));
            }
            else
            {
                throw new Exception(json_encode($this->err::status(404,"Mentor Not Deleted")));
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

    //Komentar mentori

    public function mentoriKomentar()
    {
        try{

            $this->err = new HTTPStatus();

            $db = $this->database->connect();
        
            $obj = new MentorClass($db);
        
            $data = json_decode(file_get_contents("php://input"));
        
            $obj->komentar = $data->komentar;
            $obj->id_p = $data->id_p;
            $obj->id_m = $data->id_m;
        
            if($obj->createKomentar())
            {
                echo json_encode($this->err::status(200,"Komentar Created"));
            }
            else
            {
                throw new Exception(json_encode(array("message"=>"Komentar Not Created")));
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