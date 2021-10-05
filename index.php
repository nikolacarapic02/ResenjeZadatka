<?php

use api\Mentori;
use api\Praktikanti;
use api\Grupe;

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
    $obj = new Praktikanti();
    return $obj->praktikantRead();
});

$router->get('/praktikanti/read_single/'.$id='(\d+)', function($id){
    $obj = new Praktikanti();
    return $obj->praktikantReadSingle($id);
});

$router->get('/praktikanti/read_single', function($id=1){
    $obj = new Praktikanti();
    return $obj->praktikantReadSingle($id);
});

$router->get('/mentori/read', function(){
    $obj = new Mentori();
    return $obj->mentorRead();
});

$router->get('/mentori/read_single/'.$id='(\d+)', function($id){
    $obj = new Mentori();
    return $obj->mentorReadSingle($id);
});

$router->get('/mentori/read_single', function($id=1){
    $obj = new Mentori();
    return $obj->mentorReadSingle($id);
});

$router->get('/grupe/read', function(){
    $obj = new Grupe();
    return $obj->grupaRead();
});

$router->get('/grupe/read_single/'.$id='(\d+)', function($id){
    $obj = new Grupe();
    return $obj->grupaReadSingle($id);
});

$router->get('/grupe/read_single', function($id=1){
    $obj = new Grupe();
    return $obj->grupaReadSingle($id);
});

$router->get('/grupe/listing/'.$page='(\d+)', function($page){
    $obj = new Grupe();
    return $obj->grupaListing($page);
});

$router->get('/grupe/listing', function($page = 1){
    $obj = new Grupe();
    return $obj->grupaListing($page);
});


//POST

$router->post('/praktikanti/create', function(){
    $obj = new Praktikanti();
    return $obj->praktikantCreate();
});

$router->post('/mentori/create', function(){
    $obj = new Mentori();
    return $obj->mentoriCreate();
});

$router->post('/grupe/create', function(){
    $obj = new Grupe();
    return $obj->grupaCreate();
});


//PUT

$router->put('/praktikanti/update', function(){
    $obj = new Praktikanti();
    return $obj->praktikantUpdate();
});

$router->put('/mentori/update', function(){
    $obj = new Mentori();
    return $obj->mentoriUpdate();
});

$router->put('/mentori/komentar', function(){
    $obj = new Mentori();
    return $obj->mentoriKomentar();
});

$router->put('/grupe/update', function(){
    $obj = new Grupe();
    return $obj->grupaUpdate();
});

//DELETE

$router->delete('/praktikanti/delete', function(){
    $obj = new Praktikanti();
    return $obj->praktikantDelete();
});

$router->delete('/mentori/delete', function(){
    $obj = new Mentori();
    return $obj->mentoriDelete();
});

$router->delete('/grupe/delete', function(){
    $obj = new Grupe();
    return $obj->grupaDelete();
});


//RUN

$router->run();

}
catch(Exception $e)
{
    echo $e->getMessage();
}