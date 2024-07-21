<?php 
require_once 'includes/helpers.php';

?>

    <div class="container container-regYMod">

        <form id="form" action="<?=base_url?>?controller=AltasBajas&action=save" method="POST">

            <h2>Alta de productos para funcionarios</h2>

            <?=mostrarExito('estado', 'exito');?>
            <label for="ubic" id="ubic_label">Lugar de trabajo</label>
            <select id="ubic" name="ubic">

                <option value="default">--Seleccione la ubicación--</option>
                <option value="home">Tele trabajo</option>
                <option value="plataforma">Plataforma</option>

            </select>

            <label for="input_prod" id="label_prod">Equipos</label>
            <?=mostrarErrores('producto', 'error');?>
            <input type="text" id="input_prod" name="input_prod"  placeholder="Ingrese el equipo (Ej. Etiqueta, marca, modelo)"/>

            <div id="select_prod" name="select_prod">

                <?php if($products->num_rows > 0) : ?>

                    <?php while($product = $products->fetch_assoc()) : ?>
                        <table id="table_prod">
                            <thead>
                                <tr>
                                    <th>ID:</th>
                                    <th>Modelo:</th>
                                    <th>Marca:</th>
                                </tr>
                            </thead>

                                <tbody>
                                    <tr>
                                        <td><?=$product['id_prod'];?></td>
                                        <td><?=$product['modelo'];?></td>
                                        <td><?=$product['marca'];?></td>
                                        <td><input class="check" type="checkbox" name="check[]" value="<?=$product['id'];?>" /></td>
                                    </tr>
                                </tbody>
                        </table>
                    <?php endwhile; ?>

                <?php endif; ?>
            </div>

            <label for="input_func">Funcionario</label>
            <input type="text" id="input_func" name="input_func" placeholder="Ingrese al funcionario (Ej. N° Funcionario, nombre, sector)"/>

            <select id="select_func" name="select_func">

                <?php if($funcs->num_rows > 0) : ?>

                    <?php while($func = $funcs->fetch_assoc()) : ?>

                        <option value="<?=$func['id_funcionario'];?>">N°<?=$func['id_funcionario'].', '.$func['nombre'].' '.$func['apellido'].', '.$func['nombre_sector'];?></option>

                    <?php endwhile; ?>

                <?php else : ?>
                        
                        <option value="null">No hay funcionarios con los datos ingresados</option>
                
                <?php endif; ?>
            </select>
        
            <?=mostrarErrores('errores', 'sector');?>
            <?php if($sectores->num_rows > 0) :?>
                <select id="select_sect" name="sect">
                    <?php while($sector = $sectores->fetch_assoc()) : ?>
                            <option value="<?=$sector['nombre']?>"><?=$sector['nombre']?></option>
                    <?php endwhile;?>
                </select>

            <?php endif;?>

            <?=mostrarErrores('errores', 'comentario');?>
            <label id="label_area" for="description">Comentarios</label>
            <textarea id="text_area" name="description" placeholder="Comentario sobre el alta del producto..."></textarea>

            <input id="submit" type="submit" value="Registrar" />
        </form>
    </div>
    <script src="js/alta_func.js"></script>
