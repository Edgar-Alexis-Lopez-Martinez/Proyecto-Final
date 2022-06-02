<?php
require_once('agencia.class.php');
class Usuarios extends Agencia
{
    public function read()
    {
        $linea = $this->db->prepare("select * from usuario;");
        $linea->execute();
        $usuarios = $linea->fetchAll(PDO::FETCH_ASSOC);
        return $usuarios;
    }
    public function readOne($id)
    {
        $linea = $this->db->prepare("SELECT * FROM usuario WHERE id_usuario=:id_usuario");
        $linea->bindParam(':id_usuario', $id, PDO::PARAM_INT);
        $linea->execute();
        $usuarios = $linea->fetchAll(PDO::FETCH_ASSOC);
        return $usuarios;
    }
    public function delete($id)
    {
        try {
            $this->db->beginTransaction();
            $sql = "DELETE FROM usuario_rol WHERE id_usuario=:id_usuario;";
            $borrar = $this->db->prepare($sql);
            $borrar->bindParam(':id_usuario', $id, PDO::PARAM_INT);
            $borrar->execute();
            $cuenta = $borrar->rowCount();
            $borrar = $this->db->prepare("DELETE from usuario WHERE id_usuario=:id_usuario");
            $borrar->bindParam(':id_usuario', $id, PDO::PARAM_INT);
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
            $sql = "INSERT into usuario(correo, contrasena) VALUES(:correo,md5(:contrasena))";
            $insertar = $this->db->prepare($sql);
            $insertar->bindParam(':correo', $data['correo'], PDO::PARAM_STR);
            $insertar->bindParam(':contrasena', $data['contrasena'], PDO::PARAM_STR);
            $insertar->execute();
            $cuenta = $insertar->rowCount();
            $sql = "SELECT id_usuario FROM usuario ORDER BY id_usuario DESC LIMIT 1;";
            $buscar = $this->db->prepare($sql);
            $buscar->execute();
            $usuario = $buscar->fetchAll(PDO::FETCH_ASSOC);
            if (isset($usuario[0]['id_usuario'])) {
                $id_usuario = $usuario[0]['id_usuario'];
                $susRoles = isset($_POST['rol']) ? $_POST['rol'] : array();
                $sql = "INSERT INTO usuario_rol(id_usuario,id_rol) VALUES(:id_usuario,:id_rol)";
                $insertar = $this->db->prepare($sql);
                foreach ($susRoles as $key => $rol) {
                    $insertar->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
                    $insertar->bindParam(':id_rol', $key, PDO::PARAM_INT);
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
            $sql = "UPDATE usuario SET correo=:correo, contrasena=md5(:contrasena) WHERE id_usuario=:id_usuario";
            $actualizar = $this->db->prepare($sql);
            $actualizar->bindParam(':correo', $data['correo'], PDO::PARAM_STR);
            $actualizar->bindParam(':contrasena', $data['contrasena'], PDO::PARAM_STR);
            $actualizar->bindParam(':id_usuario', $id, PDO::PARAM_INT);
            $actualizar->execute();
            if (isset($id)) {
                $id_usuario = $id;
                $susRoles = isset($_POST['rol']) ? $_POST['rol'] : array();
                $borrado = $this->delete_ur($id_usuario);
                $sql = "INSERT INTO usuario_rol(id_usuario,id_rol) VALUES(:id_usuario,:id_rol)";
                $insertar = $this->db->prepare($sql);
                foreach ($susRoles as $key => $rol) {
                    $insertar->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
                    $insertar->bindParam(':id_rol', $key, PDO::PARAM_INT);
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
    public function read_ur($id_usuario)
    {
        $linea = $this->db->prepare("SELECT * from usuario_rol where id_usuario = :id_usuario;");
        $linea->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $linea->execute();
        $usuarios_roles = $linea->fetchAll(PDO::FETCH_ASSOC);
        $roles = array();
        foreach ($usuarios_roles as $usuario_rol) {
            array_push($roles, $usuario_rol['id_rol']);
        }
        return $roles;
    }
    public function delete_ur($id_usuario)
    {
        $borrar = $this->db->prepare("DELETE from usuario_rol WHERE id_usuario=:id_usuario");
        $borrar->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $borrar->execute();
        $cuenta = $borrar->rowCount();
        return $cuenta;
    }
}
$Usuarios = new Usuarios;
$Usuarios->conexion();
