<?php
// B- ClienteAlta.php: (por POST) se ingresa Nombre y Apellido, Tipo Documento, Nro.
// Documento, Email, Tipo de Cliente (individual o corporativo), País, Ciudad y Teléfono.
// Se guardan los datos en el archivo hoteles.json, tomando un id autoincremental de 6
// dígitos como Nro. de Cliente (emulado). Si el nombre y tipo ya existen , se actualiza la
// información y se agrega al registro existente.
// completar el alta con imagen/foto del cliente, guardando la imagen con Número y Tipo
// de Cliente (ej.: NNNNNNTT) como identificación en la carpeta:
// /ImagenesDeClientes/2023.
// 2-
// ConsultarCliente.php: (por POST) Se ingresa Tipo y Nro. de Cliente, si coincide con
// algún registro del archivo hoteles.json, retornar el país, ciudad y teléfono del cliente/s.
// De lo contrario informar si no existe la combinación de nro y tipo de cliente o, si existe
// el número y no el tipo para dicho número, el mensaje: “tipo de cliente incorrecto”.

public $nombre;
public $apellido;
public $tipoDocumento;
public $nroDocumento;
public $email;
public $tipoCliente;
public $pais;
public $ciudad;
public $telefono;
public $foto;

public function __construct($nombre, $apellido, $tipoDocumento, $nroDocumento, $email, $tipoCliente, $pais, $ciudad, $telefono){

}

public static function CargarArray(){
    $array=Archivos::LeerJson('hoteles.json');
    $arrayRetorno = [];
    if($array !== null){
        foreach($array as $item) {
            $cliente = new Cliente($item['nombre'], $item['apellido'], $item['tipoDocumento'], $item['nroDocumento'], $item['email'], $item['tipoCliente'], $item['pais'], $item['ciudad'], $item['telefono']);
            $arrayRetorno[] = $cliente;}
    }
    return $arrayRetorno;
}

?>
