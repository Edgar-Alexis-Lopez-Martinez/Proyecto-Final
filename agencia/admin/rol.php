<?php
require_once('../class/roles.class.php');
require_once('../class/permisos.class.php');
$Roles->validateRol('Administrador');
$accion = isset($_GET['accion']) ? $_GET['accion'] : null;
$id = isset($_GET['id']) ? $_GET['id'] : null;
$id = is_numeric($id) ? $id : null;
$permisos = $Permisos->read();
include('view/header.php');
switch ($accion) {
    case 'create':
        $data = isset($_POST["data"]) ? $_POST["data"] : null;
        if (isset($data["enviar"])) {
            $roles = $Roles->create($data);
            if ($roles) {
                $Roles->alerta("Rol Guardado Correctamente", "success");
                $roles = $Roles->read();
                include('view/roles.php');
            } else {
                $Roles->alerta("Error Rol No Guardado", "danger");
                include('view/roles.form.php');
            }
        } else {
            include('view/roles.form.php');
        }
        break;
    case 'delete':
        $roles = $Roles->delete($id);
        if ($roles) {
            $Roles->alerta("Rol Eliminado", "success");
        } else {
            $Roles->alerta("Rol No Encontrado", "danger");
        }
        $roles = $Roles->read();
        include('view/roles.php');
        break;
    case 'update':
        $data = isset($_POST["data"]) ? $_POST["data"] : null;
        if (isset($data["enviar"])) {
            if (!is_null($id)) {
                $roles = $Roles->update($id, $data);
            }
            if ($roles) {
                $Roles->alerta("Rol Modificado Correctamente", "success");
                $roles = $Roles->read();
                include('view/roles.php');
            } else {
                $Roles->alerta("Error, Rol No Modificado", "danger");
                include('view/roles.form.php');
            }
        } else {
            if (!is_null($id)) {
                $roles = $Roles->readOne($id);
                $misPermisos = $Roles->read_pr($id);
                if (isset($roles[0])) {
                    $data = $roles[0];
                    include('view/roles.form.php');
                } else {
                    $Roles->alerta("El Rol No Existe", "danger");
                    $roles = $Roles->read();
                    include('view/roles.php');
                }
            }
        }
        break;
    case 'read':
    default:
        $roles = $Roles->read();
        include('view/roles.php');
}
include('view/footer.php');
