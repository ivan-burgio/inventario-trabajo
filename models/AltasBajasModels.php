<?php

require_once 'config/conexion.php';


class AltasModels {

    private $equipo;
    private $descripcion;
    private $user;
    private $user_admin;

    private $db;

    public function __construct() {

        $this->db = Conexion::Connect();
    }

    function getEquipo() {

        return $this->equipo;
    }

    function getDescripcion() {

        return $this->descripcion;
    }

    function getUser() {

        return $this->user;
    }

    function getUserAdmin() {

        return $this->user_admin;
    }

    function setEquipo($equipo) {

        $this->equipo = $equipo;
    }

    function setDescripcion($descripcion) {

        $this->descripcion = $descripcion;
    }

    function setUser($user) {

        $this->user = $user;
    }

    function setUserAdmin($user_admin) {

        $this->user_admin = $user_admin;
    }

    public function getFuncionario() {

        $lista_func = $this->db->query("SELECT f.id_funcionario, f.nombre, f.apellido, s.nombre AS nombre_sector FROM funcionarios f
                                        INNER JOIN sectores s ON f.sector = s.id_sector;");
        return $lista_func;
    }

    public function getProduct() {

        $lista_product = $this->db->query("SELECT id, id_prod, marca, modelo FROM productos WHERE status = 1;");
        return $lista_product;
    }

    public function updateProduct() {

        $update_inv = "UPDATE productos SET status = 1 WHERE id = '$equipo';";
        return $this->db->query($update_inv);
    }

    public function getModeloSelect($equipo) {

        $sql = "SELECT * FROM productos WHERE id = '$equipo';";
        return $this->db->query($sql);
    }

    public function getNombreFunc($funcionario) {

        $sql_nombre_func = "SELECT nombre, apellido FROM funcionarios WHERE id_funcionario = '$funcionario';";
        return $this->db->query($sql_nombre_func);
    }

    public function setAltaHome($funcionario, $equipo, $modelos, $types, $nombre, $domicilio, $precinto, $descripcion, $user, $user_id, $fecha_actual) {

        $sql = "INSERT INTO altas_productos 
                VALUES(NULL, '$funcionario', '$equipo', '$types','$modelos', '$nombre', '$fecha_actual', '$domicilio', NULL, '$precinto', '$descripcion', '$user', 1);";
        
        $comentario_inicial = "INSERT INTO comentarios VALUES(NULL, '$user_id', '$equipo', '$descripcion', '$fecha_actual');";

        $modify_status = "UPDATE productos SET status = 2 WHERE id = '$equipo';";

        $this->db->query($sql);
        $this->db->query($comentario_inicial);        
        $this->db->query($modify_status);
    }

    public function setAltaPlat($funcionario, $equipo, $modelos, $types, $nombre, $sector, $puesto, $descripcion, $user, $user_id, $fecha_actual) {

        $sql = "INSERT INTO altas_productos 
                VALUES(NULL, '$funcionario', '$equipo', '$types', '$modelos', '$nombre', '$fecha_actual', '$sector', '$puesto', NULL, '$descripcion', '$user', 1);";
    
        $comentario_inicial = "INSERT INTO comentarios VALUES(NULL, '$user_id', '$equipo', '$descripcion', '$fecha_actual');";
    
        $modify_status = "UPDATE productos SET status = 2 WHERE id = '$equipo';";
    
        $this->db->query($sql);
        $this->db->query($comentario_inicial);        
        $this->db->query($modify_status);
    }
    

    public function updateAltas() {

        $fecha_actual = date('Y-m-d H:i:s');

        $equipo = strval($this->getEquipo());
        $descripcion = strval($this->getDescripcion());
        $user = strval($this->getUser());
        $user_admin = strval($this->getUserAdmin());

        // Actualizar la última entrada de altas_productos para el producto específico
        $update_alta = "UPDATE altas_productos
                        SET status = 0,
                            usuario = '$user',
                            descripcion = '$descripcion',
                            fecha = '$fecha_actual'
                        WHERE id_producto = '$equipo'
                        AND fecha = (
                            SELECT fecha
                            FROM altas_productos
                            WHERE id_producto = '$equipo'
                            ORDER BY fecha DESC
                            LIMIT 1
                        );";
            // Insertar comentario inicial en la tabla comentarios
        $comentario_inicial = "INSERT INTO comentarios VALUES(NULL, '$user_admin', '$equipo', '$descripcion', '$fecha_actual');";

        $this->db->query($comentario_inicial);
        return $this->db->query($update_alta);
    }

    public function getSector() {

        $lista_sector = $this->db->query("SELECT * FROM sectores;");
        return $lista_sector;
    }

    public function getAltasFunc() {

        $select_altas = "SELECT a.id_funcionario, a.id_producto, a.nombre_func, a.fecha, a.lugar_trabajo, a.puesto, p.id_prod
                 FROM altas_productos a
                 INNER JOIN productos p ON p.id = a.id_producto
                 INNER JOIN (
                    SELECT id_funcionario, MAX(id) AS max_id
                    FROM altas_productos
                    WHERE status = 1
                    GROUP BY id_funcionario
                 ) AS latest ON a.id_funcionario = latest.id_funcionario AND a.id = latest.max_id
                 WHERE a.status = 1;

        ";

        return $this->db->query($select_altas);
    }

    public function getAltasProduct() {

        $select_product = "SELECT a.id_funcionario, p.id_prod, p.modelo, p.marca, a.id_producto FROM productos p
                   INNER JOIN altas_productos a ON p.id = a.id_producto
                   WHERE a.status = 1";

        return $this->db->query($select_product);
    }

    public function closeConnection() {

        $this->db->close();
    }
};

?>