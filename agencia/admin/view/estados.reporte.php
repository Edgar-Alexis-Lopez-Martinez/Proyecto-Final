<img src="../images/logo_tec.jpg" alt="logo" style="width: 100%" />
<h1 style="color: red">Estados</h1>
<br />
<table>
    <thead>
        <tr>
            <th>Num</th>
            <th>Nombre Estado</th>
            <th>Descripción</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $cont = 1;
        foreach ($estados as $estado) :
        ?>
            <tr>
                <th><?php echo $cont; ?></th>
                <td><?php echo $estado["estado"]; ?></td>
                <td><?php echo substr($estado["descripcion"], 0, 50) . "..."; ?></td>
            </tr>
        <?php $cont++;
        endforeach;  ?>
    </tbody>
</table>