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
        

//        ($id_usuario, $usuario, $rol, $operacion, id-entidad, $datos_operacion, $datos_resultado_operacion){


        if(str_contains($path, 'login'))
        {              // LOGUEO
            $param = $request->getParsedBody();
            $id_usuario = $param['id'];
            $usuario = $param['usuario'];
            $rol = $param['rol'];
            if($http_status_code == 200 )
            {
                Log::Add($id_usuario, $usuario, $rol, 'Ingreso sistema', null, null);
            }
        }
        elseif(str_contains($path, 'clientes')){                       // CLIENTES
            $param = $request->getParsedBody()["body"];
            $data_token = json_decode($request->getParsedBody()["dataToken"], true);
            $id_usuario = $data_token['id_usuario'];
            $usuario = $data_token['usuario'];
            $rol = $data_token['rol'];
            if($metodo == 'POST' && $http_status_code == 201){
                Log::Add($id_usuario, $usuario, $rol, 'CLIENTES', 'CARGAR-UNO', 0, json_encode($param), $response->getBody());
            }elseif($metodo == 'PUT' && $http_status_code == 200){
                $id_cliente = $param['id'];
                Log::Add($id_usuario, $usuario, $rol, 'CLIENTES', 'MODIFICAR-UNO', $id_cliente, json_encode($param), $response->getBody());
            }elseif($metodo == 'GET' && $http_status_code == 200){
                if(!empty($param['id'])){
                    $id_cliente = $param['id'];
                    Log::Add($id_usuario, $usuario, $rol, 'CLIENTES', 'OBTENER-UNO', $id_cliente, json_encode($param), $response->getBody());
                }else{
                    Log::Add($id_usuario, $usuario, $rol, 'CLIENTES', 'OBTENER-TODOS', null, json_encode($param), $response->getBody());                    
                }
            }
            elseif($metodo == 'DELETE' && $http_status_code == 200)
            {
                $id_cliente = $param['id'];
                Log::Add($id_usuario, $usuario, $rol, 'CLIENTES', 'ELIMINAR-UNO', $id_cliente, json_encode($param), $response->getBody());
            }else { 
                Log::Add($id_usuario, $usuario, $rol, 'ERROR', null, 'Error', json_encode($param), $response->getBody());
            }        
        return $response;
        }
        else
        {

        }
    }
}