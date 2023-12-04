<?php
// Error Handling
error_reporting(-1);
ini_set('display_errors', 1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Slim\Routing\RouteContext;

require __DIR__ . '/../vendor/autoload.php';

require_once './db/AccesoDatos.php';
require_once './controllers/ClienteController.php';
require_once './controllers/ReservaController.php';
require_once './controllers/UsuarioController.php';
require_once './middlewares/permisosMiddleware.php';
require_once './middlewares/logsMiddleware.php';



// Load ENV
// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
// $dotenv->safeLoad();

// Instantiate App
$app = AppFactory::create();

// Add error middleware
$app->addErrorMiddleware(true, true, true);
date_default_timezone_set('America/Argentina/Buenos_Aires');

// Add parse body
$app->addBodyParsingMiddleware();

$app->group('/ingresar', function (RouteCollectorProxy $group) {
    //Accesible para todos los usuarios.
    $group->post('/login', \UsuarioController::class . ':Login'); 
})->add(\logsMiddleware::class . ':LogOperacion');

// Routes
$app->group('/clientes', function (RouteCollectorProxy $group) {
    $group->get('[/]', \ClienteController::class . ':TraerTodos');
    $group->get('/{id}', \ClienteController::class . ':TraerUno');
    $group->post('[/]', \ClienteController::class . ':CargarUno')->add(\permisosMiddleware::class . ':verificarRolGerente');
    $group->put('/{id}', \ClienteController::class . ':ModificarUno');
    $group->delete('/{id}', \ClienteController::class . ':BorrarUno')->add(\permisosMiddleware::class . ':verificarRolGerente');
  })
  ->add(\logsMiddleware::class . ':LogOperacion');

$app->group('/reservas', function (RouteCollectorProxy $group) {
    $group->get('[/]', \ReservaController::class . ':TraerTodos');
    $group->get('/{id}', \ReservaController::class . ':TraerUno');
    $group->post('[/]', \ReservaController::class . ':CargarUno');
    $group->post('/{id}', \ReservaController::class . ':ModificarUno');
    $group->put('/{idCliente}', \ReservaController::class . ':reservasPorIdCliente');
    $group->delete('/{id}', \ReservaController::class . ':BorrarUno');
})->add(\permisosMiddleware::class . ':verificarRolRecepcionistaYCliente')
  ->add(\logsMiddleware::class . ':LogOperacion');

$app->group('/usuarios', function (RouteCollectorProxy $group) {
    $group->get('[/]', \UsuarioController::class . ':TraerTodos');
    $group->post('[/]', \UsuarioController::class . ':CargarUno');
});



$app->get('[/]', function (Request $request, Response $response) {    
    $payload = json_encode(array("mensaje" => "Slim Framework 4 PHP"));
    
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();





?>