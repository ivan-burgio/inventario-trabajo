<?php

if(isset($_GET)) {

    $id_producto = isset($_GET['id']) ? $_GET['id']: false;
    $modi_select = "SELECT * FROM productos WHERE id = '$id_producto';";

}