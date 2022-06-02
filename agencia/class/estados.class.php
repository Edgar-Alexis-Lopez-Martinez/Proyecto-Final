<?php
require_once('agencia.class.php');
class Estados extends Agencia
{
    public function read()
    {
        $linea = $this->db->prepare("SELECT * FROM estado");
        $linea->execute();
        $estados = $linea->fetchAll(PDO::FETCH_ASSOC);
        return $estados;
    }
    public function readOne($id)
    {
        $linea = $this->db->prepare("SELECT * FROM estado WHERE id_estado=:id_estado");
        $linea->bindParam(':id_estado', $id, PDO::PARAM_INT);
        $linea->execute();
        $estados = $linea->fetchAll(PDO::FETCH_ASSOC);
        return $estados;
    }
    public function readEstado_Ciudad($id)
    {
        $linea = $this->db->prepare("SELECT * FROM ciudad WHERE id_estado=:id_estado");
        $linea->bindParam(':id_estado', $id, PDO::PARAM_INT);
        $linea->execute();
        $estados = $linea->fetchAll(PDO::FETCH_ASSOC);
        return $estados;
    }
    public function delete($id)
    {
        $borrar = $this->db->prepare("DELETE from estado WHERE id_estado=:id_estado");
        $borrar->bindParam(':id_estado', $id, PDO::PARAM_INT);
        $borrar->execute();
        $cuenta = $borrar->rowCount();
        return $cuenta;
    }
    public function create($data)
    {
        $cuenta = null;
        $foto = $this->cargarImagen("estado");
        if ($foto) {
            $sql = "INSERT into estado(estado,descripcion,foto) VALUES(:estado,:descripcion,:foto)";
            $insertar = $this->db->prepare($sql);
            $insertar->bindParam(':estado', $data['estado'], PDO::PARAM_STR);
            $insertar->bindParam(':descripcion', $data['descripcion'], PDO::PARAM_STR);
            $insertar->bindParam(':foto', $foto, PDO::PARAM_STR);
            $insertar->execute();
            $cuenta = $insertar->rowCount();
        }
        return $cuenta;
    }
    public function update($id, $data)
    {
        $foto = $this->cargarImagen(("estado"));
        if ($foto) {
            $sql = "UPDATE estado SET estado=:estado, descripcion=:descripcion, foto=:foto
                WHERE id_estado=:id_estado";
            $actualizar = $this->db->prepare($sql);
        } else {
            $sql = "UPDATE estado SET estado=:estado, descripcion=:descripcion
                WHERE id_estado=:id_estado";
        }
        $actualizar = $this->db->prepare($sql);
        $actualizar->bindParam(':estado', $data['estado'], PDO::PARAM_STR);
        $actualizar->bindParam(':descripcion', $data['descripcion'], PDO::PARAM_STR);
        $actualizar->bindParam(':id_estado', $id, PDO::PARAM_INT);
        if ($foto) {
            $actualizar->bindParam(':foto', $foto, PDO::PARAM_STR);
        }
        $actualizar->execute();
        $cuenta = $actualizar->rowCount();
        return $cuenta;
    }
}
$Estados = new Estados;
$Estados->conexion();
