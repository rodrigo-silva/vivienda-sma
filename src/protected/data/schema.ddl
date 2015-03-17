DROP DATABASE habitacional;

CREATE DATABASE habitacional COLLATE = utf8_bin;

USE habitacional;

CREATE TABLE persona (
   id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
   nombre VARCHAR(60) NOT NULL,
   apellido VARCHAR(40) NOT NULL,
   dni INTEGER NULL,
   sexo CHAR(1) NOT NULL,
   grupo_conviviente_id INTEGER NULL,
   #Nacimiento
   fecha_nac DATE NOT NULL,
   pais_nac_id INTEGER NOT NULL,
   provincia_nac_id INTEGER NOT NULL,
   localidad_nac_id INTEGER NULL,
   nacionalidad VARCHAR(20),
   UNIQUE(nombre, apellido, dni)

) ENGINE = InnoDB;

CREATE TABLE domicilio (
   id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
   calle VARCHAR(40) NULL,
   altura VARCHAR(10) NULL,
   piso VARCHAR(3) NULL,
   departamento VARCHAR(3) NULL,
   casa VARCHAR(3) NULL,
   lote VARCHAR(3) NULL,
   observaciones VARCHAR(250) NULL

) ENGINE = InnoDB;

CREATE TABLE situacion_laboral (
   id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
   trabaja BIT(1),
   jubilado_pensionado BIT(1),
   formal BIT(1),
   ingreso_neto_mensual INTEGER,
   persona_id INTEGER NOT NULL

) ENGINE = InnoDB;

CREATE TABLE telefono (
   id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
   prefijo INTEGER NOT NULL,
   numero INTEGER NOT NULL,
   persona_id INTEGER NOT NULL
   
) ENGINE = InnoDB;

CREATE TABLE pais (
   id INTEGER NOT NULL PRIMARY KEY,
   nombre VARCHAR(40)
) ENGINE = InnoDB;

CREATE TABLE provincia (
   id INTEGER NOT NULL PRIMARY KEY,
   nombre VARCHAR(40)
) ENGINE = InnoDB;

CREATE TABLE localidad (
   id INTEGER NOT NULL PRIMARY KEY,
   nombre VARCHAR(40),
   codigo_postal INTEGER NULL,
   provincia_id INTEGER NOT NULL

) ENGINE = InnoDB;

CREATE TABLE vinculo (
   tipo VARCHAR(20),
   persona_id INTEGER NOT NULL,
   familiar_id INTEGER NOT NULL,
   PRIMARY KEY(persona_id, familiar_id)
) ENGINE = InnoDB;

CREATE TABLE persona_condicion_especial (
   persona_id INTEGER NOT NULL,
   condicion_especial_id INTEGER NOT NULL,
   PRIMARY KEY(persona_id, condicion_especial_id)
) ENGINE = InnoDB;

CREATE TABLE condicion_especial (
   id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
   nombre VARCHAR(50) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE grupo_conviviente (
   id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
   domicilio_id INTEGER NOT NULL
) ENGINE = InnoDB;

CREATE TABLE grupo_solicitante (
   persona_id INTEGER NOT NULL,
   solicitud_id INTEGER NOT NULL,
   PRIMARY KEY(persona_id, solicitud_id)
) ENGINE = InnoDB;

CREATE TABLE tipo_solicitud (
   id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
   nombre VARCHAR(30) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE condicion_lote (
   id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
   descripcion VARCHAR(50) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE vivienda_actual (
   id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
   tipo_vivienda_id INTEGER NOT NULL,
   condicion_uso_id INTEGER NOT NULL,
   condicion_alquiler_id INTEGER NULL
) ENGINE = InnoDB;

CREATE TABLE tipo_vivienda (
   id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
   descripcion VARCHAR(40) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE condicion_uso (
   id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
   descripcion VARCHAR(40) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE condicion_alquiler (
   id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
   formal BIT(1),
   costo_superior BIT(1)
) ENGINE = InnoDB;

CREATE TABLE estado_administrativo_solicitud (
   id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
   nombre VARCHAR(20)
) ENGINE = InnoDB;

CREATE TABLE solicitud (
   id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
   fecha DATE NOT NULL,
   tipo_solicitud_id INTEGER NOT NULL,
   condicion_lote_id INTEGER NULL,
   vivienda_actual_id INTEGER NOT NULL,
   grupo_conviviente_id INTEGER NOT NULL,
   titular_id INTEGER NOT NULL,
   cotitular_id INTEGER NULL,
   estado_administrativo_solicitud_id INTEGER NOT NULL,
   UNIQUE(titular_id)
) ENGINE = InnoDB;

#FOREIGN KEY'S
ALTER TABLE persona ADD FOREIGN KEY (pais_nac_id) REFERENCES pais(id) ON DELETE RESTRICT ON UPDATE NO ACTION;
ALTER TABLE persona ADD FOREIGN KEY (provincia_nac_id) REFERENCES provincia(id) ON DELETE RESTRICT ON UPDATE NO ACTION;
ALTER TABLE persona ADD FOREIGN KEY (localidad_nac_id) REFERENCES localidad(id) ON DELETE RESTRICT ON UPDATE NO ACTION;
ALTER TABLE persona ADD FOREIGN KEY (grupo_conviviente_id) REFERENCES grupo_conviviente(id) ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE situacion_laboral ADD FOREIGN KEY (persona_id) REFERENCES persona(id) ON DELETE CASCADE ON UPDATE NO ACTION;
ALTER TABLE telefono ADD FOREIGN KEY (persona_id) REFERENCES persona(id) ON DELETE CASCADE ON UPDATE NO ACTION;
ALTER TABLE localidad ADD FOREIGN KEY (provincia_id) REFERENCES provincia(id) ON DELETE RESTRICT ON UPDATE NO ACTION;
ALTER TABLE vinculo ADD FOREIGN KEY (persona_id) REFERENCES persona(id) ON DELETE CASCADE ON UPDATE NO ACTION;
ALTER TABLE vinculo ADD FOREIGN KEY (familiar_id) REFERENCES persona(id) ON DELETE CASCADE ON UPDATE NO ACTION;
ALTER TABLE persona_condicion_especial ADD FOREIGN KEY (persona_id) REFERENCES persona(id) ON DELETE CASCADE ON UPDATE NO ACTION;
ALTER TABLE persona_condicion_especial ADD FOREIGN KEY (condicion_especial_id) REFERENCES condicion_especial(id) ON DELETE CASCADE ON UPDATE NO ACTION;
ALTER TABLE grupo_solicitante ADD FOREIGN KEY (persona_id) REFERENCES persona(id) ON DELETE CASCADE ON UPDATE NO ACTION;
ALTER TABLE grupo_solicitante ADD FOREIGN KEY (solicitud_id) REFERENCES solicitud(id) ON DELETE CASCADE ON UPDATE NO ACTION;
ALTER TABLE vivienda_actual ADD FOREIGN KEY (tipo_vivienda_id) REFERENCES tipo_vivienda(id) ON DELETE RESTRICT ON UPDATE NO ACTION;
ALTER TABLE vivienda_actual ADD FOREIGN KEY (condicion_uso_id) REFERENCES condicion_uso(id) ON DELETE RESTRICT ON UPDATE NO ACTION;
ALTER TABLE vivienda_actual ADD FOREIGN KEY (condicion_alquiler_id) REFERENCES condicion_alquiler(id) ON DELETE RESTRICT ON UPDATE NO ACTION;
ALTER TABLE solicitud ADD FOREIGN KEY (tipo_solicitud_id) REFERENCES tipo_solicitud(id) ON DELETE RESTRICT ON UPDATE NO ACTION;
ALTER TABLE solicitud ADD FOREIGN KEY (vivienda_actual_id) REFERENCES vivienda_actual(id) ON DELETE RESTRICT ON UPDATE NO ACTION;
ALTER TABLE solicitud ADD FOREIGN KEY (grupo_conviviente_id) REFERENCES grupo_conviviente(id) ON DELETE RESTRICT ON UPDATE NO ACTION;
ALTER TABLE solicitud ADD FOREIGN KEY (titular_id) REFERENCES persona(id) ON DELETE RESTRICT ON UPDATE NO ACTION;
ALTER TABLE solicitud ADD FOREIGN KEY (cotitular_id) REFERENCES persona(id) ON DELETE RESTRICT ON UPDATE NO ACTION;
ALTER TABLE solicitud ADD FOREIGN KEY (condicion_lote_id) REFERENCES condicion_lote(id) ON DELETE RESTRICT ON UPDATE NO ACTION;
ALTER TABLE solicitud ADD FOREIGN KEY (estado_administrativo_solicitud_id) REFERENCES estado_administrativo_solicitud(id) ON DELETE RESTRICT ON UPDATE NO ACTION;