CREATE TABLE `tab_especialidades_doc` (
  `rowid` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_especialidad` varchar(55) DEFAULT NULL,
  `fk_user` int(11) DEFAULT '0',
  `descripcion` varchar(700) DEFAULT NULL,
  `tms` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`rowid`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8
;