<?php
// B- ClienteAlta.php: (por POST) se ingresa Nombre y Apellido, Tipo Documento, Nro.
// Documento, Email, Tipo de Cliente (individual o corporativo), País, Ciudad y Teléfono.
// Se guardan los datos en el archivo hoteles.json, tomando un id autoincremental de 6
// dígitos como Nro. de Cliente (emulado). Si el nombre y tipo ya existen , se actualiza la
// información y se agrega al registro existente.
// completar el alta con imagen/foto del cliente, guardando la imagen con Número y Tipo
// de Cliente (ej.: NNNNNNTT) como identificación en la carpeta:
// /ImagenesDeClientes/2023.

include_once "Cliente.php";
include_once "Archivos.php";
include_once "Herramientas.php";

$arrayClientes=Clientes::CargarArray();
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$tipoDocumento = $_POST['tipoDocumento'];
$nroDocumento = $_POST['nroDocumento'];
$email = $_POST['email'];
$tipoCliente = strtolower($_POST['tipoCliente']);  // INDIVIDUAL - CORPORATIVO
$pais = $_POST['pais'];
$ciudad = $_POST['ciudad'];
$telefono = $_POST['telefono'];

$fotoCliente = $_FILES['fotoCliente']['tmp_name'];
$carpetaFoto = 'C:/Users/54113/Desktop/ImagenesDeClientes/2023/';
$nombreFoto = $nroDocumento . $tipoCliente;
$extensionFoto = $_FILES['fotoCliente']['type'];
$tamanoFoto = $_FILES['fotoCliente']['size'];
$ruta_destino = $carpetaFoto . $nombreFoto . ".jpg";

try{
    if(isset($nombre) && isset($apellido) && isset($tipoDocumento) && isset($nroDocumento) && isset($email) && isset($tipoCliente) && isset($pais) && isset($ciudad) && isset($telefono)){
        if(strcmp($tipoCliente, "individual") == 0 || strcmp($tipoCliente,"corporativo") == 0){  // SI EL TIPO COINCIDE CON LOS DOS POSIBLES CASOS
            $nuevoCliente = new Clientes(Herramientas::NuevoID($arrayClientes), $nombre, $apellido, $tipoDocumento, $nroDocumento, $email, $tipoCliente, $pais, $ciudad, $telefono);
            if(Clientes::equals($nuevoCliente, $arrayClientes)){
                echo "El cliente ya existe.";                      
            }else{
                array_push($arrayClientes, $nuevoCliente);
                Archivos::GuardarJson($arrayClientes, "hoteles.json");
                echo "Cliente guardado";                
            }
        }
    }else{
        echo "Faltan datos";
    }
}catch(Exception $e){
    echo "Ocurrio un error inesperado" . $e->getMessage();
}

// Validaciones de la foto - Valida tipo archivo - tamaño - directorio: si no existe lo crea
if (!((strpos($extensionFoto, "png") || strpos($extensionFoto, "jpeg")) && ($tamanoFoto < 10000000))) {
    echo "La extensión o el tamaño de los archivos no es correcta.";
}else{
    if(!is_dir($carpetaFoto)){
        mkdir($carpetaFoto, 0777, true);
    }
    if (move_uploaded_file($fotoCliente,  $ruta_destino)){
        echo "\n La foto del cliente ha sido cargada correctamente.";
    }else{
        echo "Ocurrió algún error al subir la foto.";
    }
}







?>