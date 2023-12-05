<?php

class Log{

    public $id;
    public $id_usuario;
    public $usuario;
    public $entidad;
    public $operacion;
    public $datos_operacion; 
    public $datos_resultado_operacion;

    public static function Add($id_usuario, $usuario, $entidad, $operacion, $datos_operacion, $datos_resultado_operacion){
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO logs (id_usuario, usuario, entidad, operacion, datos_operacion, datos_resultado_operacion, fecha_hora) VALUES (:id_usuario, :usuario, :entidad, :operacion, :datos_operacion, :datos_resultado_operacion, :fecha_hora)");
        $consulta->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $consulta->bindValue(':usuario', $usuario, PDO::PARAM_STR);
        $consulta->bindValue(':entidad', $entidad, PDO::PARAM_STR);
        $consulta->bindValue(':operacion', $operacion, PDO::PARAM_STR);
        $consulta->bindValue(':datos_operacion', $datos_operacion, PDO::PARAM_STR);
        $consulta->bindValue(':datos_resultado_operacion', $datos_resultado_operacion, PDO::PARAM_STR);
        $consulta->bindValue(':fecha_hora', date('Y-m-d H:i'), PDO::PARAM_STR);
        $consulta->execute();
        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM logs");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Log');
    }

    public static function ConstructorLogs($id, $id_usuario, $usuario, $entidad, $operacion, $datos_operacion, $datos_resultado_operacion) {
        $logs = new Log();
        $logs->id = $id;
        $logs->id_usuario = $id_usuario;
        $logs->usuario = $usuario;
        $logs->entidad = $entidad;
        $logs->operacion = $operacion;
        $logs->datos_operacion = $datos_operacion;
        $logs->datos_resultado_operacion = $datos_resultado_operacion;
        return $logs;
    }
}

?>