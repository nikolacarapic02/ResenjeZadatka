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

                    $arr_p = explode("|",trim($praktikanti,'"'));
                    $arr_m = explode("|",trim($mentori,'"'));

                    $praktikanti = array();

                    for($i=0;$i<count($arr_p);$i=$i+6)
                    {
                        array_push($praktikanti,array(
                            "id" => $arr_p[$i],
                            "ime"  => $arr_p[$i+1],
                            "prezime" => $arr_p[$i+2],
                            "email" => $arr_p[$i+3],
                            "telefon" => $arr_p[$i+4],
                            "komentar" => $arr_p[$i+5]
                        ));
                    }

                    $mentori = array();

                    for($i=0;$i<count($arr_m);$i=$i+5)
                    {
                        array_push($mentori,array(
                            "id" => $arr_m[$i],
                            "ime"  => $arr_m[$i+1],
                            "prezime" => $arr_m[$i+2],
                            "email" => $arr_m[$i+3],
                            "telefon" => $arr_m[$i+4]
                        ));
                    }

                    
                    $obj_items = array(
                        "id"=> $id,
                        "naziv" => $naziv,
                        "praktikanti" => $praktikanti,
                        "mentori" => $mentori
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

            $arr_p = explode("|",trim($obj->praktikanti,'"'));
            $arr_m = explode("|",trim($obj->mentori,'"'));

            $praktikanti = array();

            for($i=0;$i<count($arr_p);$i=$i+6)
            {
                array_push($praktikanti,array(
                    "id" => $arr_p[$i],
                    "ime"  => $arr_p[$i+1],
                    "prezime" => $arr_p[$i+2],
                    "email" => $arr_p[$i+3],
                    "telefon" => $arr_p[$i+4],
                    "komentar" => $arr_p[$i+5]
                ));
            }

            $mentori = array();

            for($i=0;$i<count($arr_m);$i=$i+5)
            {
                array_push($mentori,array(
                    "id" => $arr_m[$i],
                    "ime"  => $arr_m[$i+1],
                    "prezime" => $arr_m[$i+2],
                    "email" => $arr_m[$i+3],
                    "telefon" => $arr_m[$i+4]
                ));
            }

            $obj_arr = array(
                "id" => $obj->id,
                "naziv" => $obj->naziv,
                "praktikanti" => $praktikanti,
                "mentori" => $mentori
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
            
            if(isset($data->naziv))
            {
                if(empty($data->naziv))
                {
                    throw new Exception(json_encode($this->err::status(409, "All columns must have a value!!")));
                }
                else
                {
                    $obj->naziv = $data->naziv;
                }
            }
            else
            {
                throw new Exception(json_encode($this->err::status(409, "All columns must be set!!")));
            }

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
                if(is_numeric($data->id))
                {
                    $obj->id = $data->id;
                }  
                else
                {
                    throw new Exception(json_encode($this->err::status(409, "Id must be numeric!!")));
                } 
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

                    $arr_p = explode("|",trim($praktikanti,'"'));
                    $arr_m = explode("|",trim($mentori,'"'));

                    $praktikanti = array();

                    for($i=0;$i<count($arr_p);$i=$i+6)
                    {
                        array_push($praktikanti,array(
                            "id" => $arr_p[$i],
                            "ime"  => $arr_p[$i+1],
                            "prezime" => $arr_p[$i+2],
                            "email" => $arr_p[$i+3],
                            "telefon" => $arr_p[$i+4],
                            "komentar" => $arr_p[$i+5]
                        ));
                    }

                    $mentori = array();

                    for($i=0;$i<count($arr_m);$i=$i+5)
                    {
                        array_push($mentori,array(
                            "id" => $arr_m[$i],
                            "ime"  => $arr_m[$i+1],
                            "prezime" => $arr_m[$i+2],
                            "email" => $arr_m[$i+3],
                            "telefon" => $arr_m[$i+4]
                        ));
                    }
        
                    $obj_items = array(
                        "id_gupe" => $id,
                        "naziv" => $naziv,
                        "praktikanti" => $praktikanti,
                        "mentori" => $mentori
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
