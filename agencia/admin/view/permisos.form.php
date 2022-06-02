<?php
if ($accion == "create") : ?>
    <h1 class="text-center">Nuevo Permiso</h1>
<?php else : $accion = "update" ?>
    <h1 class="text-center">Modificar Permiso</h1>
<?php endif ?>
<form method="POST" enctype="multipart/form-data" action="permiso.php?accion=<?php echo $accion; ?><?php if ($accion == "update") echo "&id=" . $id; ?>">
    <label class=" form-label">Permiso: </label>
    <input class="form-control" type="text" value="<?php echo ($accion == "update") ? $data["permiso"] : ""; ?>" name="data[permiso]" />
    <input class="btn btn-primary" type="submit" value="Guardar Permiso" name="data[enviar]" />
</form>