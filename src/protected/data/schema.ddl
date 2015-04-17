DROP DATABASE habitacional;

CREATE DATABASE habitacional COLLATE = utf8_bin;

USE habitacional;

# DE LA SOLICITUD ##################################

CREATE TABLE persona (
   id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
   nombre VARCHAR(60) NOT NULL,
   apellido VARCHAR(40) NOT NULL,
   dni INTEGER NULL,
   sexo CHAR(1) NOT NULL,
   grupo_conviviente_id INTEGER NULL,
   solicitud_id INTEGER NULL,
   #Nacimiento
   fecha_nac DATE NOT NULL,
   pais_nac VARCHAR(20) NOT NULL,
   provincia_nac VARCHAR(30) NULL,
   localidad_nac VARCHAR(50) NULL,
   nacionalidad VARCHAR(20),
   celular_prefijo INTEGER NULL,
   telefono_prefijo INTEGER NULL,
   celular INTEGER NULL,
   telefono INTEGER NULL,
   UNIQUE(dni)

) ENGINE = InnoDB;

CREATE TABLE situacion_economica (
   id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
   ingresos_laborales INTEGER NULL,
   ingresos_alimentos INTEGER NULL,
   ingresos_subsidio INTEGER NULL,
   persona_id INTEGER NOT NULL
) ENGINE = InnoDB;

CREATE TABLE situacion_laboral (
   id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
   relacion_dependencia BIT(1),
   formal BIT(1),
   ocupacion VARCHAR(30),
   situacion_economica_id INTEGER NOT NULL,
   tipo_situacion_laboral_id INTEGER NOT NULL
) ENGINE = InnoDB;

CREATE TABLE tipo_situacion_laboral (
   id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
   descripcion VARCHAR(30) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE vinculo (
   vinculo VARCHAR(20),
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


# DE LA SOLICITUD ##################################

CREATE TABLE solicitud (
   id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
   numero INTEGER NOT NULL,
   fecha DATE NOT NULL,
   tipo_solicitud_id INTEGER NOT NULL,
   tipo_vivienda_id INTEGER NOT NULL,
   condicion_lote_id INTEGER NULL,
   condicion_uso_id INTEGER NOT NULL,
   condicion_alquiler_id INTEGER NULL,
   grupo_conviviente_id INTEGER NOT NULL,
   titular_id INTEGER NOT NULL,
   cotitular_id INTEGER NULL,
   estado_administrativo_solicitud_id INTEGER NOT NULL,
   UNIQUE(titular_id)
) ENGINE = InnoDB;

CREATE TABLE condicion_lote (
   id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
   descripcion VARCHAR(50) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE tipo_solicitud (
   id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
   nombre VARCHAR(30) NOT NULL
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

CREATE TABLE grupo_conviviente (
   id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
   domicilio_id INTEGER NOT NULL,
   UNIQUE(domicilio_id)
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

# DE LA VIVIENDA ACTUAL ##################################

CREATE TABLE vivienda_actual (
   id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
   domicilio_id INTEGER NOT NULL,
   observaciones VARCHAR(250)
) ENGINE = InnoDB;


CREATE TABLE banio (
   id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
   interno BIT(1) NOT NULL,
   completo BIT(1) NOT NULL,
   es_letrina BIT(1) NOT NULL,
   vivienda_actual_id INTEGER NOT NULL
) ENGINE = InnoDB;

CREATE TABLE servicio (
   id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
   medidor BIT(1) NOT NULL,
   compartido BIT(1) NOT NULL,
   tipo_servicio_id INTEGER NOT NULL,
   vivienda_actual_id INTEGER NOT NULL
) ENGINE = InnoDB;

CREATE TABLE tipo_servicio (
   id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
   descripcion VARCHAR(30)
) ENGINE = InnoDB;

# DEL ARCHIVO ##############################################333
CREATE TABLE solicitud_archivo (
   id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
   numero INTEGER NOT NULL,
   fecha DATE NOT NULL,
   tipo_solicitud_id INTEGER NOT NULL,
   tipo_vivienda_id INTEGER NOT NULL,
   condicion_lote_id INTEGER NULL,
   condicion_uso_id INTEGER NOT NULL,
   condicion_alquiler_id INTEGER NULL,
   titular_id INTEGER NOT NULL,
   cotitular_id INTEGER NULL,
   estado_administrativo_solicitud_id INTEGER NOT NULL,
   domicilio_id INTEGER NOT NULL,
   observaciones_vivienda VARCHAR(250),
   tipo_resolucion_id INTEGER NOT NULL,
   comentarios VARCHAR(500),
   UNIQUE(numero)
) ENGINE = InnoDB;

CREATE TABLE conviviente_archivo(
   solicitud_archivo_id INTEGER NOT NULL,
   persona_id INTEGER NOT NULL,
   es_solicitante BIT(1),
   PRIMARY KEY(solicitud_archivo_id, persona_id, es_solicitante)
) ENGINE = InnoDB;

CREATE TABLE banio_archivo (
   id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
   interno BIT(1) NOT NULL,
   completo BIT(1) NOT NULL,
   es_letrina BIT(1) NOT NULL,
   solicitud_archivo_id INTEGER NOT NULL
) ENGINE = InnoDB;

CREATE TABLE servicio_archivo (
   id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
   medidor BIT(1) NOT NULL,
   compartido BIT(1) NOT NULL,
   tipo_servicio_id INTEGER NOT NULL,
   solicitud_archivo_id INTEGER NOT NULL
) ENGINE = InnoDB;

CREATE TABLE tipo_resolucion (
   id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
   descripcion VARCHAR(20)
) ENGINE = InnoDB;

CREATE TABLE user (
   id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
   username VARCHAR(10),
   password CHAR(60),
   nombre VARCHAR(40) NOT NULL,
   apellido VARCHAR(40) NOT NULL,
   role VARCHAR(10),
   UNIQUE(username)
) ENGINE = InnoDB;


#FOREIGN KEY'S
ALTER TABLE persona ADD FOREIGN KEY (grupo_conviviente_id) REFERENCES grupo_conviviente(id) ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE persona ADD FOREIGN KEY (solicitud_id) REFERENCES solicitud(id) ON DELETE RESTRICT ON UPDATE NO ACTION;
ALTER TABLE situacion_economica ADD FOREIGN KEY (persona_id) REFERENCES persona(id) ON DELETE CASCADE ON UPDATE NO ACTION;
ALTER TABLE situacion_laboral ADD FOREIGN KEY (situacion_economica_id) REFERENCES situacion_economica(id) ON DELETE CASCADE ON UPDATE NO ACTION;
ALTER TABLE situacion_laboral ADD FOREIGN KEY (tipo_situacion_laboral_id) REFERENCES tipo_situacion_laboral(id) ON DELETE RESTRICT ON UPDATE NO ACTION;
ALTER TABLE vinculo ADD FOREIGN KEY (persona_id) REFERENCES persona(id) ON DELETE CASCADE ON UPDATE NO ACTION;
ALTER TABLE vinculo ADD FOREIGN KEY (familiar_id) REFERENCES persona(id) ON DELETE CASCADE ON UPDATE NO ACTION;
ALTER TABLE persona_condicion_especial ADD FOREIGN KEY (persona_id) REFERENCES persona(id) ON DELETE CASCADE ON UPDATE NO ACTION;
ALTER TABLE persona_condicion_especial ADD FOREIGN KEY (condicion_especial_id) REFERENCES condicion_especial(id) ON DELETE CASCADE ON UPDATE NO ACTION;
ALTER TABLE grupo_conviviente ADD FOREIGN KEY (domicilio_id) REFERENCES domicilio(id) ON DELETE RESTRICT ON UPDATE NO ACTION;
ALTER TABLE vivienda_actual ADD FOREIGN KEY (domicilio_id) REFERENCES domicilio(id) ON DELETE RESTRICT ON UPDATE NO ACTION;
ALTER TABLE servicio ADD FOREIGN KEY (tipo_servicio_id) REFERENCES tipo_servicio(id) ON DELETE RESTRICT ON UPDATE NO ACTION;
ALTER TABLE banio ADD FOREIGN KEY (vivienda_actual_id) REFERENCES vivienda_actual(id) ON DELETE CASCADE ON UPDATE NO ACTION;
ALTER TABLE servicio ADD FOREIGN KEY (vivienda_actual_id) REFERENCES vivienda_actual(id) ON DELETE CASCADE ON UPDATE NO ACTION;
ALTER TABLE solicitud ADD FOREIGN KEY (tipo_vivienda_id) REFERENCES tipo_vivienda(id) ON DELETE RESTRICT ON UPDATE NO ACTION;
ALTER TABLE solicitud ADD FOREIGN KEY (condicion_uso_id) REFERENCES condicion_uso(id) ON DELETE RESTRICT ON UPDATE NO ACTION;
ALTER TABLE solicitud ADD FOREIGN KEY (condicion_alquiler_id) REFERENCES condicion_alquiler(id) ON DELETE RESTRICT ON UPDATE NO ACTION;
ALTER TABLE solicitud ADD FOREIGN KEY (tipo_solicitud_id) REFERENCES tipo_solicitud(id) ON DELETE RESTRICT ON UPDATE NO ACTION;
ALTER TABLE solicitud ADD FOREIGN KEY (grupo_conviviente_id) REFERENCES grupo_conviviente(id) ON DELETE RESTRICT ON UPDATE NO ACTION;
ALTER TABLE solicitud ADD FOREIGN KEY (titular_id) REFERENCES persona(id) ON DELETE RESTRICT ON UPDATE NO ACTION;
ALTER TABLE solicitud ADD FOREIGN KEY (cotitular_id) REFERENCES persona(id) ON DELETE RESTRICT ON UPDATE NO ACTION;
ALTER TABLE solicitud ADD FOREIGN KEY (condicion_lote_id) REFERENCES condicion_lote(id) ON DELETE RESTRICT ON UPDATE NO ACTION;
ALTER TABLE solicitud ADD FOREIGN KEY (estado_administrativo_solicitud_id) REFERENCES estado_administrativo_solicitud(id) ON DELETE RESTRICT ON UPDATE NO ACTION;
ALTER TABLE solicitud_archivo ADD FOREIGN KEY (tipo_vivienda_id) REFERENCES tipo_vivienda(id) ON DELETE RESTRICT ON UPDATE NO ACTION;
ALTER TABLE solicitud_archivo ADD FOREIGN KEY (condicion_uso_id) REFERENCES condicion_uso(id) ON DELETE RESTRICT ON UPDATE NO ACTION;
ALTER TABLE solicitud_archivo ADD FOREIGN KEY (condicion_alquiler_id) REFERENCES condicion_alquiler(id) ON DELETE RESTRICT ON UPDATE NO ACTION;
ALTER TABLE solicitud_archivo ADD FOREIGN KEY (tipo_solicitud_id) REFERENCES tipo_solicitud(id) ON DELETE RESTRICT ON UPDATE NO ACTION;
ALTER TABLE solicitud_archivo ADD FOREIGN KEY (titular_id) REFERENCES persona(id) ON DELETE RESTRICT ON UPDATE NO ACTION;
ALTER TABLE solicitud_archivo ADD FOREIGN KEY (cotitular_id) REFERENCES persona(id) ON DELETE RESTRICT ON UPDATE NO ACTION;
ALTER TABLE solicitud_archivo ADD FOREIGN KEY (condicion_lote_id) REFERENCES condicion_lote(id) ON DELETE RESTRICT ON UPDATE NO ACTION;
ALTER TABLE solicitud_archivo ADD FOREIGN KEY (estado_administrativo_solicitud_id) REFERENCES estado_administrativo_solicitud(id) ON DELETE RESTRICT ON UPDATE NO ACTION;
ALTER TABLE solicitud_archivo ADD FOREIGN KEY (tipo_resolucion_id) REFERENCES tipo_resolucion(id) ON DELETE RESTRICT ON UPDATE NO ACTION;
ALTER TABLE banio_archivo ADD FOREIGN KEY (solicitud_archivo_id) REFERENCES solicitud_archivo(id) ON DELETE RESTRICT ON UPDATE NO ACTION;

INSERT INTO condicion_especial VALUES(NULL, 'Ex combatiente');
INSERT INTO condicion_especial VALUES(NULL, 'No vidente');

INSERT INTO condicion_lote VALUES(NULL, 'Permiso comunidad');
INSERT INTO condicion_lote VALUES(NULL, 'Cedido');

INSERT INTO tipo_solicitud VALUES(NULL, 'Vivienda');
INSERT INTO tipo_solicitud VALUES(NULL, 'Lote');

INSERT INTO estado_administrativo_solicitud VALUES(NULL, 'Borrador');
INSERT INTO estado_administrativo_solicitud VALUES(NULL, 'Activa');
INSERT INTO estado_administrativo_solicitud VALUES(NULL, 'Archivada');

INSERT INTO tipo_vivienda VALUES(NULL, 'Casa Rodante');
INSERT INTO tipo_vivienda VALUES(NULL, 'Pieza');

INSERT INTO condicion_uso VALUES(NULL, 'Ocupada');
INSERT INTO condicion_uso VALUES(NULL, 'Alquilada');
INSERT INTO condicion_uso VALUES(NULL, 'Prestada');

INSERT INTO tipo_situacion_laboral VALUES (NULL, 'Ocupado');
INSERT INTO tipo_situacion_laboral VALUES (NULL, 'Desocupado');
INSERT INTO tipo_situacion_laboral VALUES (NULL, 'Jubilado o Pensionado');
INSERT INTO tipo_situacion_laboral VALUES (NULL, 'Programa Empleo');

INSERT INTO tipo_servicio VALUES (NULL, 'Luz');
INSERT INTO tipo_servicio VALUES (NULL, 'Gas');
INSERT INTO tipo_servicio VALUES (NULL, 'Agua');
INSERT INTO tipo_servicio VALUES (NULL, 'Telefono');
INSERT INTO tipo_servicio VALUES (NULL, 'Servicio de cable');
INSERT INTO tipo_resolucion VALUES (NULL, 'Adjudicado');
INSERT INTO tipo_resolucion VALUES (NULL, 'Rechazado');
INSERT INTO tipo_resolucion VALUES (NULL, 'Invalida');
INSERT INTO tipo_resolucion VALUES (NULL, 'Caducada');

INSERT INTO `persona` (`id`, `nombre`, `apellido`, `dni`, `sexo`, `grupo_conviviente_id`, `solicitud_id`, `fecha_nac`, `pais_nac`, `provincia_nac`, `localidad_nac`, `nacionalidad`, `celular_prefijo`, `telefono_prefijo`, `celular`, `telefono`) VALUES
(1, 'Rodrigo', 'Silva', 28985263, 'M', NULL, NULL, '1985-04-01', 'Argentina', 'Buenos Aires', '', 'Argentino/a', NULL, 2972, NULL, NULL),
(2, 'Maria Lujan', 'Minasian', 30409109, 'F', NULL, NULL, '1985-04-08', 'Argentina', 'Buenos Aires', '', 'Argentino/a', NULL, 2972, NULL, NULL),
(3, 'Sebastian', 'Silva Minasian', 52640255, 'M', NULL, NULL, '1985-04-01', 'Argentina', 'Buenos Aires', '', 'Argentino/a', NULL, 2972, NULL, NULL),
(4, 'Fernando', 'Alvarez', 10200300, 'M', NULL, NULL, '1985-04-01', 'Argentina', 'Buenos Aires', '', 'Argentino/a', NULL, 2972, NULL, NULL),
(5, 'Miguel', 'Angel', 20300400, 'M', NULL, NULL, '1985-04-03', 'Argentina', 'Buenos Aires', '', 'Argentino/a', NULL, 2972, NULL, NULL);

INSERT INTO situacion_economica (`id`, `ingresos_laborales`, `ingresos_alimentos`, `ingresos_subsidio`, `persona_id`) VALUES
(1, 0,0,0,1), (2, 0,0,0,2), (3, 0,0,0,3), (4, 0,0,0,4), (5, 0,0,0,5);

INSERT INTO situacion_laboral (`id`,`relacion_dependencia`,`formal`,`ocupacion`,`situacion_economica_id`, `tipo_situacion_laboral_id`) VALUES
(1, 0, 0, "", 1, 2), 
(2, 0, 0, "", 2, 2), 
(3, 0, 0, "", 3, 2), 
(4, 0, 0, "", 4, 2), 
(5, 0, 0, "", 5, 2);

INSERT INTO user VALUES (NULL, 'rsilva', '$2y$13$9xcKBGMQNfo6qC88bErlyu0qDvdqLfnX136CLsvQeI0cLkxRufxwK', 'Rodrigo', 'Silva', 'admin'); 