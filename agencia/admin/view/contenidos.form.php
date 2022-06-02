<?php
if ($accion == "create") : ?>
    <h1 class="text-center">Nuevo Contenido</h1>
<?php else : $accion = "update" ?>
    <h1 class="text-center">Modificar Contenido</h1>
<?php endif ?>
<form method="POST" enctype="multipart/form-data" action="contenido.php?accion=<?php echo $accion; ?><?php if ($accion == "update") echo "&id=" . $id; ?>">
    <label class=" form-label">Nombre Del Contenido: </label>
    <input class="form-control" type="text" value="<?php echo ($accion == "update") ? $data["contenido"] : ""; ?>" name="data[contenido]" />
    <input class="btn btn-primary" type="submit" value="Guardar Contenido" name="data[enviar]" />
</form>