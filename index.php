<?php

//HEADERS
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

require __DIR__."/vendor/autoload.php";

$router = new \Bramus\Router\Router();

try{

//GET

$router->get('/praktikanti/read', function(){
    include_once __DIR__.'/api/praktikanti/read.php';
});

$router->get('/praktikanti/read_single', function(){
    include_once __DIR__.'/api/praktikanti/read_single.php';
});

$router->get('/mentori/read', function(){
    include_once __DIR__.'/api/mentori/read.php';
});

$router->get('/mentori/read_single', function(){
    include_once __DIR__.'/api/mentori/read_single.php';
});

$router->get('/grupe/read', function(){
    include_once __DIR__.'/api/grupe/read.php';
});

$router->get('/grupe/read_single', function(){
    include_once __DIR__.'/api/grupe/read_single.php';
});

$router->get('/grupe/listing', function(){
    include_once __DIR__.'/api/grupe/listing.php';
});


//POST

$router->post('/praktikanti/create', function(){
    include_once __DIR__.'/api/praktikanti/create.php';
});

$router->post('/mentori/create', function(){
    include_once __DIR__.'/api/mentori/create.php';
});

$router->post('/grupe/create', function(){
    include_once __DIR__.'/api/grupe/create.php';
});


//PUT

$router->put('/praktikanti/update', function(){
    include_once __DIR__.'/api/praktikanti/update.php';
});

$router->put('/mentori/update', function(){
    include_once __DIR__.'/api/mentori/update.php';
});

$router->put('/mentori/komentar', function(){
    include_once __DIR__.'/api/mentori/komentar.php';
});

$router->put('/grupe/update', function(){
    include_once __DIR__.'/api/grupe/update.php';
});

//DELETE

$router->delete('/praktikanti/delete', function(){
    include_once __DIR__.'/api/praktikanti/delete.php';
});

$router->delete('/mentori/delete', function(){
    include_once __DIR__.'/api/mentori/delete.php';
});

$router->delete('/grupe/delete', function(){
    include_once __DIR__.'/api/grupe/delete.php';
});


//RUN

$router->run();

}
catch(Exception $e)
{
    echo $e->getMessage();
}