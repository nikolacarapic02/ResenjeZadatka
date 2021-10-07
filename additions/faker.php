<?php

namespace additions;

use config\DB;
use includes\HTTPStatus;

require __DIR__."/../vendor/autoload.php";

class Faker{

    //Properties
    private $database;
    private $err;

    public function __construct()
    {
        $this->database = new DB();
    }

    public function runFaker()
    {

        $db = $this->database->connect();
        $this->err = new HTTPStatus();

        $db->query("DELETE FROM praktikanti");
        $db->query("DELETE FROM mentori");
        $db->query("DELETE FROM grupe");

        $db->query("ALTER TABLE grupe AUTO_INCREMENT = 1");
        $db->query("ALTER TABLE mentori AUTO_INCREMENT = 1");
        $db->query("ALTER TABLE praktikanti AUTO_INCREMENT = 1");

        $faker = \Faker\Factory::create();

        foreach(range(1,5) as $x)
        {
            $db->query(
            "INSERT INTO grupe (id, naziv) VALUES ('{$faker->unique()->numberBetween(1,5)}', '{$faker->city}')");
        }

        $faker1 = \Faker\Factory::create();

        foreach(range(1, 12) as $x)
        {
            $db->query("INSERT INTO mentori (id, ime, prezime, email, telefon, id_grupe)
            VALUES ('{$faker1->unique()->numberBetween(1,12)}', '{$faker1->firstName}', '{$faker1->lastName}', '{$faker1->email}', '{$faker1->phoneNumber}', '{$faker1->numberBetween(1,5)}')");
        }

        $faker2 = \Faker\Factory::create();

        foreach(range(1,24) as $x)
        {
            $db->query("INSERT INTO praktikanti (id, ime, prezime, email, telefon, id_grupe, komentar)
            VALUES ('{$faker2->unique()->numberBetween(1,24)}', '{$faker2->firstName}', '{$faker2->lastName}', '{$faker2->email}', '{$faker2->phoneNumber}', '{$faker2->numberBetween(1,5)}', '')");
        }

        echo json_encode($this->err::status(200, "The database was successfully filled!!"));
    }
}