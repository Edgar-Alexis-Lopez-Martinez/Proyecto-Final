<?php
require_once('agencia.class.php');
class Pases extends Agencia
{
    public function read()
    {
        $linea = $this->db->prepare("select id_pase, pase, precio, fecha_inicio, fecha_termino, descripcion, id_ciudad , ciudad from pase LEFT JOIN ciudad c USING (id_ciudad) ORDER by pase;");
        $linea->execute();
        $pases = $linea->fetchAll(PDO::FETCH_ASSOC);
        return $pases;
    }
    public function readOne($id)
    {
        $linea = $this->db->prepare("SELECT * FROM pase WHERE id_pase=:id_pase");
        $linea->bindParam(':id_pase', $id, PDO::PARAM_INT);
        $linea->execute();
        $pases = $linea->fetchAll(PDO::FETCH_ASSOC);
        return $pases;
    }
    public function delete($id)
    {
        try {
            $this->db->beginTransaction();
            $sql = "DELETE FROM pase_contenido WHERE id_pase=:id_pase;";
            $borrar = $this->db->prepare($sql);
            $borrar->bindParam(':id_pase', $id, PDO::PARAM_INT);
            $borrar->execute();
            $cuenta = $borrar->rowCount();
            $borrar = $this->db->prepare("DELETE from pase WHERE id_pase=:id_pase");
            $borrar->bindParam(':id_pase', $id, PDO::PARAM_INT);
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
            $sql = "INSERT into pase(pase, precio, descripcion, id_ciudad, fecha_inicio, fecha_termino) VALUES(:pase,:precio,:descripcion,:id_ciudad,:fecha_inicio,:fecha_termino)";
            $insertar = $this->db->prepare($sql);
            $insertar->bindParam(':pase', $data['pase'], PDO::PARAM_STR);
            $insertar->bindParam(':precio', $data['precio'], PDO::PARAM_INT);
            $insertar->bindParam(':descripcion', $data['descripcion'], PDO::PARAM_STR);
            $insertar->bindParam(':id_ciudad', $data['id_ciudad'], PDO::PARAM_INT);
            $insertar->bindParam(':fecha_inicio', $data['fecha_inicio'], PDO::PARAM_STR);
            $insertar->bindParam(':fecha_termino', $data['fecha_termino'], PDO::PARAM_STR);
            $insertar->execute();
            $cuenta = $insertar->rowCount();
            $sql = "SELECT id_pase FROM pase ORDER BY id_pase DESC LIMIT 1;";
            $buscar = $this->db->prepare($sql);
            $buscar->execute();
            $pase = $buscar->fetchAll(PDO::FETCH_ASSOC);
            if (isset($pase[0]['id_pase'])) {
                $id_pase = $pase[0]['id_pase'];
                $susContenidos = isset($_POST['contenido']) ? $_POST['contenido'] : array();
                $sql = "INSERT INTO pase_contenido(id_pase,id_contenido) VALUES(:id_pase,:id_contenido)";
                $insertar = $this->db->prepare($sql);
                foreach ($susContenidos as $key => $contenido) {
                    $insertar->bindParam(':id_pase', $id_pase, PDO::PARAM_INT);
                    $insertar->bindParam(':id_contenido', $key, PDO::PARAM_INT);
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
            $sql = "UPDATE pase SET pase=:pase, precio=:precio, descripcion=:descripcion id_ciudad=:id_ciudad, fecha_inicio=:fecha_inicio, fecha_termino=:fecha_termino, WHERE id_pase=:id_pase";
            $actualizar = $this->db->prepare($sql);
            $actualizar->bindParam(':pase', $data['pase'], PDO::PARAM_STR);
            $actualizar->bindParam(':precio', $data['precio'], PDO::PARAM_INT);
            $actualizar->bindParam(':descripcion', $data['descripcion'], PDO::PARAM_STR);
            $actualizar->bindParam(':id_ciudad', $data['id_ciudad'], PDO::PARAM_INT);
            $actualizar->bindParam(':fecha_inicio', $data['fecha_inicio'], PDO::PARAM_STR);
            $actualizar->bindParam(':fecha_termino', $data['fecha_termino'], PDO::PARAM_STR);
            $actualizar->bindParam(':id_pase', $id, PDO::PARAM_INT);
            $actualizar->execute();
            if (isset($id)) {
                $id_pase = $id;
                $susContenidos = isset($_POST['contenido']) ? $_POST['contenido'] : array();
                $borrado = $this->delete_pase_contenido($id_pase);
                $sql = "INSERT INTO pase_contenido(id_pase,id_contenido) VALUES(:id_pase,:id_contenido)";
                $insertar = $this->db->prepare($sql);
                foreach ($susContenidos as $key => $contenido) {
                    $insertar->bindParam(':id_pase', $id_pase, PDO::PARAM_INT);
                    $insertar->bindParam(':id_contenido', $key, PDO::PARAM_INT);
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
    public function read_pase_contenido($id_pase)
    {
        $linea = $this->db->prepare("SELECT * from pase_contenido where id_pase = :id_pase;");
        $linea->bindParam(':id_pase', $id_pase, PDO::PARAM_INT);
        $linea->execute();
        $pases_contenidos = $linea->fetchAll(PDO::FETCH_ASSOC);
        $contenidos = array();
        foreach ($pases_contenidos as $pase_contenido) {
            array_push($contenidos, $pase_contenido['id_contenido']);
        }
        return $contenidos;
    }
    public function delete_pase_contenido($id_pase)
    {
        $borrar = $this->db->prepare("DELETE from pase_contenido WHERE id_pase=:id_pase");
        $borrar->bindParam(':id_pase', $id_pase, PDO::PARAM_INT);
        $borrar->execute();
        $cuenta = $borrar->rowCount();
        return $cuenta;
    }
}
$Pases = new Pases;
$Pases->conexion();
