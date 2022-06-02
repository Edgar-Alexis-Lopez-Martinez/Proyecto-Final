<?php
if ($accion == "create") : ?>
    <h1 class="text-center">Nuevo Rol</h1>
<?php else : $accion = "update" ?>
    <h1 class="text-center">Modificar Rol</h1>
<?php endif ?>
<form method="POST" enctype="multipart/form-data" action="rol.php?accion=<?php echo $accion; ?><?php if ($accion == "update") echo "&id=" . $id; ?>">
    <label class=" form-label">Rol: </label>
    <input class="form-control" type="text" value="<?php echo ($accion == "update") ? $data["rol"] : ""; ?>" name="data[rol]" />
    <h3>Permisos: </h3>
    <div class="form-check">
        <?php foreach ($permisos as $permiso) : ?>
            <input <?php if (isset($misPermisos)) {
                        if (in_array($permiso['id_permiso'], $misPermisos)) {
                            echo " checked ";
                        }
                    } ?> class="form-check-input" type="checkbox" name="permiso[<?php echo $permiso['id_permiso']; ?>]" /> <label class="form-check-label" for="flexCheckChecked"><?php echo $permiso['permiso']; ?></label>
    </div>
<?php endforeach; ?>
<br />
<input class="btn btn-primary" type="submit" value="Guardar Rol" name="data[enviar]" />
</form>