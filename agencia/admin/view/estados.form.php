<?php if ($accion == "create") : ?>
    <h1 class="text-center">Nuevo Estado</h1>
<?php else : $accion = "update" ?>
    <h1 class="text-center">Modificar Estado</h1>
    <div class="row text-center">
        <div class="col">
            <img class="rounded-circle" src="../<?php echo $data["foto"]; ?>">
        </div>
    </div>
<?php endif ?>
<form method="POST" enctype="multipart/form-data" action="estado.php?accion=<?php echo $accion; ?><?php if ($accion == "update") echo "&id=" . $id; ?>">
    <label class=" form-label">Nombre Del Estado: </label>
    <input class="form-control" type="text" value="<?php echo ($accion == "update") ? $data["estado"] : ""; ?>" name="data[estado]" />
    <label class="form-label">Descripcion: </label>
    <textarea class="form-control" name="data[descripcion]"><?php echo ($accion == "update") ? $data["descripcion"] : ""; ?></textarea>
    <label class="form-label">Foto: </label>
    <input class="form-control" type="file" value="<?php echo ($accion == "update") ? $data["foto"] : ""; ?>" name="foto" /><br />
    <input class="btn btn-primary" type="submit" value="Guardar Estado" name="data[enviar]" />
</form>