<?php

require_once 'models/InventarioModels.php';

class InventarioController {

        public function inventario() {

                if(!isset($_SESSION['user'])) {

                        header('Location:'. base_url . '?controller=Login&action=login');
                        exit();
                }

                $inventarioModel = new InventarioModels();
                $productos = $inventarioModel->getProduct();

                require_once 'views/inventario.php';
        }

        public function modificar() {

                $modificar = new InventarioModels();

                //Se valida la existencia de GET
                if($_GET) {

                        if(!isset($_SESSION['user'])) {

                                header('Location:'. base_url . '?controller=Login&action=login');
                                exit();
                        }
        
                        $id_get = isset($_GET['id_prod']) ? $_GET['id_prod'] : false;    //Se valida la existencia de datos enviados por GET
                        $modify = $modificar->getProductModify($id_get);

                        require_once 'views/modificar.php';
                };
        }


        public function producto() {

                $selectProduct = new InventarioModels();

                //Se valida la existencia de GET
                if($_GET) {

                        if(!isset($_SESSION['user'])) {

                                header('Location:'. base_url . '?controller=Login&action=login');
                                exit();
                        }
        
                        $id_get = isset($_GET['modelo']) ? $_GET['modelo'] : false; //Se valida la existencia de datos enviados por GET
                        $selects = $selectProduct->getSelectProduct($id_get);
 
                        require_once 'views/producto.php';
                };
        }

        public function modificarProducto() {

                $modificar = new InventarioModels();

                //Validar e ingresar los datos de los productos que se ingresan a la tabla productos.
                if($_POST) {

                        $id_prod = isset($_POST['id']) ? $_POST['id'] : false;                               //Se valida la existencia de datos enviados por POST
                        $marca = isset($_POST['marca']) ? $_POST['marca'] : false;                      //Se valida la existencia de datos enviados por POST
                        $modelo = isset($_POST['modelo']) ? $_POST['modelo'] : false;                   //Se valida la existencia de datos enviados por POST
                        $procesador = isset($_POST['proce']) ? $_POST['proce'] : false;                 //Se valida la existencia de datos enviados por POST
                        $ram = isset($_POST['ram']) ? $_POST['ram'] : false;                            //Se valida la existencia de datos enviados por POST
                        $almacenamiento = isset($_POST['almace']) ? $_POST['almace'] : false;           //Se valida la existencia de datos enviados por POST
                        $comentario = isset($_POST['descripcion']) ? $_POST['descripcion'] : false;    //Se valida la existencia de datos enviados por POST
                        $user_admin = $_SESSION['user']->id_admin;

                        $errores = validarCampos($id_prod, $marca, $modelo, $procesador, $ram, $almacenamiento, $comentario, $modificar);

                        if(count($errores) == 0) {

                                $products = $modificar->getProductModify($id_prod);
                                $product = $products->fetch_assoc();

                                $id = $product['id'];
                                $modificar->setId($id);
                                $modificar->setIdProd($id_prod);
                                $modificar->setMarca($marca);
                                $modificar->setModelo($modelo);
                                $modificar->setProcesador($procesador);
                                $modificar->setRam($ram);
                                $modificar->setAlmacenamiento($almacenamiento);
                                $modificar->setComentario($comentario);
                                $modificar->setUserAdmin($user_admin);

                                $modificar->setProductModify();
                                header('Location:'.base_url.'?controller=Inventario&action=inventario');


                        } else {

                                $_SESSION['errores_modify'] = $errores_modify;
                                header('Location:'.base_url.'?controller=Inventario&action=inventario');
                        }
                }
        }
                

        public function eliminarProducto() {

                // Se valida la existencia del parámetro 'id' en la solicitud GET

                if(isset($_GET['id'])) {
                // Sanitizamos el valor de 'id' para evitar inyección SQL
                $id_get = mysqli_real_escape_string($conexion, $_GET['id']);
        
                $delete = new InventarioModels();
                $delete->deleteProduct($id_get);
                // Verificamos si la consulta se ejecutó correctamente
                if($delete) {
                // Redireccionamos solo si la consulta fue exitosa
                header('Location:'.base_url.'controller=Inventario&action=inventario');
        
                } else {

                // Manejo de error si la consulta falla (opcional)
                echo "Error al ejecutar la consulta";
                }
                } else {
                        // Manejo si no se proporciona 'id' en la solicitud GET (opcional)
                        echo "No se proporcionó el parámetro 'id' en la solicitud.";
                }
        }
}


function validarCampos($id_prod, $marca, $modelo, $comentario, $modificar) {

        $errores_modify = array();

        if(empty($id_prod)) {

                $errores_modify['id'] = "Ingrese un ID para el producto";
        }

        if(empty($marca)) {

                $errores_modify['marca'] = "Ingrese la marca del producto";
        }

        if(empty($modelo)) {

                $errores_modify['modelo'] = "Ingrese el modelo del producto";
        }

        if(empty($comentario)) {

                $errores_modify['comentario'] = "Ingrese un comentario para el producto";
        }

        return $errores_modify;

}
?>