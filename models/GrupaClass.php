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
    private $ime;
    private $prezime;
    private $mentori;
    private $praktikanti;
    private $pozicija;
    private $redni_broj;

    //Error-handler
    private $err;

    //Construct with DB
    public function __construct($db)
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

        $query = "SELECT g.id, g.naziv,GROUP_CONCAT(DISTINCT(CONCAT(p.ime, ' ', p.prezime)),'') as 'praktikanti', 
        GROUP_CONCAT(DISTINCT(CONCAT(m.ime, ' ', m.prezime)),'') as 'mentori' FROM ".$this->table." g, 
        praktikanti p, mentori m WHERE g.id=p.id_grupe AND g.id = m.id_grupe 
        GROUP BY g.id, g.naziv ORDER BY g.id ASC";

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

        $query = "SELECT g.id, g.naziv,GROUP_CONCAT(DISTINCT(CONCAT(p.ime, ' ', p.prezime)),'') as 'praktikanti', 
        GROUP_CONCAT(DISTINCT(CONCAT(m.ime, ' ', m.prezime)),'') as 'mentori' FROM ".$this->table." g, 
        praktikanti p, mentori m WHERE g.id=p.id_grupe AND g.id = m.id_grupe AND g.id = :id
        GROUP BY g.id, g.naziv LIMIT 0,1";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);

        if($stmt->execute())
        {
        if($stmt->rowCount() > 0)
        {
            $row = $stmt->fetch(\PDO::FETCH_ASSOC);

            $this->id = $row["id"];
            $this->naziv = $row["naziv"];
            $this->mentori = $row["mentori"];
            $this->praktikanti = $row["praktikanti"];
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

        $query = "UPDATE ".$this->table." SET naziv = :naziv 
        WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->id = strip_tags($this->id);
        $this->naziv = strip_tags($this->naziv);

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":naziv", $this->naziv);

        if($stmt->execute())
        {
            $query1 = "SELECT id FROM ".$this->table." WHERE id=".$this->id;
            $stmt1 = $this->conn->prepare($query1);
            $stmt1->execute();
            if($stmt1->rowCount() > 0)
            {
                return true;
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

    //Delete "grupe"
    public function delete()
    {
        $this->err = new HTTPStatus();

        $query = "DELETE FROM ".$this->table." WHERE id=:id";

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

    //Listing "grupe"
    public function listing()
    {
        $rec_per_page = 5;

        if(isset($_GET["page"]))
        {
            $page = $_GET["page"];
        }
        else
        {
            $page = 1;
        }

        $start_from = ($page-1)*$rec_per_page;


        $query = "SELECT @a:=@a+1 as 'redni_broj','Mentor' as 'pozicija', ime, prezime FROM mentori, ".$this->table." g, (SELECT @a:= 0) AS a
        WHERE g.id = id_grupe 
        UNION ALL
        SELECT @a:=@a+1 as 'redni_broj','Praktikant' as 'Pozicija', ime, prezime FROM praktikanti, ".$this->table." g, (SELECT @a:= 0) AS a
        WHERE g.id = id_grupe
        ORDER BY 'pozicija'
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