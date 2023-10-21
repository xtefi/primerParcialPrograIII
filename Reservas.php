<?php
// a- ReservaHabitacion.php: (por POST) se recibe el Tipo de Cliente, Nro de Cliente,
// Fecha de Entrada, Fecha de Salida, Tipo de Habitación (Simple, Doble, Suite), y el
// importe total de la reserva. Si el cliente existe en hoteles.json, se registra la reserva en
// el archivo reservas.json con un id autoincremental). Si el cliente no existe, informar el
// error.
// b- Completar la reserva con imagen de confirmación de reserva con el nombre: Tipo de
// Cliente, Nro. de Cliente e Id de Reserva, guardando la imagen en la carpeta
// /ImagenesDeReservas2023.

class Reservas{
    public $id;
    public $idCliente;
    public $fechaEntrada;
    public $fechaSalida;
    public $tipoHabitacion;
    public $importe;

    public function __construct($idCliente, $id, $fechaEntrada, $fechaSalida, $tipoHabitacion, $importe){
        $this->idCliente = $idCliente;
        $this->id = $id;
        $this->fechaEntrada = $fechaEntrada;
        $this->fechaSalida = $fechaSalida;
        $this->$tipoHabitacion = $tipoHabitacion;
        $this->importe = $importe;
    }

    static function CargarArray(){
        $array=Archivos::LeerJson('reservas.json');
        $arrayRetorno = [];
        if($array !== null){
            foreach($array as $item) {
                $reserva = new Reservas($item['idCliente'], $item['id'], $item['fechaEntrada'], $item['fechaSalida'], $item['tipoHabitacion'], $item['importe']);
                $arrayRetorno[] = $reserva;
            }
        }
        return $arrayRetorno;
    }
}


?>