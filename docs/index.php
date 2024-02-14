<?php

/**
 * @author juanvladimir13 <juanvladimir13@gmail.com>
 * @see https://github.com/juanvladimir13
 */

require '../vendor/autoload.php';

header('HTTP-X-Empresa: juanvladimir13');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: application/x-www-form-urlencoded, multipart/form-data, text/html, application/json');

use Bramus\Router\Router;
use Veterinaria\Http\Controllers\ControllerMascota;
use Veterinaria\Http\Controllers\ControllerPropietario;

$router = new Router();

$router->get('/propietario',
    '\Veterinaria\Http\Controllers\ControllerPropietario@index');
$router->get('/propietario/(\d+)/destroy',
    '\Veterinaria\Http\Controllers\ControllerPropietario@destroy');
$router->get('/propietario/(\d+)/edit',
    '\Veterinaria\Http\Controllers\ControllerPropietario@edit');

$router->get('/propietario/form', '\Veterinaria\Http\Controllers\ControllerPropietario@create');
$router->post('/propietario/form', function () {
    $controller = new ControllerPropietario();
    $data = $_POST;
    $controller->store($data);
});

$router->get('/mascota',
    '\Veterinaria\Http\Controllers\ControllerMascota@index');
$router->get('/mascota/(\d+)/destroy',
    '\Veterinaria\Http\Controllers\ControllerMascota@destroy');
$router->get('/mascota/(\d+)/edit',
    '\Veterinaria\Http\Controllers\ControllerMascota@edit');

$router->get('/mascota/form', '\Veterinaria\Http\Controllers\ControllerMascota@create');
$router->post('/mascota/form', function () {
    $controller = new ControllerMascota();
    $data = $_POST;
    $controller->store($data);
});

$router->get('/api/v1/propietarios', function () {
    $api = new \Veterinaria\Api\V1\Controlles\ControllerPropietario();
    echo $api->index();
});

$router->get('/api/v1/propietarios/(\d+)', function ($id) {
    $api = new \Veterinaria\Api\V1\Controlles\ControllerPropietario();
    echo $api->find($id);
});

$router->delete('/api/v1/propietarios/(\d+)', function ($id) {
    $api = new \Veterinaria\Api\V1\Controlles\ControllerPropietario();
    echo $api->delete($id);
});

$router->post('/api/v1/propietarios', function () {
    $request = new \Veterinaria\Api\Request();

    $api = new \Veterinaria\Api\V1\Controlles\ControllerPropietario();
    echo $api->post($request);
});

$router->put('/api/v1/propietarios/(\d+)', function ($id) {
    $request = new \Veterinaria\Api\Request();

    $api = new \Veterinaria\Api\V1\Controlles\ControllerPropietario();
    echo $api->put($request, $id);
});

$router->set404(function () {
    echo '404';
    exit();
});

$router->run();


/*$isGET = ($_SERVER['REQUEST_METHOD'] ?? 'GET') == 'GET';
//$uri = $_SERVER['REQUEST_URI'] ?? '/';
$uri = $_SERVER['PATH_INFO'] ?? '/';


if ($isGET && $uri == '/propietario') {
    $controller = new ControllerPropietario();
    $controller->index();
}

if ($isGET && $uri == '/propietario/form') {
    $controller = new ControllerPropietario();
    $controller->create();
}

if (!$isGET && $uri == '/propietario/form') {
    $controller = new ControllerPropietario();
    $data = $_POST;
    $controller->store($data);
}

if ($isGET && $uri == '/propietario/delete') {
    $controller = new ControllerPropietario();
    $data = (int)$_GET['id'] ?? 0;
    $controller->destroy($data);
    //echo 'from' .  $data;
}*/
