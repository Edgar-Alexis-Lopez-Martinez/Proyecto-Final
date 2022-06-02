<?php
require_once('../class/contenidos.class.php');
$Contenidos->validateRol('Empleado');
$accion = isset($_GET['accion']) ? $_GET['accion'] : null;
$id = isset($_GET['id']) ? $_GET['id'] : null;
$id = is_numeric($id) ? $id : null;
include('view/header.php');
switch ($accion) {
    case 'create':
        $data = isset($_POST["data"]) ? $_POST["data"] : null;
        if (isset($data["enviar"])) {
            $contenidos = $Contenidos->create($data);
            if ($contenidos) {
                $Contenidos->alerta("Contenido Guardado Correctamente", "success");
                $contenidos = $Contenidos->read();
                include('view/contenidos.php');
            } else {
                $Contenidos->alerta("Error Contenido No Guardado", "danger");
                include('view/contenidos.form.php');
            }
        } else {
            include('view/contenidos.form.php');
        }
        break;
    case 'delete':
        $contenidos = $Contenidos->delete($id);
        if ($contenidos) {
            $Contenidos->alerta("Contenido Eliminado", "success");
        } else {
            $Contenidos->alerta("Contenido No Encontrado", "danger");
        }
        $contenidos = $Contenidos->read();
        include('view/contenidos.php');
        break;
    case 'update':
        $data = isset($_POST["data"]) ? $_POST["data"] : null;
        if (isset($data["enviar"])) {
            if (!is_null($id)) {
                $contenidos = $Contenidos->update($id, $data);
            }
            if ($contenidos) {
                $Contenidos->alerta("Contenido Modificado Correctamente", "success");
                $contenidos = $Contenidos->read();
                include('view/contenidos.php');
            } else {
                $Contenidos->alerta("Error, Contenido No Modificado", "danger");
                include('view/contenidos.form.php');
            }
        } else {
            if (!is_null($id)) {
                $contenidos = $Contenidos->readOne($id);
                if (isset($contenidos[0])) {
                    $data = $contenidos[0];
                    include('view/contenidos.form.php');
                } else {
                    $Contenidos->alerta("El Contenido No Existe", "danger");
                    $contenidos = $Contenidos->read();
                    include('view/contenidos.php');
                }
            }
        }
        break;
    case 'read':
    default:
        $contenidos = $Contenidos->read();
        include('view/contenidos.php');
}
include('view/footer.php');
