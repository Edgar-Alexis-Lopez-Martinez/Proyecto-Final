<?php
require_once('../class/pases.class.php');
require_once('../class/ciudades.class.php');
require_once('../class/contenidos.class.php');
$Pases->validateRol('Empleado');
$accion = isset($_GET['accion']) ? $_GET['accion'] : null;
$id = isset($_GET['id']) ? $_GET['id'] : null;
$id = is_numeric($id) ? $id : null;
$ciudades = $Ciudades->read();
$contenidos = $Contenidos->read();
include('view/header.php');
switch ($accion) {
    case 'create':
        $data = isset($_POST["data"]) ? $_POST["data"] : null;
        if (isset($data["enviar"])) {
            $pases = $Pases->create($data);
            if ($pases) {
                $Pases->alerta("Pase Guardado Correctamente", "success");
                $pases = $Pases->read();
                include('view/pases.php');
            } else {
                $Pases->alerta("Error Pase No Guardado", "danger");
                include('view/pases.form.php');
            }
        } else {
            include('view/pases.form.php');
        }
        break;
    case 'delete':
        $pases = $Pases->delete($id);
        if ($pases) {
            $Pases->alerta("Pase Eliminado", "success");
        } else {
            $Pases->alerta("Pase No Encontrado", "danger");
        }
        $pases = $Pases->read();
        include('view/pases.php');
        break;
    case 'update':
        $data = isset($_POST["data"]) ? $_POST["data"] : null;
        if (isset($data["enviar"])) {
            if (!is_null($id)) {
                $pases = $Pases->update($id, $data);
            }
            if ($pases) {
                $Pases->alerta("Pase Modificado Correctamente", "success");
                $pases = $Pases->read();
                include('view/pases.php');
            } else {
                $Pases->alerta("Error, Pase No Modificado", "danger");
                include('view/pases.form.php');
            }
        } else {
            if (!is_null($id)) {
                $pases = $Pases->readOne($id);
                $misContenidos = $Pases->read_pase_contenido($id);
                if (isset($pases[0])) {
                    $data = $pases[0];
                    include('view/pases.form.php');
                } else {
                    $Pases->alerta("El Pase No Existe", "danger");
                    $pases = $Pases->read();
                    include('view/pases.php');
                }
            }
        }
        break;
    case 'read':
    default:
        $pases = $Pases->read();
        include('view/pases.php');
}
include('view/footer.php');
