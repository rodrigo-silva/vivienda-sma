CREATE TABLE import(
   id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
   dniTitular INTEGER NULL,

   #pipol
   sexo CHAR(1) NOT NULL,
   apellido VARCHAR(40) NOT NULL,
   nombre VARCHAR(60) NOT NULL,
   dni INTEGER NULL,
   fecha_nac DATE NOT NULL,
   anio_residencia INTEGER NULL,
   telefono INTEGER NULL,
   celular_prefijo INTEGER NULL,
   celular INTEGER NULL,
   tipo_situacion_laboral_id INTEGER NOT NULL,
   relacion_dependencia CHAR(1),
   ingresos_laborales INTEGER NULL,
   nacionalidad VARCHAR(20),
   pais_nac VARCHAR(20) NOT NULL,
   provincia_nac VARCHAR(30) NULL,
   localidad_nac VARCHAR(50) NULL,

   #Solicitud
   fecha DATE NOT NULL,

   calle VARCHAR(40) NULL,
   altura VARCHAR(10) NULL,
   barrio VARCHAR(40) NULL,
   cruce_calle_1 VARCHAR(40) NULL,
   cruce_calle_2 VARCHAR(40) NULL,
   piso VARCHAR(3) NULL,
   departamento VARCHAR(3) NULL,
   casa VARCHAR(3) NULL,
   puerta VARCHAR(3) NULL,
   lote VARCHAR(3) NULL,
   manzana VARCHAR(3) NULL,
   edificio VARCHAR(20) NULL,

   tipo_solicitud_id INTEGER NOT NULL,
   condicion_lote_id INTEGER NULL,
   tipo_vivienda_id INTEGER NOT NULL,
   condicion_uso_id INTEGER NOT NULL,
   es_alquiler CHAR(1),
   formal CHAR(1),
   costo_superior CHAR(1),
   comparte_dormitorio CHAR(1),

   UNIQUE(dni)
) ENGINE = InnoDB;