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

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$tipoDocumento = $_POST['tipoDocumento'];
$nroDocumento = $_POST['nroDocumento'];
$email = $_POST['email'];
$tipoCliente = $_POST['tipoCliente'];
$pais = $_POST['pais'];
$ciudad = $_POST['ciudad'];
$telefono = $_POST['telefono'];
$fotoCliente = $_FILES['fotoCliente'];




?>