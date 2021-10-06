<?php

namespace additions;

use config\DB;

require "../vendor/autoload.php";

class Faker{

    //Properties
    private $database;

    public function __construct()
    {
        $this->database = new DB();
    }

    public function runFaker()
    {

        $db = $this->database->connect();

        $db->query("DELETE FROM praktikanti");
        $db->query("DELETE FROM mentori");
        $db->query("DELETE FROM grupe");

        $db->query("ALTER TABLE grupe AUTO_INCREMENT = 1");
        $db->query("ALTER TABLE mentori AUTO_INCREMENT = 1");
        $db->query("ALTER TABLE praktikanti AUTO_INCREMENT = 1");

        $faker = \Faker\Factory::create();

        foreach(range(1,4) as $x)
        {
            $db->query(
            "INSERT INTO grupe (id, naziv) VALUES ('{$faker->unique()->numberBetween(1,4)}', '{$faker->city}')");
        }

        $faker1 = \Faker\Factory::create();

        foreach(range(1, 7) as $x)
        {
            $db->query("INSERT INTO mentori (id, ime, prezime, email, telefon, id_grupe)
            VALUES ('{$faker1->unique()->numberBetween(1,7)}', '{$faker1->firstName}', '{$faker1->lastName}', '{$faker1->email}', '{$faker1->phoneNumber}', '{$faker1->numberBetween(1,4)}')");
        }

        $faker2 = \Faker\Factory::create();

        foreach(range(1,15) as $x)
        {
            $db->query("INSERT INTO praktikanti (id, ime, prezime, email, telefon, id_grupe, komentar)
            VALUES ('{$faker2->unique()->numberBetween(1,15)}', '{$faker2->firstName}', '{$faker2->lastName}', '{$faker2->email}', '{$faker2->phoneNumber}', '{$faker2->numberBetween(1,4)}', '')");
        }
    }
}