CREATE TABLE persona (
   id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
   nombre VARCHAR(60) NOT NULL,
   apellido VARCHAR(40) NOT NULL,
   dni INTEGER NULL,
   sexo CHAR(1) NOT NULL,
   #Nacimiento
   fecha_nac DATETIME NOT NULL,
   pais_nac_id INTEGER NOT NULL,
   provincia_nac_id INTEGER NOT NULL,
   localidad_nac_id INTEGER NOT NULL,
   nacionalidad VARCHAR(20)

) ENGINE = InnoDB;

CREATE TABLE domicilio (
   id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
   calle VARCHAR(40) NULL,
   altura VARCHAR(10) NULL,
   piso VARCHAR(3) NULL,
   departamento VARCHAR(3) NULL,
   casa VARCHAR(3) NULL,
   lote VARCHAR(3) NULL,
   observaciones VARCHAR(250),
   provincia_id INTEGER NOT NULL,
   localidad_id INTEGER NOT NULL

) ENGINE = InnoDB;

CREATE TABLE situacion_laboral (
   id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
   trabaja BIT(1),
   jubilado_pensionado BIT(1),
   formal BIT(1),
   persona_id INTEGER

) ENGINE = InnoDB;

CREATE TABLE telefono (
   id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
   prefijo INTEGER NOT NULL,
   numero INTEGER NOT NULL,
   persona_id INTEGER
   
) ENGINE = InnoDB;

CREATE TABLE pais (
   id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
   nombre VARCHAR(40)
) ENGINE = InnoDB;

CREATE TABLE provincia (
   id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
   nombre VARCHAR(40)
) ENGINE = InnoDB;

CREATE TABLE localidad (
   id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
   nombre VARCHAR(40),
   provincia_id INTEGER NOT NULL

) ENGINE = InnoDB;

CREATE TABLE tipo_vinculo (
   id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
   nombre VARCHAR(20)
) ENGINE = InnoDB;

CREATE TABLE vinculo (
   tipo_vinculo_id INTEGER NOT NULL,
   persona_id INTEGER NOT NULL,
   familiar_id INTEGER NOT NULL
) ENGINE = InnoDB;

CREATE TABLE grupo_conviviente (
   id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
   domicilio_id INTEGER NOT NULL

) ENGINE = InnoDB;

ALTER TABLE situacion_laboral ADD FOREIGN KEY (persona_id) REFERENCES persona(id) ON DELETE CASCADE;
ALTER TABLE telefono ADD FOREIGN KEY (persona_id) REFERENCES persona(id) ON DELETE CASCADE;
ALTER TABLE localidad ADD FOREIGN KEY (provincia_id) REFERENCES provincia(id) ON DELETE CASCADE;
ALTER TABLE vinculo ADD FOREIGN KEY (tipo_vinculo_id) REFERENCES tipo_vinculo(id) ON DELETE CASCADE;
ALTER TABLE vinculo ADD FOREIGN KEY (persona_id) REFERENCES persona(id) ON DELETE CASCADE;
ALTER TABLE vinculo ADD FOREIGN KEY (familiar_id) REFERENCES persona(id) ON DELETE CASCADE;