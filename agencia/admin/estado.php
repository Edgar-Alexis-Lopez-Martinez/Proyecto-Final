<?php
require_once('../class/estados.class.php');
$Estados->validateRol('Empleado');
$accion = isset($_GET['accion']) ? $_GET['accion'] : null;
$id = isset($_GET['id']) ? $_GET['id'] : null;
$id = is_numeric($id) ? $id : null;
include('view/header.php');
switch ($accion) {
    case 'create':
        $data = isset($_POST["data"]) ? $_POST["data"] : null;
        if (isset($data["enviar"])) {
            $estados = $Estados->create($data);
            if ($estados) {
                $Estados->alerta("Estado Insertado Correctamente", "success");
                $estados = $Estados->read();
                include('view/estados.php');
            } else {
                $Estados->alerta("Error Estado No Guardado", "danger");
                include('view/estados.form.php');
            }
        } else {
            include('view/estados.form.php');
        }
        break;
    case 'delete':
        $estados = $Estados->delete($id);
        if ($estados) {
            $Estados->alerta("Estado Eliminado", "success");
        } else {
            $Estados->alerta("Estado No Encontrado", "danger");
        }
        $estados = $Estados->read();
        include('view/estados.php');
        break;
    case 'update':
        $data = isset($_POST["data"]) ? $_POST["data"] : null;
        if (isset($data["enviar"])) {
            if (!is_null($id)) {
                $estados = $Estados->update($id, $data);
            }
            if ($estados) {
                $Estados->alerta("Estado Modificado Correctamente", "success");
                $estados = $Estados->read();
                include('view/estados.php');
            } else {
                $Estados->alerta("Error, Estado No Modificado", "danger");
                include('view/estados.form.php');
            }
        } else {
            if (!is_null($id)) {
                $estados = $Estados->readOne($id);
                if (isset($estados[0])) {
                    $data = $estados[0];
                    include('view/estados.form.php');
                } else {
                    $Estados->alerta("El Estado No Existe", "danger");
                    $estados = $Estados->read();
                    include('view/estados.php');
                }
            }
        }
        break;
    case 'reporte':
        ob_clean();
        $estados = $Estados->read();
        ob_start();
        include('view/estados.reporte.php');
        $variable = ob_get_clean();
        $Estados->pdf('P', 'A4', $variable, 'prueba.pdf');
        break;
    case 'read':
    default:
        $estados = $Estados->read();
        include('view/estados.php');
}
include('view/footer.php');
