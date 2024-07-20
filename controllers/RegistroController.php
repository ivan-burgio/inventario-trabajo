<?php
require_once 'models/RegistroModels.php';


class RegistroController {
    
    public function registro() {

        if(!isset($_SESSION['user'])) {

            header('Location: ../index.php');
            exit();
        };

        $registro_prod = new RegistroModels();
        $types = $registro_prod->showTypes();
        
        require_once 'views/registro.php';
    }

    public function save() {

        //Validar e ingresar los datos de los productos que se ingresan a la tabla productos.
        if($_POST) {

            unset($_SESSION['estado']);

            $registro = new RegistroModels();

            $id_prod = isset($_POST['id']) ? $_POST['id'] : false;                               //Se valida la existencia de datos enviados por POST
            $marca = isset($_POST['marca']) ? $_POST['marca'] : false;                      //Se valida la existencia de datos enviados por POST
            $modelo = isset($_POST['modelo']) ? $_POST['modelo'] : false;                   //Se valida la existencia de datos enviados por POST
            $procesador = isset($_POST['proce']) ? $_POST['proce'] : false;                 //Se valida la existencia de datos enviados por POST
            $ram = isset($_POST['ram']) ? $_POST['ram'] : false;                            //Se valida la existencia de datos enviados por POST
            $almacenamiento = isset($_POST['almace']) ? $_POST['almace'] : false;           //Se valida la existencia de datos enviados por POST
            $descripcion = isset($_POST['description']) ? $_POST['description'] : false;    //Se valida la existencia de datos enviados por POST
            $user = $_SESSION['user']->nombre.' '.$_SESSION['user']->apellido;

            $estado = array();     //Se crea array de estado

            validarCampos($id_prod, $marca, $modelo, $procesador, $ram, $almacenamiento, $descripcion, $user, $estado, $registro);
            
            $registro->closeConnection();
            header('Location:'.base_url. 'views/registro.php');
        };
    }
}


//----------------------------------------FUNCIONES----------------------------------------

function ValidarCampos($id_prod, $marca, $modelo, $procesador, $ram, $almacenamiento, $descripcion, $user, $estado, $registro) {

    if(empty($id_prod)) {

        $estado['id_prod'] = "Ingrese un id para el producto";
    }

    if(empty($marca)) {

        $estado['marca'] = "Ingrese la marca del producto";
    }

    if(empty($descripcion)) {

        $estado['descripcion'] = "Ingrese una descripcion del producto";
    }

    if(count($estado) == 0) {

        $registro->setId_Prod($id_prod);
        $registro->setMarca($marca);
        $registro->setModelo($modelo);
        $registro->setProcesador($procesador);
        $registro->setRam($ram);
        $registro->setAlmacenamiento($almacenamiento);
        $registro->setDescripcion($descripcion);
        $registro->setUsuario($user);

        validarTipoProducto($id_prod, $marca, $modelo, $procesador, $ram, $almacenamiento, $descripcion, $user, $estado, $registro);

    }
}


function validarTipoProducto($id_prod, $marca, $modelo, $procesador, $ram, $almacenamiento, $descripcion, $user, $estado, $registro) {

    //Se valida el tipo de valor del select
    if($_POST['select'] && $_POST['select'] == 'torre') { //En caso de que sea 'torre' se validan los otros campos

        countErrorTorre($estado, $id_prod, $marca, $modelo, $procesador, $ram, $almacenamiento, $descripcion, $user, $registro);

    //Se valida el tipo de valor del select
    } elseif($_POST['select'] && $_POST['select'] == 'perife') { //En caso de que sea 'perife' se realiza la validación del array de estado

        countErrorPerife($estado, $id_prod, $marca, $modelo, $descripcion, $user, $registro);

    } else {

        //Si no se selecciona alguno de los dos valores anteriormente mencionados, se guarda en el array de $estado
        $estado['select'] = "Seleccione una opcion";
        $_SESSION['estado'] = $estado;
    }
    
}

function countErrorTorre($estado, $id_prod, $marca, $modelo, $procesador, $ram, $almacenamiento, $descripcion, $user, $registro) {

    if(count($estado) == 0) { //Si el array de estado está vacio, entonces se realiza la inserción a la BD

        ingresarProducTorre($id_prod, $marca, $modelo, $procesador, $ram, $almacenamiento, $descripcion, $user, $registro);
        $estado['exito_torre'] = "Se registró el periferico con éxito";
        $_SESSION['estado'] = $estado;

    } else {

        $_SESSION['estado'] = $estado;
    };

}

function countErrorPerife($estado, $id_prod, $marca, $modelo, $descripcion, $user, $registro) {

    if(count($estado) == 0) { //Si el array de estado está vacio, entonces se realiza la inserción a la BD

        ingresarProducPerife($id_prod, $marca, $modelo, $descripcion, $user, $registro);
        $estado['exito_perife'] = "Se registró el periferico con éxito";
        $_SESSION['estado'] = $estado;

    } else {
        
        //En caso de que hayan estado, se guarda en una session el array asociativo.
        $_SESSION['estado'] = $estado;
    };
}

function ingresarProducTorre($id_prod, $marca, $modelo, $procesador, $ram, $almacenamiento, $descripcion, $user, $registro) {

    //Se genera la consulta para la BD
    $registro->registroTorre($id_prod, $marca, $modelo, $procesador, $ram, $almacenamiento, $descripcion, $user);


}

function ingresarProducPerife($id_prod, $marca, $modelo, $descripcion, $user, $registro) {

    //Se genera la consulta para la BD
    $registro->registroPerife($id_prod, $marca, $modelo, $descripcion, $user);
}

?>