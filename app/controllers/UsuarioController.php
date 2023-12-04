<?php
require_once './models/Usuario.php';
require_once './models/AutentificadorJWT.php';
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

    public function Login($request, $response, $args){
      //Se verifica el usuario y devuelve el token
      $parametros = $request->getParsedBody();
      $id = $parametros['id'];
      $usuario = $parametros['usuario'];
      $pass = $parametros['password'];
      if(!isset($id) || !isset($pass) || !isset($usuario)){
        $response->getBody()->write(json_encode(array("error" => "Error en los datos ingresados para login.")));
        $response = $response->withStatus(400);
      }else{
        $usuario = Usuario::obtenerUsuario($id, $usuario);
        if(isset($usuario)){
          //Existe el usuario, verificamos el password
          if(strcmp($pass, $usuario->pass) == 0){
            $datos = json_encode(array("id_usuario" => $usuario->id, "usuario" => $usuario->usuario, "rol" => $usuario->rol));
            $token = AutentificadorJWT::CrearToken($datos);
            $response->getBody()->write(json_encode(array("token" => $token)));
          }else{
            echo $pass;
            echo $usuario->pass;
          $response->getBody()->write(json_encode(array("error" => "Ocurrió un error, password incorrecto.")));
          $response = $response->withStatus(400);
          }        
        }else{
          $response->getBody()->write(json_encode(array("error" => "Ocurrió un error al generar el token.")));
          $response = $response->withStatus(400);
        }
      }
      return $response->withHeader('Content-Type', 'application/json');
    }

    
}