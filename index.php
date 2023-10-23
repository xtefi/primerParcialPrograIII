<?php
// A- index.php: Recibe todas las peticiones que realiza el cliente (utilizaremos Postman),
// y administra a qué archivo se debe incluir.

switch ($_SERVER['REQUEST_METHOD']){
    case 'POST':
        switch($_GET['op']){
            case 'ClienteAlta':
                include "ClienteAlta.php";
                break;
            case 'ConsultarCliente':
                include "ConsultarCliente.php";
                break;
            case 'ReservarHabitacion':
                include "ReservarHabitacion.php";
                break;
            case 'CancelarReserva':
                include "CancelarReservas.php";
                break;
            case 'AjusteReserva':
                include "AjusteReserva.php";
                break;
        }
        break;
    case 'GET':
        switch($_GET['op']){
            case 'ConsultarReserva':
                include "ConsultarReservas.php";
                break;
        }
        break;
    case 'PUT':
        switch($_GET['op']){
            case 'ModificarCliente':
                include "ModificarCliente.php";
                break;

        }
}


?>