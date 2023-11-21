<?php
// 9- BorrarCliente.php (por DELETE), debe recibir un número el tipo y número de cliente
// y debe realizar la baja de la cuenta (soft-delete, no físicamente) y la foto relacionada a
// ese cliente debe moverse a la carpeta /ImagenesBackupClientes/2023.
include_once "Cliente.php";
include_once "Archivos.php";

$arrayClientes=Clientes::CargarArray();

$nroCliente = $_GET['nroCliente'];
$tipoCliente = strtoupper($_GET['tipoCliente']);
$nroDni = $_GET['nroDni'];

$carpetaFoto = 'C:/Users/54113/Desktop/ImagenesDeClientes/2023/';
$nuevoDestino = 'C:/Users/54113/Desktop/ImagenesBackupClientes/2023/';
$nombreFoto = $nroDni . $tipoCliente;
$ruta_antiguoDestino = $carpetaFoto . $nombreFoto . ".jpg";
$ruta_nuevoDestino = $nuevoDestino . $nombreFoto . ".jpg";

foreach($arrayClientes as $cliente){
    if($cliente->id == $nroCliente && $cliente->tipoCliente == $tipoCliente && $cliente->nroDocumento == $nroDni){
        $cliente->activo = false;
        Archivos::GuardarJson($arrayClientes, 'hoteles.json');
        echo "Se ha registrado la baja del cliente";
        break;
    }
    else{
        echo "No se ha localizado algun cliente con los datos proporcionados";
    }         
}
if (file_exists($ruta_antiguoDestino)) {  
    if(!is_dir($nuevoDestino)){
        mkdir($nuevoDestino, 0777, true);
    }  
    if (rename($ruta_antiguoDestino, $ruta_nuevoDestino)) {
        echo "\nLa foto del cliente se ha movido a $ruta_nuevoDestino.";
    } else {
        echo "\nError al mover el archivo.";
    }
} else {
    echo "\nEl archivo no existe en el directorio origen.";
}


?>