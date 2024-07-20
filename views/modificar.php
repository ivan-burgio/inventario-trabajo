
    <a href="inventario.php"><img src="<?=base_url?>assets/back.svg" alt="Volver" /></a>

    <div class="container container-regYMod">

        <?php while($product = $modify->fetch_assoc()): ?>
            
            <form id="form" action="<?=base_url?>?controller=Inventario&action=modificarProducto" method="POST">

                <h2>Modificar productos</h2>

                <label for="id">ID</label>
                <input type="text" name="id" value="<?=$product['id_prod'];?>">

                <label for="marca">Marca</label>
                <input type="text" name="marca" value="<?=$product['marca'];?>">

                <label for="modelo">Modelo</label>
                <input type="text" name="modelo" value="<?=$product['modelo'];?>">

                <label for="description">Comentario</label>
                <textarea name="descripcion"><?=$product['descripcion'];?></textarea>

                <label for="proce">Procesador</label>
                <input type="text" name="proce" value="<?=$product['procesador'];?>">
                
                <label for="ram">Ram</label>
                <input type="text" name="ram" value="<?=$product['ram'];?>">

                <label for="almace">Almacenamiento</label>
                <input type="text" name="almace" value="<?=$product['almacenamiento'];?>">
                
                <input id="submit" type="submit" value="Modificar">

            </form>

        <?php endwhile; ?>

    </div>
