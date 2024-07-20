<?php
require_once 'config/parameters.php';
?>


    <div class="container container-login">
        <h1>Inventario - <span class="title">Skytel</span> Avanza <span class="title">Uruguay</span></h1>

        <?php if (isset($_SESSION['errores_log']['login'])): ?>
            <p class="error"><?= $_SESSION['errores_log']['login'] ?></p>
        <?php endif; ?>

        <form id="form-login" action="<?= base_url ?>?controller=Login&action=login" method="POST">
            <label for="email">Usuario</label>
            <input type="email" name="email" id="email" required/>

            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password" required/>

            <input type="submit" value="Ingresar" />
        </form>
    </div>




