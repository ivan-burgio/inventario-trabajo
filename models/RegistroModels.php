<?php

class RegistroModels {

    private $id;
    private $id_prod;
    private $tipo_prod;
    private $marca;
    private $modelo;
    private $procesador;
    private $ram;
    private $almacenamiento;
    private $alta;
    private $descripcion;
    private $usuario;
    private $status;
    private $db;

    public function __construct() {

        $this->db = Conexion::Connect();
    }

    public function setId($id) {

        $this->id = $this->db->real_escape_string($id);
    }

    public function setId_Prod($id_prod) {

        $this->id_prod = $this->db->real_escape_string($id_prod);
    }

    public function setTipo_Prod($tipo_prod) {

        $this->tipo_prod = $this->db->real_escape_string($tipo_prod);
    }

    public function setMarca($marca) {

        $this->marca = $this->db->real_escape_string($marca);
    }

    public function setModelo($modelo) {

        $this->modelo = $this->db->real_escape_string($modelo);
    }

    public function setProcesador($procesador) {

        $this->procesador = $this->db->real_escape_string($procesador);
    }

    public function setRam($ram) {

        $this->ram = $this->db->real_escape_string($ram);
    }

    public function setAlmacenamiento($almacenamiento) {

        $this->almacenamiento = $this->db->real_escape_string($almacenamiento);
    }

    public function setAlta($alta) {

        $this->alta = $this->db->real_escape_string($alta);
    }

    public function setDescripcion($descripcion) {

        $this->descripcion = $this->db->real_escape_string($descripcion);
    }

    public function setUsuario($usuario) {

        $this->usuario = $this->db->real_escape_string($usuario);
    }

    public function setStatus($status) {

        $this->status = $this->db->real_escape_string($status);
    }

    public function showTypes() {

        return $select_tipos_query = $this->db->query("SELECT * FROM tipos");
    }

    public function registroTorre($id_prod, $marca, $modelo, $procesador, $ram, $almacenamiento, $descripcion, $user) {

        return $registro_equip = $this->db->query("INSERT INTO productos VALUES(NULL, '$id_prod', '$marca', '$modelo', '$proce', '$ram', '$almacenamiento', CURDATE(), '$descripcion', '$user', 1);");
    }

    public function registroPerife($id_prod, $marca, $modelo, $descripcion, $user) {

        return $registro_perife = $this->db->query("INSERT INTO productos VALUES(NULL, '$id_prod', '$marca', '$modelo',NULL, NULL, NULL, CURDATE(), '$descripcion', '$user', 1);");
    }

    public function closeConnection() {

        $this->db->close();
    }
}

?>