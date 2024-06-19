
CREATE TABLE sectores (

id_sector       INT PRIMARY KEY,
nombre          VARCHAR(30)
    
)ENGINE=InnoDB;


CREATE TABLE funcionarios (

id_funcionario  INT PRIMARY KEY,
nombre          VARCHAR(30),
apellido        VARCHAR(30),
sector          INT,

CONSTRAINT fk_sectores FOREIGN KEY(sector) REFERENCES sectores(id_sector)

)ENGINE=InnoDB;


CREATE TABLE productos (

id              VARCHAR(50) NOT NULL PRIMARY KEY,
marca           VARCHAR(100) NOT NULL,
modelo          VARCHAR(100) NOT NULL,
procesador      CHAR(20),
ram             CHAR(10),
almacenamiento  CHAR(10),
alta            DATE,
descripcion     TEXT

)ENGINE=InnoDB;

CREATE TABLE admin (

id_admin            INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
nombre              CHAR(30),
apellido            CHAR(30),
email               CHAR(50),
contraseña          VARCHAR(255)

)ENGINE=InnoDB;

CREATE TABLE comentarios(

id_comentario       INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
id_admin            INT NOT NULL,
id_producto         VARCHAR(50) NOT NULL,
comentarios         TEXT,

FOREIGN KEY (id_admin) REFERENCES admin (id_admin),
FOREIGN KEY (id_producto) REFERENCES productos (id)

)ENGINE=InnoDB;

CREATE TABLE altas_productos (

id_funcionario      INT,
id_producto         VARCHAR(50),
marca_produ         VARCHAR(100),
nombre_func         VARCHAR(60),
fecha               DATE,
status              INT,

FOREIGN KEY (id_funcionario) REFERENCES funcionario(id_funcionario),
FOREIGN KEY (id_producto) REFERENCES productos(id)
)ENGINE=InnoDB;