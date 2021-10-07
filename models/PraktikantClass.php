<?php

namespace models;

use models\PravilaInterface;
use Exception;
use PDOException;
use includes\HTTPStatus;

class PraktikantClass implements PravilaInterface
{
    //DB stuff
    private $conn;
    private $table = "praktikanti";

    //Properties
    private $id;
    private $ime;
    private $prezime;
    private $email;
    private $telefon;
    private $id_grupe;
    private $komentar;
    private $naziv_grupe;

    //Error-handler
    private $err;

    //Constructor with DB
    protected function __construct($db)
    {
        $this->conn = $db;
    }

    //Setter
    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    //Getter
    public function __get($name)
    {
        return $this->$name;
    }

    //Read "praktikanti"
    public function read()
    {
        $this->err = new HTTPStatus();

        $query = "SELECT g.naziv as 'naziv_grupe', p.id, p.ime, p.prezime, p.email, p.telefon, p.id_grupe, p.komentar 
        FROM ".$this->table." p LEFT JOIN grupe g ON p.id_grupe = g.id 
        ORDER BY p.id ASC";

        $stmt = $this->conn->prepare($query);

        if($stmt->execute())
        {
            return $stmt;
        }
        else
        {
            throw new PDOException();
        }
    }

    //Read-Single "praktikanti"
    public function readSingle()
    {
        $this->err = new HTTPStatus();

        $query = "SELECT g.naziv as 'naziv_grupe', p.id, p.ime, p.prezime, p.email, p.telefon, p.id_grupe, p.komentar
        FROM ".$this->table." p LEFT JOIN grupe g ON p.id_grupe = g.id
        WHERE p.id = :id
        LIMIT 0,1";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()){

            if($stmt->rowCount() > 0)
            {

                $row = $stmt->fetch(\PDO::FETCH_ASSOC);

                $this->id = $row["id"];
                $this->ime = $row["ime"];
                $this->prezime = $row["prezime"];
                $this->email = $row["email"];
                $this->telefon = $row["telefon"];
                $this->id_grupe = $row["id_grupe"];
                $this->naziv_grupe = $row["naziv_grupe"];
                $this->komentar = $row["komentar"];
            }
            else
            {
                throw new Exception(json_encode($this->err::status(404, "Id doesn't exist!!")));
            }
        }
        else
        {
            throw new PDOException();
        }
    }

    //Create "praktikanti"
    public function create()
    {
        $this->err = new HTTPStatus();

        $query = "INSERT INTO ".$this->table." SET ime = :ime, 
        prezime = :prezime, email = :email, telefon = :telefon, id_grupe = :id_grupe, komentar = ''";

        $stmt = $this->conn->prepare($query);

        $this->ime = strip_tags($this->ime);
        $this->prezime = strip_tags($this->prezime);
        $this->email = strip_tags($this->email);
        $this->telefon = strip_tags($this->telefon);
        $this->id_grupe = strip_tags($this->id_grupe);

        $stmt->bindParam(":ime", $this->ime);
        $stmt->bindParam(":prezime", $this->prezime);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":telefon", $this->telefon);
        $stmt->bindParam(":id_grupe", $this->id_grupe);

        $query1 = "SELECT id FROM grupe WHERE id=".$this->id_grupe;
        $stmt1 = $this->conn->prepare($query1);
        $stmt1->execute();
        
        if($stmt1->rowCount() > 0)
        { 
            if($stmt->execute())
            {
                return true;
            }
            else
            {
                throw new PDOException();
            }
        }
        else
        {
            throw new Exception(json_encode($this->err::status(409, "id_grupe doesn't exist!!")));
        }
    }

    //Update "praktikanti"
    public function update()
    {
        $this->err = new HTTPStatus();

        $query = "UPDATE ".$this->table." SET ";

        if(isset($this->id) && $this->id != "")
        {
            $query1 = "SELECT id FROM ".$this->table." WHERE id=".$this->id;
            $stmt1 = $this->conn->prepare($query1);
            $stmt1->execute();

            if($stmt1->rowCount() > 0)
            {
                if(isset($this->ime) || isset($this->prezime) || isset($this->email) || isset($this->telefon) || isset($this->id_grupe))
                {
                    if(isset($this->ime))
                    {
                        if(empty($this->ime))
                        {
                            throw new Exception(json_encode($this->err::status(409, "Columns must have a value!!")));
                        }
                        else
                        {
                            $this->ime = strip_tags($this->ime);
                            $query = $query . "ime = '".$this->ime."',";
                        }
                    }
                    if(isset($this->prezime))
                    {
                        if(empty($this->prezime))
                        {
                            throw new Exception(json_encode($this->err::status(409, "Columns must have a value!!")));
                        }
                        else
                        {
                            $this->prezime = strip_tags($this->prezime);
                            $query = $query . "prezime = '".$this->prezime."',";
                        }
                    }
                    if(isset($this->email))
                    {
                        if(empty($this->email))
                        {
                            throw new Exception(json_encode($this->err::status(409, "Columns must have a value!!")));
                        }
                        else
                        {
                            $this->email = strip_tags($this->email);
                            $query = $query . "email = '".$this->email."',";
                        }
                    }
                    if(isset($this->telefon))
                    {
                        if(empty($this->telefon))
                        {
                            throw new Exception(json_encode($this->err::status(409, "Columns must have a value!!")));
                        }
                        else
                        {
                            $this->telefon = strip_tags($this->telefon);
                            $query = $query . "telefon = '".$this->telefon."',";
                        }
                    }
                    if(isset($this->id_grupe))
                    {
                        $query2 = "SELECT g.naziv FROM ".$this->table." p, grupe g WHERE g.id=".$this->id_grupe;
                        $stmt2 = $this->conn->prepare($query2);
                        $stmt2->execute();

                        if($stmt2->rowCount() > 0)
                        {
                            if(empty($this->id_grupe))
                            {
                                throw new Exception(json_encode($this->err::status(409, "Columns must have a value!!")));
                            }
                            else
                            {
                                $this->id_grupe = strip_tags($this->id_grupe);
                                $query = $query . "id_grupe = '".$this->id_grupe."',";
                            }
                        }
                        else
                        {
                            throw new Exception(json_encode($this->err::status(409, "id_grupe doesn't exist!!")));
                        }
                    }

                    $query = rtrim($query,",") . " WHERE id = ".$this->id;
                }
                else
                {
                    throw new Exception(json_encode($this->err::status(409, "You must fill at least one column!!")));
                }
            }
            else
            {
                throw new Exception(json_encode($this->err::status(404, "Id doesn't exist!!")));
            }
        }
        else
        {
            throw new Exception(json_encode($this->err::status(404, "Id is not set!!")));
        }

        $stmt = $this->conn->prepare($query);

        if($stmt->execute())
        {
            return true;
        }
        else
        {
            throw new PDOException();
        }
    }

    //Delete "praktikanti"
    public function delete()
    {
        $this->err = new HTTPStatus();

        //Main query

        $query = "DELETE FROM ".$this->table." WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->id = strip_tags($this->id);

        $stmt->bindParam(":id", $this->id);

        $query1 = "SELECT id FROM ".$this->table." WHERE id=".$this->id;
        $stmt1 = $this->conn->prepare($query1);
        $stmt1->execute();

        if($stmt1->rowCount() > 0)
        {
            if($stmt->execute())
            {  
                return true;
            }
            else
            {
                throw new PDOException();
            }
        }
        else
        {
            throw new Exception(json_encode($this->err::status(404, "Id doesn't exist!!")));
        }
    }
}