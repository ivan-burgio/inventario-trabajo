
    <div class="search">
        <input type="text" id="search" name="search" placeholder="Buscador de productos...">
    </div>

    <div class="container">

        <?php if($productos->num_rows == 0) : ?>

            <h2> No hay productos guardados en el inventario</h2>
            
        <?php else : ?>

            <?php while($producto = $productos->fetch_assoc()) : ?>

                <table id="table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Lugar de uso</th>
                            <th>Funcionario</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?=$producto['id_prod']?></td>
                            <td><?=$producto['marca']?></td>
                            <td><?=$producto['modelo']?></td>
                            <?php if(empty($producto['lugar_trabajo'] && $producto['nombre_func'])) :?>
                                <td>Disponible</td>
                                <td>Sin asignar</td>
                            <?php else : ?>
                                <td><?=$producto['lugar_trabajo']?></td>
                                <td><a href="historico.php?id=<?=$producto['id_funcionario']?>"><?=$producto['nombre_func']?></a></td>
                            <?php endif;?>
                            <td>
                                <a href="<?=base_url?>?controller=Inventario&action=producto&modelo=<?=$producto['id_prod']?>"><img src="<?=base_url?>assets/eye.svg" alt="Ver"/></a> 
                            </td>
                        </tr>
                    </tbody>
                </table>

            <?php endwhile;?>
            
        <?php endif; ?>

    </div>
    <script src="js/inventario.js"></script>
