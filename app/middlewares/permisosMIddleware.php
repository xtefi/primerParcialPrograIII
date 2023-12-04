<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class permisosMiddleware{

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = $handler->handle($request);
        $existingContent = (string) $response->getBody();
    
        $response = new Response();
        $response->getBody()->write('BEFORE' . $existingContent);
    
        return $response;
    }

    public static function verificarRolGerente(Request $request, RequestHandler $handler)
    {
        $parametros = $request->getQueryParams();
        $rol = $parametros['rol'];

        if(strtoupper($rol) === 'GERENTE'){
            $response = $handler->handle($request);
        } else {
            $response = new Response();
            $payload = json_encode(array('mensaje' => 'No sos Socio'));
            $response->getBody()->write($payload);
        }
        return $response->withHeader('Content-Type', 'application/json');
    }

    public static function verificarRolRecepcionistaYCliente(Request $request, RequestHandler $handler)
    {
        $parametros = $request->getQueryParams();
        $rol = $parametros['rol'];

        if(strtoupper($rol) === 'RECEPCIONISTA' || strtoupper($rol) === 'CLIENTE'){
            $response = $handler->handle($request);
        } else {
            $response = new Response();
            $payload = json_encode(array('mensaje' => 'No sos Recepcionista'));
            $response->getBody()->write($payload);
        }
        return $response->withHeader('Content-Type', 'application/json');
    }

}