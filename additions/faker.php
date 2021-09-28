<?php

require "/Applications/MAMP/htdocs/Zadatak2/vendor/autoload.php";

$faker = Faker\Factory::create();

$db = new PDO("mysql:host=localhost;dbname=QuantoxPraksa", "Nikola", "Nikola9122002");

$db->query("DELETE FROM mentori");

foreach(range(1, 7) as $x)
{
    $db->query("
    INSERT INTO mentori (ime, prezime, email, telefon)
    VALUES ('{$faker->firstName}', '{$faker->lastName}', '{$faker->email}', '{$faker->phoneNumber}')
    ");
}
