CREATE TABLE `tab_odontograma_paciente_cab` (
  `rowid` int(11) NOT NULL AUTO_INCREMENT,
  `numero` varchar(45) DEFAULT NULL,
  `fk_user` int(11) DEFAULT '0',
  `descripcion` varchar(700) DEFAULT NULL,
  `fk_tratamiento` int(11) DEFAULT '0',
  `fecha` datetime NOT NULL,
  `fk_paciente` int(11) DEFAULT '0',
  `estado_odont` varchar(10) DEFAULT 'A',
  PRIMARY KEY (`rowid`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8
;