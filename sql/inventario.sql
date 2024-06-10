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

id        VARCHAR(50) NOT NULL PRIMARY KEY,
marca           VARCHAR(100) NOT NULL,
modelo          VARCHAR(100) NOT NULL,
procesador      CHAR(20),
ram             CHAR(10),
almacenamiento  CHAR(10),
alta            DATE,
descripcion     TEXT

)ENGINE=InnoDB;