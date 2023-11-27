<?php
require_once './models/Reserva.php';
require_once './interfaces/IApiUsable.php';

class ReservaController extends Reserva implements IApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $param = $request->getParsedBody();
        $tipoCliente = $param['tipoCliente'];
        $idCliente = $param['idCliente'];
        $fechaEntrada = $param['fechaEntrada'];
        $fechaSalida = $param['fechaSalida'];
        $tipoHabitacion = $param['tipoHabitacion'];
        $importe = $param['importe'];
        $activa = $param['activa'];
        $ajuste = $param['ajuste'];

        // Creamos la reserva
        $rsv = new Reserva();
        $rsv->tipoCliente = $tipoCliente;
        $rsv->idCliente = $idCliente;
        $rsv->fechaEntrada = $fechaEntrada;
        $rsv->fechaSalida = $fechaSalida;
        $rsv->tipoHabitacion = $tipoHabitacion;
        $rsv->importe = $importe;
        $rsv->activa = $activa;
        $rsv->ajuste = $ajuste;
        $rsv->crearReserva();

        $payload = json_encode(array("mensaje" => "Reserva registrado con éxito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno($request, $response, $args)
    {
      $parametros = $request->getQueryParams();
      $id = $args['id'];
      $tipoCliente = $parametros['tipoCliente'];

      $reserva = Reserva::obtenerReserva($id, $tipoCliente);
      $payload = json_encode($reserva);

      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
      $lista = Reserva::obtenerTodos();
      $payload = json_encode(array("lista de reservas" => $lista));

      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'application/json');
    }
    
    public function ModificarUno($request, $response, $args)
    {
      $param = $request->getParsedBody();
      $id = $args['id'];
      $importe = $param['importe'];
      $ajuste = $param['ajuste'];
      Reserva::modificarReserva($id, $importe, $ajuste);

      $payload = json_encode(array("mensaje" => "Reserva ajustada con exito"));

      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args)
    {
      $parametros = $request->getQueryParams();

      $id = $args['id'];
      $tipoCliente = $parametros['tipoCliente'];
      $idCliente = $parametros['idCliente'];
      Reserva::borrarReserva($id, $tipoCliente, $idCliente);

      $payload = json_encode(array("mensaje" => "Se ha dado de baja la reserva"));

      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'application/json');
    }
}