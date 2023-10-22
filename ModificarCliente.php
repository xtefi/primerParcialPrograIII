<?php
// 5- ModificarCliente.php (por PUT)
// Debe recibir todos los datos propios de un cliente; si dicho cliente existe (comparar por
// Tipo y Nro. de Cliente) se modifica, de lo contrario informar que no existe ese cliente.

include_once "Cliente.php";

$arrayCliente = Clientes::CargarArray();
$datos = json_decode(file_get_contents("php://input"), true);

if(($datos['id'] != null && (strcmp($item['nombre'], "") != 0) &&
    (strcmp($item['apellido'], "") != 0) $item['tipoDocumento'], $item['nroDocumento'], $item['email'], $item['tipoCliente'], $item['pais'], $item['ciudad'], $item['telefono']);)

?>