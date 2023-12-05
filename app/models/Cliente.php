<?php

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
        $query = "INSERT INTO hoteles (nombre, apellido, tipoDocumento, nroDocumento, email, tipoCliente, pais, ciudad, telefono, modoPago, activo ) VALUES ('$this->nombre', '$this->apellido', '$this->tipoDocumento', '$this->nroDocumento', '$this->email', '$this->tipoCliente', '$this->pais', '$this->ciudad', '$this->telefono', '$this->modoPago', '$this->activo')";        
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
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, nombre, apellido, tipoDocumento, nroDocumento, email, tipoCliente, pais, ciudad, telefono, modoPago, activo FROM hoteles");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Cliente');
    }

    public static function obtenerCliente($id, $tipoCliente)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT pais, ciudad, telefono FROM hoteles WHERE id = ? AND tipoCliente= ?");
        $consulta->bindParam(1, $id);
        $consulta->bindParam(2, $tipoCliente);
        $consulta->execute();

        return $consulta->fetchObject('Cliente');
    }

    public static function modificarCliente($id, $nombre, $apellido, $tipoDocumento, $nroDocumento, $email, $tipoClienteActual, $nuevoTipoCliente, $pais, $ciudad, $telefono, $modoPago, $activo) 
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $query="UPDATE hoteles SET nombre = ?, apellido = ?, tipoDocumento = ?, nroDocumento = ?, email = ?, tipoCliente = ?, pais = ?, ciudad = ?, telefono = ?, modoPago = ?, activo = ? WHERE id = ?  AND tipoCliente = ?";
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
        $consulta = $objAccesoDato->prepararConsulta("UPDATE hoteles SET activo = false WHERE id = :id AND tipoDocumento = :tipoDocumento AND nroDocumento = :nroDocumento");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->bindValue(':tipoDocumento', $tipoDocumento, PDO::PARAM_STR);
        $consulta->bindValue(':nroDocumento', $nroDocumento, PDO::PARAM_STR);
        $consulta->execute();
    }

    public static function verificarDni($nroDocumento){
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM hoteles WHERE nroDocumento = :nroDocumento");
        $consulta->bindValue(':nroDocumento', $nroDocumento, PDO::PARAM_STR);
        $consulta->execute();
        if(!empty($consulta)){
            return true;
        }
        return false;
    }


}

?>

