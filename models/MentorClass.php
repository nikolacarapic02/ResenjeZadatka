<?php

namespace models;

use Exception;
use models\PravilaInterface;
use models\AbstractPravila;
use PDOException;
use includes\HTTPStatus;

class MentorClass extends AbstractPravila implements PravilaInterface
{
    //DB Stuff
    private $conn;
    private $table = "mentori";

    //Properties
    private $id;
    private $id_p;
    private $id_m;
    private $ime;
    private $prezime;
    private $email;
    private $telefon;
    private $id_grupe;
    private $naziv_grupe;
    private $komentar;

    //Error-handler
    private $err;

    //Construct with DB
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

        $query = "SELECT g.naziv as 'naziv_grupe', m.id, m.ime, m.prezime,
        m.email, m.telefon, m.id_grupe FROM ".$this->table." m LEFT JOIN grupe g 
        ON m.id_grupe = g.id ORDER BY m.id ASC";

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

        $query = "SELECT g.naziv as 'naziv_grupe', m.id, m.ime, m.prezime, 
        m.email, m.telefon, m.id_grupe FROM ".$this->table." m LEFT JOIN grupe g ON 
        m.id_grupe = g.id WHERE m.id = :id LIMIT 0,1";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);

        if($stmt->execute())
        {
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

    //Create "mentori"
    public function create()
    {
        $this->err = new HTTPStatus();

        $query = "INSERT INTO ".$this->table." SET ime = :ime, 
        prezime = :prezime, email = :email, telefon = :telefon, 
        id_grupe = :id_grupe";

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

        if(empty($this->ime) || empty($this->prezime) || empty($this->email) || empty($this->telefon) || empty($this->id_grupe))
        {
            throw new Exception(json_encode($this->err::status(409, "All columns must have a value!!"))); 
        }
        else if($stmt1->rowCount() > 0)
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

    //Update "mentori"
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
                        $this->ime = strip_tags($this->ime);
                        $query = $query . "ime = '".$this->ime."',";
                    }
                    if(isset($this->prezime))
                    {
                        $this->prezime = strip_tags($this->prezime);
                        $query = $query . "prezime = '".$this->prezime."',";
                    }
                    if(isset($this->email))
                    {
                        $this->email = strip_tags($this->email);
                        $query = $query . "email = '".$this->email."',";
                    }
                    if(isset($this->telefon))
                    {
                        $this->telefon = strip_tags($this->telefon);
                        $query = $query . "telefon = '".$this->telefon."',";
                    }
                    if(isset($this->id_grupe))
                    {
                        $this->id_grupe = strip_tags($this->id_grupe);
                        $query = $query . "id_grupe = '".$this->id_grupe."',";
                    }

                    $query = rtrim($query,",") . " WHERE id = ".$this->id;
                }
                else
                {
                    throw new Exception(json_encode($this->err::status(404, "You must fill at least one column!!")));
                }
            }
            else
            {
                throw new Exception(json_encode($this->err::status(404, "Id doesn't exist!!")));
            }
        }
        else
        {
            throw new Exception(json_encode($this->err::status(404, "id is not set!!")));
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

    //Delete "mentori"
    public function delete()
    {
        $this->err = new HTTPStatus();

        $query = "DELETE FROM ".$this->table." 
        WHERE id = :id";

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
            throw new Exception(json_encode($this->err::status(404,"Id doesn't exist!!")));
        }
    }

    //Komentar "mentori"
    public function createKomentar()
    {
        $this->err = new HTTPStatus();

        $query = "UPDATE praktikanti, mentori 
        SET komentar = CONCAT(komentar,char(10),:komentar,' napisao/la: ',mentori.ime,' ',mentori.prezime,'; datum: ',CURRENT_DATE(),', vreme: ',CURRENT_TIME()) 
        WHERE praktikanti.id = :id_p AND mentori.id = :id_m AND praktikanti.id_grupe = mentori.id_grupe";

        $stmt = $this->conn->prepare($query);

        $this->komentar = strip_tags($this->komentar);
        $this->id_p = strip_tags($this->id_p);
        $this->id_m = strip_tags($this->id_m);

        $stmt->bindParam(":komentar", $this->komentar);
        $stmt->bindParam(":id_p", $this->id_p);
        $stmt->bindPAram(":id_m", $this->id_m);

        if(empty($this->komentar) || empty($this->id_p) || empty($this->id_m))
        {
            throw new Exception(json_encode($this->err::status(409, "All columns must have a value!!"))); 
        }
        else
        {
            if($stmt->execute())
            {
                $query1 = "SELECT p.id, m.id FROM praktikanti p, ".$this->table." m WHERE p.id=".$this->id_p." 
                AND m.id=".$this->id_m." AND p.id_grupe = m.id_grupe";
                $stmt1 = $this->conn->prepare($query1);
                $stmt1->execute();
                if($stmt1->rowCount() > 0)
                {
                    return true;
                }
                else
                {
                    throw new Exception(json_encode($this->err::status(404, "Mentor cannot leave a comment for this praktikant!!")));
                }
            }
            else
            {
                throw new PDOException();
            }
        }
    }
}