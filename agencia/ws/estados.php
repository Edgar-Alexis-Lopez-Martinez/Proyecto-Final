<?php
include_once('../class/agencia.class.php');
include_once('../class/estados.class.php');
$accion = $_SERVER['REQUEST_METHOD'];
$datos = array();
switch ($accion) {
    case 'POST':
        $data[0] = $_POST;
        if (isset($_GET['id_estado'])) {
            $id = $_GET['id_estado'];
            foreach ($data as $estado) {
                $estados = $Estados->update($id, $estado);
                $status = 200;
                $mensaje = 'Se Actualizo El Registro Correctamente';
            }
        } else {
            foreach ($data as $estado) {
                $estados = $Estados->create($estado);
                $status = 200;
                $mensaje = 'Se Creo El Registro Correctamente';
            }
        }

        break;

    case 'DELETE':
        if (isset($_GET['id_estado'])) {
            $id_estados = $_GET['id_estado'];
            $cantidad = $Estados->delete($id_estado);
            $status = 200;
            $mensaje = 'Se Ha Eliminado Con Exito El Estado';
        } else {
            $status = 404;
            $mensaje = 'No Se Ha Encontrado EL Estado Para Eliminar';
        }

        break;

    case 'GET':
    default:
        if (isset($_GET['id_estado'])) {
            $id_estados = $_GET['id_estado'];
            $datos = $Estados->readOne($id_estado);
        } else {
            $datos = $Estados->read();
        }
        $datos = $Estados->read();
        $status = 200;
        $mensaje = 'Se Han Procesado Con Exito Los Estados';
}
$Agencia->json($datos, $status, $mensaje);
