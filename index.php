<?php
// A- index.php: Recibe todas las peticiones que realiza el cliente (utilizaremos Postman),
// y administra a qué archivo se debe incluir.

switch ($_SERVER['REQUEST_METHOD']){
    case 'POST':
        switch($_GET['op']){
            case 'alta':
                include "ClienteAlta.php";
                break;
            case 'consultar':
                include "ConsultarCliente.php";
                break;
        }
        break;
    case 'GET':
        switch($_GET['op']){
            case 'reserva':
                include "ReservarHabitacion.php";
                break;
        }
        break;
}


?>