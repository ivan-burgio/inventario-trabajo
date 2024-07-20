<?php

require_once 'config/conexion.php';

class InventarioModels {

    private $id;
    private $id_prod;
    private $marca;
    private $modelo;
    private $ram;
    private $procesador;
    private $almacenamiento;
    private $comentario;
    private $user_admin;

    private $db;


    function getId() {

        return $this->id;
    }

    function getIdProd() {

        return $this->id_prod;
    }

    function getMarca() {

        return $this->marca;
    }

    function getModelo() {

        return $this->modelo;
    }

    function getRam() {

        return $this->ram;
    }

    function getProcesador() {
        
        return $this->procesador;
    }

    function getAlmacenamiento() {

        return $this->almacenamiento;
    }

    function getComentario() {

        return $this->comentario;
    }

    function getUserAdmin() {

        return $this->user_admin;
    }

    function setId($id) {

        $this->id = $id;
    }

    function setIdProd($id_prod) {

        $this->id_prod = $id_prod;
    }

    function setMarca($marca) {

        $this->marca = $marca;
    }

    function setModelo($modelo) {

        $this->modelo = $modelo;
    }

    function setRam($ram) {

        $this->ram = $ram;
    }

    function setProcesador($procesador) {
        
        $this->procesador = $procesador;
    }

    function setAlmacenamiento($almacenamiento) {

        $this->almacenamiento = $almacenamiento;
    }

    function setComentario($comentario) {

        $this->comentario = $comentario;
    }

    function setUserAdmin($user_admin) {

        $this->user_admin = $user_admin;
    }

    public function __construct() {

        $this->db = Conexion::Connect();
    }

    public function getProduct() {

        //Se genera la consulta para la BD
        $sql_product = "SELECT p.*, a.*
        FROM productos p
        LEFT JOIN altas_productos a ON p.id = a.id_producto AND a.status = 1
        WHERE p.status != 0;";

        return $productos = $this->db->query($sql_product); 

        $this->db->close();

    }

    public function getSelectProduct($id_get) {

            //Se genera la consulta para la BD
        $select_pro = "SELECT 
                        p.id, p.id_prod, p.marca, p.modelo, p.procesador, p.ram, p.almacenamiento, 
                        p.alta, p.descripcion, p.usuario, 
                        c.comentarios AS ultimo_comentario
                        FROM productos p
                        LEFT JOIN 
                        (SELECT id_producto, comentarios
                        FROM comentarios c1
                        WHERE fecha = (SELECT MAX(fecha) FROM comentarios c2 WHERE c2.id_producto = c1.id_producto)
                            ) c ON p.id = c.id_producto
                        WHERE p.id_prod = '$id_get' AND p.status != 0;";

        return $this->db->query($select_pro);
    }

    public function getProductModify($id_producto) {

        $modify = "SELECT * FROM productos WHERE id_prod = '$id_producto';";
        return $this->db->query($modify);
    }

    public function setProductModify() {

        $id = $this->getId();
        $id_prod = $this->getIdProd();
        $marca = $this->getMarca();
        $modelo = $this->getModelo();
        $ram = $this->getRam();
        $procesador = $this->getProcesador();
        $almacenamiento = $this->getAlmacenamiento();
        $comentario = $this->getComentario();
        $user_admin = $this->getUserAdmin();

        //Se genera la consulta para la BD
        $update = "UPDATE productos 
        SET marca = '$marca', modelo = '$modelo', procesador = '$procesador', ram = '$ram', almacenamiento = '$almacenamiento' WHERE id_prod = '$id_prod';";
        $comentario_inicial = "INSERT INTO comentarios VALUES(NULL, '$user_admin', '$id', '$comentario', NOW());";

        $this->db->query($comentario_inicial);
        $this->db->query($update);

    }

    public function deleteProduct($id_get) {

        // Generamos la consulta SQL para actualizar el producto
        $sql_delete = "UPDATE productos SET status = 0 WHERE id = '$id_get'";
        return $this->db->query($sql_delete);

    }

}

?>