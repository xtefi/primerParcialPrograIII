<?php
// 6- CancelarReserva.php: (por POST) se recibe el Tipo de Cliente, Nro de Cliente, y el Id
// de Reserva a cancelar. Si el cliente existe en hoteles.json y la reserva en reservas.json,
// se marca como cancelada en el registro de reservas. Si el cliente o la reserva no existen,
// informar el tipo de error.
include_once 'Cliente.php';
include_once 'Reservas.php';
include_once 'Archivos.php';

$arrayClientes=Clientes::CargarArray();
$arrayReservas = Reservas::CargarArray();

$tipoCliente = $_POST['tipoCliente'];
$idCliente = $_POST['idCliente'];
$idReserva = $_POST['idReserva'];
$mensaje = "No se ha encontrado cliente con ese id.";
$clienteLocalizado = false;

foreach($arrayClientes as $cliente){          // Nota -> No puedo romper este foreach si se cancela la reserva
    if($cliente->id == $idCliente){
        $clienteLocalizado = true;
        echo "Cliente localizado.\n";       
        break;
    }
}
if($clienteLocalizado === true){
    foreach($arrayReservas as $reserva){
        if($reserva->id == $idReserva && $reserva->idCliente == $idCliente){
            $reserva->activa = false;
            Archivos::GuardarJson($arrayReservas, 'reservas.json');
            $mensaje = "Reserva cancelada.";
            break;
        }else{
            $mensaje = "No se ha encontrado ninguna reserva para ese cliente con el id indicado.";
        }   
    }
}

echo $mensaje;

?>