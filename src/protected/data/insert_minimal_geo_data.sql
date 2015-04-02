USE habitacional;
#INSERT INTO pais VALUES ('1', 'Argentina');

#INSERT INTO provincia VALUES ('1', 'Buenos Aires', '1');
#INSERT INTO provincia VALUES ('2', 'Capital Federal', '1');
#INSERT INTO provincia VALUES ('3', 'Catamarca', '1');
#INSERT INTO provincia VALUES ('4', 'Chaco', '1');
#INSERT INTO provincia VALUES ('5', 'Chubut', '1');
#INSERT INTO provincia VALUES ('6', 'Cordoba', '1');
#INSERT INTO provincia VALUES ('7', 'Corrientes', '1');
#INSERT INTO provincia VALUES ('8', 'Entre Rios', '1');
#INSERT INTO provincia VALUES ('9', 'Formosa', '1');
#INSERT INTO provincia VALUES ('10', 'Jujuy', '1');
#INSERT INTO provincia VALUES ('11', 'La Pampa', '1');
#INSERT INTO provincia VALUES ('12', 'La Rioja', '1');
#INSERT INTO provincia VALUES ('13', 'Mendoza', '1');
#INSERT INTO provincia VALUES ('14', 'Misiones', '1');
#INSERT INTO provincia VALUES ('15', 'Neuquen', '1');
#INSERT INTO provincia VALUES ('16', 'Ri Negro', '1');
#INSERT INTO provincia VALUES ('17', 'Salta', '1');
#INSERT INTO provincia VALUES ('18', 'San Juan', '1');
#INSERT INTO provincia VALUES ('19', 'San Luis', '1');
#INSERT INTO provincia VALUES ('20', 'Santa Cruz', '1');
#INSERT INTO provincia VALUES ('21', 'Santa Fe', '1');
#INSERT INTO provincia VALUES ('22', 'Santiago del Estero', '1');
#INSERT INTO provincia VALUES ('23', 'Tierra del Fuego', '1');
#INSERT INTO provincia VALUES ('24', 'Tucuman', '1');

#INSERT INTO localidad VALUES ('7804', 'LA FORTUNA', '8370', '15');
#INSERT INTO localidad VALUES ('7805', 'LAGO LOLOG', '8370', '15');
#INSERT INTO localidad VALUES ('7806', 'LAS BANDURRIAS', '8370', '15');
#INSERT INTO localidad VALUES ('7807', 'LASCAR', '8370', '15');
#INSERT INTO localidad VALUES ('7808', 'LOLOG', '8370', '15');
#INSERT INTO localidad VALUES ('7809', 'VILLA LAGO MELIQUINA', '8370', '15');
#INSERT INTO localidad VALUES ('7810', 'QUENTRENQUEN', '8373', '15');
#INSERT INTO localidad VALUES ('7811', 'QUILA QUINA', '8370', '15');
#INSERT INTO localidad VALUES ('7812', 'QUINQUIMITREO', '8373', '15');
#INSERT INTO localidad VALUES ('7813', 'SAN MARTIN DE LOS ANDES', '8370', '15');

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
INSERT INTO tipo_situacion_laboral VALUES (NULL, 'Descupado');
INSERT INTO tipo_situacion_laboral VALUES (NULL, 'Jubilado o Pensionado');
INSERT INTO tipo_situacion_laboral VALUES (NULL, 'Programa Empleo');

