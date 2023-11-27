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

class Cliente{
    public $id;
    public $nombre;
    public $apellido;
    public $tipoDocumento;
    public $nroDocumento;
    public $email;
    public $tipoCliente;
    public $pais;
    public $ciudad;
    public $telefono;
    public $modoPago;
    public $activo;

    public function crearCliente()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $query = "INSERT INTO clientes (nombre, apellido, tipoDocumento, nroDocumento, email, tipoCliente, pais, ciudad, telefono, modoPago, activo ) VALUES ('$this->nombre', '$this->apellido', '$this->tipoDocumento', '$this->nroDocumento', '$this->email', '$this->tipoCliente', '$this->pais', '$this->ciudad', '$this->telefono', '$this->modoPago', '$this->activo')";        
        $consulta = $objAccesoDatos->prepararConsulta($query);
        // $claveHash = password_hash($this->clave, PASSWORD_DEFAULT);
        // $consulta->bindValue(':usuario', $this->usuario, PDO::PARAM_STR);
        // $consulta->bindValue(':clave', $claveHash);
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, nombre, apellido, tipoDocumento, nroDocumento, email, tipoCliente, pais, ciudad, telefono, modoPago, activo FROM clientes");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Cliente');
    }

    public static function obtenerCliente($id, $tipoCliente)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT pais, ciudad, telefono FROM clientes WHERE id = ? AND tipoCliente= ?");
        $consulta->bindParam(1, $id);
        $consulta->bindParam(2, $tipoCliente);
        $consulta->execute();

        return $consulta->fetchObject('Cliente');
    }

    public static function modificarCliente($id, $nombre, $apellido, $tipoDocumento, $nroDocumento, $email, $tipoClienteActual, $nuevoTipoCliente, $pais, $ciudad, $telefono, $modoPago, $activo) 
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $query="UPDATE clientes SET nombre = ?, apellido = ?, tipoDocumento = ?, nroDocumento = ?, email = ?, tipoCliente = ?, pais = ?, ciudad = ?, telefono = ?, modoPago = ?, activo = ? WHERE id = ?  AND tipoCliente = ?";
        $consulta = $objAccesoDato->prepararConsulta($query);
        $consulta->bindParam(1, $nombre);
        $consulta->bindParam(2, $apellido);
        $consulta->bindParam(3, $tipoDocumento);
        $consulta->bindParam(4, $nroDocumento);
        $consulta->bindParam(5, $email);
        $consulta->bindParam(6, $nuevoTipoCliente);
        $consulta->bindParam(7, $pais);
        $consulta->bindParam(8, $ciudad);
        $consulta->bindParam(9, $telefono);
        $consulta->bindParam(10, $modoPago);
        $consulta->bindParam(11, $activo);
        $consulta->bindParam(12, $id);
        $consulta->bindParam(13, $tipoClienteActual);
        $consulta->execute();
    }

    public static function borrarCliente($id, $tipoDocumento, $nroDocumento)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE clientes SET activo = false WHERE id = :id AND tipoDocumento = :tipoDocumento AND nroDocumento = :nroDocumento");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->bindValue(':tipoDocumento', $tipoDocumento, PDO::PARAM_STR);
        $consulta->bindValue(':nroDocumento', $nroDocumento, PDO::PARAM_STR);
        $consulta->execute();
    }

}

?>

