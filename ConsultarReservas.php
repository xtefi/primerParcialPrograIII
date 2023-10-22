<?php
// 4- ConsultaReservas.php: (por GET)
include_once "Reservas.php";
include_once "Cliente.php";
include_once "Archivos.php";

$arrayReservas = Reservas::CargarArray();
$arrayCliente = Clientes::CargarArray();
$tipoHabitacion = $_GET['tipoHabitacion'];
$fecha = strtotime($_GET['fecha']);
$fechaDesde = strtotime($_GET['fechaDesde']);
$fechaHasta = strtotime($_GET['fechaHasta']);
$idCliente = $_GET['idCliente'];
$activa = $_GET['activa'];
$totalImporte=0;
$totalReservas=0;


// a- El total de reservas (importe) por tipo de habitación y fecha en un día en particular
// (se envía por parámetro), si no se pasa fecha, se muestran las del día anterior.
if(isset($fecha) && isset($tipoHabitacion)){
    foreach($arrayReservas as $reserva){
        if((strtotime($reserva->fechaEntrada) <= $fecha) && (strtotime($reserva->fechaSalida) >= $fecha) && (strcmp($reserva->tipoHabitacion, $tipoHabitacion) == 0)){
            $totalImporte+=$reserva->importe;
            $totalReservas++;             
        }
    }
    echo "Total de reservas en la fecha indicada para ese tipo de habitación: " . $totalReservas . " - Importe: " . $totalImporte;
}

// b- El listado de reservas para un cliente en particular. 
if(isset($idCliente)){
    foreach($arrayReservas as $reserva){
        if($idCliente === $reserva->idCliente){
            echo "\nReservas del cliente " . $reserva->idCliente . "\nid: " . $reserva->id . " - fecha de entrada: " . $reserva->fechaEntrada . " - fecha salida: " . $reserva->fechaSalida . " - tipo de habitación: " . $reserva->tipoHabitacion . " - importe: " . $reserva->importe;
        }
    }
}

// c- El listado de reservas entre dos fechas ordenado por fecha.
$arrayOrdenadoPorFecha=[];
if(isset($fechaDesde) && isset($fechaHasta)){
    foreach($arrayReservas as $reserva){    
        if((strtotime($reserva->fechaEntrada) <= $fechaDesde)){
            array_push($arrayOrdenadoPorFecha, $reserva);
        }    
    } //&& (strtotime($reserva->fechaSalida) >= $fechaHasta)
}
if(count($arrayOrdenadoPorFecha)>0){
    asort($arrayOrdenadoPorFecha);
    foreach($arrayOrdenadoPorFecha as $reserva){
        echo "\nid: " . $reserva->id . " - fecha de entrada: " . $reserva->fechaEntrada . " - fecha salida: " . $reserva->fechaSalida . " - tipo de habitación: " . $reserva->tipoHabitacion . " - importe: " . $reserva->importe;            
    }
}

// d- El listado de reservas por tipo de habitación.
if(isset($tipoHabitacion)){
    foreach($arrayReservas as $reserva){
        if((strcmp($reserva->tipoHabitacion, $tipoHabitacion) == 0)){
            echo "\n\nReserva habitación tipo: " . $reserva->tipoHabitacion ." - id: " . $reserva->id . " - fecha de entrada: " . $reserva->fechaEntrada . " - fecha salida: " . $reserva->fechaSalida . " - importe: " . $reserva->importe;            
        }
    }
}
?>