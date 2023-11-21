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
$tipoDocumento = strtoupper($_POST['tipoDocumento']); // DNI - LE - LC - PASAPORTE
$nroDocumento = $_POST['nroDocumento'];
$email = $_POST['email'];
$tipoCliente = strtoupper($_POST['tipoCliente']);  // INDI - CORPO
$pais = $_POST['pais'];
$ciudad = $_POST['ciudad'];
$telefono = $_POST['telefono'];
$modoPago = $_POST['modoPago'];
$activo = strtoupper($_POST['activo']);
$tipoDeCliente = $tipoCliente . "-" . $tipoDocumento;

$fotoCliente = $_FILES['fotoCliente']['tmp_name'];
$carpetaFoto = 'C:/Users/54113/Desktop/ImagenesDeClientes/2023/';
$nombreFoto = $nroDocumento . $tipoDeCliente;
$extensionFoto = $_FILES['fotoCliente']['type'];
$tamanoFoto = $_FILES['fotoCliente']['size'];
$ruta_destino = $carpetaFoto . $nombreFoto . ".jpg";

try{
    if(isset($nombre) && isset($apellido) && isset($tipoDocumento) && isset($nroDocumento) && isset($email) && isset($tipoCliente) && isset($pais) && isset($ciudad) && isset($telefono)){
        if( (strcmp($tipoCliente, "INDI") == 0 || strcmp($tipoCliente,"CORPO") == 0) && (strcmp($tipoDocumento, "DNI") == 0 || strcmp($tipoDocumento, "LE") == 0 || strcmp($tipoDocumento, "LC") == 0 || strcmp($tipoDocumento, "PASAPORTE") == 0)){  // SI EL TIPO COINCIDE CON LOS DOS POSIBLES CASOS
            $tipoDeCliente = $tipoCliente . "-" . $tipoDocumento;
            $nuevoCliente = new Clientes(Herramientas::NuevoID($arrayClientes), $nombre, $apellido, $tipoDocumento, $nroDocumento, $email, $tipoDeCliente, $pais, $ciudad, $telefono, $modoPago, $activo);
            if(Clientes::equals($nuevoCliente, $arrayClientes)){
                echo "El cliente ya existe.";                      
            }else{
                array_push($arrayClientes, $nuevoCliente);
                Archivos::GuardarJson($arrayClientes, "hoteles.json");
                echo "Cliente guardado";                
            }
        }else{
            echo "Tipo de cliente o tipo de DNI mal ingresados, favor revise.";
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