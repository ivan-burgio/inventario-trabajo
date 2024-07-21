

    <div class="container container-bajas">

        <div class="func">
            <input type="text" id="id_func" name="id_func" placeholder="N° de funcionario o nombre..."/>

            <h3>Funcionarios con productos</h3>
            <?php if($funcAltas->num_rows > 0) : ?>
                <?php while($func = $funcAltas->fetch_assoc()) : ?>

                    <button class="btn_func" value="<?=$func['id_funcionario'];?>">
                        <table id="table_baja">
                            <thead>
                                <tr>
                                    <th>N°Funcionario</th>
                                    <th>Nombre</th>
                                    <th>Lugar de trabajo</th>
                                    <th>Puesto</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?=$func['id_funcionario']?></td>
                                    <td><?=$func['nombre_func']?></td>
                                    <td><?=$func['lugar_trabajo']?></td>
                                    <td><?=$func['puesto']?></td>
                                </tr>
                            </tbody>
                        </table>
                    </button>

                <?php endwhile; ?>

            <?php else : ?>

                <p>No hay funcionario con productos asignados</p>

            <?php endif; ?>
        </div>
        
        <form action="<?=base_url?>?controller=AltasBajas&action=bajasProdu" method="POST" class="product_func">

            <h3>Productos del funcionario seleccionado</h3>        

            <div class="table_prod_func">
                <?php while($product = $producAltas->fetch_assoc()) : ?>
                    <table id="table_prod" name="table_func" value="<?=$product['id_funcionario'];?>">
                        <thead>
                            <tr>
                                <th>ID_Func:</th>
                                <th>ID:</th>
                                <th>Modelo:</th>
                                <th>Marca:</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td><?=$product['id_funcionario'];?></td>
                                <td><?=$product['id_prod'];?></td>
                                <td><?=$product['modelo'];?></td>
                                <td><?=$product['marca'];?></td>
                                <td><input class="check" type="checkbox" name="check_baja[]" value="<?=$product['id_producto'];?>" /></td>
                            </tr>
                        </tbody>
                    </table>
                <?php endwhile; ?>

                <textarea name='description'></textarea>
                <input type="submit" id="input_baja" value="Dar de baja" />
            </div>
        </form>
    </div>
    <script src="js/bajas_func.js"></script>
