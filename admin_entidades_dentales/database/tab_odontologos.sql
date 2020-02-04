CREATE TABLE `tab_odontologos` (
  `rowid` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_doc` varchar(55) DEFAULT NULL,
  `apellido_doc` varchar(55) DEFAULT NULL,
  `celular` varchar(45) DEFAULT NULL,
  `telefono_convencional` varchar(45) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `ciudad` varchar(45) DEFAULT NULL,
  `direccion` varchar(45) DEFAULT NULL,
  `fk_especialidad` int(11) DEFAULT '0',
  `fecha_nacim` date DEFAULT NULL,
  `sexo` varchar(45) DEFAULT NULL,
  `tms` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `estado` varchar(45) DEFAULT 'A',
  `icon` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`rowid`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8
;