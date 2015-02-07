CREATE TABLE persona (
   id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
   nombre VARCHAR(60) NOT NULL,
   apellido VARCHAR(40) NOT NULL,
   dni INTEGER NULL,
   sexo CHAR(1)

) ENGINE = InnoDB;

CREATE TABLE situacion_laboral (
   id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
   trabaja BIT(1),
   jubilado_pensionado BIT(1),
   formal BIT(1),
   persona_id INTEGER,
   
   FOREIGN KEY (persona_id) REFERENCES persona(id) ON DELETE CASCADE

) ENGINE = InnoDB;