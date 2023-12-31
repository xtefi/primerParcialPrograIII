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
$totalImporte=0;


// a- El total de reservas (importe) por tipo de habitación y fecha en un día en particular
// (se envía por parámetro), si no se pasa fecha, se muestran las del día anterior.
if(isset($tipoHabitacion)){
    foreach($arrayReservas as $reserva){
        if($fecha == null || (strcmp($fecha, "") == 0) || !isset($fecha)){
            $fecha = mktime(0, 0, 0, date("m")  , date("d")-1, date("Y"));   // ACA OBTENGO LA FECHA DE AYER
            date('Y-m-d', $fecha);
        }
        if((strtotime($reserva->fechaEntrada) <= $fecha) && (strtotime($reserva->fechaSalida) >= $fecha) && (strcmp($reserva->tipoHabitacion, $tipoHabitacion) == 0)){
            $totalImporte+=$reserva->importe;          
        }
    }
    echo "Total de reservas en la fecha " . date('y-m-d', $fecha) . " para habitacines tipo " . $tipoHabitacion . "\n" . " - Importe: " . $totalImporte;
}

//////////////////////////B////////////////////////////////////////// 
echo "\n\n b- Listado de reservas para un cliente en particular.";
if(isset($idCliente)){
    foreach($arrayReservas as $reserva){
        if($idCliente == $reserva->idCliente){
            echo "\nReservas del cliente " . $reserva->idCliente . "\nid: " . $reserva->id . " - fecha de entrada: " . $reserva->fechaEntrada . " - fecha salida: " . $reserva->fechaSalida . " - tipo de habitación: " . $reserva->tipoHabitacion . " - importe: " . $reserva->importe;
        }
    }
}

///////////////////////////C//////////////////////////////////////////
echo "\n\n c- Listado de reservas entre dos fechas ordenado por fecha.";
// creo un subarray que cumpla con las fechas ingresadas
$subArrayReservas=[];
if(isset($fechaDesde) && isset($fechaHasta) && $fechaDesde <= $fechaHasta){
    foreach($arrayReservas as $reserva){    
        if((strtotime($reserva->fechaEntrada) >= $fechaDesde) && (strtotime($reserva->fechaSalida) <= $fechaHasta)){
            array_push($subArrayReservas, $reserva);
        }    
    } 
}
// Creo una funcion para comparar por fecha y la aplico en "usort"
function compararPorFechaEntrada($a, $b) {
    return strtotime($a->fechaEntrada) - strtotime($b->fechaEntrada);
}
usort($subArrayReservas, 'compararPorFechaEntrada');
foreach ($subArrayReservas as $reserva) {
    echo "\nID: " . $reserva->id . ", Fecha de Entrada: " . $reserva->fechaEntrada . ", tipo de habitacion: " . $reserva->tipoHabitacion ;
}

////////////////////////////D///////////////////////////////////////
echo "\n\nd- Listado de reservas por tipo de habitación.";
if(isset($tipoHabitacion)){
    foreach($arrayReservas as $reserva){
        if((strcmp($reserva->tipoHabitacion, $tipoHabitacion) == 0)){
            echo "\nReserva habitación tipo: " . $reserva->tipoHabitacion ." - id: " . $reserva->id . " - fecha de entrada: " . $reserva->fechaEntrada . " - fecha salida: " . $reserva->fechaSalida . " - importe: " . $reserva->importe;            
        }
    }
}
?>