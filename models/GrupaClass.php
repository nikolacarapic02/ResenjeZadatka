<?php

namespace models;

use models\PravilaInterface;
use Exception;
use models\AbstractPravila;
use PDOException;
use includes\HTTPStatus;

class GrupaClass extends AbstractPravila implements PravilaInterface
{
    //DB Stuff
    private $conn;
    private $table = "grupe";

    //Properties
    private $id;
    private $naziv;
    private $mentori;
    private $praktikanti;
    private $ime;
    private $prezime;
    private $email;
    private $telefon;
    private $id_grupe;
    private $komentar;
    private $pozicija;
    private $redni_broj;

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

    //Read "grupe"
    public function read()
    {
        $this->err = new HTTPStatus();

        $query = "SELECT g.id, g.naziv,GROUP_CONCAT(DISTINCT(CONCAT(p.id, '|', p.ime, '|', p.prezime, '|', p.email, '|', p.telefon, '|',p.komentar)) SEPARATOR '|') as 'praktikanti', 
        GROUP_CONCAT(DISTINCT(CONCAT(m.id, '|', m.ime, '|', m.prezime, '|', m.email, '|', m.telefon)) SEPARATOR '|') as 'mentori' FROM ".$this->table." g, 
        praktikanti p, mentori m WHERE g.id=p.id_grupe AND g.id = m.id_grupe
        GROUP BY g.id, g.naziv";

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

    //Read-Single "grupe"
    public function readSingle()
    {
        $this->err = new HTTPStatus();

        //Main query

        $query = "SELECT g.id, g.naziv,GROUP_CONCAT(DISTINCT(CONCAT(p.id, '|', p.ime, '|', p.prezime, '|', p.email, '|', p.telefon, '|', p.komentar)) SEPARATOR '|') as 'praktikanti', 
        GROUP_CONCAT(DISTINCT(CONCAT(m.id, '|', m.ime, '|', m.prezime, '|', m.email, '|', m.telefon)) SEPARATOR '|') as 'mentori' FROM ".$this->table." g, 
        praktikanti p, mentori m WHERE g.id=p.id_grupe AND g.id = m.id_grupe AND g.id = :id
        GROUP BY g.id, g.naziv LIMIT 0,1";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);

        //Query to check if the id exists

        $query1 = "SELECT * FROM ".$this->table." g WHERE g.id = :id";

        $stmt1 = $this->conn->prepare($query1);

        $stmt1->bindParam(":id", $this->id);

        //Query to check if the group has mentors and an interns

        $query2 = "SELECT p.ime, m.ime
        FROM grupe g, praktikanti p, mentori m
        WHERE g.id = p.id_grupe AND g.id = m.id_grupe AND g.id = :id";

        $stmt2 = $this->conn->prepare($query2);

        $stmt2->bindParam(":id", $this->id);

        if($stmt1->execute())
        {
            if($stmt1->rowCount() > 0)
            {
                if($stmt2->execute())
                {
                    if($stmt2->rowCount() > 0)
                    {
                        if($stmt->execute())
                        {
                            $row = $stmt->fetch(\PDO::FETCH_ASSOC);

                            $this->id = $row["id"];
                            $this->naziv = $row["naziv"];
                            $this->mentori = $row["mentori"];
                            $this->praktikanti = $row["praktikanti"];
                        }
                        else
                        {
                            throw new PDOException();
                        }
                    }
                    else
                    {
                        throw new Exception(json_encode($this->err::status(404, "The group exists, but has no mentors or interns!!")));
                    }
                }
                else
                {
                    throw new PDOException();
                }
            }
            else
            {
                throw new Exception(json_encode($this->err::status(404, "Group doesn't exist!!")));
            } 
        }
        else
        {
            throw new PDOException();
        }
    }

    //Create "grupe"
    public function create()
    {
        $this->err = new HTTPStatus();

        $query = "INSERT INTO ".$this->table." SET naziv = :naziv";

        $stmt = $this->conn->prepare($query);

        $this->naziv = strip_tags($this->naziv);

        $stmt->bindParam(":naziv", $this->naziv);

        if(empty($this->naziv))
        {
            throw new Exception(json_encode($this->err::status(409, "All columns must have a value!!"))); 
        }
        else 
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
    }

    //Update "grupe"
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
                if(isset($this->naziv))
                {

                    $this->naziv = strip_tags($this->naziv);
                    $query = $query . "naziv = '".$this->naziv."',";
                    

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
    //Delete "grupe"
    public function delete()
    {
        //Main query

        $this->err = new HTTPStatus();

        $query = "DELETE FROM ".$this->table." WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        $this->id = strip_tags($this->id);

        $stmt->bindParam(":id", $this->id);

        //Query to check if id of group exists

        $query1 = "SELECT g.id FROM ".$this->table." g WHERE g.id = :id";

        $stmt1 = $this->conn->prepare($query1);

        $stmt1->bindParam(":id", $this->id);

        //Query to check if the group has mentors or interns

        $query2 = "SELECT p.ime
        FROM praktikanti p, grupe g
        WHERE g.id = p.id_grupe AND g.id=:id
        UNION ALL
        SELECT m.ime
        FROM mentori m, grupe g
        WHERE g.id = m.id_grupe AND g.id=:id";

        $stmt2 = $this->conn->prepare($query2);

        $stmt2->bindParam(":id", $this->id);
        
        $stmt1->execute();

        if($stmt1->rowCount() > 0)
        {
            $stmt2->execute();
            
            if($stmt2->rowCount() > 0)
            {
                throw new Exception(json_encode($this->err::status(409, "The group cannot be deleted because it contains interns or mentors!!")));
            }
            else
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
        }
        else
        {
            throw new Exception(json_encode($this->err::status(404,"Id doesn't exist!!")));
        }
    }

    //Listing "grupe"
    public function listing()
    {
        $rec_per_page = 2;

        $start_from = ($this->page-1)*$rec_per_page;

        $query = "SELECT g.id, g.naziv,GROUP_CONCAT(DISTINCT(CONCAT(p.id, '|', p.ime, '|', p.prezime, '|', p.email, '|', p.telefon, '|', p.komentar)) SEPARATOR '|') as 'praktikanti', 
        GROUP_CONCAT(DISTINCT(CONCAT(m.id, '|', m.ime, '|', m.prezime, '|', m.email, '|', m.telefon)) SEPARATOR '|') as 'mentori' FROM ".$this->table." g, 
        praktikanti p, mentori m WHERE g.id=p.id_grupe AND g.id = m.id_grupe
        GROUP BY g.id, g.naziv
        LIMIT ".$start_from.", ".$rec_per_page;

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
}