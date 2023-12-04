<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

require_once './models/Log.php';

class logsMiddleware
{
    public static function LogOperacion(Request $request, RequestHandler $handler): Response
    {
        //Logueo de acciones de las acciones(cambio de estados de pedidos, mesas, usuarios)
        $response = new Response();
        $response = $handler->handle($request);
        $path = $request->getUri()->getPath();
        $metodo = $request->getMethod();
        $http_status_code = $response->getStatusCode();
        $param = $request->getParsedBody();

        if(str_contains($path, 'login'))                           // LOGIN
        { 
            $request = $request->getParsedBody();
            $id_usuario = $request['id'];
            $usuario = $request['usuario'];
            Log::Add($id_usuario, $usuario, 'LOGIN', 'LOGUEO-SISTEMA', "", "");

        }
        elseif(str_contains($path, 'clientes')){                       // CLIENTES
            $jwtHeader = $request->getHeaderLine('Authorization');
            $tokenWithoutBearer = str_replace('Bearer ', '', $jwtHeader);
            $usuario = AutentificadorJWT::ObtenerData($tokenWithoutBearer);

            if($metodo == 'POST'){
                Log::Add($usuario->id, $usuario->usuario, 'CLIENTES', 'CARGAR-UNO', json_encode($param), $response->getBody());
            }elseif($metodo == 'PUT'){
                $id_cliente = $args['id'];
                Log::Add($usuario->id, $usuario->usuario, 'CLIENTES', 'MODIFICAR-UNO', json_encode($param), $response->getBody());
            }elseif($metodo == 'GET'){
                if(!empty($param['idCliente'])){
                    $id_cliente = $param['idCliente'];
                    Log::Add($usuario->id, $usuario->usuario, 'CLIENTES', 'OBTENER-UNO', json_encode($param), $response->getBody());
                }else{
                    Log::Add($usuario->id, $usuario->usuario, 'CLIENTES', 'OBTENER-TODOS', json_encode($param), $response->getBody());                    
                }
            }
            elseif($metodo == 'DELETE')
            {
                $id_cliente = $param['id'];
                Log::Add($id_usuario, $usuario, 'CLIENTES', 'ELIMINAR-UNO', json_encode($param), $response->getBody());
            }else { 
                Log::Add($id_usuario, $usuario, 'ERROR','Error', json_encode($param), $response->getBody());
            }        

        }elseif(str_contains($path, 'reservas')){
            $jwtHeader = $request->getHeaderLine('Authorization');
            $tokenWithoutBearer = str_replace('Bearer ', '', $jwtHeader);
            $usuario = AutentificadorJWT::ObtenerData($tokenWithoutBearer);

            if($metodo == 'POST'){
                Log::Add($usuario->id, $usuario->usuario, 'RESERVAS', 'CARGAR-UNO', json_encode($param), $response->getBody());
            }elseif($metodo == 'PUT'){
                $id_cliente = $args['id'];
                Log::Add($usuario->id, $usuario->usuario, 'RESERVAS', 'MODIFICAR-UNO', json_encode($param), $response->getBody());
            }elseif($metodo == 'GET'){
                if(!empty($param['idCliente'])){
                    $id_cliente = $param['idCliente'];
                    Log::Add($usuario->id, $usuario->usuario, 'RESERVAS', 'OBTENER-UNO', json_encode($param), $response->getBody());
                }else{
                    Log::Add($usuario->id, $usuario->usuario, 'RESERVAS', 'OBTENER-TODOS', json_encode($param), $response->getBody());                    
                }
            }
            elseif($metodo == 'DELETE')
            {
                $id_cliente = $param['id'];
                Log::Add($id_usuario, $usuario, 'RESERVAS', 'ELIMINAR-UNO', $id_cliente, json_encode($param), $response->getBody());
            }else { 
                Log::Add($id_usuario, $usuario, 'ERROR', null, 'Error', json_encode($param), $response->getBody());
            } 
        }
        return $response;

    }
}