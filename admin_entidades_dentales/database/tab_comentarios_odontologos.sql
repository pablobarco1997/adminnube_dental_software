CREATE TABLE `tab_comentarios_odontologos` (
  `rowid` int(11) NOT NULL AUTO_INCREMENT,
  `fk_odontologos` int(11) DEFAULT '0',
  `comentario` varchar(700) DEFAULT NULL,
  `tms` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_paciente` int(11) DEFAULT '0',
  PRIMARY KEY (`rowid`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8
;