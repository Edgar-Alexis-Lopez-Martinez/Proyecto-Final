<?php if ($accion == "create") : ?>
    <h1 class="text-center">Nueva Ciudad</h1>
<?php else : $accion = "update" ?>
    <h1 class="text-center">Modificar Ciudad</h1>
    <div class="row text-center">
        <div class="col">
            <img class="rounded-circle" src="../<?php echo $data["foto"]; ?>">
        </div>
    </div>
<?php endif ?>
<form method="POST" enctype="multipart/form-data" action="ciudad.php?accion=<?php echo $accion; ?><?php if ($accion == "update") echo "&id=" . $id; ?>">
    <label class=" form-label">Nombre De La Ciudad: </label>
    <input class="form-control" type="text" value="<?php echo ($accion == "update") ? $data["ciudad"] : ""; ?>" name="data[ciudad]" />
    <label class="form-label">Estado: </label>
    <select name="data[id_estado]" id="" class="form-control">
        <?php
        foreach ($estados as $estado) :
        ?>
            <option <?php if (isset($data["id_estado"])) {
                        if ($data["id_estado"] == $estado["id_estado"]) echo "selected";
                    } ?> value="<?php echo $estado["id_estado"]; ?>"> <?php echo $estado["estado"]; ?></option>
        <?php endforeach; ?>
    </select><br />
    <label class="form-label">Foto: </label>
    <input class="form-control" type="file" value="<?php echo ($accion == "update") ? $data["foto"] : ""; ?>" name="foto" />
    <input class="btn btn-primary" type="submit" value="Guardar Ciudad" name="data[enviar]" />
</form>