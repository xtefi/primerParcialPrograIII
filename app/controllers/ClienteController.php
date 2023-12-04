<?php
require_once './models/Cliente.php';
require_once './interfaces/IApiUsable.php';

class ClienteController extends Cliente implements IApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $param = $request->getParsedBody();
        $nombre = $param['nombre'];
        $apellido = $param['apellido'];
        $tipoDocumento = $param['tipoDocumento'];
        $nroDocumento = $param['nroDocumento'];
        $email = $param['email'];
        $tipoCliente = $param['tipoCliente'];
        $pais = $param['pais'];
        $ciudad = $param['ciudad'];
        $telefono = $param['telefono'];
        $modoPago = $param['modoPago'];

        if(Cliente::verificarDni($nroDocumento) == true){
          if(!isset($nombre) || !isset($apellido) || !isset($tipoDocumento) || !isset($nroDocumento) || !isset($email) || !isset($tipoCliente) || !isset($pais) || !isset($ciudad) || !isset($telefono)){
            $response->getBody()->write(json_encode(array("error" => "Error en la carga de datos, favor verifique")));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
          }else{
                    // Creamos el cliente
            $clte = new Cliente();
            $clte->nombre = strtoupper($nombre);
            $clte->apellido = strtoupper($apellido);
            $clte->tipoDocumento = strtoupper($tipoDocumento);
            $clte->nroDocumento = $nroDocumento;
            $clte->email = $email;
            if(strcmp(strtoupper($tipoCliente), "CORPORATIVO")){
              $clte->tipoCliente = "CORPO-" . $tipoDocumento;
            }elseif (strcmp(strtoupper($tipoCliente), "INDIVIDUAL")) {
              $clte->tipoCliente = "INDI-" . $tipoDocumento;
            }
            $clte->pais = $pais;
            $clte->ciudad = $ciudad;
            $clte->telefono = $telefono;
            $clte->modoPago = $modoPago;
            $clte->activo = true;
            $clte->crearCliente();

            $payload = json_encode(array("mensaje" => "Cliente registrado con éxito"));

            $response->getBody()->write($payload);
            return $response
              ->withHeader('Content-Type', 'application/json')->withStatus(201);
          }
        }

    }

    public function TraerUno($request, $response, $args)
    {
        $parametros = $request->getQueryParams();
        $tipoCliente = strtoupper($parametros['tipoCliente']);
        $id = $args['id'];
        $cliente = Cliente::obtenerCliente($id, $tipoCliente);
        $payload = json_encode($cliente);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    public function TraerTodos($request, $response, $args)
    {
        $lista = Cliente::obtenerTodos();
        $payload = json_encode(array("listaCliente" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
    
    public function ModificarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $id = $args['id'];
        $nombre = $parametros['nombre'];
        $apellido = $parametros['apellido'];
        $tipoDocumento = $parametros['tipoDocumento'];
        $nroDocumento = $parametros['nroDocumento'];
        $email = $parametros['email'];
        $tipoClienteActual = $parametros['tipoClienteActual'];
        $nuevoTipoCliente = $parametros['nuevoTipoCliente'];
        $pais = $parametros['pais'];
        $ciudad = $parametros['ciudad'];
        $telefono = $parametros['telefono'];
        $modoPago = $parametros['modoPago'];
        $activo = $parametros['activo'];
        Cliente::modificarCliente($id, $nombre, $apellido, $tipoDocumento, $nroDocumento, $email, $tipoClienteActual, $nuevoTipoCliente, $pais, $ciudad, $telefono, $modoPago, $activo);

        $payload = json_encode(array("mensaje" => "Usuario modificado con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    public function BorrarUno($request, $response, $args)
    {
        $parametros = $request->getQueryParams();

        $id = $args['id'];
        $tipoDocumento = $parametros['tipoDocumento'];
        $nroDocumento = $parametros['nroDocumento'];
        Cliente::borrarCliente($id, $tipoDocumento, $nroDocumento);

        $payload = json_encode(array("mensaje" => "Se ha dado de baja el cliente"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}