CREATE TABLE `tab_odontograma_update` (
  `rowid` int(11) NOT NULL AUTO_INCREMENT,
  `fk_diente` int(11) DEFAULT '0',
  `json_caras` varchar(300) DEFAULT NULL,
  `type_hermiarcada` varchar(100) DEFAULT NULL,
  `fk_estado_pieza` int(11) DEFAULT '0',
  `fk_tratamiento` int(11) DEFAULT '0',
  `fk_paciente` int(11) DEFAULT '0',
  `tms` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`rowid`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8
;