CREATE TABLE `tab_odontograma_paciente_det` (
  `rowid` int(11) NOT NULL AUTO_INCREMENT,
  `fk_diente` int(11) DEFAULT '0',
  `json_caras` varchar(800) DEFAULT NULL,
  `fk_estado_diente` int(11) DEFAULT '0',
  `fk_tratamiento` int(11) DEFAULT '0',
  `obsrvacion` varchar(800) DEFAULT NULL,
  `list_caras` varchar(800) DEFAULT NULL,
  `fecha` date NOT NULL,
  `estado_anulado` varchar(3) DEFAULT 'A',
  PRIMARY KEY (`rowid`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8
;
