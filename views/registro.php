<?php 

require_once 'includes/helpers.php';


?>

    <div class="container container-regYMod">
        
        <form id="form" action="<?=base_url?>?controller=Registro&action=save" method="POST">

            <h2>Registros de productos</h2>
            
            <?=mostrarExito('estado', 'exito_perife')?>
            <?=mostrarExito('estado', 'exito_torre')?>
            <?=mostrarErrores('estado', 'id'); ?>
            <label for="id">ID</label>
            <input type="text" id="id" name="id" placeholder="Ingrese la etiqueta del equipo"/>

            <?=mostrarErrores('estado', 'marca'); ?>
            <label for="marca">Marca</label>
            <input type="text" id="marca" name="marca"  placeholder="Ingrese la marca del equipo"/>

            <?=mostrarErrores('estado', 'modelo'); ?>
            <label for="modelo">Modelo</label>
            <input type="text" id="modelo" name="modelo" placeholder="Ingrese el modelo del equipo"/>

            <?=mostrarErrores('estado', 'select'); ?>
            <label for="select">Equipo</label>
            <select id="select" name="select">

                <option value="seleccione" selected>--seleccione una opción--</option>
                <option value="torre">Torre</option>
                <option value="perife">Periferico</option>

            </select>

            <label for="tipo">Tipo</label>
            <?php if($types->num_rows > 0) : ?>
                <select name="tipo">
                    <?php while($result_tipos =  $types->fetch_assoc()) : ?>
                        <option value="<?=$result_tipos['id'];?>"><?=$result_tipos['nombre'];?></option>
                    <?php endwhile;?>
                </select>
            <?php endif;?>

            <?=mostrarErrores('estado', 'descripcion'); ?>
            <label for="description">Descripcion y comentario inicial</label>
            <textarea name="description" placeholder="Descripción general del equipo..."></textarea>

            <input id="submit" type="submit" value="Registrar" />
        </form>
    </div>
    <script src="../js/registro.js"></script>
