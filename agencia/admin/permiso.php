<?php
require_once('../class/permisos.class.php');
$Permisos->validateRol('Administrador');
$accion = isset($_GET['accion']) ? $_GET['accion'] : null;
$id = isset($_GET['id']) ? $_GET['id'] : null;
$id = is_numeric($id) ? $id : null;
include('view/header.php');
switch ($accion) {
    case 'create':
        $data = isset($_POST["data"]) ? $_POST["data"] : null;
        if (isset($data["enviar"])) {
            $permisos = $Permisos->create($data);
            if ($permisos) {
                $Permisos->alerta("Permiso Guardado Correctamente", "success");
                $permisos = $Permisos->read();
                include('view/permisos.php');
            } else {
                $Permisos->alerta("Error Permiso No Guardado", "danger");
                include('view/permisos.form.php');
            }
        } else {
            include('view/permisos.form.php');
        }
        break;
    case 'delete':
        $permisos = $Permisos->delete($id);
        if ($permisos) {
            $Permisos->alerta("Permiso Eliminado", "success");
        } else {
            $Permisos->alerta("Permiso No Encontrado", "danger");
        }
        $permisos = $Permisos->read();
        include('view/permisos.php');
        break;
    case 'update':
        $data = isset($_POST["data"]) ? $_POST["data"] : null;
        if (isset($data["enviar"])) {
            if (!is_null($id)) {
                $permisos = $Permisos->update($id, $data);
            }
            if ($permisos) {
                $Permisos->alerta("Permiso Modificado Correctamente", "success");
                $permisos = $Permisos->read();
                include('view/permisos.php');
            } else {
                $Permisos->alerta("Error, Permiso No Modificado", "danger");
                include('view/permisos.form.php');
            }
        } else {
            if (!is_null($id)) {
                $permisos = $Permisos->readOne($id);
                if (isset($permisos[0])) {
                    $data = $permisos[0];
                    include('view/permisos.form.php');
                } else {
                    $Permisos->alerta("El Permiso No Existe", "danger");
                    $permisos = $Permisos->read();
                    include('view/permisos.php');
                }
            }
        }
        break;
    case 'read':
    default:
        $permisos = $Permisos->read();
        include('view/permisos.php');
}
include('view/footer.php');
