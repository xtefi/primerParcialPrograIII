<?php
// 7- AjusteReserva.php (por POST),
// Se ingresa el número de reserva afectada al ajuste y el motivo del mismo. El número de
// reserva debe existir.
// Guardar en el archivo ajustes.json
// Actualiza en el estado de la reserva en el archivo reservas.json
include_once 'Reservas.php';
include_once 'Archivos.php';

$arrayReservas = Reservas::CargarArray();
$idReserva = $_POST['idReserva'];
$nuevoImporte = $_POST['nuevoImporte'];
$motivo = $_POST['motivo'];
$mensaje = "No se ha encontrado reserva bajo ese ID.";

foreach($arrayReservas as $reserva){
    if($reserva->id == $idReserva){
        $reserva->importe = $nuevoImporte;
        $reserva->ajuste = $motivo;
        Archivos::GuardarJson($arrayReservas, 'reservas.json');
        $mensaje= "Ajuste aplicado";
        break;
    }
}
echo $mensaje;
?>