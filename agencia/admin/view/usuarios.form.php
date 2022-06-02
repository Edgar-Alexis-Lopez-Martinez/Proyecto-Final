<?php
if ($accion == "create") : ?>
    <h1 class="text-center">Nuevo Usuario</h1>
<?php else : $accion = "update" ?>
    <h1 class="text-center">Modificar Usuario</h1>
<?php endif ?>
<form method="POST" enctype="multipart/form-data" action="usuario.php?accion=<?php echo $accion; ?><?php if ($accion == "update") echo "&id=" . $id; ?>">
    <label class=" form-label">Corre Electronico: </label>
    <input type="email" class="form-control" value="<?php echo ($accion == "update") ? $data["correo"] : ""; ?>" name="data[correo]" />
    <label class=" form-label">Contraseña: </label>
    <input type="password" class="form-control" value="<?php echo ($accion == "update") ? $data["contrasena"] : ""; ?>" name="data[contrasena]" />
    <h3>Roles: </h3>
    <div class="form-check">
        <?php foreach ($roles as $rol) : ?>
            <input <?php if (isset($misRoles)) {
                        if (in_array($rol['id_rol'], $misRoles)) {
                            echo " checked ";
                        }
                    } ?> class="form-check-input" type="checkbox" name="rol[<?php echo $rol['id_rol']; ?>]" /> <label class="form-check-label" for="flexCheckChecked"><?php echo $rol['rol']; ?></label>
    </div>
<?php endforeach; ?>
<br />
<input class="btn btn-primary" type="submit" value="Guardar Rol" name="data[enviar]" />
</form>