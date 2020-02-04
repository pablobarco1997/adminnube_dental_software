CREATE TABLE `tab_fichero_pacientes_det` (
  `rowid` int(11) NOT NULL AUTO_INCREMENT,
  `fk_fichero_paciente_cab` int(11) DEFAULT '0',
  `ruta_fichero` varchar(100) DEFAULT NULL,
  `name_direct` varchar(100) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`rowid`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8
;