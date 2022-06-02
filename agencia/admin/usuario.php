<?php
require_once('../class/usuarios.class.php');
require_once('../class/roles.class.php');
$Usuarios->validateRol('Administrador');
$accion = isset($_GET['accion']) ? $_GET['accion'] : null;
$id = isset($_GET['id']) ? $_GET['id'] : null;
$id = is_numeric($id) ? $id : null;
$roles = $Roles->read();
include('view/header.php');
switch ($accion) {
    case 'create':
        $data = isset($_POST["data"]) ? $_POST["data"] : null;
        if (isset($data["enviar"])) {
            $usuarios = $Usuarios->create($data);
            if ($usuarios) {
                $Usuarios->alerta("Usuario Guardado Correctamente", "success");
                $usuarios = $Usuarios->read();
                include('view/usuarios.php');
            } else {
                $Usuarios->alerta("Error Usuario No Guardado", "danger");
                include('view/usuarios.form.php');
            }
        } else {
            include('view/usuarios.form.php');
        }
        break;
    case 'delete':
        $usuarios = $Usuarios->delete($id);
        if ($usuarios) {
            $Usuarios->alerta("Usuario Eliminado", "success");
        } else {
            $Usuarios->alerta("Usuario No Encontrado", "danger");
        }
        $usuarios = $Usuarios->read();
        include('view/usuarios.php');
        break;
    case 'update':
        $data = isset($_POST["data"]) ? $_POST["data"] : null;
        if (isset($data["enviar"])) {
            if (!is_null($id)) {
                $usuarios = $Usuarios->update($id, $data);
            }
            if ($usuarios) {
                $Usuarios->alerta("Usuario Modificado Correctamente", "success");
                $usuarios = $Usuarios->read();
                include('view/usuarios.php');
            } else {
                $Usuarios->alerta("Error, Usuario No Modificado", "danger");
                include('view/usuarios.form.php');
            }
        } else {
            if (!is_null($id)) {
                $usuarios = $Usuarios->readOne($id);
                $misRoles = $Usuarios->read_ur($id);
                if (isset($usuarios[0])) {
                    $data = $usuarios[0];
                    include('view/usuarios.form.php');
                } else {
                    $Usuarios->alerta("El Usuario No Existe", "danger");
                    $usuarios = $Usuarios->read();
                    include('view/usuarios.php');
                }
            }
        }
        break;
    case 'read':
    default:
        $usuarios = $Usuarios->read();
        include('view/usuarios.php');
}
include('view/footer.php');
