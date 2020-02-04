CREATE TABLE `tab_fichero_pacientes_cab` (
  `rowid` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_creat` datetime DEFAULT NULL,
  `fk_doc` int(11) DEFAULT '0',
  `fk_paciente` int(11) DEFAULT '0',
  `titulo` varchar(55) DEFAULT NULL,
  `comment` varchar(700) DEFAULT NULL,
  `tms` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`rowid`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8
;