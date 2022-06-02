<?php
require_once('agencia.class.php');
class Roles extends Agencia
{
    public function read()
    {
        $linea = $this->db->prepare("select * from rol;");
        $linea->execute();
        $roles = $linea->fetchAll(PDO::FETCH_ASSOC);
        return $roles;
    }
    public function readOne($id)
    {
        $linea = $this->db->prepare("SELECT * FROM rol WHERE id_rol=:id_rol");
        $linea->bindParam(':id_rol', $id, PDO::PARAM_INT);
        $linea->execute();
        $roles = $linea->fetchAll(PDO::FETCH_ASSOC);
        return $roles;
    }
    public function delete($id)
    {
        try {
            $this->db->beginTransaction();
            $sql = "DELETE FROM permiso_rol WHERE id_rol=:id_rol;";
            $borrar = $this->db->prepare($sql);
            $borrar->bindParam(':id_rol', $id, PDO::PARAM_INT);
            $borrar->execute();
            $cuenta = $borrar->rowCount();
            $borrar = $this->db->prepare("DELETE from rol WHERE id_rol=:id_rol");
            $borrar->bindParam(':id_rol', $id, PDO::PARAM_INT);
            $borrar->execute();
            $cuenta = $borrar->rowCount();
            $this->db->commit();
            return $cuenta;
        } catch (Exception $e) {
            $this->db->rollback();
            return 0;
        }
    }
    public function create($data)
    {
        $cuenta = null;
        try {
            $this->db->beginTransaction();
            $sql = "INSERT into rol(rol) VALUES(:rol)";
            $insertar = $this->db->prepare($sql);
            $insertar->bindParam(':rol', $data['rol'], PDO::PARAM_STR);
            $insertar->execute();
            $cuenta = $insertar->rowCount();
            $sql = "SELECT id_rol FROM rol ORDER BY id_rol DESC LIMIT 1;";
            $buscar = $this->db->prepare($sql);
            $buscar->execute();
            $rol = $buscar->fetchAll(PDO::FETCH_ASSOC);
            if (isset($rol[0]['id_rol'])) {
                $id_rol = $rol[0]['id_rol'];
                $susPermisos = isset($_POST['permiso']) ? $_POST['permiso'] : array();
                $sql = "INSERT INTO permiso_rol(id_permiso,id_rol) VALUES(:id_permiso,:id_rol)";
                $insertar = $this->db->prepare($sql);
                foreach ($susPermisos as $key => $permiso) {
                    $insertar->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
                    $insertar->bindParam(':id_permiso', $key, PDO::PARAM_INT);
                    $insertar->execute();
                }
                $this->db->commit();
                return $cuenta;
            } else {
                $this->db->rolback();
                return 0;
            }
        } catch (Exception $e) {
            $this->db->rollback();
            return 0;
        }
    }
    public function update($id, $data)
    {
        try {
            $this->db->beginTransaction();
            $sql = "UPDATE rol SET rol=:rol WHERE id_rol=:id_rol";
            $actualizar = $this->db->prepare($sql);
            $actualizar->bindParam(':rol', $data['rol'], PDO::PARAM_STR);
            $actualizar->bindParam(':id_rol', $id, PDO::PARAM_INT);
            $actualizar->execute();
            if (isset($id)) {
                $id_rol = $id;
                $susPermisos = isset($_POST['permiso']) ? $_POST['permiso'] : array();
                $borrado = $this->delete_pr($id_rol);
                $sql = "INSERT INTO permiso_rol(id_permiso,id_rol) VALUES(:id_permiso,:id_rol)";
                $insertar = $this->db->prepare($sql);
                foreach ($susPermisos as $key => $permiso) {
                    $insertar->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
                    $insertar->bindParam(':id_permiso', $key, PDO::PARAM_INT);
                    $insertar->execute();
                }
                $this->db->commit();
                return $actualizar;
            } else {
                $this->db->rolback();
                return 0;
            }
        } catch (Exception $e) {
            $this->db->rollback();
        }
    }
    public function read_pr($id_rol)
    {
        $linea = $this->db->prepare("SELECT * from permiso_rol where id_rol = :id_rol;");
        $linea->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
        $linea->execute();
        $permisos_roles = $linea->fetchAll(PDO::FETCH_ASSOC);
        $permisos = array();
        foreach ($permisos_roles as $permiso_rol) {
            array_push($permisos, $permiso_rol['id_permiso']);
        }
        return $permisos;
    }
    public function delete_pr($id_rol)
    {
        $borrar = $this->db->prepare("DELETE from permiso_rol WHERE id_rol=:id_rol");
        $borrar->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
        $borrar->execute();
        $cuenta = $borrar->rowCount();
        return $cuenta;
    }
}
$Roles = new Roles;
$Roles->conexion();
