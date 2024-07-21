<?php

require_once 'models/AltasBajasModels.php';

class AltasBajasController {

    public function altas() {

        if(!isset($_SESSION['user'])) {

            header('Location:'.base_url.'?controller=Login&action=loginview');
            exit();
        };

        $altaModel = new AltasModels();

        $funcs = $altaModel->getFuncionario();
        $products = $altaModel->getProduct();
        $sectores = $altaModel->getSector();
        $altaModel->closeConnection();
        require_once 'views/altas.php';
    }

    public function bajas() {

        $altaModel = new AltasModels();

        if(!isset($_SESSION['user'])) {

            header('Location:'.base_url.'?controller=Login&action=loginview');
            exit();
        };

        $funcAltas = $altaModel->getAltasFunc();
        $producAltas = $altaModel->getAltasProduct();
        require_once 'views/bajas.php';
    }

    public function bajasProdu() {

        if($_POST) {

            $bajasProdu = new AltasModels();

            unset($_SESSION['errores']);
            unset($_SESSION['exitoBaja']);
        
            // Verificar y obtener datos del formulario
            if(isset($_POST['check_baja'])) {
        
                $check_prod = $_POST['check_baja'];
                $descripcion = isset($_POST['description']) ? $_POST['description'] : '';
                $user = $_SESSION['user']['nombre'] . ' ' . $_SESSION['user']['apellido'];
                $user_admin = $_SESSION['user']['id_admin'];
                
                $estado = validarCamposBaja($descripcion, $check_prod);
        
                if(count($estado) == 0) {
                     // Realizar la baja y actualizar el estado de los productos
                    foreach($check_prod as $equipo) {
        
                        if(!empty($equipo)) {

                            $bajasProdu->setEquipo($equipo);
                            $bajasProdu->setDescripcion($descripcion);
                            $bajasProdu->setUser($user);
                            $bajasProdu->setUserAdmin($user_admin);
        
                            // Insertar la baja en la tabla altas_productos
                            $bajasProdu->updateAltas();
        
                            // Guardar mensaje de éxito en sesión
                            $estado['exito'] = "Baja realizada con éxito";
                            $_SESSION['exitoBaja'] = $estado;
                        
                        } 
                    }
        
                } else {
        
                    $_SESSION['errores'] = $estado;
                }
        
                header('Location:'.base_url.'?controller=AltasBajas&action=bajas');
            }
        }
    }

    public function save() {

        $altaModel = new AltasModels();

        if($_POST) {

            unset($_SESSION['estado']);
            unset($_SESSION['errores']);
            unset($_SESSION['producto']);
        
            $checks = isset($_POST['check']) ? $_POST['check'] : false;
        
            if ($checks) {
        
                $funcionario = isset($_POST['select_func']) ? $_POST['select_func'] : false;
                $domicilio = isset($_POST['direc']) ? $_POST['direc'] : false;
                $sector = isset($_POST['sect']) ? $_POST['sect'] : false;
                $precinto = isset($_POST['precinto']) ? $_POST['precinto'] : false;
                $descripcion = isset($_POST['description']) ? $_POST['description'] : false;
        
                $estado = array();
        
                validarCampos($checks, $funcionario, $domicilio, $sector, $precinto, $descripcion, $estado);
                
                $altaModel->closeConnection();
                header('Location:'.base_url.'?controller=AltasBajas&action=altas');
        
            } else {
        
                $_SESSION['producto']['error'] = 'Seleccione por lo menos un producto';

                $altaModel->closeConnection();
                header('Location:'.base_url.'?controller=AltasBajas&action=altas');
            }
        
        }
    }
}




//----------------------------------------FUNCIONES----------------------------------------

function validarCamposBaja($descripcion, $check_prod) {

    $estado = [];

    if(empty($descripcion)) {
        
        $estado['comentario'] = "Ingrese el motivo de la baja"; 
        $_SESSION['errores'] = $estado;
    };

    if(count($check_prod) == 0 ) {

        $estado['producto'] = "Seleccione un producto para la baja";
        $_SESSION['errores'] = $estado;
    }

    return $estado;
}

// Funcion para validar los datos ingresados en los campos del form
function validarCampos($checks, $funcionario, $domicilio, $sector, $precinto, $descripcion, $estado) {

    if(empty($descripcion)) {

        $estado['comentario'] = "Ingrese un comentario para el alta";

    }

    if(empty($sector)) {

        $estado['sector'] = "Seleccione un sector";
    }

    countError($checks, $estado, $funcionario, $domicilio, $sector, $precinto, $descripcion);
}

// Funcion para contar los posibles errores en los campos del form
function countError($checks, $estado, $funcionario, $domicilio, $sector, $precinto, $descripcion) {

    if (count($estado) == 0) {

        createQuery($checks, $estado, $funcionario, $domicilio, $sector, $precinto, $descripcion);

    } else {

        $_SESSION['errores'] = $estado;
        header('Location:'.base_url.'?controller=Altas&action=altas');
        exit();
    }
}

// Funcion para crear las querys de los select y aplicar la condicional dependiendo si es teletrabajo o plataforma
function createQuery($checks, $estado, $funcionario, $domicilio, $sector, $precinto, $descripcion) {

    $altaModel = new AltasModels();

    $equipo_one = isset($checks[0]) ? $checks[0] : false;
    $equipo_two = isset($checks[1]) ? $checks[1] : false;
    $equipo_three = isset($checks[2]) ? $checks[2] : false;
    $equipo_four = isset($checks[3]) ? $checks[3] : false;
    $equipo_five = isset($checks[4]) ? $checks[4] : false;
    $equipo_six = isset($checks[0]) ? $checks[0] : false;
    $equipo_seven = isset($checks[1]) ? $checks[1] : false;
    $equipo_eight = isset($checks[2]) ? $checks[2] : false;
    $equipo_nine = isset($checks[3]) ? $checks[3] : false;
    $equipo_ten = isset($checks[4]) ? $checks[4] : false;

    $modelos = [];

    foreach ([$equipo_one, $equipo_two, $equipo_three, $equipo_four, $equipo_five, $equipo_six, $equipo_seven, $equipo_eight, $equipo_nine, $equipo_ten] as $equipo) {

        if ($equipo != null) {
            
            $producto = $altaModel->getModeloSelect($equipo);
            $product = $producto->fetch_assoc();
            $modelos[] = $product['modelo'];
            $types[] = $product['tipo_prod'];

        } else {

            $modelos[] = false;
            $type[] = false;
        }
    }

    $funcionario_name = $altaModel->getNombreFunc($funcionario);
    $nombre_func = $funcionario_name->fetch_assoc();
    $nombre = $nombre_func['nombre'] . ' ' . $nombre_func['apellido'];

    $user = $_SESSION['user']->nombre . ' ' . $_SESSION['user']->apellido;
    $user_id = $_SESSION['user']->id_admin;

    if ($_POST['ubic'] == 'home') {

        insertQueryHome($funcionario, $checks, $modelos, $types, $nombre, $domicilio, $precinto, $descripcion, $user, $user_id, $altaModel);

    } elseif ($_POST['ubic'] == 'plataforma') {
        
        $puesto = isset($_POST['box']) ? $_POST['box'] : false;
        insertQueryPlat($funcionario, $checks, $modelos, $types, $nombre, $sector, $puesto, $descripcion, $user, $user_id, $altaModel);
    }
}

// Funcion para gestionar el alta para teletrabajo
function insertQueryHome($funcionario, $checks, $modelos, $types, $nombre, $domicilio, $precinto, $descripcion, $user, $user_id, $altaModel) {
    
    $fecha_actual = date('Y-m-d H:i:s');

    foreach ($checks as $index => $equipo) {
        if ($equipo != null && $modelos[$index] && $types[$index]) {
           
            $altaModel->setAltaHome($funcionario, $equipo, $modelos[$index], $types[$index], $nombre, $domicilio, $precinto, $descripcion, $user, $user_id, $fecha_actual);
        }
    }

    $fecha = date('d-m-Y');
    archivoTT($funcionario, $nombre, $fecha);
    $estado['exito'] = "Alta para teletrabajo generada con exito";
    $_SESSION['estado'] = $estado;

}

// Funcion para gestioanr el alta para plataforma
function insertQueryPlat($funcionario, $checks, $modelos, $types, $nombre, $sector, $puesto, $descripcion, $user, $user_id, $altaModel) {

    $fecha_actual = date('Y-m-d H:i:s');

    foreach ($checks as $index => $equipo) {
        
        if ($equipo != null && $modelos[$index]&& $types[$index]) {
            
            $altaModel->setAltaPlat($funcionario, $equipo, $modelos[$index], $types[$index], $nombre, $sector, $puesto, $descripcion, $user, $user_id, $fecha_actual);
        }
    }

    $estado['exito'] = "Alta para plataforma generada con exito";
    $_SESSION['estado'] = $estado;
}
?>
