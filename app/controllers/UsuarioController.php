<?php
require_once './models/Usuario.php';
require_once './interfaces/IApiUsable.php';

class UsuarioController extends Usuario 
{
    public function CargarUno($request, $response, $args)
    {
        $param = $request->getParsedBody();
        $usuario = $param['usuario'];
        $pass = $param['pass'];
        $email = $param['email'];
        $rol = $param['rol'];

        // Creamos el cliente
        $clte = new Usuario();
        $clte->usuario = $usuario;
        $clte->pass = $pass;
        $clte->email = $email;
        $clte->rol = $rol;

        $clte->crearCliente();

        $payload = json_encode(array("mensaje" => "Usuario registrado con éxito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
      $lista = Usuario::obtenerTodos();
      $payload = json_encode(array("lista de reservas" => $lista));

      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    
}