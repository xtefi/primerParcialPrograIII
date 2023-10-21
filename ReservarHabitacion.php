<?php
// a- ReservaHabitacion.php: (por POST) se recibe el Tipo de Cliente, ID de Cliente,
// Fecha de Entrada, Fecha de Salida, Tipo de Habitación (Simple, Doble, Suite), y el
// importe total de la reserva. Si el cliente existe en hoteles.json, se registra la reserva en
// el archivo reservas.json con un id autoincremental). Si el cliente no existe, informar el
// error.
// b- Completar la reserva con imagen de confirmación de reserva con el nombre: Tipo de
// Cliente, Nro. de Cliente e Id de Reserva, guardando la imagen en la carpeta
// /ImagenesDeReservas2023.

include_once "Cliente.php";
include_once "Archivos.php";
include_once "Herramientas.php";
include_once "Reservas.php";

$arrayClientes=Clientes::CargarArray();
$arrayReservas = Reservas::CargarArray();
$tipoCliente = $_POST['tipoCliente'];
$idCliente = $_POST['idCliente'];
$id = Herramientas::NuevoID($arrayReservas);
$fechaEntrada = $_POST['fechaEntrada'];
$fechaSalida = $_POST['fechaSalida'];
$tipoHabitacion = strtolower($_POST['tipoHabitacion']);
$importe = $_POST['importe'];
$mensaje = "Error, el cliente no existe, no se puede gestionar reserva.";

$fotoReserva = $_FILES['fotoReserva']['tmp_name'];
$carpetaFoto = 'C:/Users/54113/Desktop/ImagenesDeReservas2023/';
$nombreFoto = $tipoCliente . "-" . $idCliente . "-" . $id;
$extensionFoto = $_FILES['fotoReserva']['type'];
$tamanoFoto = $_FILES['fotoReserva']['size'];
$ruta_destino = $carpetaFoto . $nombreFoto . ".jpg";


if(isset($tipoCliente) && isset($idCliente) && isset($fechaEntrada) && isset($fechaSalida) && isset($tipoHabitacion) && isset($importe)){
    foreach($arrayClientes as $cliente){
        if($cliente->id == $idCliente && (strcmp($cliente->tipoCliente,$tipoCliente)==0)){
            if((strcmp($tipoHabitacion, 'simple')==0) || (strcmp($tipoHabitacion, 'doble')==0) || (strcmp($tipoHabitacion, 'suite')==0)){
                $reserva = new Reservas($idCliente, $id, $fechaEntrada, $fechaSalida, $tipoHabitacion, $importe);
                array_push($arrayReservas, $reserva);
                Archivos::GuardarJson($arrayReservas, 'reservas.json');
                $mensaje = "\nReserva registrada con éxito.";
            }else{
                $mensaje = "\nError al escoger tipo de habitación, favor revise.";
            }
        }
    }
    echo $mensaje;
}

// Validaciones de la foto - Valida tipo archivo - tamaño - directorio: si no existe lo crea
if (!((strpos($extensionFoto, "png") || strpos($extensionFoto, "jpeg")) && ($tamanoFoto < 10000000))) {
    echo "La extensión o el tamaño de los archivos no es correcta.";
}else{
    if(!is_dir($carpetaFoto)){
        mkdir($carpetaFoto, 0777, true);
    }
    if (move_uploaded_file($fotoReserva,  $ruta_destino)){
        echo "\n La foto del cliente ha sido cargada correctamente.";
    }else{
        echo "Ocurrió algún error al subir la foto.";
    }
}


?>