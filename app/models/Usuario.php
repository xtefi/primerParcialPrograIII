<?php

class Usuario{
    public $usuario;
    public $email;
    public $pass;
    public $rol;  // GERENTE - RECEPCIONISTA - CLIENTE


    public function crearUsuario()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $query = "INSERT INTO usuarios (usuario, email, pass, rol) VALUES ('$this->usuario', '$this->email', '$this->pass', '$this->rol')";        
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
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, usuario, email, pass, rol FROM usuarios");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Usuario');
    }





}