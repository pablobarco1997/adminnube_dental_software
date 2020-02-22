CREATE TABLE `tab_evolucion_plantramiento` (
  `rowid` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_create` datetime DEFAULT NULL,
  `fk_paciente` int(11) DEFAULT '0',
  `fk_plantram_cab` int(11) DEFAULT '0',
  `fk_plantram_det` int(11) DEFAULT '0',
  `observacion` varchar(500) DEFAULT NULL,
  `fk_diente` int(11) DEFAULT '0',
  `json_caras` varchar(250) DEFAULT NULL,
  `estado_diente` int(11) DEFAULT '0',
  `fk_doctor` int(11) DEFAULT '0',
  `id_login` int(11) DEFAULT '0',
  PRIMARY KEY (`rowid`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8
;