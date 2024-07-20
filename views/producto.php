
    <div class="container container-producto">

        <a href="<?=base_url?>?controller=Inventario&action=inventario"><img src="<?=base_url?>assets/back.svg" alt="Volver" /></a>

        <?php if($selects->num_rows > 0) : ?>

            <?php while($torre = $selects->fetch_assoc()) : ?>

                <?php if($torre['procesador'] == '') : ?>
                    
                    <table>
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Alta</th>
                                <th>Descripcion</th>
                                <th>Último comentario</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?=$torre['id_prod']?></td>
                                <td><?=$torre['marca']?></td>
                                <td><?=$torre['modelo']?></td>
                                <td><?=$torre['alta']?></td>
                                <td><?=$torre['descripcion']?></td>
                                <td>"<?=$torre['ultimo_comentario']?>"</td>
                                <td>
                                    <a href="../lib/eliminar_sql.php?id=<?=$torre['id'];?>"><img src="<?=base_url?>assets/trash.svg" alt="Eliminar" /></a>
                                    <a href="comentarios.php?id=<?=$torre['id']?>"><img src="<?=base_url?>assets/comments.svg" alt="Modificar" /></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                <?php else : ?>

                    <table>
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Procesador</th>
                                <th>Ram</th>
                                <th>Memoria</th>
                                <th>Alta</th>
                                <th>Descripción</th>
                                <th>Último comentario</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?=$torre['id_prod']?></td>
                                <td><?=$torre['marca']?></td>
                                <td><?=$torre['modelo']?></td>
                                <td><?=$torre['procesador']?></td>
                                <td><?=$torre['ram']?></td>
                                <td><?=$torre['almacenamiento']?></td>
                                <td><?=$torre['alta']?></td>
                                <td><?=$torre['descripcion']?></td>
                                <td>"<?=$torre['ultimo_comentario']?>"</td>
                                <td>
                                    <a href="../lib/eliminar_sql.php?id=<?=$torre['id']?>"><img src="<?=base_url?>assets/trash.svg" alt="Eliminar" /></a>
                                    <a href="<?=base_url?>?controller=Inventario&action=modificar&id_prod=<?=$torre['id_prod']?>"><img src="<?=base_url?>assets/edit.svg" alt="Editar" /></a>
                                    <a href="comentarios.php?id=<?=$torre['id']?>"><img src="<?=base_url?>assets/comments.svg" alt="Modificar" /></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                <?php endif;?>

            <?php endwhile;?>

        <?php else :?>

            <?php echo "<h1>No hay productos para mostrar</h1>";?>

        <?php endif; ?>
        
    </div>