<?php
// a- ReservaHabitacion.php: (por POST) se recibe el Tipo de Cliente, Nro de Cliente,
// Fecha de Entrada, Fecha de Salida, Tipo de Habitación (Simple, Doble, Suite), y el
// importe total de la reserva. Si el cliente existe en hoteles.json, se registra la reserva en
// el archivo reservas.json con un id autoincremental). Si el cliente no existe, informar el
// error.
// b- Completar la reserva con imagen de confirmación de reserva con el nombre: Tipo de
// Cliente, Nro. de Cliente e Id de Reserva, guardando la imagen en la carpeta
// /ImagenesDeReservas2023.

class Reserva{
    public $id;
    public $tipoCliente;
    public $idCliente;
    public $fechaEntrada;
    public $fechaSalida;
    public $tipoHabitacion;
    public $importe;
    public $activa;
    public $ajuste;


    // AGREGAR CONTROL PARA VERIFICAR DATOS DEL CLIENTE
    public function crearReserva()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $query = "INSERT INTO reservas (tipoCliente, idCliente, fechaEntrada, fechaSalida, tipoHabitacion, importe, activa, ajuste) VALUES ('$this->tipoCliente', '$this->idCliente', '$this->fechaEntrada', '$this->fechaSalida', '$this->tipoHabitacion', '$this->importe', '$this->activa', '$this->ajuste')";        
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
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, tipoCliente, idCliente, fechaEntrada, fechaSalida, tipoHabitacion, importe, activa, ajuste FROM reservas");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Reserva');
    }

    public static function obtenerReserva($id, $tipoCliente)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, tipoCliente, idCliente, fechaEntrada, fechaSalida, tipoHabitacion, importe, activa, ajuste FROM reservas WHERE id = ? AND tipoCliente= ?");
        $consulta->bindParam(1, $id);
        $consulta->bindParam(2, $tipoCliente);
        $consulta->execute();

        return $consulta->fetchObject('Reserva');
    }

    public static function modificarReserva($id, $ajuste, $nuevoMonto) 
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $query="UPDATE reservas SET ajuste = ?, nuevoMonto = ? WHERE id = ?";
        $consulta = $objAccesoDato->prepararConsulta($query);
        $consulta->bindParam(1, $ajuste);
        $consulta->bindParam(2, $nuevoMonto);
        $consulta->bindParam(3, $id);
        $consulta->execute();
    }

    public static function borrarReserva($id, $tipoCliente, $idCliente)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE reservas SET activa = false WHERE id = :id AND tipoCliente = :tipoCliente AND idCliente = :idCliente");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->bindValue(':tipoCliente', $tipoCliente, PDO::PARAM_STR);
        $consulta->bindValue(':idCliente', $idCliente, PDO::PARAM_STR);
        $consulta->execute();
    }


}


?>