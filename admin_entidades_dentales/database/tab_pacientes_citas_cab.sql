CREATE TABLE `tab_pacientes_citas_cab` (
  `rowid` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_create` datetime DEFAULT NULL,
  `fk_paciente` int(11) DEFAULT '0',
  `comentario` varchar(700) DEFAULT NULL,
  `fk_login_user` int(11) DEFAULT '0',
  `tms` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`rowid`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8
;