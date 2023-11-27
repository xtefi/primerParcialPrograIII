<?php
// ConsultarCliente.php: (por POST) Se ingresa Tipo y Nro. de Cliente, si coincide con
// algún registro del archivo hoteles.json, retornar el país, ciudad y teléfono del cliente/s.
// De lo contrario informar si no existe la combinación de nro y tipo de cliente o, si existe
// el número y no el tipo para dicho número, el mensaje: “tipo de cliente incorrecto
include_once 'Archivos.php';
include_once 'Cliente.php';

$tipoCliente = $_POST['tipoCliente'];
$id = $_POST['id'];
$arrayClientes = Clientes::CargarArray();
$mensaje="Cliente no encontrado";
foreach($arrayClientes as $item){
    if($item->id == $id){
        if((strcmp($item->tipoCliente,$tipoCliente) == 0)){
            $mensaje= "Pais: " . $item->pais . " - Ciudad: " . $item->ciudad . " - Telefono: " . $item->telefono;
            break;
        }else{
            $mensaje= "\nTipo de cliente incorrecto para el ID ingresado.";
            break;
        }        
    }       
}
echo $mensaje;
?>