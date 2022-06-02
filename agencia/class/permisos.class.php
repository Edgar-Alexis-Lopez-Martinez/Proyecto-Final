<?php
require_once('agencia.class.php');
class Permisos extends Agencia
{
    public function read()
    {
        $linea = $this->db->prepare("select * from permiso;");
        $linea->execute();
        $permisos = $linea->fetchAll(PDO::FETCH_ASSOC);
        return $permisos;
    }
    public function readOne($id)
    {
        $linea = $this->db->prepare("SELECT * FROM permiso WHERE id_permiso=:id_permiso");
        $linea->bindParam(':id_permiso', $id, PDO::PARAM_INT);
        $linea->execute();
        $permisos = $linea->fetchAll(PDO::FETCH_ASSOC);
        return $permisos;
    }
    public function delete($id)
    {
        $borrar = $this->db->prepare("DELETE from permiso WHERE id_permiso=:id_permiso");
        $borrar->bindParam(':id_permiso', $id, PDO::PARAM_INT);
        $borrar->execute();
        $cuenta = $borrar->rowCount();
        return $cuenta;
    }
    public function create($data)
    {
        $cuenta = null;
        $sql = "INSERT into permiso(permiso) VALUES(:permiso)";
        $insertar = $this->db->prepare($sql);
        $insertar->bindParam(':permiso', $data['permiso'], PDO::PARAM_STR);
        $insertar->execute();
        $cuenta = $insertar->rowCount();
        return $cuenta;
    }
    public function update($id, $data)
    {
        $sql = "UPDATE permiso SET permiso=:permiso WHERE id_permiso=:id_permiso";
        $actualizar = $this->db->prepare($sql);
        $actualizar->bindParam(':permiso', $data['permiso'], PDO::PARAM_STR);
        $actualizar->bindParam(':id_permiso', $id, PDO::PARAM_INT);
        $actualizar->execute();
        $cuenta = $actualizar->rowCount();
        return $cuenta;
    }
}
$Permisos = new Permisos;
$Permisos->conexion();
