<?php
require_once('../class/ciudades.class.php');
require_once('../class/estados.class.php');
$Estados->validateRol('Empleado');
$accion = isset($_GET['accion']) ? $_GET['accion'] : null;
$id = isset($_GET['id']) ? $_GET['id'] : null;
$id = is_numeric($id) ? $id : null;
$estados = $Estados->read();
include('view/header.php');
switch ($accion) {
    case 'create':
        $data = isset($_POST["data"]) ? $_POST["data"] : null;
        if (isset($data["enviar"])) {
            $ciudades = $Ciudades->create($data);
            if ($ciudades) {
                $Ciudades->alerta("Ciudad Guardada Correctamente", "success");
                $ciudades = $Ciudades->read();
                include('view/ciudades.php');
            } else {
                $Ciudades->alerta("Error Ciudad No Guardada", "danger");
                include('view/ciudades.form.php');
            }
        } else {
            include('view/ciudades.form.php');
        }
        break;
    case 'delete':
        $ciudades = $Ciudades->delete($id);
        if ($ciudades) {
            $Ciudades->alerta("Ciudad Eliminada", "success");
        } else {
            $Ciudades->alerta("Ciudad No Encontrada", "danger");
        }
        $ciudades = $Ciudades->read();
        include('view/ciudades.php');
        break;
    case 'update':
        $data = isset($_POST["data"]) ? $_POST["data"] : null;
        if (isset($data["enviar"])) {
            if (!is_null($id)) {
                $ciudades = $Ciudades->update($id, $data);
            }
            if ($ciudades) {
                $Ciudades->alerta("Ciudad Modificada Correctamente", "success");
                $ciudades = $Ciudades->read();
                include('view/ciudades.php');
            } else {
                $Ciudades->alerta("Error, Ciudad No Modificada", "danger");
                include('view/ciudades.form.php');
            }
        } else {
            if (!is_null($id)) {
                $ciudades = $Ciudades->readOne($id);
                if (isset($ciudades[0])) {
                    $data = $ciudades[0];
                    include('view/ciudades.form.php');
                } else {
                    $Ciudades->alerta("La Ciudad No Existe", "danger");
                    $ciudades = $Ciudades->read();
                    include('view/ciudades.php');
                }
            }
        }
        break;
    case 'read':
    default:
        $ciudades = $Ciudades->read();
        include('view/ciudades.php');
}
include('view/footer.php');

//$Agencia->send_correo("edgarmlmp@gmail.com", "Prueba 2", "Este Es Otro Correo De Prueba");
