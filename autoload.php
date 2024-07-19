<?php

function autocargar($classname) {

    include 'controllers/'. $classname . '.php';
};

sql_autoload_register('autocargar');

?>