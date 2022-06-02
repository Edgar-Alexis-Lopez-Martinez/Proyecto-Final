<?php
require_once('agencia.class.php');
class Contenidos extends Agencia
{
    public function read()
    {
        $linea = $this->db->prepare("select * from contenido;");
        $linea->execute();
        $contenidos = $linea->fetchAll(PDO::FETCH_ASSOC);
        return $contenidos;
    }
    public function readOne($id)
    {
        $linea = $this->db->prepare("SELECT * FROM contenido WHERE id_contenido=:id_contenido");
        $linea->bindParam(':id_contenido', $id, PDO::PARAM_INT);
        $linea->execute();
        $contenidos = $linea->fetchAll(PDO::FETCH_ASSOC);
        return $contenidos;
    }
    public function delete($id)
    {
        $borrar = $this->db->prepare("DELETE from contenido WHERE id_contenido=:id_contenido");
        $borrar->bindParam(':id_contenido', $id, PDO::PARAM_INT);
        $borrar->execute();
        $cuenta = $borrar->rowCount();
        return $cuenta;
    }
    public function create($data)
    {
        $cuenta = null;
        $sql = "INSERT into contenido(contenido) VALUES(:contenido)";
        $insertar = $this->db->prepare($sql);
        $insertar->bindParam(':contenido', $data['contenido'], PDO::PARAM_STR);
        $insertar->execute();
        $cuenta = $insertar->rowCount();
        return $cuenta;
    }
    public function update($id, $data)
    {
        $sql = "UPDATE contenido SET contenido=:contenido WHERE id_contenido=:id_contenido";
        $actualizar = $this->db->prepare($sql);
        $actualizar->bindParam(':contenido', $data['contenido'], PDO::PARAM_STR);
        $actualizar->bindParam(':id_contenido', $id, PDO::PARAM_INT);
        $actualizar->execute();
        $cuenta = $actualizar->rowCount();
        return $cuenta;
    }
}
$Contenidos = new Contenidos;
$Contenidos->conexion();
