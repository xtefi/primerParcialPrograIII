<?php
// 5- ModificarCliente.php (por PUT)
// Debe recibir todos los datos propios de un cliente; si dicho cliente existe (comparar por
// Tipo y Nro. de Cliente) se modifica, de lo contrario informar que no existe ese cliente.

include_once "Cliente.php";
include_once "Archivos.php";

$arrayCliente = Clientes::CargarArray();
$datos = json_decode(file_get_contents("php://input"), true);
$mensaje = "\nNo se ha encotrado cliente con los datos ingresados.";

// if(($datos['id'] != null && (strcmp($datos['nombre'], "") != 0) &&
//     (strcmp($datos['apellido'], "") != 0) $datos['tipoDocumento'], $datos['nroDocumento'], $datos['email'], $datos['tipoCliente'], $datos['pais'], $datos['ciudad'], $datos['telefono']);)

foreach($arrayCliente as $cliente){
    if(($cliente->id === $datos['id']) && ($cliente->tipoCliente === $datos['tipoCliente'])){
        $cliente->nombre=$datos['nombre'];
        $cliente->apellido=$datos['apellido'];
        $cliente->tipoDocumento=$datos['tipoDocumento'];
        $cliente->nroDocumento=$datos['nroDocumento'];
        $cliente->email=$datos['email'];
        $cliente->tipoCliente=$datos['tipoCliente'];
        $cliente->pais=$datos['pais'];
        $cliente->ciudad=$datos['ciudad'];
        $cliente->telefono=$datos['telefono'];
        Archivos::GuardarJson($arrayCliente, 'hoteles.json');
        $mensaje = "\nCliente modificado con éxito.";
        break;
    }
}

echo $mensaje;

?>