<?php
if ($accion == "create") : ?>
    <h1 class="text-center">Nuevo Pase</h1>
<?php else : $accion = "update" ?>
    <h1 class="text-center">Modificar Pase</h1>
<?php endif ?>
<form method="POST" enctype="multipart/form-data" action="pase.php?accion=<?php echo $accion; ?><?php if ($accion == "update") echo "&id=" . $id; ?>">
    <label class=" form-label">Nombre Del Pase: </label>
    <input class="form-control" type="text" value="<?php echo ($accion == "update") ? $data["pase"] : ""; ?>" name="data[pase]" />
    <label class="form-label">Precio: </label>
    <input class="form-control" type="number" name="data[precio]" />
    <label class="form-label">Fecha De Inicio: </label>
    <input class="form-control" type="date" name="data[fecha_inicio]" pattern="\d{4}-\d{1,2}-\d{1,2}" />
    <label class="form-label">Fecha De Termino: </label>
    <input class="form-control" type="date" name="data[fecha_termino]" pattern="\d{4}-\d{1,2}-\d{1,2}" />
    <label class="form-label">Descripcion: </label>
    <textarea class="form-control" name="data[descripcion]"><?php echo ($accion == "update") ? $data["descripcion"] : ""; ?></textarea>
    <label class="form-label">Ciudad: </label>
    <select name="data[id_ciudad]" id="" class="form-control">
        <?php
        foreach ($ciudades as $ciudad) :
        ?>
            <option <?php if (isset($data["id_ciudad"])) {
                        if ($data["id_ciudad"] == $ciudad["id_ciudad"]) echo "selected";
                    } ?> value="<?php echo $ciudad["id_ciudad"]; ?>"> <?php echo $ciudad["ciudad"]; ?></option>
        <?php endforeach; ?>
    </select><br />
    <h3>Escoge El Contenido Del Pase</h3>
    <div class="form-check">
        <?php foreach ($contenidos as $contenido) : ?>
            <input <?php if (isset($misContenidos)) {
                        if (in_array($contenido['id_contenido'], $misContenidos)) {
                            echo " checked ";
                        }
                    } ?> class="form-check-input" type="checkbox" name="contenido[<?php echo $contenido['id_contenido']; ?>]" /> <label class="form-check-label" for="flexCheckChecked"><?php echo $contenido['contenido']; ?></label>
    </div>
<?php endforeach; ?>
<br />
<input class="btn btn-primary" type="submit" value="Guardar Pase" name="data[enviar]" />
</form>