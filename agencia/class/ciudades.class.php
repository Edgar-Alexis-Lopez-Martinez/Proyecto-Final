<?php
require_once('agencia.class.php');
class Ciudades extends Agencia
{
    public function read()
    {
        $linea = $this->db->prepare("select id_ciudad, ciudad, id_estado , estado, c.foto from ciudad c LEFT JOIN estado e USING (id_estado) ORDER by ciudad;");
        $linea->execute();
        $ciudades = $linea->fetchAll(PDO::FETCH_ASSOC);
        return $ciudades;
    }
    public function readOne($id)
    {
        $linea = $this->db->prepare("SELECT * FROM ciudad WHERE id_ciudad=:id_ciudad");
        $linea->bindParam(':id_ciudad', $id, PDO::PARAM_INT);
        $linea->execute();
        $ciudades = $linea->fetchAll(PDO::FETCH_ASSOC);
        return $ciudades;
    }
    public function readCiudad_Pase($id)
    {
        $linea = $this->db->prepare("select pase,precio,fecha_inicio,fecha_termino,descripcion,ciudad,contenido from contenido join pase_contenido on contenido.id_contenido=pase_contenido.id_contenido join pase on pase_contenido.id_pase=pase.id_pase join ciudad on pase.id_ciudad=ciudad.id_ciudad WHERE ciudad.id_ciudad = :id_ciudad GROUP BY pase, precio, fecha_inicio, fecha_termino, descripcion, ciudad, contenido ORDER By pase;");
        $linea->bindParam(':id_ciudad', $id, PDO::PARAM_INT);
        $linea->execute();
        $ciudades = $linea->fetchAll(PDO::FETCH_ASSOC);
        return $ciudades;
    }
    public function delete($id)
    {
        $borrar = $this->db->prepare("DELETE from ciudad WHERE id_ciudad=:id_ciudad");
        $borrar->bindParam(':id_ciudad', $id, PDO::PARAM_INT);
        $borrar->execute();
        $cuenta = $borrar->rowCount();
        return $cuenta;
    }
    public function create($data)
    {
        $cuenta = null;
        $foto = $this->cargarImagen("ciudades");
        if ($foto) {
            $sql = "INSERT into ciudad(ciudad,foto, id_estado) VALUES(:ciudad,:foto,:id_estado)";
            $insertar = $this->db->prepare($sql);
            $insertar->bindParam(':ciudad', $data['ciudad'], PDO::PARAM_STR);
            $insertar->bindParam(':foto', $foto, PDO::PARAM_STR);
            $insertar->bindParam(':id_estado', $data['id_estado'], PDO::PARAM_INT);
            $insertar->execute();
            $cuenta = $insertar->rowCount();
        }
        return $cuenta;
    }
    public function update($id, $data)
    {
        $foto = $this->cargarImagen(("ciudades"));
        if ($foto) {
            $sql = "UPDATE ciudad SET ciudad=:ciudad, foto=:foto, id_estado=:id_estado WHERE id_ciudad=:id_ciudad";
            $actualizar = $this->db->prepare($sql);
        } else {
            $sql = "UPDATE ciudad SET ciudad=:ciudad, id_estado=:id_estado WHERE id_ciudad=:id_ciudad";
        }
        $actualizar = $this->db->prepare($sql);
        $actualizar->bindParam(':ciudad', $data['ciudad'], PDO::PARAM_STR);
        $actualizar->bindParam(':id_estado', $data['id_estado'], PDO::PARAM_INT);

        $actualizar->bindParam(':id_ciudad', $id, PDO::PARAM_INT);
        if ($foto) {
            $actualizar->bindParam(':foto', $foto, PDO::PARAM_STR);
        }
        $actualizar->execute();
        $cuenta = $actualizar->rowCount();
        return $cuenta;
    }
}
$Ciudades = new Ciudades;
$Ciudades->conexion();
